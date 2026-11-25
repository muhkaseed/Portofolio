{{-- Tombol Hapus dengan konfirmasi. Variabel: $action, $tanya --}}
<form method="POST" action="{{ $action }}" class="form-inline" onsubmit="return confirm({{ \Illuminate\Support\Js::from($tanya) }});">
  @csrf
  <button type="submit" class="btn-aksi btn-hapus" title="Hapus" aria-label="Hapus"><x-ikon name="trash" /><span>Hapus</span></button>
</form>
