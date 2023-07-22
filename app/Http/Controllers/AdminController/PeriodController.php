<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Period::orderBy('id' , 'desc')->get();
        return view('admin.periods.index' , compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dates = Date::all();
        return view('admin.periods.create' , compact('dates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name'            => 'sometimes|string|max:191',
            'date_id'         => 'required|exists:dates,id',
            'start_at'        => 'required',
            'end_at'          => 'required',
            'people_count'    => 'required|integer'
        ]);
        // create new period
        Period::create([
            'name'         => $request->name,
            'date_id'      => $request->date_id,
            'start_at'     => $request->start_at,
            'end_at'       => $request->end_at,
            'status'       => 'available',
            'people_count' => $request->people_count
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('periods.index');
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
        $period = Period::findOrFail($id);
        $dates = Date::all();
        return view('admin.periods.edit' , compact('period' , 'dates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $period = Period::findOrFail($id);
        $this->validate($request , [
            'name'            => 'sometimes|string|max:191',
            'date_id'         => 'required|exists:dates,id',
            'start_at'        => 'required',
            'end_at'          => 'required',
            'people_count'    => 'required|integer'
        ]);
        $period->update([
            'name'         => $request->name == null ? $period->name : $request->name,
            'date_id'      => $request->date_id,
            'start_at'     => $request->start_at,
            'end_at'       => $request->end_at,
            'people_count' => $request->people_count
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('periods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $period = Period::findOrFail($id);
        $period->delete();
        flash(trans('messages.updated'))->success();
        return redirect()->route('periods.index');
    }
}
