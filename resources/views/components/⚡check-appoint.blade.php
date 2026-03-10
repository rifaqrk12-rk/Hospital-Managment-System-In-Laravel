<?php

use Livewire\Component;
use App\Models\appointment;

new class extends Component
{
    public $selectedStatus = [];
    public $updatingId = null;
    
    public function getAppointmentProperty()
    {
        $id = session('user_id');
        $data = appointment::with('patients', 'doctor')->get();
        return $data;
    }
    
    public function updateStatus($appointmentId, $status)
    {
        try {
            $appointment = appointment::findOrFail($appointmentId);
            $appointment->status = $status;
            $appointment->save();
            
            session()->flash('success', 'Status updated successfully!');
            $this->updatingId = null;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating status: ' . $e->getMessage());
        }
    }
    
    public function confirmUpdate($appointmentId)
    {
        $this->updatingId = $appointmentId;
    }
    
    public function cancelUpdate()
    {
        $this->updatingId = null;
    }
    
  
};
?>

<div>
    <div class="container">
        <h4 class="text-center mb-3">View All Appointments</h4>
        
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
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
                        <td>{{ $appoint->doctor->doctor_name ?? 'N/A' }}</td>
                        <td>{{ $appoint->patients->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appoint->appointment_date)->format('d M, Y') }}</td>
                        <td>{{ substr($appoint->start_time, 0, 5) }}</td>
                        <td>{{ substr($appoint->end_time, 0, 5) }}</td>
                        <td>
                            @if($updatingId == $appoint->id)
                                {{-- Status Update Dropdown --}}
                                <select class="form-select form-select-sm" 
                                        wire:change="updateStatus({{ $appoint->id }}, $event.target.value)">
                                    <option value="pending" {{ $appoint->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="confirmed" {{ $appoint->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                    <option value="cancelled" {{ $appoint->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    <option value="completed" {{ $appoint->status == 'completed' ? 'selected' : '' }}>✓ Completed</option>
                                </select>
                            @else
                                {{-- Status Badge --}}
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        'completed' => 'info'
                                    ];
                                    $color = $statusColors[$appoint->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} p-2">
                                    {{ ucfirst($appoint->status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($updatingId == $appoint->id)
                                <button class="btn btn-sm btn-outline-secondary" 
                                        wire:click="cancelUpdate">
                                    Cancel
                                </button>
                            @else
                                <button class="btn btn-sm btn-outline-primary" 
                                        wire:click="confirmUpdate({{ $appoint->id }})">
                                    <i class="bi bi-pencil"></i> Change Status
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Optional CSS --}}
<style>
    .badge {
        font-size: 0.9em;
        padding: 0.5em 1em;
    }
    .form-select-sm {
        width: 130px;
        display: inline-block;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>