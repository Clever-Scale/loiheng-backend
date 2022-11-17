<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        if (session('category-create')) {
            toast(Session::get('category-create'), "success");
        }
        if (session('category-delete')) {
            toast(Session::get('category-delete'), "success");
        }
        if (session('category-update')) {
            toast(Session::get('category-update'), "success");
        }
        $categories = Category::orderBy('id', 'desc')->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('parent', 0)->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $path = '';
        if ($request->file()) {
            $fileName = time() . '_' . $request->picture->getClientOriginalName();
            $filePath = $request->file('picture')->storeAs('Category', $fileName, 'public');
            $path = '/storage/' . $filePath;
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $path,
            'level' => $request->level,
            'picture_blob' => $request->picture_blob,
            'status' => $request->status,
            'created_by' => $request->created_by,
            'parent' => $request->parent,
        ]);
        return redirect()->route('category')->with('category-create', "Category has been created Successfully!");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('parent', 0)->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $this->validate($request, [
            'name' => 'required',
        ]);


        // dd($request->role_id);
        $pathEmp = $request->file('picture');
        $path= Category::where('id', $id)->value('picture');
        if($pathEmp){
            if ($request->file()) {
                $fileName = time() . '_' . $request->picture->getClientOriginalName();
                $filePath = $request->file('picture')->storeAs('Category', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
        }

        Category::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $path,
            'level' => $request->level,
            'picture_blob' => $request->picture_blob,
            'status' => $request->status,
            'created_by' => $request->created_by,
            'parent' => $request->parent,
        ]);
        return redirect()->route('category')->with('category-update', "Category has been updated Successfully!");
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return redirect()->route('category')->with('category-delete', 'Category has been deleted successfully!');
    }
}
