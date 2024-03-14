<?php

namespace Modules\Sale\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sale;
use App\Models\MasterData;

class SaleBookController extends Controller
{
    public function listBook()
    {
        $data['title'] = 'Reservasi';
        $data['list'] = Sale::getBookList();

        return view('sale::book.index', $data);
    }

    public function addBook()
    {
        $data['title'] = 'Tambah Reservasi';
        $data['customer'] = Sale::getCustomerList();
        $data['city'] = Sale::getMasterCityList();
        $data['bus'] = MasterData::getMasterBusList();

        return view('sale::book.add', $data);
    }

    public function addBookStore(Request $request)
    {
        $credentials = $request->validate([
            'customer'      => ['required', 'string'],
            'bookdate'      => ['required', 'string'],
            'address'       => ['required', 'string'],
            'city_from'     => ['required', 'string'],
            'city_to'       => ['required', 'string'],
            'downpayment'   => ['required', 'string'],
        ]);

        $dateRange = explode('-',$request->bookdate);
        $dateFrom = dateTimeRangeFormatToSave($dateRange[0]);
        $dateTo = dateTimeRangeFormatToSave($dateRange[1]);
        $bookingCode = generateCode('JBK');
        $uuid = generateUuid();
        $finalPayment = numberClearence($request->total_price) - numberClearence($request->downpayment);
        
        $saveData = [
            'uuid'                  => $uuid,
            'booking_code'          => $bookingCode,
            'customer_uuid'         => $request->customer,
            'start_date'            => $dateFrom,
            'finish_date'           => $dateTo,
            'days_count'            => $request->dayscount,
            'pickup_address'        => $request->address,
            'departure_city_uuid'   => $request->city_from,
            'destination_city_uuid' => $request->city_to,
            'notes'                 => $request->notes,
            'price'                 => numberClearence($request->price),
            'discount'              => $request->discount ? numberClearence($request->discount) : 0,
            'tax'                   => numberClearence($request->tax),
            'total_price'           => numberClearence($request->total_price),
            'booked_by'             => auth()->user()->uuid,
            'down_payment'          => numberClearence($request->downpayment),
            'final_payment'         => $finalPayment,
        ];

        $saveBusData = [];
        foreach ($request->bus as $key => $value) {
            $saveBusData[] = [
                'book_uuid' =>  $uuid,
                'bus_uuid'  =>  $value,
                'price'     =>  numberClearence($request->busPrice[$key]),
            ];
        }
        
        $saveBook = Sale::saveBook($saveData);
        $saveBookBus = Sale::saveBookBus($saveBusData);

        if ($saveBook) {
            return back()->with('success', 'Booking tersimpan!');
        }

        return back()->with('failed', 'Booking gagal tersimpan!');   
    }

    public function editBook($uuid)
    {
        $data['title'] = 'Ubah Reservasi';
        $data['city'] = Sale::getMasterCityList();
        $data['current'] = Sale::getBook($uuid);
        $data['bus'] = MasterData::getMasterBusList();
        $data['bookbus'] = Sale::getBookBus($uuid);
        $data['datedata'] = dateRangeFormFormat($data['current']->start_date, $data['current']->finish_date);

        return view('sale::book.edit', $data);
    }

    public function editBookUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'bookdate'   => ['required', 'string'],
            'address'    => ['required', 'string'],
            'city_from'  => ['required', 'string'],
            'city_to'    => ['required', 'string'],
            'downpayment'   => ['required', 'string'],
        ]);

        $dateRange = explode('-',$request->bookdate);
        $dateFrom = dateTimeRangeFormatToSave($dateRange[0]);
        $dateTo = dateTimeRangeFormatToSave($dateRange[1]);
        $finalPayment = numberClearence($request->total_price) - numberClearence($request->downpayment);
        
        $updateData = [
            'start_date'            => $dateFrom,
            'finish_date'           => $dateTo,
            'days_count'            => $request->dayscount,
            'pickup_address'        => $request->address,
            'departure_city_uuid'   => $request->city_from,
            'destination_city_uuid' => $request->city_to,
            'notes'                 => $request->notes,
            'price'                 => numberClearence($request->price),
            'discount'              => $request->discount ? numberClearence($request->discount) : 0,
            'tax'                   => numberClearence($request->tax),
            'total_price'           => numberClearence($request->total_price),
            'updated_by'             => auth()->user()->uuid,
            'down_payment'          => numberClearence($request->downpayment),
            'final_payment'         => $finalPayment,
        ];

        $updateBusData = [];
        foreach ($request->bus as $key => $value) {
            $updateBusData[] = [
                'book_uuid' =>  $uuid,
                'bus_uuid'  =>  $value,
                'price'     =>  numberClearence($request->busPrice[$key]),
            ];
        }
        
        $updateBook = Sale::updateBook($uuid, $updateData);
        $removeBookBus = Sale::removeBookBus($uuid);
        $saveBookBus = Sale::saveBookBus($updateBusData);

        if ($updateBook) {
            return back()->with('success', 'Booking berhasil diubah!');
        }

        return back()->with('failed', 'Booking gagal diubah!');   
    }

    public function deleteBook($uuid)
    {
        $delete = Sale::removeBook($uuid);

        return back()->with('success', 'Booking terhapus!');
    }

    public function detailBook(Request $request, $uuid)
    {
        $data['title'] = 'Detail Reservasi';
        $data['detailBook'] = Sale::getBook($uuid);
        $data['bookbus'] = Sale::getBookBus($uuid);

        return view('sale::book.detail', $data);
    }
}
