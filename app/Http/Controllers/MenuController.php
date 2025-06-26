<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin', 'permission:manage users']);
    }

    public function index()
    {
        $menus = Menu::with('submenus')->orderBy('order')->get();
        return inertia('Menus/Index', ['menus' => $menus]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'route' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'integer',
        ]);

        $menu = Menu::create($request->all());
        $menu->roles()->sync($request->input('roles', []));

        event(new \App\Events\MenuUpdated($menu)); // Trigger real-time update

        return redirect()->route('menus.index');
    }
}