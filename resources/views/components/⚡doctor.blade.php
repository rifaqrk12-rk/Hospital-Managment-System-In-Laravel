<?php

use Livewire\Component;
use App\Models\department;
use App\Models\Doctor;

new class extends Component
{
    public $suggestion = [];
    public $department, $selectedid;
    public $doctor_name, $email, $phone, $specialization, $qualification, $exp_years, $consul_fees;
    public $editid, $editdoctor;
    public $deptid;
    public function open()
    {
        $this->dispatch('Opennow');
    }

    public function updatedDepartment()
    {

        if (strlen($this->department) > 2) {

            $this->suggestion = department::where('department_name', 'like', '%' . $this->department . '%')->select('id', 'department_name')->limit(5)->get();
        } else {
            $this->suggestion = [];
        }
    }

    public function select($id, $department)
    {

        $this->selectedid = $id;
        $this->department = $department;
        $this->suggestion = [];
    }

    public function save()
    {

        Doctor::create([

            'dept_id' => $this->selectedid,
            'doctor_name' => $this->doctor_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'specialization' => $this->specialization,
            'qualification' => $this->qualification,
            'experience_years' => $this->exp_years,
            'consultation_fee' => $this->consul_fees
        ]);

        $this->reset('selectedid', 'doctor_name', 'email', 'phone', 'specialization', 'qualification', 'exp_years', 'consul_fees');
        session()->flash('success', 'Successfully Inserted');
    }

    public function getDoctorsProperty()
    {

        return Doctor::with('department')->get();
    }

    public function edit($id)
    {

        $data = Doctor::with('department')->findOrFail($id);
        $this->editdoctor = $data;
        $this->deptid = $data->dept_id;
        $this->editid = $data->id;
        $this->department = $data->department->department_name;
        $this->doctor_name = $data->doctor_name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->specialization = $data->specialization;
        $this->qualification = $data->qualification;
        $this->exp_years = $data->experience_years;
        $this->consul_fees = $data->consultation_fee;
        $this->dispatch('editdoctor');
    }

    public function editnow()
    {
        try {
            $data = Doctor::with('department')->findOrFail($this->editid);
            $data->update([
                'dept_id' => $this->deptid,
                'doctor_name' => $this->doctor_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'specialization' => $this->specialization,
                'qualification' => $this->qualification,
                'experience_years' => $this->exp_years,
                'consultation_fee' => $this->consul_fees,
            ]);

            if ($this->deptid && $this->department) {
                $department = department::findOrFail($this->deptid);
                if ($department) {
                    $department->update([
                        'department_name' => $this->department
                    ]);

                    session()->flash('success', 'Updated Successfully');
                    $this->reset([
                        'doctor_name',
                        'email',
                        'phone',
                        'specialization',
                        'qualification',
                        'exp_years',
                        'consul_fees'
                    ]);
                    $this->dispatch('closeedit');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating doctor: ' . $e->getMessage());
        }
    }
};
?>

<div>

    <div>

        <div class="container bg-white rounded-2">

            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold">Add Doctor Now</h5>
                <button type="button" wire:click="open" class="btn btn-primary m-1">Add Doctor</button>
            </div>



            <div class="modal fade" tabindex="-1" id="showmodal" wire:ignore.self>
                <div class="modal-dialog modal-lg">

                    <div class="modal-content">
                        <div class="modal-header" style="background-color: blueviolet;">
                            <h5 class="text-white">Add Doctor</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="color:white"></button>
                        </div>
                        <div class="modal-body">

                            <form wire:submit.prevent="save" class="p-2">
                                <div class="row mb-2">
                                    <div class="col-md-12 position-relative">
                                        <label class="form-label">Select Department</label>
                                        <input type="text" wire:model.live="department" class="form-control" placeholder="Search Department Name">

                                        @if (!empty($this->suggestion))
                                        <div class="position-absolute w-100 bg-white shadow-sm" style="z-index: 1000; max-height:300px; overflow-y: auto;">

                                            @foreach ($this->suggestion as $suggest)
                                            <div class="border-bottom p-2 " wire:click="select({{ $suggest->id }},'{{ $suggest->department_name }}')" style="cursor: pointer;">
                                                {{ $suggest->department_name }}
                                            </div>

                                            @endforeach

                                            @endif

                                        </div>

                                    </div>


                                    <div class="d-flex gap-2">
                                        <!---Doctor Name--->
                                        <div class="col-md-6">
                                            <label class="form-label">Doctor Name:</label>
                                            <input type="text" wire:model.defer="doctor_name" class="form-control mb-2" placeholder="Enter Doctor Name">
                                        </div>

                                        <!---Doctor Email--->

                                        <div class="col-md-6">
                                            <label class="form-label">Doctor Email:</label>
                                            <input type="email" wire:model.defer="email" class="form-control mb-2" placeholder="Enter Doctor Email">
                                        </div>
                                    </div>


                                    <div class="d-flex gap-2">
                                        <!---Phone--->

                                        <div class="col-md-6">
                                            <label class="form-label">Phone:</label>
                                            <input type="number" wire:model.defer="phone" class="form-control mb-2" placeholder="Enter Phone">
                                        </div>


                                        <!---Doctor Specialization--->

                                        <div class="col-md-6">
                                            <label class="form-label">Specialization:</label>
                                            <input type="text" wire:model.defer="specialization" class="form-control mb-2" placeholder="Enter Specialization">
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <!---Doctor qualification--->

                                        <div class="col-md-6">
                                            <label class="form-label">Qualification:</label>
                                            <input type="text" wire:model.defer="qualification" class="form-control mb-2" placeholder="Enter qualification">
                                        </div>

                                        <!---Doctor Experience Years--->

                                        <div class="col-md-6">
                                            <label class="form-label">Experience Years:</label>
                                            <input type="number" wire:model.defer="exp_years" class="form-control mb-2" placeholder="Enter Experience Years">
                                        </div>
                                    </div>

                                    <!---Doctor Consultation fees--->

                                    <div class="col-md-12">
                                        <label class="form-label">Consul_fees:</label>
                                        <input type="number" wire:model.defer="consul_fees" class="form-control mb-2" placeholder="Enter Consul_fees">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Add Doctor</button>

                                </div>






                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>

        @endif

        <div class="container mt-3 ">
            <h4 class="text-center mb-3">View All Departments</h4>


            <table class="table ">
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Doctor Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Experience Years</th>
                        <th>Consultation Fees</th>
                        <th>Action</th>

                </thead>
                <tbody>
                    @foreach ($this->Doctors as $doct)

                    <tr>
                        <td>{{ $doct->department->department_name }}</td>
                        <td>{{ $doct->doctor_name }}</td>
                        <td>{{ $doct->email }}</td>
                        <td>{{ $doct->specialization }}</td>
                        <td>{{ $doct->experience_years }}</td>
                        <td>{{ $doct->consultation_fee}}</td>
                        <td>
                            <button type="button" wire:click="edit({{ $doct->id }})" class="btn btn-secondary">Edit</button>
                            <button type="button" wire:click="delete({{ $doct->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>


            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="editdoct">

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Doctor</h5>
                        </div>
                        <div class="modal-body">

                            <form wire:submit.prevent="editnow">

                                <!---Department Name--->
                                <div class="col-md-12">
                                    <label class="form-label">Department Name:</label>
                                    <input type="text" wire:model.defer="department" class="form-control mb-2" placeholder="Enter Doctor Name">
                                </div>

                                <div class="d-flex gap-2">

                                    <!---Doctor Name--->
                                    <div class="col-md-6">
                                        <label class="form-label">Doctor Name:</label>
                                        <input type="text" wire:model.defer="doctor_name" class="form-control mb-2" placeholder="Enter Doctor Name">
                                    </div>

                                    <!---Doctor Email--->

                                    <div class="col-md-6">
                                        <label class="form-label">Doctor Email:</label>
                                        <input type="email" wire:model.defer="email" class="form-control mb-2" placeholder="Enter Doctor Email">
                                    </div>
                                </div>


                                <div class="d-flex gap-2">
                                    <!---Phone--->

                                    <div class="col-md-6">
                                        <label class="form-label">Phone:</label>
                                        <input type="number" wire:model.defer="phone" class="form-control mb-2" placeholder="Enter Phone">
                                    </div>


                                    <!---Doctor Specialization--->

                                    <div class="col-md-6">
                                        <label class="form-label">Specialization:</label>
                                        <input type="text" wire:model.defer="specialization" class="form-control mb-2" placeholder="Enter Specialization">
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <!---Doctor qualification--->

                                    <div class="col-md-6">
                                        <label class="form-label">Qualification:</label>
                                        <input type="text" wire:model.defer="qualification" class="form-control mb-2" placeholder="Enter qualification">
                                    </div>

                                    <!---Doctor Experience Years--->

                                    <div class="col-md-6">
                                        <label class="form-label">Experience Years:</label>
                                        <input type="number" wire:model.defer="exp_years" class="form-control mb-2" placeholder="Enter Experience Years">
                                    </div>
                                </div>

                                <!---Doctor Consultation fees--->

                                <div class="col-md-12">
                                    <label class="form-label">Consul_fees:</label>
                                    <input type="number" wire:model.defer="consul_fees" class="form-control mb-2" placeholder="Enter Consul_fees">
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary mt-3">Edit</button>
                                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
                                </div>
                        </div>
                        </form>

                    </div>
                </div>

            </div>


        </div>


    </div>