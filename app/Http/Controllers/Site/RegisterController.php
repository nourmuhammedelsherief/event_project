<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Date;
use App\Models\Period;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserPeriod;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterController extends Controller
{
    public function show_register()
    {
        $dates = Date::all();
        return view('site.register' , compact('dates'));
    }
    public function get_periods($id)
    {
        $sub_categories = Period::whereDateId($id)->get();
        return response()->json($sub_categories);
    }

    public function register(Request $request)
    {
        $this->validate($request , [
            'first_name' => 'required|string|max:191',
            'user_name' => 'required|string|max:191',
            'email'     => 'required|email|max:191',
            'entity'    => 'nullable|string|max:191',
            'date_id'   => 'required|exists:dates,id',
            'period_id'   => 'required|exists:periods,id',
        ]);
        // create new user
        $period = Period::find($request->period_id);
        $period_users = UserPeriod::wherePeriodId($period->id)
            ->whereStatus('accepted')
            ->count();
        if ($period->people_count > $period_users)
        {
            $checkUser = User::whereEmail($request->email)->first();
            if ($checkUser)
            {
                $checkUserPeriod = UserPeriod::whereUserId($checkUser->id)
                    ->wherePeriodId($period->id)
                    ->first();
                if ($checkUserPeriod)
                {
                    flash(trans('messages.URegisterBefore'))->error();
                    return redirect()->back();
                }else{
                    // create user period
                    UserPeriod::create([
                        'user_id'      => $checkUser->id,
                        'period_id'    => $period->id,
                        'status'       => Setting::first()->auto_active == 'true' ? 'accepted' : 'waiting',
                    ]);
                    flash(trans('messages.successRegistered'))->success();
                    return redirect()->back();
                }
            }else{
                // register new user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'user_name'  => $request->user_name,
                    'email'      => $request->email,
                    'entity'     => $request->entity,
                ]);
                // create user period
                UserPeriod::create([
                    'user_id'      => $user->id,
                    'period_id'    => $period->id,
                    'status'       => Setting::first()->auto_active == 'true' ? 'accepted' : 'waiting',
                ]);
                flash(trans('messages.successRegistered'))->success();
                return redirect()->back();
            }
        }else{
            flash(trans('messages.noPlaceAtEvent'))->error();
            return redirect()->back();
        }
    }

    public function show_barcode($id)
    {
        $user = UserPeriod::findOrFail($id);
        return view('site.barcode' , compact('user'));
    }

    public function barcode_details($id)
    {
        $user = UserPeriod::findOrFail($id);
        return view('site.barcode_details' , compact('user'));
    }

    public function confirm_attendance(Request $request , $id)
    {
        $user = UserPeriod::findOrFail($id);
        $this->validate($request , [
            'attendance_code' => 'required|exists:admins,attendance_code|max:191'
        ]);
        $admin = Admin::where('attendance_code' , $request->attendance_code)->first();
        // confirm attendance to this user
        $user->update([
            'attendance' => 'true',
            'admin_id'   => $admin->id,
        ]);
        flash(trans('messages.attendance_confirmed_successfully'))->success();
        return redirect()->back();
    }

}
