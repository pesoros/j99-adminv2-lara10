@extends('layouts.main', ['title' => $title ])

@section('content')
 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List {{ $title }}</h3>
        <div class="float-right">
            <a href="{{ url('usermanagement/account/add') }}" class="btn bg-gradient-primary btn-sm">Tambah data</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="datatable-def" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($list as $value)
            <tr>
              <td>{{ $value->name }}</td>
              <td>{{ $value->email }}</td>
              <td>
                <div class="btn-group btn-block">
                  <a href="#" class="btn btn-success btn-sm"><i class="fa fa-success"></i> Edit</a>
                  <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-danger"></i> Hapus</a>
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