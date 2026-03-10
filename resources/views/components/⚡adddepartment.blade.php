<?php

use Livewire\Component;
use App\Models\department;

new class extends Component
{
    public $department, $editid;
    public function open()
    {

        $this->dispatch('OpenModal');
    }

    public function save()
    {

        department::create([

            'department_name' => $this->department

        ]);

        $this->reset('department');
        $this->dispatch('closeModal');
        session()->flash('success', 'Added Successfully');
    }

    public function getDepartmentProperty()
    {

        return department::all();
    }

    public function edit($id)
    {

        $data = department::findOrFail($id);
        $this->editid = $data->id;
        $this->department = $data->department_name;
        $this->dispatch('editmodal');
    }

    public function editnow()
    {

        $data = department::findOrFail($this->editid);
        $data->update([

            'department_name' => $this->department

        ]);

        $this->reset('department');
        $this->dispatch('closeit');
    }

    public function delete($id)
    {

        $data = department::findOrFail($id);
        $data->delete();
    }
};
?>

<div>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container bg-white rounded-2">

        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-semibold">Add Department Now</h5>
            <button type="button" wire:click="open" class="btn btn-primary m-1">Add Department</button>
        </div>

        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="show">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet;">
                        <h5 class="text-white">Add Department</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="color:white"></button>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Add Department</label>
                                    <input type="text" wire:model.defer="department" class="form-control mb-3" placeholder="Enter Department Name">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Now</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Table-->




    <div class="container mt-3 ">
        <h4 class="text-center mb-3">View All Departments</h4>


        <table class="table text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department Name</th>
                    <th>Action</th>

            </thead>
            <tbody>
                @foreach ($this->Department as $dept)

                <tr>
                    <td>{{ $dept->id }}</td>
                    <td>{{ $dept->department_name }}</td>
                    <td>
                        <button type="button" wire:click="edit({{ $dept->id }})" class="btn btn-secondary">Edit</button>
                        <button type="button" wire:click="delete({{ $dept->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>


        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="edit">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Department Name</h5>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="editnow">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Edit Department Name</label>
                                    <input type="text" wire:model.defer="department" class="form-control" value="{{ $department }}">
                                </div>
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