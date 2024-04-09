<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $appointments = Appointment::all(); 
        return response()->json($appointments);
    }

    /**
     * 
     */
    public function getAppointment(): JsonResponse
    {
        $appointments = Appointment::whereHas('users', function ($query) { 
            $query->where('user_id', Auth::user()->id);
        })->get();
        return response()->json($appointments);
    }

    /**
     * 
     */
    public function getUserAppointment($appointmentId): JsonResponse
    {
        $appointment = Appointment::where('id', $appointmentId)->first();
        return response()->json($appointment);
    }

    public function getLessons()
    {
        $lessons = Appointment::where('lesson', true)->get();
        return response()->json($lessons);
    }

    /**
     * Update the status of the specified appointment.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id, Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            $appointment->status_id = $request->input('status_id', 3);

            $appointment->save();

            return response()->json(['message' => 'Appointment status updated successfully', 'appointment' => $appointment]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update appointment status', 'error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $start = Carbon::parse($request->start)->setTimezone('Europe/Amsterdam');
        $end = Carbon::parse($request->end)->setTimezone('Europe/Amsterdam');

        $appointment = new Appointment();
        $appointment->start = $start;
        $appointment->end = $end;
        $appointment->court_id = $request->court_id;
        $appointment->lesson = $request->lesson;
        $appointment->status_id = $request->status_id;
        $appointment->save();
        
        $user = Auth::user();
        $appointmentUser = new AppointmentUser;
        $appointmentUser->appointment_id = $appointment->id;
        $appointmentUser->user_id = $user->id;
        $appointmentUser->save();

        if ($request->teacherId != null)
        {
            $appointmentUser = new AppointmentUser;
            $appointmentUser->appointment_id = $appointment->id;
            $appointmentUser->user_id = $request->teacherId;
            $appointmentUser->save();
        }

        return redirect()->back();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
