<?php

namespace App\Http\Controllers;

use App\Models\ScheduleClass;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $scheduleClasses = ScheduleClass::upcoming()
            ->with('classType', 'instructor')
            ->notBooked()
            ->oldest()->get();
        return view('member.book')->with('scheduleClasses', $scheduleClasses);
    }
    public function store(Request $request)
    {
        auth()->user()->bookings()->attach($request->schedule_class_id);
        return redirect()->route('booking.create');
    }
    public function index()
    {
        $bookings = auth()->user()->bookings()->upcoming()->get();
        return view('member.upcoming')->with('bookings', $bookings);
    }
    public function destroy(int $id)
    {
        auth()->user()->bookings()->detach($id);
        return redirect()->route('booking.index');

    }
}
