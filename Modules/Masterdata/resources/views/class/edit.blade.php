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
          <label for="class_name">Nama Kelas</label>
          <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Masukkan nama kelas" value="{{ $current->name }}">
        </div>
        <div class="form-group">
          <label for="seat_count">Jumlah kursi</label>
          <input type="number" class="form-control" id="seat_count" name="seat_count" placeholder="Masukkan nama kelas" value="{{ $current->seat }}">
        </div>
        <div class="form-group">
          <label>Fasilitas</label>
          <select class="select2 select2-hidden-accessible" multiple="multiple" name="facilities[]" data-placeholder="Pilih fasilitas" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
            @foreach ($facilities as $facility)
              @if(in_array($facility->id, $selectedFacilities))
              <option value="{{ $facility->id }}" selected>
                  {{ $facility->name }}
              </option>
              @else
              <option value="{{ $facility->id }}">
                  {{ $facility->name }}
              </option>
              @endif 

            @endForeach
          </select>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ url('masterdata/class') }}" onclick="return confirm('Anda yakin mau kembali?')" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Max Penggunaan Unit Kelas {{ $current->name }}</h3>
    </div>
    <form action="{{ url('masterdata/class/add/limit') }}/{{ $current->uuid }}" method="post">
      @csrf
      <div class="card-body row">
        <div class="col-sm-2">
          <div class="form-group">
            <label for="limit_count">Max Penggunaan Unit</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="number" class="form-control" id="limit_count" name="limit_count" placeholder="Masukkan Limit Penggunaan Unit">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <input type="text" class="form-control" id="monthyearpicker" name="limit_date">
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </form>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="datatable-def" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>Limit Penggunaan Unit</th>
          <th>Bulan</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($limit as $key => $value)
            <tr>
              <td width="20" class="text-center">{{ intval($key) + 1 }}</td>
              <td>{{ $value->limit }}</td>
              <td>{{ $value->month }}</td>
              <td>{{ $value->year }}</td>
              <td>
                <div class="btn-group btn-block">
                  @if (permissionCheck('delete')) <a href="{{ url('masterdata/class/delete/limit/'.$value->id) }}" onclick="return confirm('Anda yakin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a> @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
 
@endsection