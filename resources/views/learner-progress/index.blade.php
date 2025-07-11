@extends('layouts.app')

@section('content')

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
        $('#learners-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("learner-progress.data") }}',
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'courses', name: 'courses', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
