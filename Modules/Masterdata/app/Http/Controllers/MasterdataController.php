<?php

namespace Modules\Masterdata\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MasterData;

class MasterdataController extends Controller
{
    public function listMasterBus()
    {
        $data['title'] = 'Bus';
        $data['list'] = MasterData::getMasterBusList();

        return view('masterdata::bus.index', $data);
    }
}
