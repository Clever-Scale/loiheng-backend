<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class DeliveryController extends Controller
{
    public function index()
    {
        if (session('delivery-created')) {
            toast(Session::get('delivery-created'), "success");
        }
        if (session('delivery-delete')) {
            toast(Session::get('delivery-delete'), "success");
        }
        if (session('delivery-edit')) {
            toast(Session::get('delivery-edit'), "success");
        }
        return view('dashboard.deliveries.index');
    }

    public function getDeliveryList(Request $request)
    {
        if ($request->ajax()) {
            $data = Delivery::latest();
            return DataTables::of($data)
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
                                    <a href="' . route("delivery.edit", ["id" => $row->id]) . '" class="btn btn-primary btn-sm mb-2" style="width:100%">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <form method="post" action="' . route("delivery.delete", ["id" => $row->id]) . ' "
                                    id="from1" data-flag="0">
                                    ' . csrf_field() . '<input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                style="width: 100%">Delete</button>
                                        </form>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->rawColumns(['created_at', 'action' ])
                    ->make(true);
        }
    }

    public function create()
    {
        return view('dashboard.deliveries.create');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'fee' => 'required',
        ]);

        Delivery::create([
                'name' => $request->name,
                'fee' => $request->fee,

        ]);
        return redirect()->route('delivery')->with('delivery-created', "Delivery has been created successfully!");
    }

    public function edit($id)
    {
        $delivery = Delivery::findorFail($id);

        return view('dashboard.deliveries.edit', compact('delivery'));

    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'fee' => 'required',
        ]);

        Delivery::where('id', $id)->update([
                'name' => $request->name,
                'fee' => $request->fee,

        ]);
        return redirect()->route('delivery')->with('delivery-edit', "Delivery has been updated successfully!");
    }

    public function delete($id)
    {
        Delivery::find($id)->update([
            'is_active' => false
        ]);
        return redirect()->route('delivery')->with('delivery-delete', 'Delivery has been deleted successfully!');
    }
}
