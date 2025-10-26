<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Notifications\UserApproved;
use App\Notifications\UserRejected;
use App\Notifications\CompanyApproved;
use App\Notifications\CompanyRejected;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        $pendingCompanies = Company::where('status', 'pending')->get();

        return view('admin.verifications.index', compact('pendingUsers', 'pendingCompanies'));
    }

    public function approveUser(User $user)
    {
        $user->update(['status' => 'approved']);

        $user->notify(new UserApproved());

        return redirect()->route('admin.verifications.index')->with('success', 'User approved successfully.');
    }

    public function rejectUser(User $user)
    {
        $user->update(['status' => 'rejected']);

        $user->notify(new UserRejected());

        return redirect()->route('admin.verifications.index')->with('success', 'User rejected successfully.');
    }

    public function approveCompany(Company $company)
    {
        $company->update(['status' => 'approved']);

        $company->notify(new CompanyApproved());

        return redirect()->route('admin.verifications.index')->with('success', 'Company approved successfully.');
    }

    public function rejectCompany(Company $company)
    {
        $company->update(['status' => 'rejected']);

        $company->notify(new CompanyRejected());

        return redirect()->route('admin.verifications.index')->with('success', 'Company rejected successfully.');
    }
}