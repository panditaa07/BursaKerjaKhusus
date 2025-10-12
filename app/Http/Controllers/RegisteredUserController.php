<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

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
            $rules['nik_nisn'] = 'required|string|unique:users,nik_nisn';
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
        ];

        if ($role === 'user') {
            $userData['nik_nisn'] = $request->nik_nisn;
        } elseif ($role === 'company') {
            $userData['company_name'] = $request->company_name;
        }

        $user = User::create($userData);

        // If registering as company, create company record
        if ($role === 'company') {
            $company = \App\Models\Company::create([
                'user_id' => $user->id,
                'name' => $request->company_name,
                'is_verified' => false, // Default to unverified
            ]);
            $user->company_id = $company->id;
            $user->save();
        }

        // Auto-login after registration
        auth()->login($user);

        // Clear cached route, config, and views to prevent redirection issues
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        // Remove any stale intended url to avoid fallback to /home
        session()->forget('url.intended');

        // Role-based redirect after login
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard.index');
        } elseif ($role === 'company') {
            return redirect()->route('company.dashboard.index');
        } elseif ($role === 'user') {
            return redirect()->route('user.dashboard.index');
        } else {
            auth()->logout();
            return redirect('/login')->withErrors(['role' => 'Role tidak valid.']);
        }
    }
}