<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\UserPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $users = UserPeriod::whereStatus($status)
            ->orderBy('id' , 'desc')
            ->paginate(300);
        return view('admin.users.index' , compact('users' , 'status'));
    }

    public function active_user($id , $staus)
    {
        $user = UserPeriod::find($id);
        $user->update([
            'status' => $staus
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('users.index' , $staus);
    }
    public function destroy($id)
    {
        $user = UserPeriod::findOrFail($id);
        $user->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
}
