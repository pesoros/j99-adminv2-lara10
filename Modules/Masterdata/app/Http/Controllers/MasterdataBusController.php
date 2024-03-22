<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataBusController extends Controller
{
    public function listMasterBus()
    {
        $data['title'] = 'Bus';
        $data['list'] = MasterData::getMasterBusList();

        return view('masterdata::bus.index', $data);
    }

    public function addMasterBus()
    {
        $data['title'] = 'Tambah Master Bus';
        $data['class'] = MasterData::getMasterClassList();

        return view('masterdata::bus.add', $data);
    }

    public function addMasterBusStore(Request $request)
    {
        $credentials = $request->validate([
            'bus_name'              => ['required', 'string'],
            'registration_number'   => ['required', 'string'],
            'brand'                 => ['required', 'string'],
            'model'                 => ['required', 'string'],
            'class_uuid'            => ['required', 'string'],
            'email_bus'             => ['required', 'string'],
        ]);
        
        $saveData = [
            'uuid' => generateUuid(),
            'name' => $request->bus_name,
            'registration_number' => $request->registration_number,
            'brand' => $request->brand,
            'model' => $request->model,
            'class_uuid' => $request->class_uuid,
            'email' => $request->email_bus,
        ];
        
        $saveBus = MasterData::saveMasterBus($saveData);

        if ($saveBus) {
            return back()->with('success', 'Master bus tersimpan!');
        }

        return back()->with('failed', 'Master bus gagal tersimpan!');   
    }

    public function editMasterBus($uuid)
    {
        $data['title'] = 'Edit Master Bus';
        $data['class'] = MasterData::getMasterClassList();
        $data['current'] = MasterData::getMasterBus($uuid);

        return view('masterdata::bus.edit', $data);
    }

    public function editMasterBusUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'bus_name'              => ['required', 'string'],
            'registration_number'   => ['required', 'string'],
            'brand'                 => ['required', 'string'],
            'model'                 => ['required', 'string'],
            'class_uuid'            => ['required', 'string'],
            'email_bus'             => ['required', 'string'],
        ]);
        
        $updateData = [
            'name' => $request->bus_name,
            'registration_number' => $request->registration_number,
            'brand' => $request->brand,
            'model' => $request->model,
            'class_uuid' => $request->class_uuid,
            'email' => $request->email_bus,
            'status' => 1,
        ];
        
        $updateBus = MasterData::updateMasterBus($uuid, $updateData);

        if ($updateBus) {
            return back()->with('success', 'Master bus berhasil diubah!');
        }

        return back()->with('failed', 'Master bus gagal diubah!');   
    }

    public function deleteMasterBus($uuid)
    {
        $delete = MasterData::removeMasterBus($uuid);

        return back()->with('success', 'Master bus terhapus!');
    }
}
