<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        if ($company->logo && file_exists(storage_path('app/public/' . $company->logo))) {
            unlink(storage_path('app/public/' . $company->logo));
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }

    public function verify(Company $company) {
    $company->is_verified = true;
    $company->save();
    // optionally send email to company user
    return back()->with('success','Company verified');
}
}
