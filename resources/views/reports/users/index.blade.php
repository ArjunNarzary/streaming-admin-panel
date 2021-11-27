@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List of Users</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0">
          <thead>
            <tr>
            <th>#</th>
              <th width="20%">Name</th>
              <th>Email ID</th>
              <th>Phone No.</th>
              <th>Account Created</th>
              <th>Total Expense</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $key=>$user)
              <tr>
                  <td>{{ $key+1 }}</td>
                  <td><a href="{{ route('user.transactions', ['user' => $user->id]) }}">{{ $user->name }}</a></td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->phone }}</td>
                  <td>{{\Carbon\Carbon::parse($user->created_at)->format('d-m-Y')}}</td>
                  <td class="text-center">Rs. {{ $user->totalBillings }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('#eventsTable').DataTable({
        "columnDefs": [
        { "orderable": false, "targets": [4,5] }
        ]
    });
    });
</script>
@endpush
