@extends('layouts.main', ['title' => $title ])

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4>
              <img src="http://localhost:8000/assets/images/logo/j99-logo-wide.png" alt="J99 Logo" height="38" style="opacity: .8">
              <small class="float-right">{{ dateFormat($detailBook->created_at) }}</small>
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-6 invoice-col">
            <p class="lead">Pelanggan</p>
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Nama :</th>
                  <td>{{ $detailBook->customer_name }}</td>
                </tr>
                <tr>
                  <th>Alamat :</th>
                  <td>{{ $detailBook->customer_address }}</td>
                </tr>
                <tr>
                  <th>Email :</th>
                  <td>{{ $detailBook->customer_email }}</td>
                </tr>
                <tr>
                  <th>Telephone :</th>
                  <td>{{ numberSpacer($detailBook->customer_phone)}}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-sm-6 invoice-col">
            <p class="lead">Detail perjalanan</p>
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Tanggal keberangkatan :</th>
                  <td>{{ dateTimeFormat($detailBook->start_date) }}</td>
                </tr>
                <tr>
                  <th>Tanggal pulang :</th>
                  <td>{{ dateTimeFormat($detailBook->finish_date) }}</td>
                </tr>
                <tr>
                  <th>Alamat Penjemputan :</th>
                  <td>{{ $detailBook->pickup_address }}</td>
                </tr>
                <tr>
                  <th>Kota Keberangakatan :</th>
                  <td>{{ $detailBook->city_from }}</td>
                </tr>
                <tr>
                  <th>Kota Tujuan :</th>
                  <td>{{ $detailBook->city_to }}</td>
                </tr>
                <tr>
                  <th>Catatan :</th>
                  <td>{{ $detailBook->notes }}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <p class="lead">Bus</p>
            <table class="table table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Nama bus</th>
                <th>Kelas</th>
                <th>Seat</th>
                <th width="15%">Harga</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($bookbus as $key => $bus)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $bus->name }}</td>
                    <td>{{ $bus->classname }}</td>
                    <td>{{ $bus->seat }}</td>
                    <td>{{ formatAmount($bus->price) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
          </div>
          <!-- /.col -->
          <div class="col-6">
            <p class="lead">Biaya</p>

            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Biaya:</th>
                  <td>{{ formatAmount($detailBook->price) }}</td>
                </tr>
                <tr>
                  <th style="width:50%">Discount:</th>
                  <td>{{ formatAmount($detailBook->discount) }}</td>
                </tr>
                <tr>
                  <th style="width:50%">Pajak:</th>
                  <td>{{ formatAmount($detailBook->tax) }}</td>
                </tr>
                <tr>
                  <th style="width:50%">biaya:</th>
                  <td>{{ formatAmount($detailBook->total_price) }}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
              Payment
            </button>
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
              <i class="fas fa-download"></i> Generate PDF
            </button> --}}
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
 
@endsection
