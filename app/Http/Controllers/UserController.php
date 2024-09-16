<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        // pencarian data rentlog berdasarkan user yg lagi dipilih
        $rentlogs = RentLogs::with(['user', 'book'])->where('user_id', Auth::user()->id)->get();
        return view('profile', ['rent_logs' => $rentlogs]);
    }

    public function index()
    {
        // memunculkan user selain admin (hanya role id 2)
        $users = User::where('role_id', 2)->where('status', 'active')->get();
        return view('user', ['users' => $users]);
    }

    public function registeredUser()
    {
        $registeredUsers = User::where('status', 'inactive')->where('role_id', 2)->get();
        return view('registered-user', ['registeredUsers' => $registeredUsers]);
    }

    public function show($slug)
    {
        // ngambil data dari slug
        $user = User::where('slug', $slug)->first();
        // pencarian data rentlog berdasarkan user yg lagi dipilih
        $rentlogs = RentLogs::with(['user', 'book'])->where('user_id', $user->id)->get();
        return view('user-detail', ['user' => $user, 'rent_logs' => $rentlogs]);
    }

    public function approve($slug)
    {
        // ngambil data dari slug
        $user = User::where('slug', $slug)->first();
        // ganti statusnya jadi active
        $user->status = 'active';
        $user->save();

        return redirect('user-detail/'.$slug) ->with('status', 'User Approved Successfully');
    }

    public function delete($slug)
    {
        $user = User::where('slug', $slug)->first();
        return view('user-delete', ['user' => $user]);
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->first();
        $user->delete();

        return redirect('users') ->with('status', 'User Deleted Successfully');
    }

    public function bannedUser()
    // untuk melihat data yang didelete (soft delete)
    {
        $bannedUsers = User::onlyTrashed()->get();
        return view('user-banned', ['bannedUsers' => $bannedUsers]);
    }

    public function restore($slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        $user->restore();

        return redirect('users') ->with('status', 'User Restored Successfully');
    }
}
