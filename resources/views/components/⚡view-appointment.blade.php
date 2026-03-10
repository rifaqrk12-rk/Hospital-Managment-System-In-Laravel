<?php

use Livewire\Component;
use App\Models\appointment;
use App\Models\Doctor;


new class extends Component
{
    public $editid, $doctorname, $patientname, $appointment_date, $start_time, $end_time, $status;
    public function getAppointmentProperty()
    {

        $id = session('user_id');
        $data = appointment::with('patients', 'doctor')->where('patient_id', $id)->get();
        return $data;
    }

    public function edit($id)
    {

        $data = appointment::with('patients', 'doctor')->findOrFail($id);
        $this->editid = $data->id;
        $this->doctorname = $data->doctor->doctor_name;
        $this->patientname = $data->patients->name;
        $this->appointment_date = $data->appointment_date;
        $this->start_time = $data->start_time;
        $this->end_time = $data->end_time;
        $this->status = $data->status;
        $this->dispatch('OpenModal');
    }

    public function delete($id){

        $data=appointment::findOrFail($id);
        $data->delete($data->id);
        session()->flash('success','Deleted Successfully');

    }



};
?>

<div>
    <div class="container">
        <h4 class="text-center mb-3">View All Appointments</h4>
        <table class="table">

            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($this->Appointment as $appoint)
                <tr>
                    <td>{{ $appoint->doctor->doctor_name }}</td>
                    <td>{{ $appoint->patients->name }}</td>
                    <td>{{ $appoint->appointment_date }}</td>
                    <td>{{ $appoint->start_time }}</td>
                    <td>{{ $appoint->end_time }}</td>
                    <td>{{ $appoint->status }}</td>
                    <td>
                        <button type="button" wire:click="delete('{{ $appoint->id }}')" class="btn btn-danger">Delete</button>
                    </td>
                </tr>

                @endforeach
            </tbody>



        </table>
    </div>

   
</div>