@extends('layout.admin-layout')

@section('content')

  <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h4 class="mb-0" id="pageTitle">Dashboard</h4>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <p class="mb-0 fw-bold">Admin User</p>
                    <small class="text-muted">admin@cityhospital.com</small>
                </div>
                <div class="user-avatar">A</div>
            </div>
        </div>
        
        <!-- ===== DASHBOARD SECTION ===== -->
        <div id="dashboardSection">
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card blue">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Total Doctors</p>
                                <div class="stat-number">24</div>
                                <small class="text-success">+3 this month</small>
                            </div>
                            <div class="stat-icon">
                                <i class="fa-solid fa-user-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card green">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Total Patients</p>
                                <div class="stat-number">1,245</div>
                                <small class="text-success">+120 today</small>
                            </div>
                            <div class="stat-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card orange">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Departments</p>
                                <div class="stat-number">12</div>
                                <small>8 active</small>
                            </div>
                            <div class="stat-icon">
                                <i class="fa-solid fa-building"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card red">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Appointments</p>
                                <div class="stat-number">48</div>
                                <small>12 pending</small>
                            </div>
                            <div class="stat-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="section-card">
                        <h5 class="section-title">Quick Actions</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary" onclick="showSection('departments')">
                                <i class="fa-solid fa-plus me-2"></i>Add Department
                            </button>
                            <button class="btn btn-primary" onclick="showSection('doctors')">
                                <i class="fa-solid fa-user-plus me-2"></i>Add Doctor
                            </button>
                            <button class="btn btn-primary" onclick="showSection('schedule')">
                                <i class="fa-solid fa-clock me-2"></i>Add Schedule
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="fa-solid fa-file-pdf me-2"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Appointments -->
            <div class="row mt-3">
                <div class="col-md-8">
                    <div class="table-container">
                        <h5 class="mb-3">Recent Appointments</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rahul Kumar</td>
                                    <td>Dr. Sharma</td>
                                    <td>2026-03-08</td>
                                    <td>10:30 AM</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Priya Singh</td>
                                    <td>Dr. Verma</td>
                                    <td>2026-03-08</td>
                                    <td>11:45 AM</td>
                                    <td><span class="badge badge-success">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>Amit Patel</td>
                                    <td>Dr. Gupta</td>
                                    <td>2026-03-08</td>
                                    <td>02:00 PM</td>
                                    <td><span class="badge badge-success">Confirmed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="table-container">
                        <h5 class="mb-3">Today's Summary</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total Appointments</span>
                                <span class="fw-bold">48</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Completed</span>
                                <span class="fw-bold text-success">32</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="fw-bold text-warning">12</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Cancelled</span>
                                <span class="fw-bold text-danger">4</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Doctors Available</span>
                                <span class="fw-bold">18/24</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

@endsection