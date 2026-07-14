<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function __construct()
    {
        // Restrict all actions in this controller to super_admin only
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'super_admin') {
                abort(403, 'Unauthorized action. Only Super Admins can manage administrators.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $admins = Admin::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,staff',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'type' => 'internal',
                'status' => 1,
            ]);

            // 2. Create Admin profile
            Admin::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => ucfirst(str_replace('_', ' ', $validated['role'])),
            ]);
        });

        return redirect()->route('admin.admins.index')->with('success', 'Administrator created successfully.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.form', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $user = $admin->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id ?? null),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,staff',
        ]);

        DB::transaction(function () use ($validated, $admin, $user) {
            // Update User
            if ($user) {
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->role = $validated['role'];
                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }
                $user->save();
            }

            // Update Admin profile
            $admin->name = $validated['name'];
            $admin->email = $validated['email'];
            $admin->role = ucfirst(str_replace('_', ' ', $validated['role']));
            if (!empty($validated['password'])) {
                $admin->password = Hash::make($validated['password']);
            }
            $admin->save();
        });

        return redirect()->route('admin.admins.index')->with('success', 'Administrator updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Prevent deleting yourself
        if ($admin->user_id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        DB::transaction(function () use ($admin) {
            if ($admin->user) {
                $admin->user->delete();
            }
            $admin->delete();
        });

        return redirect()->route('admin.admins.index')->with('success', 'Administrator deleted successfully.');
    }
}
