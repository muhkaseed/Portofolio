<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Halaman website portofolio (pengganti index.php).
 * Semua konten diambil dari database db_cv.
 */
class PortfolioController extends Controller
{
    // GET / : tampilkan halaman (termasuk pencarian & filter project)
    public function index(Request $request)
    {
        return $this->tampil($request);
    }

    // POST / : form kontak -> simpan ke tabel pesan_kontak
    public function kirimPesan(Request $request)
    {
        $formData = ['nama' => '', 'email' => '', 'subjek' => '', 'pesan' => ''];
        $labelForm = ['nama' => 'Nama', 'email' => 'Email', 'subjek' => 'Subjek', 'pesan' => 'Pesan'];
        $formErrors = [];

        foreach ($formData as $field => $value) {
            $formData[$field] = trim((string) $request->input($field, ''));
            if ($formData[$field] === '') {
                $formErrors[$field] = $labelForm[$field] . ' wajib diisi.';
            }
        }
        if ($formData['email'] !== '' && ! filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $formErrors['email'] = 'Format email tidak valid. Contoh: nama@email.com';
        }
        // Batas panjang sesuai kolom database
        foreach (['nama' => 100, 'email' => 100, 'subjek' => 150, 'pesan' => 5000] as $field => $maks) {
            if (! isset($formErrors[$field]) && mb_strlen($formData[$field]) > $maks) {
                $formErrors[$field] = $labelForm[$field] . ' terlalu panjang (maksimal ' . $maks . ' karakter).';
            }
        }

        if ($formErrors) {
            return $this->tampil($request, $formData, $formErrors, 'Mohon lengkapi seluruh field terlebih dahulu.', true);
        }

        DB::table('pesan_kontak')->insert($formData);

        // Redirect agar refresh halaman tidak mengirim pesan dua kali.
        return redirect(route('home', ['status' => 'terkirim']) . '#contact');
    }

    private function tampil(Request $request, array $formData = null, array $formErrors = [], string $pesanSapaan = '', bool $pesanGagal = false)
    {
        $formData ??= ['nama' => '', 'email' => '', 'subjek' => '', 'pesan' => ''];
        if ($pesanSapaan === '' && $request->query('status') === 'terkirim') {
            $pesanSapaan = 'Terima kasih! Pesan Anda telah tersimpan.';
        }

        // ---------- Profil ----------
        $profil = DB::table('profil')->where('id', 1)->first();
        $nama = $profil->nama ?? '';
        [$namaDepan, $namaAksen] = $this->pecahNama($nama);
        $inisial = $this->hurufPertama($namaDepan !== '' ? $namaDepan : $namaAksen)
            . ($namaDepan !== '' ? $this->hurufPertama($namaAksen) : '');

        // ---------- Skills ----------
        $skills = DB::table('skill')->orderBy('id')->get();

        // ---------- Education ----------
        $education = [];
        foreach (DB::table('education')->orderBy('urutan')->orderBy('id')->get() as $e) {
            $adaProgram = (bool) preg_match('/^(D[1-4]|S[1-3])$/i', $e->jenjang);
            $education[] = [
                'nama' => $e->institusi,
                'periode' => $e->tahun_mulai . '–' . ($e->tahun_selesai === null ? 'sekarang' : $e->tahun_selesai),
                'label' => $adaProgram ? 'Program' : 'Jurusan',
                'detail' => $adaProgram ? trim($e->jenjang . ' ' . $e->jurusan) : $e->jurusan,
                'keterangan' => (string) $e->keterangan,
            ];
        }

        // ---------- Experience ----------
        $experiences = [];
        foreach (DB::table('experience')->orderBy('urutan')->orderBy('id')->get() as $x) {
            $poin = preg_split('/\R/u', (string) $x->tanggung_jawab, -1, PREG_SPLIT_NO_EMPTY);
            $poin = array_values(array_filter(array_map('trim', $poin), fn ($t) => $t !== ''));
            $experiences[] = [
                'judul' => $x->organisasi . ($x->jabatan !== '' ? ' — ' . $x->jabatan : ''),
                'periode' => $x->periode,
                'deskripsi' => (string) $x->deskripsi,
                'tanggung_jawab' => $poin,
            ];
        }

        // ---------- Projects (+ pencarian & filter kategori) ----------
        $projects = [];
        foreach (DB::table('projects')->orderBy('id')->get() as $p) {
            $tipe = in_array($p->status_tipe, ['done', 'progress', 'paused'], true) ? $p->status_tipe : 'progress';
            $projects[] = [
                'judul' => $p->nama,
                'kategori' => $p->kategori,
                'tahun' => $p->tahun === null ? null : (int) $p->tahun,
                'deskripsi' => $p->deskripsi,
                'teknologi' => (string) $p->teknologi,
                'link' => $this->urlAman($p->link),
                'status' => $p->status,
                'status_class' => 'status-' . $tipe,
            ];
        }

        $kataKunci = trim((string) $request->query('cari', ''));
        $kategoriDipilih = trim((string) $request->query('kategori', ''));
        $namaPengunjung = trim((string) $request->query('nama', ''));

        $kategoriProject = [];
        foreach ($projects as $project) {
            if (! in_array($project['kategori'], $kategoriProject, true)) {
                $kategoriProject[] = $project['kategori'];
            }
        }
        sort($kategoriProject, SORT_NATURAL | SORT_FLAG_CASE);

        $projectTampil = array_filter($projects, function ($project) use ($kataKunci, $kategoriDipilih) {
            $cocokJudul = $kataKunci === '' || stripos($project['judul'], $kataKunci) !== false;
            $cocokKategori = $kategoriDipilih === '' || $project['kategori'] === $kategoriDipilih;

            return $cocokJudul && $cocokKategori;
        });
        usort($projectTampil, fn ($a, $b) => ($b['tahun'] ?? 0) <=> ($a['tahun'] ?? 0));

        // ---------- Certificates ----------
        $certificates = [];
        foreach (DB::table('certificates')->orderBy('urutan')->orderBy('id')->get() as $c) {
            $certificates[] = [
                'nama' => $c->nama,
                'penyelenggara' => $c->penyelenggara,
                'tahun' => $c->tahun,
                'deskripsi' => (string) $c->deskripsi,
                'link' => $this->urlAman($c->link),
                'ikon' => $c->ikon,
            ];
        }

        // ---------- Kontak ----------
        $kontak = DB::table('kontak')->where('id', 1)->first();
        $instagram = null;
        $whatsapp = null;
        $email = null;
        if ($kontak) {
            $igLink = $this->urlAman($kontak->instagram_link);
            if ($igLink !== '' && $kontak->instagram_username !== '') {
                $instagram = ['href' => $igLink, 'teks' => $kontak->instagram_username];
            }
            $waLink = $this->urlAman($kontak->whatsapp_link);
            $waTeks = $kontak->whatsapp_tampil !== '' ? $kontak->whatsapp_tampil : $kontak->whatsapp_nomor;
            if ($waLink !== '' && $waTeks !== '') {
                $whatsapp = ['href' => $waLink, 'teks' => $waTeks];
            }
            $emLink = $this->urlAman($kontak->email_link, true);
            if ($emLink === '' && $kontak->email_alamat !== '') {
                $emLink = 'mailto:' . $kontak->email_alamat;
            }
            if ($emLink !== '' && $kontak->email_alamat !== '') {
                $email = ['href' => $emLink, 'teks' => $kontak->email_alamat];
            }
        }

        return view('portfolio.index', [
            'profil' => $profil,
            'nama' => $nama,
            'namaDepan' => $namaDepan,
            'namaAksen' => $namaAksen,
            'inisial' => $inisial,
            'statusTeks' => ($profil->status_mahasiswa ?? 1) ? 'Mahasiswa Aktif' : 'Bukan Mahasiswa Aktif',
            'metaDeskripsi' => 'Portofolio ' . $nama . (($profil->prodi ?? '') !== '' ? ', mahasiswa ' . $profil->prodi : '') . '.',
            'skills' => $skills,
            'education' => $education,
            'experiences' => $experiences,
            'projects' => $projects,
            'projectTampil' => $projectTampil,
            'kategoriProject' => $kategoriProject,
            'certificates' => $certificates,
            'instagram' => $instagram,
            'whatsapp' => $whatsapp,
            'email' => $email,
            'kataKunci' => $kataKunci,
            'kategoriDipilih' => $kategoriDipilih,
            'namaPengunjung' => $namaPengunjung,
            'sapaan' => 'Halo, ' . $namaPengunjung . '! Selamat datang di portofolio saya.',
            'formData' => $formData,
            'formErrors' => $formErrors,
            'pesanSapaan' => $pesanSapaan,
            'pesanGagal' => $pesanGagal,
        ]);
    }

    // Pecah nama untuk judul Home: dua kata terakhir tampil berwarna aksen.
    private function pecahNama(string $nama): array
    {
        $kata = preg_split('/\s+/', trim($nama), -1, PREG_SPLIT_NO_EMPTY);
        $n = count($kata);
        if ($n >= 3) {
            return [implode(' ', array_slice($kata, 0, $n - 2)), implode(' ', array_slice($kata, $n - 2))];
        }
        if ($n === 2) {
            return [$kata[0], $kata[1]];
        }

        return ['', $n === 1 ? $kata[0] : ''];
    }

    private function hurufPertama(string $teks): string
    {
        return mb_strtoupper(mb_substr($teks, 0, 1, 'UTF-8'), 'UTF-8');
    }

    // Hanya izinkan tautan http(s) (atau mailto) agar tidak ada javascript: dari data.
    private function urlAman($url, bool $bolehMailto = false): string
    {
        $url = trim((string) $url);
        if (preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }
        if ($bolehMailto && preg_match('/^mailto:/i', $url)) {
            return $url;
        }

        return '';
    }
}
