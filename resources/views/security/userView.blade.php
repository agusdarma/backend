@extends('layouts.master')
@section('content')
<table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>FIRST NAME</th>
            </tr>
        </thead>
    </table>
@endsection
@section('jsSelect2')
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://localhost:8000//UserData/view/data',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'first_name' }
        ]
    });
});
</script>
@endsection
@section('cssSelect2')
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection
