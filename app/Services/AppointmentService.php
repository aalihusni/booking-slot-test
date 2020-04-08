<?php

namespace App\Services;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentService
{


    CONST SLOT_WEEKDAY = 2;
    CONST SLOT_WEEKEND = 4;
    CONST OFFDAY = ['Sunday'];
    CONST WEEKDAY = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    CONST WEEKEND = ['Saturday'];

    private $model;

    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }

    public function isValidDate($submitDate)
    {
        $another21Days = Carbon::today()->addDays(21);

        return $submitDate->gt($another21Days);
    }

    public function checkSlot($inspectionTime)
    {
        if ($inspectionTime->isWeekend()) {
            return $this->slotWeekend($inspectionTime);
        } else {
            return $this->slotWeekday($inspectionTime);
        }
    }

    public function slotWeekday($inspectionTime)
    {
        if (!in_array($inspectionTime->format('l'), self::WEEKDAY, true)) {
            return 100;
        }

        $slot = $this->model->where('inspection_time_start', $inspectionTime)->count();
        if ($slot < self::SLOT_WEEKDAY) {
            if ($slot === 0) {
                return 1;
            } else {
                return $slot + 1;
            }
        }
        return 99;
    }

    public function slotWeekend($inspectionTime)
    {
        if (!in_array($inspectionTime->format('l'), self::WEEKEND, true)) {
            return 100;
        }
        //check for available slot
        $slot = $this->model->where('inspection_time_start', $inspectionTime)->count();
        if ($slot < self::SLOT_WEEKEND) {
            if ($slot === 0) {
                return 1;
            } else {
                return $slot + 1;
            }
        }
        return 99;

    }

    public function createAppointment($payload)
    {
        if (!$this->isValidDate($payload['inspection_time_start'])) {
            return [
                'status' => false,
                'message' => 'Invalid date',
            ];
        }

        $slotAvailable = $this->checkSlot($payload['inspection_time_start']);
        $data = null;
        $response['status'] = false;
        $response['message'] = 'no slot available';
        if ($slotAvailable !== 99 && $slotAvailable !== 100) {
            $payload['inspection_slot'] = $slotAvailable;
            $data = $this->model->create($payload);
        }

        if ($slotAvailable === 100) {
            $response['message'] = 'Invalid date selected';
        }

        if ($data) {
            $response['status'] = true;
            $response['message'] = 'Slot booked';
        }

        return $response;
    }

    public function appointmentList()
    {
        $today = Carbon::today();
        $appointments = DB::table('appointment')
            ->where('inspection_time_start', '>=', $today)
            ->selectRaw('inspection_time_start as start, inspection_time_end as end, count(*) AS content')->groupBy('inspection_time_end', 'inspection_time_start')->get();

        foreach ($appointments as $appointment) {
            $appointment->content = 'Slot booked ' . $appointment->content;
            $inspectionTime = Carbon::parse($appointment->start);
            if ($appointment->content === 2 && in_array($inspectionTime->format('l'), self::WEEKDAY, true)) {
                $appointment->content = 'Fully booked';
            }

            if ($appointment->content === 4 && in_array($inspectionTime->format('l'), self::WEEKEND, true)) {
                $appointment->content = 'Fully booked';
            }
        }
        return $appointments;
    }
}