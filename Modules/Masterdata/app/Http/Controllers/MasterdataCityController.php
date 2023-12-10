<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataCityController extends Controller
{
    public function listMasterCity()
    {
        $data['title'] = 'Kota';
        $data['list'] = MasterData::getMasterCityList();

        return view('masterdata::city.index', $data);
    }

    public function addMasterCity()
    {
        $data['title'] = 'Tambah Master Kota';
        $data['province'] = MasterData::getMasterProvinceList();

        return view('masterdata::city.add', $data);
    }

    public function addMasterCityStore(Request $request)
    {
        $credentials = $request->validate([
            'city_name'      => ['required', 'string'],
            'province'   => ['required'],
        ]);
        
        $saveData = [
            'uuid' => generateUuid(),
            'name' => $request->city_name,
            'province_uuid' => $request->province,
        ];
        
        $saveCity = MasterData::saveMasterCity($saveData);

        if ($saveCity) {
            return back()->with('success', 'Master kota tersimpan!');
        }

        return back()->with('failed', 'Master kota gagal tersimpan!');   
    }
}
