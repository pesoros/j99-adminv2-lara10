<?php

namespace Modules\Sale\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sale;

class SaleCustomerController extends Controller
{
    public function listCustomer()
    {
        $data['title'] = 'Customer';
        $data['list'] = Sale::getCustomerList();

        return view('sale::customer.index', $data);
    }

    public function addCustomer()
    {
        $data['title'] = 'Tambah Customer';
        $data['city'] = Sale::getMasterCityList();

        return view('sale::customer.add', $data);
    }

    public function addCustomerStore(Request $request)
    {
        $credentials = $request->validate([
            'customer_name'   => ['required', 'string'],
            'id_number'       => ['required', 'string'],
            'phone'           => ['required', 'string'],
            'city'            => ['required', 'string'],
            'address'         => ['required', 'string'],
        ]);
        
        $saveData = [
            'uuid' => generateUuid(),
            'name' => $request->customer_name,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'city_uuid' => $request->city,
            'address' => $request->address,
        ];
        
        $saveCustomer = Sale::SaveCustomer($saveData);

        if ($saveCustomer) {
            return back()->with('success', 'Customer tersimpan!');
        }

        return back()->with('failed', 'Customer gagal tersimpan!');   
    }
}