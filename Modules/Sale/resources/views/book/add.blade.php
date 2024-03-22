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
          <select class="form-control select2bs4" name="customer" style="width: 100%;" required>
            <option value="">Pilih<option>
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
            <input type="text" class="form-control float-right datepick" id="datetimerangepicker" name="bookdate" value="{{ old('date') }}">
            <div class="input-group-append">
              <span class="input-group-text" id="dayscount">
                2 hari
              </span>
              <input type="hidden" class="form-control" name="dayscount" value="{{ old('dayscount') }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>Alamat Penjemputan</label>
          <textarea class="form-control" name="address" rows="3" placeholder="Masukkan alamat penjemputan">{{ old('address') }}</textarea>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Kota Penjemputan</label>
          <select class="form-control select2bs4" name="city_from" style="width: 100%;" required>
            <option value="">Pilih<option>
            @foreach ($city as $cityItem)
              <option value="{{ $cityItem->uuid }}" @selected(old('city_from') == $cityItem->uuid)>
                {{ $cityItem->name }}
              </option>
            @endForeach
          </select>
        </div>
        <div class="form-group">
          <label>Kota Tujuan</label>
          <select class="form-control select2bs4" name="city_to" style="width: 100%;" required>
            <option value="">Pilih<option>
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
      <div class="col-sm-6">
        <div class="form-group">
          <label for="bus">Bus</label>
          <div id="busForm">
            <div class="row">
              <div class="col-sm-6">
                <select class="form-control select2bs4" name="bus[]" style="width: 100%;" required>
                  <option value="">Pilih<option>
                  @foreach ($bus as $busItem)
                      <option value="{{ $busItem->uuid }}" @selected(old('bus[]') == $busItem->uuid)>
                          {{ $busItem->name }} | {{ $busItem->class }} | {{ $busItem->seat }} Kursi
                      </option>
                  @endForeach
                </select>
              </div>
              <div class="col-sm-4">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" class="form-control moneyform busprice businput_1" name="busPrice[]" placeholder="Masukkan harga bus" required>
                </div>
              </div>
              <div class="col-sm-2">
                <a type="button" id="addRow" class="btn btn-success">Tambah</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="price">Biaya</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="price" placeholder="0" readonly>
          </div>
        </div>
        <div class="form-group">
          <label for="discount">Diskon</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="discount" placeholder="0">
          </div>
        </div>
        <div class="form-group">
          <label for="tax">PPN 11%</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="tax" placeholder="0" readonly>
            <div class="input-group-append">
              <span class="input-group-text">
                <input type="checkbox" name="hasTax" id="taxcheckbox" checked>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="total_price">Total Biaya</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="total_price" placeholder="0" readonly>
          </div>
        </div>
        <div class="form-group">
          <label for="downpayment">Uang Muka</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="downpayment" placeholder="0" required>
          </div>
        </div>
        <div class="form-group">
          <label for="finalpayment">Pelunasan</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" class="form-control moneyform" name="finalpayment" placeholder="0">
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="card-footer">
      <button type="submit" onclick="return confirm('Anda yakin data sudah benar?')" class="btn btn-primary">Submit</button>
      <a href="{{ url('sale/book') }}" onclick="return confirm('Anda yakin mau kembali?')" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
 
@endsection

@push('extra-scripts')
<script type="text/javascript">
    $(function () {
      const busData = {!!json_encode($bus)!!};
      let rowCount = 1;
      
      $('#addRow').click(function(){
        let html = '';
        rowCount++;
        html += '<div class="row" id="busrow_'+ rowCount +'"><div class="col-sm-6"><select class="form-control select2bs4" name="bus[]" style="width: 100%;">';
        for (let index = 0; index < busData.length; index++) {
          html += '<option value="' + busData[index].uuid + '">' + busData[index].name + ' | ' + busData[index].class + ' | ' + busData[index].seat + ' Kursi</option>';
        }
        html += '</select></div><div class="col-sm-4"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Rp</span>';
        html += '</div><input type="text" class="form-control moneyform busprice businput_'+ rowCount +'" name="busPrice[]" placeholder="Masukkan harga bus" required></div></div><div class="col-sm-1">';
        html += '<a type="button" id="'+ rowCount +'" class="btn btn-danger removeRow">Hapus</a>';
        $('#busForm').append(html);
        $('.businput_' + rowCount).mask('000.000.000', {reverse: true});
        $('.businput_' + rowCount).change(function(){
          triggerPrice()
        });
        $('.select2bs4:last').select2({
          theme: 'bootstrap4'
        });
      });

      $('.businput_1').change(function(){
        triggerPrice()
      });

      $('input[name="discount"]').change(function(){
        triggerPrice()
      });

      $('#taxcheckbox').change(function(){
        triggerPrice()
      });

      $('.datepick').change(function(){
        const dateCombine = $(this).val().split("-");
        
        let dateA = dateCombine[0].trim();
        dateA = dateA.split("/");
        dateA = new Date(dateA[2].slice(0, 4), dateA[1] - 1, dateA[0]);

        let dateB = dateCombine[1].trim();
        dateB = dateB.split("/");
        dateB = new Date(dateB[2].slice(0, 4), dateB[1] - 1, dateB[0]);

        var milli_secs = dateA.getTime() - dateB.getTime();
        var days = milli_secs / (1000 * 3600 * 24);

        const diff = Math.round(Math.abs(days)) + 1;
        $("#dayscount").html(diff + " hari");
        $('input[name="dayscount"]').val(diff);
      });

      $(document).on('click', '.removeRow', function(){
        var button_id = $(this).attr("id"); 
        $('#busrow_'+button_id+'').remove();
      });

      function triggerPrice(){
        let sum = 0;
        $('.busprice').each(function(){
            const value = $(this).val().length !== 0 ? $(this).val().replace(/\D/g,'') : 0;
            sum += parseFloat(value);
        });
        const discount = $('input[name="discount"]').val().length !== 0 ? $('input[name="discount"]').val().replace(/\D/g,'') : 0;
        const price = sum - parseFloat(discount);
        const tax = $('#taxcheckbox').is(":checked") === true ? (price * (11 / 100)) : 0;
        const total = price + tax;

        $('input[name="price"]').val(sum);
        $('input[name="price"]').mask('000.000.000', {reverse: true});
        $('input[name="tax"]').val(tax);
        $('input[name="tax"]').mask('000.000.000', {reverse: true});
        $('input[name="total_price"]').val(total);
        $('input[name="total_price"]').mask('000.000.000', {reverse: true});
      }

      // prevent enter
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    });
</script>
@endpush
