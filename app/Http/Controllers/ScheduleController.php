<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Scheduler;
use App\Models\Service;
use App\Models\User;
use App\Notifications\SchedulerCreated;
use App\View\Components\auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
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

    public function create()
    {
        $services = Service::all();
        $staffUsers = User::role('staff')->get();

        return view('schedule.create')->with([
            'services' => $services,
            'staffUsers' => $staffUsers,
        ]);
    }

    public function store(ScheduleRequest $request)
    {
        $service = Service::find(request('service_id'));
        $from = Carbon::parse(request('from.date') . ' ' . request('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);
        $staffUser = User::find($request->input('staff_user_id'));

        $request->checkReservationRules($staffUser, auth()->user(), $from, $to, $service);

        $scheduler = Scheduler::create([
            'from' => $from,
            'to' => $to,
            'status' => 'pending',
            'staff_user_id' => request('staff_user_id'),
            'client_user_id' => auth()->id(),
            'service_id' => $service->id,
        ]);


        $staffUser->notify(new SchedulerCreated($scheduler));
        

        return redirect(route('schedule', ['date' => $from->format('Y-m-d')]));
    }

    public function edit(Scheduler $scheduler)
    {
        if (auth()->user()->cannot('update', $scheduler)) {
            abort(403, 'Acción no autorizada.');
        }

        $services = Service::all();
        $staffUsers = User::role('staff')->get();

        return view('schedule.edit')->with([
            'scheduler' => $scheduler,
            'services' => $services,
            'staffUsers' => $staffUsers,
        ]);

    }

    public function update(Scheduler $scheduler,  ScheduleRequest $request)
    {
        if (auth()->user()->cannot('update', $scheduler)) {
            abort(403, 'Acción no autorizada.');
        }

        $service = Service::find(request('service_id'));
        $from = Carbon::parse(request('from.date') . ' ' . request('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);
        $staffUser = User::find($request->input('staff_user_id'));

        $request->checkRescheduleRules($scheduler, $staffUser, auth()->user(), $from, $to, $service);

        $scheduler->update([
            'from' => $from,
            'to' => $to,
            'staff_user_id' => request('staff_user_id'),
            'service_id' => $service->id,
        ]);

        return redirect(route('schedule', ['date' => $from->format('Y-m-d')]));
    }

    public function destroy(Scheduler $scheduler) 
    {
        if (auth()->user()->cannot('delete', $scheduler)) {
            return back()->withErrors('No es posible cancelar esta cita');
        }

        $scheduler->delete();

        return back();
    }
}
