<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use App\Models\ProductPicture;
use Illuminate\Support\Carbon;
use App\Models\ProductWarranty;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        if (session('product-create')) {
            toast(Session::get('product-create'), "success");
        }
        if (session('product-delete')) {
            toast(Session::get('product-delete'), "success");
        }
        $categories = Category::get();
        $brands = Brand::get();
        $products = ProductResource::collection(Product::orderBy('id', 'desc')->get());
        $products = json_decode(json_encode($products));
        // dd($products);
        return view('dashboard.products.index', compact('products', 'categories', 'brands'));
    }
    public function getProductList(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return DataTables::of($data)
                    ->escapeColumns(['description'])
                    ->editColumn('category_id', function ($cat) {
                        return Category::findOrFail( $cat->category_id)->name;
                    })
                    ->editColumn('brand_id', function ($row) {
                        return Brand::findOrFail( $row->brand_id)->name;
                    })
                    ->addColumn('cover_img', function ($row) {
                        $url = asset($row->cover_img ? $row->cover_img : "assets/img/images.jpg");
                        return '<img src="' . $url . '"
                    alt="Profile Image" style="width: 60px; height: 60px; border-radius: 4px;">';
                    })
                    ->addColumn('created_at', function ($row) {
                        return '
                        <div class="d-flex ">
                        <div>
                            <i class="bi bi-calendar-date mx-2"></i>
                        </div>
                            <div class="px-2 ">
                                ' . Carbon::create($row->created_at)->toFormattedDateString() .
                            '</div>
                        </div>';
                    })
                    ->addColumn('price', function ($row) {
                        return '<p style="font-size: 18px; color: green; font-weight: 600;">' . $row->price . ' $</p>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu p-4">
                                <li>
                                    <a href="' . route("product.show", ["id" => $row->id]) . '" class="btn btn-success btn-sm mb-2" style="width:100%">
                                        Show
                                    </a>
                                </li>
                                <li>
                                    <a href="' . route("product.edit", ["id" => $row->id]) . '" class="btn btn-primary btn-sm mb-2" style="width:100%">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <form method="post" action="' . route("product.delete", ["id" => $row->id]) . ' "
                                    id="from1" data-flag="0">
                                    ' . csrf_field() . '<input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                style="width: 100%">Delete</button>
                                        </form>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->filter(function ($instance) use ($request) {
                        if ($request->get('category_id')){
                            $instance->where('category_id', $request->get('category_id'));
                        }
                        if ($request->get('brand_id')){
                            $instance->where('brand_id', $request->get('brand_id'));
                        }
                        if($request->has('from_date')){
                            $from_date = Carbon::parse($request->get('from_date'))->format('Y-m-d');
                            $to_date = Carbon::parse($request->get('to_date'))->format('Y-m-d');
                            $start_date = $from_date != null ? "$from_date 00:00:00" : null;
                            $end_date = $to_date != null ? "$to_date 23:59:59" : null;
                            $instance = $instance->whereBetween('created_at', [$start_date, $end_date]);

                        }
                    })
                    ->rawColumns(['description', 'created_at', 'action', 'price', 'cover_img'  ])
                    ->make(true);
        }
    }

    public function create()
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('dashboard.products.create', compact('categories', 'brands'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'cover_img' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required'
        ],[
            "cover_img.required" => "Pleace select cover image!",
            "category_id.required" => "Pleace select category!",
            "brand_id.required" => "Pleace select brand!",
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

        // Cover start
        $pathCover = '';
        if ($request->file()) {
            $fileNameCover = time() . '_' . $request->cover_img->getClientOriginalName();
            $filePathCover = $request->file('cover_img')->storeAs('Product', $fileNameCover, 'public');
            $pathCover = '/storage/' . $filePathCover;
        }
        // Cover end
        // Description File start
        $pathDescFile = '';
        if ($request->file('desc_file')) {
            $descFileName = time() . '_' . $request->desc_file->getClientOriginalName();
            $descFilePath = $request->file('desc_file')->storeAs('Description', $descFileName, 'public');
            $pathDescFile = '/storage/' . $descFilePath;
        }
        // Description File end
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'cover_img' => $pathCover,
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


        if(!is_null($request->service_key[0])){
            $count = count($request->service_key);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    ProductWarranty::create([
                        'product_id' => $product->id,
                        'service_key' => $request->service_key[$i],
                        'service_value' => $request->service_value[$i],
                    ]);
                }
            }
        }

        if(!is_null($request->spec_key[0])){
            $countSpec = count($request->spec_key);
            if ($countSpec > 0) {
                for ($j = 0; $j < $countSpec; $j++) {
                    ProductSpec::create([
                        'product_id' => $product->id,
                        'spec_key' => $request->spec_key[$j],
                        'spec_value' => $request->spec_value[$j],
                    ]);
                }
            }
        }

        if($request->file('image')){
            $countImg = count($request->image);
            if ($countImg > 0) {
                for ($k = 0; $k < $countImg; $k++) {
                        $filename = time() . '_' . $request->image[$k]->getClientOriginalName();
                        $filepath = $request->file('image')[$k]->storeAs('ProductImg', $filename, 'public');
                        $path = '/storage/' . $filepath;
                        ProductPicture::create([
                            'product_id' => $product->id,
                            'image' => $path,
                            'display_order' => $request->display_order[$k],
                        ]);
                }
            }
        }

        return redirect()->route('product')->with('product-create', 'Product has been created successfully!');
    }

    public function show($id)
    {
        $products =  ProductResource::collection(Product::where('id', $id)->get());
        $products = json_decode(json_encode($products));
        return view('dashboard.products.show', compact('products'));
    }

    public function edit($id)
    {
        $categories = Category::get();
        $brands = Brand::get();
        $products =  ProductResource::collection(Product::where('id', $id)->get());
        $products = json_decode(json_encode($products));
        // dd($products);
        return view('dashboard.products.edit', compact('categories', 'brands', 'products'));
    }

    public function update(Request $request, $id)
    {
    //    dd($request->all());
       $this->validate($request, [
        'name' => 'required',
        'price' => 'required',
        'sku' => 'required',
        'category_id' => 'required',
        'brand_id' => 'required'
        ],[
            "cover_img.required" => "Pleace select cover image!",
            "category_id.required" => "Pleace select category!",
            "brand_id.required" => "Pleace select brand!",
        ]);

        // Cover start
        $pathCo = $request->file('cover_img');
        $pathCover= Product::where('id', $id)->value('cover_img');
        if ($pathCo) {
            $fileNameCover = time() . '_' . $request->cover_img->getClientOriginalName();
            $filePathCover = $request->file('cover_img')->storeAs('Product', $fileNameCover, 'public');
            $pathCover = '/storage/' . $filePathCover;
        }
        // Cover end
        // Description File start
        $pathDes = $request->file('desc_file');
        $pathDescFile= Product::where('id', $id)->value('desc_file');
        if ($pathDes) {
            $descFileName = time() . '_' . $request->desc_file->getClientOriginalName();
            $descFilePath = $request->file('desc_file')->storeAs('Description', $descFileName, 'public');
            $pathDescFile = '/storage/' . $descFilePath;
        }
        // Description File end
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'cover_img' => $pathCover,
            'product_code' => $request->product_code,
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


        if(!is_null($request->edit_service_key[0])){
            $count = count($request->edit_service_key);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $service_product_id = $request->service_product_id[$i];
                    ProductWarranty::where('id', $service_product_id)->update([
                        'service_key' => $request->edit_service_key[$i],
                        'service_value' => $request->edit_service_value[$i],
                    ]);
                }
            }
        }

        if(!is_null($request->edit_spec_key[0])){
            $countSpec = count($request->edit_spec_key);
            if ($countSpec > 0) {
                for ($j = 0; $j < $countSpec; $j++) {
                    $spec_product_id = $request->spec_product_id[$i];
                    ProductSpec::where('id', $spec_product_id)->update([
                        'spec_key' => $request->edit_spec_key[$j],
                        'spec_value' => $request->edit_spec_value[$j],
                    ]);
                }
            }
        }

        if($request->file('edit_image')){
            $countImg = count($request->edit_image);
            if ($countImg > 0) {
                for ($k = 0; $k < $countImg; $k++) {
                        $filename = time() . '_' . $request->edit_image[$k]->getClientOriginalName();
                        $filepath = $request->file('image')[$k]->storeAs('ProductImg', $filename, 'public');
                        $path = '/storage/' . $filepath;
                        $img_product_id = $request->img_product_id[$k];
                        $editPath = $request->file('edit_image');
                        $pathEditImg= ProductPicture::where('id', $k)->value('image');
                        ProductPicture::where('id', $img_product_id)->update([
                            'product_id' => $product->id,
                            'image' => $pathEditImg,
                            'display_order' => $request->display_order[$k],
                        ]);
                }
            }
        }

        if(!is_null($request->service_key[0])){
            $count = count($request->service_key);
            if ($count > 0) {
                for ($g = 0; $g < $count; $g++) {
                    ProductWarranty::create([
                        'product_id' => $product->id,
                        'service_key' => $request->service_key[$g],
                        'service_value' => $request->service_value[$g],
                    ]);
                }
            }
        }

        if(!is_null($request->spec_key[0])){
            $countSpec = count($request->spec_key);
            if ($countSpec > 0) {
                for ($h = 0; $h < $countSpec; $h++) {
                    ProductSpec::create([
                        'product_id' => $product->id,
                        'spec_key' => $request->spec_key[$h],
                        'spec_value' => $request->spec_value[$h],
                    ]);
                }
            }
        }

        if($request->file('image')){
            $countImg = count($request->image);
            if ($countImg > 0) {
                for ($t = 0; $t < $countImg; $t++) {
                        $filename = time() . '_' . $request->image[$t]->getClientOriginalName();
                        $filepath = $request->file('image')[$t]->storeAs('ProductImg', $filename, 'public');
                        $path = '/storage/' . $filepath;
                        ProductPicture::create([
                            'product_id' => $product->id,
                            'image' => $path,
                            'display_order' => $request->display_order[$t],
                        ]);
                }
            }
        }

        return redirect()->route('product')->with('product-create', 'Product has been edited successfully!');
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product')->with('product-delete', 'Product has been deleted successfully!');
    }
}
