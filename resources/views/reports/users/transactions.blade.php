@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="text-right pb-2">
        <a href="{{ route('users.all') }}"><button class="btn btn-sm btn-primary">Back</button></a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <h6 class="font-weight-bold text-uppercase text-primary mb-0">Name</h6>
               {{ $user->first_name }} {{ $user->last_name }}
                <h6 class="font-weight-bold text-uppercase text-primary mb-0">Phone No</h6>
               {{ $user->phone }}
            </div>
            <div class="col-12 col-md-6">
                <h6 class="font-weight-bold text-uppercase text-primary mb-0">Email Address</h6>
               {{ $user->email }}
                <h6 class="font-weight-bold text-uppercase text-primary mb-0">Account Created</h6>
               {{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}
            </div>
        </div>
    </div>
    <div class="card-body">
      <h6 class="m-0 mb-2 font-weight-bold text-primary">List of Purchases</h6>

      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0" id="transactions">
          <thead>
            <tr>
              <th>#</th>
              <th width="20%">Section</th>
              <th>Section Title</th>
              <th>Amount</th>
              <th>Tansaction Date</th>
            </tr>
          </thead>
          <tbody id="table-parchase-list">
                @php
                  $slno = 0;
                @endphp
                @foreach($seasonTrans as $trans)
                        @php
                            $slno = $slno + 1;
                        @endphp
                    <tr>
                        <td>{{ $slno }}</td>
                        <td>{{ $trans->section }}</td>
                        <td>{{ $trans->season->series->title }} {{ $trans->season->title }}</td>
                        <td>{{ $trans->amount }}</td>
                        <td>{{ Carbon\Carbon::parse($trans->updated_at)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach

                @foreach($movieTrans as $trans)
                    @php
                        $slno = $slno + 1;
                    @endphp
                    <tr>
                        <td>{{ $slno }}</td>
                        <td>{{ $trans->section }}</td>
                        <td>{{ $trans->movie->title ?? $trans->season->title }}</td>
                        <td>{{ $trans->amount }}</td>
                        <td>{{ Carbon\Carbon::parse($trans->updated_at)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
          </tbody>
        </table>
      </div>
      <div class="float-right pt-3">
        <h5 class="font-weight-bold text-uppercase">Total Amount: Rs.<span id="total">{{ $totalAmount }}</span></h5>
      </div>
    </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    <script>
    $(document).ready(function() {
    $('#transactions').DataTable({
        "columnDefs": [
            {
            "order": [[4, 'desc']],
            }
        ]
    });
    });
</script>
@endpush
