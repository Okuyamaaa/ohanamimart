<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::first();
        return view('admin.company.index', compact('company'));
    }

   
    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'representative' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'resption_hours' => 'required',
            'URL' => 'required',
            'establishment_date' => 'required',
            'business' => 'required',
            'capital' => 'required',
        ]);

        $company->name = $request->input('name');
        $company->representative = $request->input('representative');
        $company->address = $request->input('address');
        $company->phone_number = $request->input('phone_number');
        $company->resption_hours = $request->input('resption_hours');
        $company->URL = $request->input('URL');
        $company->establishment_date = $request->input('establishment_date');
        $company->business = $request->input('business');
        $company->capital = $request->input('capital');
        $company->update();

        return to_route('admin.company.index')->with('flash_message', '会社概要を編集しました。');



  
    }

}
