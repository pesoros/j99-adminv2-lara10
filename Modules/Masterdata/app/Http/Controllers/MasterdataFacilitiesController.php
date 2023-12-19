<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataFacilitiesController extends Controller
{
    public function listMasterFacilities()
    {
        $data['title'] = 'Facilities';
        $data['list'] = MasterData::getMasterFacilitiesList();

        return view('masterdata::facilities.index', $data);
    }

    public function addMasterFacilities()
    {
        $data['title'] = 'Tambah Master Facilities';

        return view('masterdata::facilities.add', $data);
    }

    public function addMasterFacilitiesStore(Request $request)
    {
        $credentials = $request->validate([
            'facility_name'      => ['required', 'string'],
        ]);
        
        $data = [
            'uuid' => generateUuid(),
            'name' => $request->facility_name,
        ];

        $save = MasterData::saveMasterFacilities($data);

        if ($save) {
            return back()->with('success', 'Master fasilitas tersimpan!');
        }

        return back()->with('failed', 'Master fasilitas gagal tersimpan!');   
    }

    public function editMasterFacilities($uuid)
    {
        $data['title'] = 'Edit Master Facilities';
        $data['current'] = MasterData::getMasterFacilities($uuid);

        return view('masterdata::facilities.edit', $data);
    }

    public function editMasterFacilitiesUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'facility_name' => ['required', 'string'],
        ]);
        
        $updateData = [
            'name' => $request->facility_name,
        ];
        
        $updateFacilities = MasterData::updateMasterFacilities($uuid, $updateData);

        if ($updateFacilities) {
            return back()->with('success', 'Master fasilitas berhasil diubah!');
        }

        return back()->with('failed', 'Master fasilitas gagal diubah!');   
    }
    
    public function deleteMasterFacilities($uuid)
    {
        $checkContains = MasterData::checkFacilitiesContains($uuid);

        if (count($checkContains) > 0) {
            return back()->with('failed', 'Masih ada fasilitas yang dipakai oleh Master kelas');
        }

        $delete = MasterData::removeMasterFacilities($uuid);

        return back()->with('success', 'Master fasilitas terhapus!');
    }
}
