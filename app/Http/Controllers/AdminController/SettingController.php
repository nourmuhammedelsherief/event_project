<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\ContactUs;
use App\Models\History;
use App\Models\Setting;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        $setting = Setting::find(1);
        return view('admin.settings.setting' , compact('setting'));
    }

    public function store_setting(Request $request)
    {
        $this->validate($request , [
            'auto_active'     => 'sometimes',
        ]);
        $setting = Setting::find(1);
        $setting->update($request->all());
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

}
