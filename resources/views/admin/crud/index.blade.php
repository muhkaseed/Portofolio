@extends('layouts.admin')
@section('title', $c['judul'])
@section('menu', $c['menu'])

@section('content')
    <div class="page-head">
      <div>
        <h1 class="admin-title">{{ $c['judul'] }}</h1>
        <p class="admin-sub">{{ $c['deskripsi'] }}</p>
      </div>
      <a class="btn" href="{{ route('admin.' . $c['slug'] . '.create') }}"><x-ikon name="plus" />{{ $c['tombolTambah'] }}</a>
    </div>

    <div class="card table-card">
      <table class="data-table">
        <thead>
          <tr>
            <th class="col-no">No</th>
            @foreach ($c['kolom'] as $kolom)
              <th>{{ $kolom[0] }}</th>
            @endforeach
            <th class="col-aksi">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td class="col-no">{{ $loop->iteration }}</td>
              @foreach ($c['kolom'] as $kolom)
                <td data-label="{{ $kolom[0] }}">{!! $kolom[1]($row) !!}</td>
              @endforeach
              <td class="col-aksi">
                <div class="aksi-group">
                  <a class="btn-aksi btn-edit" href="{{ route('admin.' . $c['slug'] . '.edit', $row->id) }}" title="Edit" aria-label="Edit"><x-ikon name="edit" /><span>Edit</span></a>
                  @include('admin.partials.hapus', ['action' => route('admin.' . $c['slug'] . '.destroy', $row->id), 'tanya' => $c['hapusTanya']($row)])
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="{{ count($c['kolom']) + 2 }}" class="kosong">{{ $c['kosong'] }}</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
@endsection
