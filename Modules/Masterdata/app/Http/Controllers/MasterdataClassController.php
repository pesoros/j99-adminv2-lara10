<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataClassController extends Controller
{
    public function listMasterClass()
    {
        $data['title'] = 'Kelas';
        $data['list'] = MasterData::getMasterClassList();

        return view('masterdata::class.index', $data);
    }

    public function addMasterClass()
    {
        $data['title'] = 'Tambah Master Kelas';
        $data['facilities'] = MasterData::getMasterFacilitiesList();

        return view('masterdata::class.add', $data);
    }

    public function addMasterClassStore(Request $request)
    {
        $credentials = $request->validate([
            'class_name'      => ['required', 'string'],
            'seat_count'   => ['required'],
        ]);
        
        $saveData = [
            'uuid' => generateUuid(),
            'name' => $request->class_name,
            'seat' => $request->seat_count,
        ];
        
        $saveClassId = MasterData::SaveMasterClass($saveData);
        $getClass = MasterData::getMasterClass($saveData['uuid']);

        foreach ($request->facilities as $key => $value) {
            $data[$key]['class_id'] = $getClass->id;
            $data[$key]['facilities_id'] = $value;
        }

        $saveClassFacilities = MasterData::saveClassFacilities($data);

        if ($saveClassId) {
            return back()->with('success', 'Master kelas tersimpan!');
        }

        return back()->with('failed', 'Master kelas gagal tersimpan!');   
    }

    public function editMasterClass($uuid)
    {
        $data['title'] = 'Edit Master Class';
        $data['current'] = MasterData::getMasterClass($uuid);
        $data['facilities'] = MasterData::getMasterFacilitiesList();
        $data['limit'] = MasterData::getClassLimit($uuid);
        $tempSelected = MasterData::getMasterClassFacilities($data['current']->id);
        $data['selectedFacilities'] = [];
        foreach ($tempSelected as $key => $value) {
            $data['selectedFacilities'][$key] = intval($value->facilities_id);
        }

        return view('masterdata::class.edit', $data);
    }

    public function editMasterClassUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'class_name'      => ['required', 'string'],
            'seat_count'   => ['required'],
        ]);
        
        $updateData = [
            'name' => $request->class_name,
            'seat' => $request->seat_count,
        ];

        $getClassId = MasterData::getMasterClass($uuid);
        $classId = $getClassId->id;

        $updateClassFacilities = [];
        foreach ($request->facilities as $key => $value) {
            $updateClassFacilities[] = [
                'class_id' =>  $classId,
                'facilities_id'  =>  $value,
            ];
        }

        $updateClass = MasterData::updateMasterClass($uuid, $updateData);
        $removeClassFacilities = MasterData::removeClassFacilities($classId);
        $saveClassFacilities = MasterData::saveClassFacilities($updateClassFacilities);

        // if ($updateClass) {
        //     return back()->with('success', 'Master kelas berhasil diubah!');
        // }

        return back()->with('failed', 'Master kelas gagal diubah!');   
    }
    
    public function deleteMasterClass($uuid)
    {
        $checkContains = MasterData::checkClassContains($uuid);

        if (count($checkContains) > 0) {
            return back()->with('failed', 'Masih ada kelas yang dipakai oleh Master kelas');
        }

        $getClassId = MasterData::getMasterClass($uuid);
        $classId = $getClassId->id;
        $removeClassFacilities = MasterData::removeClassFacilities($classId);
        $delete = MasterData::removeMasterClass($uuid);

        if ($delete) {
            return back()->with('success', 'Master kelas berhasil terhapus!');
        }

        return back()->with('success', 'Master kelas gagal terhapus!');
    }

    public function addMasterClassLimit(Request $request, $uuid) {
        $credentials = $request->validate([
            'limit_count'      => ['required'],
            'limit_date'   => ['required'],
        ]);

        $date = explode('/', $request->limit_date);

        // echo("<script>console.log('PHP: " . json_encode($date) . "');</script>");

        $data = [
            'class_uuid' => $uuid,
            'month' => $date[0],
            'year' => $date[1],
            'limit' => $request->limit_count,
        ];

        $saveLimit = MasterData::saveMasterClassLimit($data);

        if ($saveLimit) {
            return back()->with('success', 'Master limit kelas berhasil ditambah!');
        }

        return back()->with('failed', 'Master limit kelas gagal ditambah!'); 
    }

    public function deleteMasterClassLimit($id) {

        $delete = MasterData::removeMasterClassLimit($id);

        if ($delete) {
            return back()->with('success', 'Master limit kelas berhasil terhapus!');
        }

        return back()->with('success', 'Master limit kelas gagal terhapus!');
    }
}
