@extends('layouts.app')

@section('content')

<div class="mb-4">
    <label for="courseFilter" class="form-label">Filter by Course:</label>
    <select id="courseFilter" class="form-select" style="max-width: 300px;">
        <option value="">All Courses</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
</div>

<div class="card">
            <div class="card-header"><h1 class="display-6">Learner Progress Dashboard</h1></div>
            <div class="card-body">
                <table id="learners-table" class="table table-striped">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Courses Enrolled (Progress %)</th>
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
                { data: 'full_name', name: 'full_name' },
                { data: 'courses', name: 'courses', orderable: false, searchable: false }
            ]
        });

        // When the dropdown changes, reload the table
        $('#courseFilter').on('change', function () {
            table.ajax.reload();
        });
    });
</script>
@endpush
