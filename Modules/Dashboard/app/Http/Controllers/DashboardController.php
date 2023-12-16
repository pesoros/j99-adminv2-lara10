<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';

        $bus = Dashboard::getDashBusList();

        foreach ($bus as $key => $value) {
            $busAgenda = Dashboard::getDashBusAgenda($value->uuid);
            $value->agenda = $busAgenda;
        }

        $row = [];
        foreach ($bus as $key => $value) {
            $row[] = '&nbsp;&nbsp;<label>'.$value->name.'</label>&nbsp;&nbsp;';
        }

        $data['busAgenda'] = $bus;
        $data['busRow'] = $row;

        return view('dashboard::dashboard.index', $data);
    }
}
