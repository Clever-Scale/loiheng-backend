<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        if (session('setting-edit')) {
            toast(Session::get('setting-edit'), "success");
        }
        return view('dashboard.settings.index');
    }
    public function getSettingList(Request $request)
    {
        if ($request->ajax()) {
            $data = Setting::latest();
            return DataTables::of($data)
            ->escapeColumns(['value'])
            ->editColumn('created_by', function ($row) {
                return User::findOrFail( $row->created_by)->fullname;
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
                            <a href="' . route("settings.edit", ["id" => $row->id]) . '" class="btn btn-primary btn-sm mb-2" style="width:100%">
                                Edit
                            </a>
                        </li>
                    </ul>
                </div>';
            })
            ->rawColumns(['created_at', 'action', 'value' ])
            ->make(true);
        }
    }

    public function edit($id)
    {
        $setting =  Setting::findOrFail($id);
        return view('dashboard.settings.edit', compact('setting'));
    }

    public function update($key, Request $request)
    {

        $data = Setting::where('key', $key)->update([
            'value' => $request->value
        ]);

        return redirect()->route('settings')->with('setting-edit', 'Setting has been updated successfully.');
    }
}
