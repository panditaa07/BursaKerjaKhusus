<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserNotification;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create($role = null)
    {
        if (!$role) {
            return view('auth.register_choice');
        }

        $validRoles = ['company', 'user'];
        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        return view('auth.register_' . $role);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request, $role)
    {
        $validRoles = ['company', 'user'];
        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|confirmed|min:8',
        ];

        if ($role === 'user') {
            $rules['nisn'] = 'required|string|max:20|unique:users,nisn';
        } elseif ($role === 'company') {
            $rules['company_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $roleModel = Role::where('name', $role)->first();
        if (!$roleModel) {
            return back()->withErrors(['role' => 'Role tidak ditemukan.']);
        }

        $userData = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $roleModel->id,
            'status'    => 'pending',
        ];

        if ($role === 'user') {
            $userData['nisn'] = $request->nisn;
        } elseif ($role === 'company') {
            $userData['company_name'] = $request->company_name;
        }

        $user = User::create($userData);

        // If registering as company, create company record
        if ($role === 'company') {
            $company = \App\Models\Company::create([
                'user_id' => $user->id,
                'name' => $request->company_name,
                'status' => 'pending',
            ]);
            $user->company_id = $company->id;
            $user->save();
        }

        // Notify admin about new user registration
        $admin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if ($admin) {
            Notification::send($admin, new NewUserNotification($user));
        }

        return redirect('/login')->with('status', 'Akun Anda telah berhasil dibuat dan sedang menunggu persetujuan admin.');
    }
}
