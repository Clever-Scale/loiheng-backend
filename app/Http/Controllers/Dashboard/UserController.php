<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        if (session('user-delete')) {
            toast(Session::get('user-delete'), "success");
        }
        $users = User::where('is_admin', '=', 'admin')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->route('user')->with('user-delete', 'User has been deleted successfully!');
    }
}
