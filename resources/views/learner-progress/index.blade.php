@extends('layouts.app')

@section('content')

<style>
body {
      background: #e2e1e0;
}
#learners-table thead th:nth-child(1) {
    width:25%;
}
#learners-table thead th:nth-child(2) {
    width:35%;
}
#learners-table thead th:nth-child(3) {
    text-align: left !important;
    width:40%;
}
.progress{
    --bs-progress-bar-bg: #CCC !important ;
}
small{
    color: #777;
}
.card {
    background: #fff;
    border-radius: 2px;
    margin: 1rem 0rem 2rem;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important;
}
.c-img.c-logo {
    width: 200px;
}
.card-header{
    background-color: #EEE!important;
}
.bg-danger{
    background-color: #FF0000 !important;
}
</style>
<h1 class="display-6">Learner Progress Dashboard</h1>
<div class="card">
    <div class="card-header"><div class="row g-3 align-items-center py-2">
        <div class="col-auto">
            <label for="courseFilter"><strong>Filter by Course:</strong></label>
        </div>
        <div class="col-auto">
            <select id="courseFilter" class="form-select" style="max-width: 300px;">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">
                    {{ $course->name }} ({{ $course->enrolments_count }})
                </option>
                @endforeach
            </select>
        </div>
    </div></div>
    <div class="card-body">
        <table id="learners-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Courses Enrolled (Progress %)</th>
                    <th>Average Progress</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


@endsection

@push('scripts')
<script type="module">  
    $(function() {
        const table = $('#learners-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("learner-progress.data") }}',
                data: function (d) {
                    d.course_id = $('#courseFilter').val(); // Send selected course ID
                }
            },
            columns: [
                { data: 'full_name', name: 'full_name', orderable: false, searchable: false  },
                { data: 'courses', name: 'courses', orderable: false, searchable: false },
                { data: 'average_progress', name: 'average_progress' }
            ]

        });

        // When the dropdown changes, reload the table
        $('#courseFilter').on('change', function () {
            table.ajax.reload();
        });
    });
</script>
@endpush
