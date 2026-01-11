<x-dashboard.layout>
    <x-slot:title>Dashboard</x-slot:title>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards Row -->
    <div class="row">
        <!-- Total Volunteers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Volunteers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_volunteers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Tasks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Workplaces Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Workplaces
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_workplaces'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Assignments Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Assignments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_assignments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Top Volunteers by Assignments -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Volunteers by Assignments</h6>
                </div>
                <div class="card-body">
                    @forelse($volunteerStats->take(5) as $volunteer)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-800">{{ $volunteer->name }}</span>
                            <span class="badge badge-primary">{{ $volunteer->assignments_count }}</span>
                        </div>
                    @empty
                        <p class="text-muted">No volunteer data available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Workplaces by Assignments -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Workplaces by Assignments</h6>
                </div>
                <div class="card-body">
                    @forelse($workplaceStats->take(5) as $workplace)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-gray-800">{{ $workplace->name }}</span>
                            <span class="badge badge-info">{{ $workplace->assignments_count }}</span>
                        </div>
                    @empty
                        <p class="text-muted">No workplace data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Data Tables Row -->
    <div class="row">
        <!-- Recent Assignments -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Assignments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Volunteer</th>
                                    <th>Task</th>
                                    <th>Workplace</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivity as $assignment)
                                    <tr>
                                        <td>{{ $assignment->volunteer->name ?? 'N/A' }}</td>
                                        <td>{{ $assignment->task->name ?? 'N/A' }}</td>
                                        <td>{{ $assignment->workplace->name ?? 'N/A' }}</td>
                                        <td>{{ $assignment->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No recent assignments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('volunteers.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus"></i> Add Volunteer
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('tasks.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> Add Task
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('workplace.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-building"></i> Add Workplace
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('assignment.create') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clipboard"></i> Add Assignment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.layout>
