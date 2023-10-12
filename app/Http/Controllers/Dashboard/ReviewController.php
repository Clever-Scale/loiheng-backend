<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function index(Request $request)
    {

        if (session('delete')) {
            toast(Session::get('brand-delete'), "success");
        }
        $reviews = ProductReview::query();
        if(!is_null($request->key)){
            $reviews = $reviews->where('content', 'LIKE', "%$request->key%");
        }
        $reviews = $reviews->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);
        return view('dashboard.reviews.index', compact('reviews'));
    }
    public function delete($id)
    {

        ProductReview::where('id', $id)->delete();

        return redirect()->route('reviews')->with('delete', 'Review has been deleted successfully!');
    }


}
