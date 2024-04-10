<?php

namespace App\Http\Controllers;

use App\Models\AppointmentUser;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppointmentUser  $appointmentUser
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentUser $appointmentUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppointmentUser  $appointmentUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentUser $appointmentUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppointmentUser  $appointmentUser
     * @return \Illuminate\Http\Response
     * 
     * change the status of the appointment
     * if status_id = 1 remove the user
     * if status_id = 3 add the user
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->status_id = $request->status_id;
        $appointment->save();

        if ($request->status_id == 3) {
            $appointment_user = new AppointmentUser;
            $appointment_user->appointment_id = $appointment->id;
            $appointment_user->user_id = Auth::user()->id;
            $appointment_user->save();
        } else {
            $appointment_user = AppointmentUser::where([["user_id", Auth::user()->id], ["appointment_id", $appointment->id]])->delete();
        }

        return response()->json(['message' => 'Appointment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppointmentUser  $appointmentUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentUser $appointmentUser)
    {
        //
    }
}
