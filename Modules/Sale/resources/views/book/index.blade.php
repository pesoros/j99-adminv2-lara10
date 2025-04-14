@extends('layouts.main', ['title' => $title ])

@section('content')
 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List {{ $title }}</h3>
        <div class="float-right">
          @if (permissionCheck('add'))
            <a href="{{ url('sale/book/add') }}" class="btn bg-gradient-primary btn-sm">Tambah data</a>
          @endif
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="datatable-def-custom" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>Kode Booking</th>
          <th>Nama Pelanggan</th>
          <th>Kota</th>
          <th>Tanggal Penjemputan</th>
          <th>Tanggal Kembali</th>
          <th>Total Harga</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($list as $key => $value)
            <tr>
              <td width="20" class="text-center">{{ intval($key) + 1 }}</td>
              <td>{{ $value->booking_code }}</td>
              <td>{{ $value->customer_name }}</td>
              <td>{{ $value->city_from }} - {{ $value->city_to }}</td>
              <td>{{ dateTimeFormat($value->start_date) }}</td>
              <td>{{ dateTimeFormat($value->finish_date) }}</td>
              <td>Rp. {{ number_format($value->total_price, 0) }}</td>
              <td>
                <div class="btn-group btn-block">
                  @if (permissionCheck('show')) <a href="{{ url('sale/book/show/detail/'.$value->uuid) }}" class="btn btn-warning btn-sm">Detail</a> @endif
                  @if (permissionCheck('edit')) <a href="{{ url('sale/book/edit/'.$value->uuid) }}" class="btn btn-success btn-sm">Edit</a> @endif
                  @if (permissionCheck('delete')) <a href="{{ url('sale/book/delete/'.$value->uuid) }}" onclick="return confirm('Anda yakin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a> @endif
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