<?php

namespace Modules\Sale\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sale;

class SaleCustomerController extends Controller
{
    public function __construct()
    {
        $this->userCategoryList = [
            'Biro',
            'Instansi',
            'User',
            'Lain-lain',
        ];
    }

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
        $data['category'] = $this->userCategoryList;

        return view('sale::customer.add', $data);
    }

    public function addCustomerStore(Request $request)
    {
        $credentials = $request->validate([
            'customer_name'   => ['required', 'string'],
            'customer_email'  => ['required', 'string'],
            'id_number'       => ['required', 'string'],
            'phone'           => ['required', 'string'],
            'city'            => ['required', 'string'],
            'address'         => ['required', 'string'],
            'category'         => ['required', 'string'],
        ]);
        
        $saveData = [
            'uuid' => generateUuid(),
            'name' => $request->customer_name,
            'email' => $request->customer_email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'city_uuid' => $request->city,
            'address' => $request->address,
            'category' => $request->category,
        ];
        
        $saveCustomer = Sale::saveCustomer($saveData);

        if ($saveCustomer) {
            return back()->with('success', 'Customer tersimpan!');
        }

        return back()->with('failed', 'Customer gagal tersimpan!');   
    }

    public function editCustomer($uuid)
    {
        $data['title'] = 'Ubah Customer';
        $data['city'] = Sale::getMasterCityList();
        $data['current'] = Sale::getCustomer($uuid);
        $data['category'] = $this->userCategoryList;

        return view('sale::customer.edit', $data);
    }

    public function editCustomerUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'customer_name'   => ['required', 'string'],
            'customer_email'  => ['required', 'string'],
            'id_number'       => ['required', 'string'],
            'phone'           => ['required', 'string'],
            'city'            => ['required', 'string'],
            'address'         => ['required', 'string'],
            'category'         => ['required', 'string'],
        ]);
        
        $updateData = [
            'name' => $request->customer_name,
            'email' => $request->customer_email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'city_uuid' => $request->city,
            'address' => $request->address,
            'category' => $request->category,
        ];
        
        $updateCustomer = Sale::updateCustomer($uuid, $updateData);

        if ($updateCustomer) {
            return back()->with('success', 'Customer berhasil diubah!');
        }

        return back()->with('failed', 'Customer gagal diubah!');   
    }

    public function deleteCustomer($uuid)
    {
        $delete = Sale::removeCustomer($uuid);

        return back()->with('success', 'Customer terhapus!');
    }
}
