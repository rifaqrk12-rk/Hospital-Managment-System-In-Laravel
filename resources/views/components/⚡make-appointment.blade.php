<?php

use App\Models\appointment;
use Livewire\Component;
use App\Models\doctor;
use App\Models\doctor_schedule;
use Carbon\Carbon;

new class extends Component
{
    public $appointmentdate, $doctor_id, $selectedslot, $selectedtime;
    public $step = 1;
    public $availibleslots = [];

    public function getDoctorProperty()
    {

        return doctor::with('department')->get();
    }

    public function appointment($id)
    {
        $data = doctor::findOrFail($id);
        $this->doctor_id = $data->id;
        $this->dispatch('appointmentModal');
    }

    public function updatedAppointmentdate()
    {
        $this->fetchavailibleslots();
    }

    public function fetchavailibleslots()
    {

        $day_of_week = Carbon::parse($this->appointmentdate)->format('l');

        $schedule = doctor_schedule::where('doctor_id', $this->doctor_id)->where('day_of_week', $day_of_week)->where('is_active', 1)->first();

        if (!$schedule) {

            session()->flash('error', 'No doctor Found on this Date');
            return;
        }

        $this->generateslots($schedule);
    }

    public function generateslots($schedule)
    {

        $starttime = Carbon::parse($schedule->start_time);
        $endtime = Carbon::parse($schedule->end_time);
        $slotduration = $schedule->slot_duration;
        $isbookedslot = appointment::where('doctor_id', $this->doctor_id)->where('appointment_date', $this->appointmentdate)
            ->where('status', 'confirmed')->pluck('start_time')->map(function ($time) {
                return substr($time, 0, 5);
            })->toArray();


        while ($starttime < $endtime) {

            $endslot = $starttime->copy()->addMinutes($slotduration);
            $slottime = $starttime->format('H:i');

            $isbooked = in_array($starttime->format('H:i'), $isbookedslot);

            $slots[] = [

                'start' => $slottime,
                'end' => $endslot->format('H:i'),
                'display' => $starttime->format('g:i A') . '-' . $endslot->format('g:i A'),
                'availible' => !$isbooked,
            ];
            $starttime->addMinutes($slotduration);
            $this->availibleslots = $slots;
        }
    }

    public function selectslot($startime)
    {

        foreach ($this->availibleslots as $slot) {

            if ($slot['start'] == $startime && $slot['availible']) {

                $this->selectedslot = $slot;
                $this->step = 2;
                break;
            }
        }
        $this->selectedtime = $startime;
    }

    public function makeappointment()
    {

        $data = appointment::create([

            'doctor_id' => $this->doctor_id,
            'patient_id' => session('user_id'),
            'appointment_date' => $this->appointmentdate,
            'start_time' => $this->selectedslot['start'],
            'end_time' => $this->selectedslot['end'],
            'status' => 'pending'
        ]);

        session()->flash('success', 'Inserted Successfully');
        $this->dispatch('closenow');
    }

    public function backtostep1()
    {

        $this->step = 1;
        $this->availibleslots = null;
    }
};
?>

<div>

    <div class="container bg-white py-2 rounded-4 shadow-sm">
        <h3 class="text-center mb-3">Make Appointment Now</h3>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <!---Card--->
        @if ($this->Doctor)
        <div class="row g-4">
            @foreach ($this->Doctor as $doct)
            <div class="col-md-4 ">
                <div class="card shadow-sm">

                    <div class="card-body ">
                        <p class="text-center fw-semibold">{{ $doct->doctor_name }}</p>
                        <p>Department : {{ $doct->department->department_name }}</p>
                        <p>Email: {{ $doct->email }}</p>
                        <p>Specialization: {{ $doct->specialization }}</p>
                        <p>Qualification: {{ $doct->qualification }}</p>
                        <p>Experience Years: {{ $doct->experience_years }}</p>
                        <p>Consultation Fees :{{ $doct->consultation_fee }}</p>
                        <button type="button" class="btn btn-primary" wire:click="appointment({{ $doct->id }})">Make Appointment</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif


        <!--Modal--->

        <div class="modal fade" tabindex="-1" id="modalappoint" wire:ignore.self>

            <div class="modal-dialog">
                <div class="modal-content">

                    @if ($step==1)
                    <div class="modal-body">
                        <h6>Select Date</h6>
                        <input type="date" class="form-control mb-2" wire:model.live="appointmentdate">
                        @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($appointmentdate)
                        <div class="d-flex flex-wrap gap-3 align-items-center mt-3">
                            @if ($this->availibleslots)
                            @foreach ($this->availibleslots as $slot)
                            @if ($slot['availible'])
                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="selectslot('{{ $slot['start'] }}')">
                                {{ $slot['display'] }}
                            </button>
                            @else

                            <button type="button" class="btn btn-outline-primary btn-sm" disabled>
                                {{ $slot['display'] }}
                                <span class="badge bg-danger ms-1">Booked</span>
                            </button>

                            @endif

                            @endforeach

                            @endif

                        </div>


                        @endif

                    </div>
                    @elseif($step==2)
                    <div class="modal-header" style="background-color: blue;">
                        <h5 class="text-center text-white">Confirmation Appointment</h5>
                    </div>
                    <div class="modal-body">

                        @php
                        $doctor=doctor::findOrFail($this->doctor_id);
                        @endphp
                        <div class="row p-1">
                            <div class="col-md-7">
                                <p class="fw-bold">Doctor Name:</p>
                            </div>
                            <div class="col-md-5">
                                <p>{{ $doctor->doctor_name }}</p>
                            </div>
                        </div>

                        <div class="row p-1">
                            <div class="col-md-7">
                                <p class="fw-bold">Appointment Date:</p>
                            </div>
                            <div class="col-md-5">
                                <p>{{ $appointmentdate }}</p>
                            </div>
                        </div>


                        <div class="row p-1">
                            <div class="col-md-7">
                                <p class="fw-bold">Time:</p>
                            </div>
                            <div class="col-md-5">
                                <p>{{ $this->selectedslot['display'] }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" wire:click="makeappointment" class="btn btn-primary">Confirm Appointment</button>
                            <button type="button" class="btn btn-secondary" wire:click="backtostep1">Back</button>
                        </div>

                    </div>



                    @endif

                </div>
            </div>

        </div>










    </div>








</div>