<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Volu System</title>
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('build/assets/css/bootstrap.min.css') }}">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="{{ asset('build/dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}">
    {{-- bootstrap --}}
    {{-- <link rel="stylesheet" href="{{ asset('build/dashboard-assets/css/bootstrap.min.css') }}"> --}}
    <!-- Custom styles for this template-->
    <link href="{{ asset('build/dashboard-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-4">
            <a href="/login" class="btn btn-outline-primary btn-lg shadow-sm px-4 py-2 d-flex align-items-center">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </a>
        </div>
        <h1 class="mb-4 text-primary fw-bold">Volunteers Assignments</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 px-4 py-3">
                <h5 class="mb-3 fw-semibold">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    Assignments
                    <small class="text-muted">({{ $assignments->count() }})</small>
                </h5>
                <form method="GET" class="d-flex mb-0">
                    <input type="text" name="q" class="form-control me-2"
                        placeholder="Search by volunteer, task, workplace, or status" value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-borderless">
                        <thead class="bg-light">
                            <tr>
                                <th class="w-50 fw-normal text-secondary">Volunteer</th>
                                <th class="fw-normal text-secondary" style="max-width: 220px;">Workplace</th>
                                <th class="fw-normal text-secondary" style="max-width: 300px;">Task</th>
                                <th class="fw-normal text-secondary text-center" style="width:120px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $assignment)
                                <tr>
                                    <td style="max-width: 250px;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-3"
                                                style="width:40px;height:40px;font-weight:600;font-size:1rem;">
                                                {{ strtoupper(substr($assignment->volunteer->name ?? 'N', 0, 1)) }}
                                            </div>
                                            <div class="overflow-hidden">
                                                <div class="fw-semibold text-truncate">
                                                    {{ $assignment->volunteer->name ?? 'N/A' }}</div>
                                                @if (!empty($assignment->volunteer->email))
                                                    <small
                                                        class="text-muted">{{ $assignment->volunteer->email }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width: 220px;">
                                        <span
                                            class="text-dark text-truncate">{{ $assignment->workplace->name ?? 'N/A' }}</span>
                                    </td>
                                    <td style="max-width: 300px;">
                                        <span
                                            class="text-info text-truncate">{{ $assignment->task->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill {{ $assignment->status_badge_class ?? 'bg-secondary' }} px-3 py-2">
                                            {{ ucfirst($assignment->status ?? 'unknown') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <div class="mb-2"><i class="fas fa-inbox fa-2x text-secondary"></i></div>
                                        No assignments found.
                                        @if (request('q'))
                                            <div><a href="{{ request()->url() }}"
                                                    class="btn btn-sm btn-outline-secondary mt-3">Clear filters</a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (method_exists($assignments, 'links'))
                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <small class="text-muted">Showing {{ $assignments->count() }} assignment(s)</small>
                    <div>
                        {{ $assignments->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('build/dashboard-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('build/dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('build/dashboard-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('build/dashboard-assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
