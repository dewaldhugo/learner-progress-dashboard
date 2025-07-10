@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Learner Progress Dashboard</h1>

    <table id="learners-table" class="table table-striped">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Courses Enrolled (Progress %)</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
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
