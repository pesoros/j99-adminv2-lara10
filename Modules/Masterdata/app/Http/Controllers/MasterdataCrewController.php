<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataCrewController extends Controller
{
    public function listMasterCrew()
    {
        $data['title'] = 'Crew';
        $data['list'] = MasterData::getMasterCrewList();

        return view('masterdata::crew.index', $data);
    }

    public function attendanceMasterCrew($uuid)
    {
        $data['title'] = 'Absensi Crew';
        $data['current'] = MasterData::getMasterCrew($uuid);
        $data['list'] = MasterData::getMasterCrewAttendance($uuid);

        foreach ($data['list'] as $key => $value) {
            if ($value->check_out_time == null) {
                $data['list'][$key]->distance = 0;
            } else {
                $theta = $value->check_in_long - $value->check_out_long;
                $dist = sin(deg2rad($value->check_in_lat)) * sin(deg2rad($value->check_out_lat)) + cos(deg2rad($value->check_in_lat)) * cos(deg2rad($value->check_out_lat)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $km = $miles * 1.609344;
                $data['list'][$key]->distance = round($km, 2);
            }
        }
        return view('masterdata::crew.detail', $data);
    }
}
