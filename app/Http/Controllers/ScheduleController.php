<?php

namespace App\Http\Controllers;

use App\Models\Scheduler;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index ()
    {
        $date = Carbon::parse(request()->input('date'));

       
        $dayScheduler = Scheduler::where('client_user_id', auth()->id())
        ->whereDate('from', $date->format('Y-m-d'))
        ->orderBy('from', 'ASC')
        ->get();

        

        return view('schedule.index')
            ->with([
                'date' => $date,
                'dayScheduler' => $dayScheduler,
            ]);
        }
}
