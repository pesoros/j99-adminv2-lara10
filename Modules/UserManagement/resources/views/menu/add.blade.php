@extends('layouts.main', ['title' => $title ])

@section('content')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h5><i class="icon fas fa-ban"></i> Gagal Validasi!</h5>
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
</div>
@endif

@if (session('success'))
  <div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
  {{ session('success') }}
  </div>
@endif

@if (session('failed'))
  <div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
  {{ session('failed') }}
  </div>
@endif
 
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Form {{ $title }}</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form action="{{ url()->current() }}" method="post">
    @csrf
    <div class="card-body row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="menuname">Nama</label>
          <input type="text" class="form-control" id="menuname" name="menuname" placeholder="Masukkan nama menu" value="{{ old('menuname') }}">
        </div>
        <div class="form-group">
          <label for="urllink">Path Url</label>
          <input type="text" class="form-control" id="urllink" name="urllink" placeholder="Masukkan path url menu (ex: parent/child)" value="{{ old('urllink') }}">
        </div>
        <div class="form-group">
          <label for="module">Module</label>
          <input type="text" class="form-control" id="module" name="module" placeholder="Masukkan module menu" value="{{ old('module') }}">
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Parent</label>
          <select class="form-control select2bs4" name="parent" style="width: 100%;">
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent') == $parent)>
                    {{ $parent->title }}
                </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label for="order">Urutan</label>
          <input type="number" class="form-control" id="order" name="order" placeholder="Masukkan urutan menu" value="{{ old('order') }}">
        </div>
        <div class="form-group">
          <label for="icon">Icon - <a target="_blank" href="https://fontawesome.com/icons">klik untuk referensi</a></label>
          <input type="text" class="form-control" id="icon" name="icon" placeholder="Masukkan icon menu" value='<i class="far fa-circle nav-icon"></i>'>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ url('usermanagement/menu') }}" onclick="return confirm('Anda yakin mau kembali?')" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
 
@endsection