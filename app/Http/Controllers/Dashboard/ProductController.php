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
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Session;

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
                    ->rawColumns(['description', 'created_at', 'action', 'price'  ])
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
        if ($request->file('desc_file')) {
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
                foreach($request->file('image') as $uploadedFile){
                    $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                    $path = $uploadedFile->storeAs('ProductImg', $filename, 'public');
                    ProductPicture::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'display_order' => $request->display_order[$k],
                    ]);
                }
                // Description File end
            }
        }

        return redirect()->route('product')->with('product-create', 'Product has been created successfully!');
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product')->with('product-delete', 'Product has been deleted successfully!');
    }
}
