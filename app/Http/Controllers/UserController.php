<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $this->authorize('view users');
        $users = User::with('roles')->get();
        return inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Users/Create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'roles' => 'array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('users.index');
    }

    // edit, update, show, destroy reviewed later
    public function edit(User $user)
    {
        $this->authorize('edit users');
        $roles = Role::all();
        return inertia('Users/Edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit users');
        $user->update($request->only('name', 'email'));
        $user->syncRoles($request->input('roles'));
        return redirect()->route('users.index');
    }
}
