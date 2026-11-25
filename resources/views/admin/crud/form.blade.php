{{-- Form umum untuk semua menu (tambah, edit, dan form tunggal seperti Profil & Kontak). --}}
@extends('layouts.admin')
@section('title', $judul)
@section('menu', $c['menu'])

@section('content')
    <div class="page-head">
      <div>
        <h1 class="admin-title">{{ $judul }}</h1>
        <p class="admin-sub">{{ $c['deskripsi'] }} Tanda <span style="color:var(--error)">*</span> wajib diisi.</p>
      </div>
    </div>

    <form class="card form-card{{ ! empty($c['sempit']) ? ' form-sempit' : '' }}" method="POST" action="{{ $action }}" novalidate>
      @csrf

      @if ($errors->any())
        <div class="alert alert-error" role="alert">
          @foreach ($errors->all() as $pesanError)
            <div>{{ $pesanError }}</div>
          @endforeach
        </div>
      @endif

      @php $gridTerbuka = false; @endphp
      @foreach ($c['fields'] as $f)
        @php $tipe = $f['type'] ?? 'text'; @endphp

        @if ($tipe === 'section')
          @if ($gridTerbuka) </div> @endif
          <p class="form-section">{{ $f['label'] }}</p>
          <div class="form-grid">
          @php $gridTerbuka = true; @endphp
          @continue
        @endif

        @if (! $gridTerbuka)
          <div class="form-grid">
          @php $gridTerbuka = true; @endphp
        @endif

        @php
          $nama = $f['name'];
          $nilai = old($nama, $values[$nama] ?? '');
        @endphp

        <div class="form-group{{ ! empty($f['full']) ? ' full' : '' }}">
          @if ($tipe === 'checkbox')
            <label>{{ $f['label'] }}</label>
            <div class="check-row">
              <input type="checkbox" id="{{ $nama }}" name="{{ $nama }}" value="1" {{ (session()->hasOldInput() ? (int) old($nama, 0) : (int) ($values[$nama] ?? 1)) === 1 ? 'checked' : '' }}>
              <label for="{{ $nama }}">{{ $f['text'] }}</label>
            </div>
          @else
            <label for="{{ $nama }}">{{ $f['label'] }}@if (! empty($f['required'])) <span class="wajib">*</span>@endif</label>

            @if ($tipe === 'textarea')
              <textarea id="{{ $nama }}" name="{{ $nama }}" rows="{{ $f['rows'] ?? 4 }}">{{ $nilai }}</textarea>
            @elseif ($tipe === 'select')
              <select id="{{ $nama }}" name="{{ $nama }}">
                @foreach ($f['options'] as $kode => $teks)
                  <option value="{{ $kode }}" {{ (string) $nilai === (string) $kode ? 'selected' : '' }}>{{ $teks }}</option>
                @endforeach
              </select>
            @else
              <input type="text" id="{{ $nama }}" name="{{ $nama }}"
                     @if (! empty($f['maxlength'])) maxlength="{{ $f['maxlength'] }}" @endif
                     @if ($tipe === 'number') inputmode="numeric" @endif
                     @if ($tipe === 'datalist') list="daftar-{{ $nama }}" @endif
                     @if (! empty($f['placeholder'])) placeholder="{{ $f['placeholder'] }}" @endif
                     value="{{ $nilai }}">
              @if ($tipe === 'datalist')
                <datalist id="daftar-{{ $nama }}">
                  @foreach ($f['options'] as $opsi)<option value="{{ $opsi }}">@endforeach
                </datalist>
              @endif
            @endif

            @if (! empty($f['hint']))
              <p class="hint">{!! $f['hint'] !!}</p>
            @endif
          @endif
        </div>
      @endforeach
      @if ($gridTerbuka) </div> @endif

      <div class="form-actions">
        <button type="submit" class="btn">{{ $tombol }}</button>
        <a class="btn-ghost" href="{{ $batal }}">Batal</a>
      </div>
    </form>
@endsection
