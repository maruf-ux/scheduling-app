<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Models\ScheduleClass;
use Illuminate\Http\Request;

class ScheduleClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduleClasses = auth()->user()->scheduleClasses()->where('date_time', '>', now())->oldest('date_time')->get();
        return view('instructor.upcoming')->with('scheduleClasses', $scheduleClasses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classTypes = ClassType::all();
        return view('instructor.schedule')->with('classTypes', $classTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date_time = $request->input('date') . ' ' . $request->input('time');

        $request->merge([
            'date_time' => $date_time,
            'instructor_id' => auth()->user()->id
        ]);

        $validated = $request->validate([
            'class_type_id' => 'required',
            'instructor_id' => 'required',
            'date_time' => 'required|unique:schedule_classes,date_time|after:now'
        ]);

        ScheduleClass::create($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScheduleClass $schedule)
    {
        if (auth()->user()->id !== $schedule->instructor_id) {
            abort(403);
        }
        $schedule->delete();
        return redirect()->route('schedule.index');
    }
}

