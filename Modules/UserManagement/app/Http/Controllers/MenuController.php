<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Menu;
use App\Models\Role;

class MenuController extends Controller
{
    public function listMenu()
    {
        $data['title'] = 'Menu';
        $data['list'] = Menu::getMenu();

        return view('usermanagement::menu.index', $data);
    }

    public function addMenu()
    {
        $data['title'] = 'Tambah Menu';
        $data['parents'] = Menu::getMenuParent();
        return view('usermanagement::menu.add', $data);
    }
    
    public function addMenuStore(Request $request)
    {
        $credentials = $request->validate([
            'menuname' => ['required', 'string'],
            'urllink' => ['required', 'string'],
            'module' => ['required', 'string'],
            'parent' => ['required', 'string'],
            'order' => ['required', 'string'],
            'icon' => ['required', 'string'],
        ]);

        $create = Menu::create([
            'title' => $request->menuname,
            'url' => $request->urllink,
            'module' => $request->module,
            'parent_id' => $request->parent,
            'order' => $request->order,
            'icon' => $request->icon,
            'slug' => sluggify($request->menuname),
            'status' => 1,
        ]);

        if ($create) {
            return back()->with('success', 'Menu tersimpan!');
        }

        return back()->with('failed', 'Menu gagal tersimpan!');        
    }
}
