<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Date;
use Illuminate\Http\Request;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dates = Date::orderBy('id' , 'desc')->get();
        return view('admin.dates.index' , compact('dates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'event_date' => 'required|date',
        ]);
        Date::create([
            'event_date' => $request->event_date,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('dates.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $date = Date::findOrFail($id);
        return view('admin.dates.edit' , compact('date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $date = Date::findOrFail($id);
        $this->validate($request , [
            'event_date' => 'required|date',
        ]);
        $date->update([
            'event_date' => $request->event_date,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('dates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $date = Date::findOrFail($id);
        if ($date->periods->count() > 0):
            flash('لا يمكنك حذف هذا التاريخ ﻷنه مستخدم في بعض الفترات')->error();
            return redirect()->back();
        endif;
        $date->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('dates.index');
    }
}
