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
            'customer'   => ['required', 'string'],
            'bookdate'   => ['required', 'string'],
            'address'    => ['required', 'string'],
            'city_from'  => ['required', 'string'],
            'city_to'    => ['required', 'string'],
        ]);

        $dateRange = explode('-',$request->bookdate);
        $dateFrom = dateTimeRangeFormatToSave($dateRange[0]);
        $dateTo = dateTimeRangeFormatToSave($dateRange[1]);
        $bookingCode = generateCode('JBK');
        $uuid = generateUuid();
        
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
        ];

        $saveBusData = [];
        foreach ($request->bus as $key => $value) {
            $saveBusData[] = [
                'book_uuid' =>  $uuid,
                'bus_uuid' =>  $value,
                'price' =>  numberClearence($request->busPrice[$key]),
            ];
        }
        
        $saveBook = Sale::saveBook($saveData);
        $saveBookBus = Sale::saveBookBus($saveBusData);

        if ($saveBook) {
            return back()->with('success', 'Customer tersimpan!');
        }

        return back()->with('failed', 'Customer gagal tersimpan!');   
    }

    public function editBook($uuid)
    {
        $data['title'] = 'Ubah Reservasi';
        $data['city'] = Sale::getMasterCityList();
        $data['current'] = Sale::getBook($uuid);

        return view('sale::book.edit', $data);
    }

    public function editBookUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'customer_name'   => ['required', 'string'],
            'id_number'       => ['required', 'string'],
            'phone'           => ['required', 'string'],
            'city'            => ['required', 'string'],
            'address'         => ['required', 'string'],
        ]);
        
        $updateData = [
            'name' => $request->customer_name,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'city_uuid' => $request->city,
            'address' => $request->address,
        ];
        
        $updateCustomer = Sale::updateBook($uuid, $updateData);

        if ($updateCustomer) {
            return back()->with('success', 'Customer berhasil diubah!');
        }

        return back()->with('failed', 'Customer gagal diubah!');   
    }

    public function deleteBook($uuid)
    {
        $delete = Sale::removeBook($uuid);

        return back()->with('success', 'Customer terhapus!');
    }
}
