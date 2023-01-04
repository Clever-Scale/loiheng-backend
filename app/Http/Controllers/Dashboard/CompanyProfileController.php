<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\CompanyProfileResource;

class CompanyProfileController extends Controller
{
    public function index()
    {
        if (session('company-edit')) {
            toast(Session::get('company-edit'), "success");
        }
        $company = CompanyProfileResource::collection(CompanyProfile::get());
        // dd($company);
        $company = $company->first();
        return view('dashboard.company-profile.index', compact('company'));
    }

    public function edit($id)
    {
        $company = CompanyProfile::find($id);
        return view('dashboard.company-profile.edit', compact('company'));
    }

    public function update($id, Request $request)
    {

        $pathEmp = $request->file('image');
        $path= CompanyProfile::where('id', $id)->value('image');
        if($pathEmp){
            if ($request->file()) {
                $fileName = time() . '_' . $request->image->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('User', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
        }


        $data = CompanyProfile::where('id', $id)->update([
            'image' => $path,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('company')->with('company-edit', 'Company profile has been updated successfully.');
    }
}
