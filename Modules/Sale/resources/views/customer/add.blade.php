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
      <div class="col-sm-12">
        <div class="form-group">
          <label for="customer_name">Nama Pelanggan</label>
          <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Masukkan nama pelanggan" value="{{ old('customer_name') }}">
        </div>
        <div class="form-group">
          <label for="id_number">Nomor Identitas</label>
          <input type="text" class="form-control" id="id_number" name="id_number" placeholder="Masukkan nomor identitas" value="{{ old('id_number') }}">
        </div>
        <div class="form-group">
          <label for="phone">Telephone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telephone" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
          <label>Kota</label>
          <select class="form-control select2bs4" name="city" style="width: 100%;">
            @foreach ($city as $cityItem)
                <option value="{{ $cityItem->uuid }}" @selected(old('city') == $cityItem->uuid)>
                    {{ $cityItem->name }}
                </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <textarea class="form-control" name="address" rows="3" placeholder="Masukkan alamat">{{ old('address') }}</textarea>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ url('sale/customer') }}" onclick="return confirm('Anda yakin mau kembali?')" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
 
@endsection