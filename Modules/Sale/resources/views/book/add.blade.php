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
          <label>Pelanggan</label>
          <select class="form-control select2bs4" name="customer" style="width: 100%;">
            @foreach ($customer as $customerItem)
                <option value="{{ $customerItem->uuid }}" @selected(old('city_from') == $customerItem->uuid)>
                    {{ $customerItem->name }}
                </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label>Tanggal</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="far fa-calendar-alt"></i>
              </span>
            </div>
            <input type="text" class="form-control float-right" id="datetimerangepicker" name="bookdate" value="{{ old('date') }}">
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group">
          <label>Alamat Penjemputan</label>
          <textarea class="form-control" name="address" rows="3" placeholder="Masukkan alamat penjemputan">{{ old('address') }}</textarea>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Kota Penjemputan</label>
          <select class="form-control select2bs4" name="city_from" style="width: 100%;">
            @foreach ($city as $cityItem)
            <option value="{{ $cityItem->uuid }}" @selected(old('city_from') == $cityItem->uuid)>
              {{ $cityItem->name }}
            </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label>Kota Tujuan</label>
          <select class="form-control select2bs4" name="city_to" style="width: 100%;">
            @foreach ($city as $cityItem)
            <option value="{{ $cityItem->uuid }}" @selected(old('city_to') == $cityItem->uuid)>
              {{ $cityItem->name }}
            </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label>Catatan</label>
          <textarea class="form-control" name="notes" rows="3" placeholder="Masukkan catatan jika ada">{{ old('notes') }}</textarea>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ url('sale/book') }}" onclick="return confirm('Anda yakin mau kembali?')" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
 
@endsection