<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function index()
    {
        if (session('brand-create')) {
            toast(Session::get('brand-create'), "success");
        }
        if (session('brand-delete')) {
            toast(Session::get('brand-delete'), "success");
        }
        if (session('brand-update')) {
            toast(Session::get('brand-update'), "success");
        }
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $path = '';
        if ($request->file()) {
            $fileName = time() . '_' . $request->picture->getClientOriginalName();
            $filePath = $request->file('picture')->storeAs('Brand', $fileName, 'public');
            $path = '/storage/' . $filePath;
        }

        Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $path,
            'is_active' => $request->is_active,
            'created_by' => $request->created_by,
        ]);
        return redirect()->route('brand')->with('brand-create', "Brand has been created Successfully!");
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('dashboard.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $barnd = Brand::find($id);
        $this->validate($request, [
            'name' => 'required',
        ]);


        // dd($request->role_id);
        $pathEmp = $request->file('picture');
        $path= Brand::where('id', $id)->value('picture');
        if($pathEmp){
            if ($request->file()) {
                $fileName = time() . '_' . $request->picture->getClientOriginalName();
                $filePath = $request->file('picture')->storeAs('Brand', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
        }

        Brand::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $path,
            'is_active' => $request->is_active,
            'created_by' => $request->created_by,
        ]);
        return redirect()->route('brand')->with('brand-update', "Brand has been updated Successfully!");
    }

    public function delete($id)
    {
        Brand::find($id)->delete();
        return redirect()->route('brand')->with('brand-delete', 'Brand has been deleted successfully!');
    }
}
