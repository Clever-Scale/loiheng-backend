<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        if (session('contact-delete')) {
            toast(Session::get('contact-delete'), "success");
        }
        return view('dashboard.contact.index');
    }
    public function getContactList(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::latest();
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
                            <form method="post" action="' . route("contact.delete", ["id" => $row->id]) . ' "
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

    public function delete($id)
    {
        Contact::find($id)->delete();
        return redirect()->route('contact')->with('contact-delete', 'Contact has been deleted successfully!');
    }
}
