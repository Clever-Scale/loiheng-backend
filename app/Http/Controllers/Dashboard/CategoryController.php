<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(Request $request)
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
        $categories = Category::query();
        if(!is_null($request->key)){
            $categories = $categories->where('name', 'LIKE', "%$request->key%");
        }

        $categories = $categories->where("is_active", 1)->orderBy('created_at', 'desc')->paginate($request->limit ? $request->limit : 10);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->where('parent', 0)->get();
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
        $category = Category::where('is_active', 1)->findOrFail($id);
        $categories = Category::where('is_active', 1)->where('parent', 0)->get();
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
        Category::findorFail($id)->update([
            'is_active' => 0
        ]);

        Category::where('brand_id', $id)->update([
            'is_active' => 0,
        ]);

        $product = Product::where('category_id', $id)->get();
        foreach($product as $prod){
            Promotion::where('product_id', $prod->id)->update([
                'is_active' => false
            ]);
        }
        return redirect()->route('category')->with('category-delete', 'Category has been deleted successfully!');
    }
}
