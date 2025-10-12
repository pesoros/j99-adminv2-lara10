@extends('layouts.main', ['title' => $title ])

@section('content')

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

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4>
              <img src="{{asset('assets/images/logo/j99-logo-wide.png')}}" alt="J99 Logo" height="70" style="opacity: .8">
              <small class="float-right">Kode Booking: {{ $detailBook->booking_code }}<br>Tanggal: {{ dateFormat($detailBook->created_at) }}</small>
              <small class="float-right"></small>
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <br>
        <br>
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
                  <th style="width:50%">Total Biaya:</th>
                  <td>{{ formatAmount($detailBook->total_price) }}</td>
                </tr>
              </table>

              <p class="lead">Pembayaran</p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Uang Muka:</th>
                    <td>{{ formatAmount($detailBook->down_payment) }}</td>
                  </tr>
                  @if ($detailBook->final_payment > 0)
                  <tr>
                    <th style="width:50%">Pelunasan:</th>
                    <td>{{ formatAmount($detailBook->final_payment) }}</td>
                  </tr>
                  @endif
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>

        <div class="etc-section">
          <br>
          <hr>
          <br>
        </div>

        <!-- t&c column -->
        <div class="row tnc-section">
          <div class="col-12 tnc-place">
            <p>Maka dengan ini akan memenuhi syarat dan ketentuan sebagai berikut:</p>
            <ol>
              <li>Harga sewa diatas termasuk: BBM, Driver & Assistant Driver selama perjalanan;</li>
              <li>Harga sewa diatas belum termasuk: biaya parkir, biaya tol, kapal ferry, dll. Armada & akomodasi lain akan dibebankan kepada penyewa;</li>
              <li>Harga yang tercantum dalam Surat Pemesanan ini bersifat tetap dan mengikat, kecuali terjadi perubahan harga BBM dari Pemerintah;</li>
              <li>Apabila tidak dilakukan pembayaran tanda jadi sampai dengan tanggal jatuh tempo, maka booking sewa Bus dianggap batal;</li>
              <li>Reschedule maksimal di lakukan 4 (empat) hari sebelum tanggal keberangkatan dengan dikenakan Reschedule fee 15% dari total harga sewa;</li>
              <li>Reschedule tanpa biaya paling lambat dilakukan 14 (empat belas) hari sebelum tanggal keberangkatan dan hanya berlaku 1 (satu) kali serta dapat digunakan dalam jangka waktu 1 (satu) tahun; (ketentuan dan syarat berlaku);</li>
              <li>Seluruh pembayaran yang sudah dilakukan tidak dapat ditarik kembali oleh sebab apapun;</li>
              <li>Surat Pemesanan ini Bukan merupakan Bukti Pembayaran;</li>
              <li>Surat pemesanan ini dianggap Sah, apabila kedua belah Pihak;</li>
              <li>Pembayaran baru dianggap Sah apabila:(1)Ada bukti transfer dari penyewa, dan/atau, (2)Ada kuitansi yang dikeluarkan oleh Bagian Keuangan PT. Gilang Sembilan Sembilan;</li>
              <li>Pembayaran dianggap Sah apabila melalui transfer pembayaran melalui virtual account yang tertera pada Invoice yang dikeluarkan oleh Bagian Keuangan PT. Gilang Sembilan Sembilan;</li>
            </ol>
          </div>
        </div>

        <div class="etc-section">
          <br>
          <br>
        </div>

        <!-- date column -->
        <div class="row date-section">
          <div class="col-12 date-place">
            <p>Malang, _______________</p>
          </div>
        </div>

        <div class="etc-section">
          <br>
          <br>
        </div>

        <!-- signature column -->
        <div class="row signature-section">
          <div class="col-5 signature-place">
            <p>Sales Pariwisata</p>
            <p>Juragan 99 Trans</p>
          </div>
          <div class="col-5 signature-place">
            <p>Pemesan / Penyewa</p>
          </div>
        </div>

        <br>
        <br>


        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <a href="#" rel="noopener" target="_blank" class="btn btn-default printPage"><i class="fas fa-print"></i> Print</a>
            {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
              Payment
            </button>
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
              <i class="fas fa-download"></i> Generate PDF
            </button> --}}
          </div>
        </div>


        <!-- /.invoice -->
      </div><!-- /.col -->

      <div class="invoice p-3 mb-3">
        <div class="row">
          <div class="col-12">
            <p class="lead">Manajemen Pembayaran</p>
            <div class="row">
              <div class="col-12">
                <form action="{{ url('sale/book/add-payment/'.$detailBook->uuid) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Nominal</label>
                    <input type="text" name="amount" id="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Deskripsi</label>
                    <input type="text" name="description" id="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">File</label>
                    <input type="file" name="file" id="" class="form-control">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
              <div class="col-12">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nominal</th>
                      <th>Deskripsi</th>
                      <th>File</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($bookpayment as $key => $payment)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ formatAmount($payment->amount) }}</td>
                      <td>{{ $payment->description }}</td>
                      <td><a href="{{ asset($payment->file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="1">Total</th>
                      <th colspan="3">{{ formatAmount($totalpayment) }}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.row -->
  </div>

  @endsection
  @push('extra-scripts')
  <script type="text/javascript">
    $(function() {
      $('a.printPage').click(function() {
        window.print();
        return false;
      });
    });
  </script>
  @endpush