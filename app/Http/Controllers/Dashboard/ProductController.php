<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductWarranty;
use App\Http\Controllers\Controller;
use App\Models\ProductPicture;
use App\Models\ProductSpec;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        if (session('product-create')) {
            toast(Session::get('product-create'), "success");
        }
        return view('dashboard.products.index');
    }

    public function create()
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('dashboard.products.create', compact('categories', 'brands'));
    }

    public function save(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
        ]);
        $prod_no = Product::orderBy('id', 'DESC')->pluck('id')->first();
            if ($prod_no == null or $prod_no == "") {
                #If Table is Empty
                $num = 1;
                $prod_no = sprintf('%04d',$num);
            } else {
                #If Table has Already some Data

                $num = $prod_no + 1;
                $prod_no =sprintf('%04d',$num);
            }
        $product_code = 'LH' . $prod_no;

        // Description File start
        $pathDescFile = '';
        if ($request->file()) {
            $descFileName = time() . '_' . $request->desc_file->getClientOriginalName();
            $descFilePath = $request->file('desc_file')->storeAs('Description', $descFileName, 'public');
            $pathDescFile = '/storage/' . $descFilePath;
        }
        // Description File end
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'product_code' => $product_code,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'sku' => $request->sku,
            'desc_file' => $pathDescFile,
            'status' => $request->status,
            'is_preorder' => $request->is_preorder,
            'is_feature_product' => $request->is_feature_product,
            'is_new_arrival' => $request->is_new_arrival,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        $count = count($request->service_key);
        if ($request->service_key[0] != null) {
            for ($i = 0; $i < $count; $i++) {
                ProductWarranty::create([
                    'product_id' => $product->id,
                    'service_key' => $request->service_key[$i],
                    'service_value' => $request->service_value[$i],
                ]);
            }
        }

        $countSpec = count($request->spec_key);
        if ($request->spec_key[0] != null) {
            for ($j = 0; $j < $countSpec; $j++) {
                ProductSpec::create([
                    'product_id' => $product->id,
                    'spec_key' => $request->spec_key[$j],
                    'spec_value' => $request->spec_value[$j],
                ]);
            }
        }

        $countImg = count($request->spec_key);
        if ($request->spec_key[0] != null) {
            for ($k = 0; $k < $countImg; $k++) {
                // Description File start
                $path = '';
                if ($request->file()) {
                    $fileName = time() . '_' . $request->image[$k]->getClientOriginalName();
                    $filePath = $request->file('image')->storeAs('ProductImg', $fileName, 'public');
                    $path = '/storage/' . $filePath;
                }
                // Description File end
                ProductPicture::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'display_order' => $request->display_order[$k],
                ]);
            }
        }

        return redirect()->route('product')->with('product-create', 'Product has been created successfully!');
    }
}
