<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\BannerSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BannerSliderController extends Controller
{
    public function index()
    {
        if (session('banner-create')) {
            toast(Session::get('banner-create'), "success");
        }
        if (session('banner-delete')) {
            toast(Session::get('banner-delete'), "success");
        }
        return view('dashboard.banner-slider.index');
    }

    public function getBannerSliderList(Request $request)
    {
        if ($request->ajax()) {
            $data = BannerSlider::select('*');
            return DataTables::of($data)
                ->editColumn('created_by', function ($user) {
                    return User::findOrFail( $user->created_by)->fullname;
                })
                ->addColumn('image', function ($row) {
                    $url = asset($row->image ? $row->image : "assets/img/pp.jpg");
                    return '<img src="' . $url . '"
                alt="Image" style="width: 60px; height: 60px; border-radius: 4px;">';
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
                ->addColumn('action', function ($row) {
                    return '
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu p-4">
                            <li>
                                <a href="' . route("banner-slider.edit", ["id" => $row->id]) . '" class="btn btn-primary btn-sm mb-2" style="width:100%">
                                    Edit
                                </a>
                            </li>
                            <li>
                                <form method="post" action="' . route("banner-slider.delete", ["id" => $row->id]) . ' "
                                id="from1" data-flag="0">
                                ' . csrf_field() . '<input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm delete"
                                            style="width: 100%">Delete</button>
                                    </form>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['created_at', 'action', 'image'  ])
                ->make(true);
        }
    }

    public function create()
    {
        return view('dashboard.banner-slider.create');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'image' => 'required',
        ], [
            "image.required" => "Pleace select image!",
        ]);
        $path = '';
        $fileName = time() . '_' . $request->image->getClientOriginalName();
        $filePath = $request->file('image')->storeAs('BannerSlider', $fileName, 'public');
        $path = '/storage/' . $filePath;
        BannerSlider::create([
            'image' => $path,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('banner-slider')->with('banner-create', 'Banner image has been created successfully!');
    }

    public function edit($id)
    {
        $banner = BannerSlider::findOrFail($id);
        return view('dashboard.banner-slider.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $pathEmp = $request->file('image');
        $path= BannerSlider::where('id', $id)->value('image');
        if($pathEmp){
            if ($request->file()) {
                $fileName = time() . '_' . $request->image->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('BannerSlider', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
        }
        BannerSlider::where('id', $id)->update([
            'image' => $path,
            'created_by' => $request->created_by,
        ]);
        return redirect()->route('banner-slider')->with('banner-update', "Banner image has been updated Successfully!");
    }


    public function delete($id)
    {
        BannerSlider::find($id)->delete();
        return redirect()->route('banner-slider')->with('banner-delete', 'Banner image has been deleted successfully!');
    }
}
