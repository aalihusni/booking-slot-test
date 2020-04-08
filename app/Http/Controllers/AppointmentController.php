<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = $this->service->appointmentList();

        foreach ($appointments as $appointment) {

        }
        return response()->json([
            'success' => true,
            'data' => $appointments,
            'message' => 'List of appointments'
        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $dateOnly = explode('T', $request->appointment_date);
        $combinedDatetime = Carbon::parse($dateOnly[0] . ' ' . $request->appointment_time);

        $combinedDatetime2 = Carbon::parse($dateOnly[0] . ' ' . $request->appointment_time);
        $payload = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'car_plate' => $request->car_plate,
            'inspection_time_start' => $combinedDatetime,
            'inspection_time_end' => $combinedDatetime2->addMinutes(30),
        ];

        $data = $this->service->createAppointment($payload);

        return response()->json([
            'message' => $data['message'],
            'status' => $data['status'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
