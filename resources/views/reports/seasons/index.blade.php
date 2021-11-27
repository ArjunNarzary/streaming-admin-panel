@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List of Seasons</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0" id="seasonTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Series Title</th>
              <th>Season No.</th>
              <th width="20%">Season Title</th>
              <th>Language</th>
              <th>Release Date</th>
              <th>Total Episodes</th>
              <th>Status</th>
              <th class="text-center">Premium Status</th>
              <th class="text-center">Total Earned</th>
            </tr>
          </thead>
          <tbody>
            @foreach($seasons as $key=>$season)
              <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $season->series->title }}</td>
                  <td>{{ $season->season_no }}</td>
                  <td><a href="{{ route('report.season.detail', ['id' => $season->id]) }}">{{$season->title}}</a></td>
                  <td>{{ $season->series->language }}</td>
                  <td>{{ $season->total_episodes }}</td>
                  <td>{{\Carbon\Carbon::parse($season->release_date)->format('d-m-Y')}}</td>
                  <td class="{{ $season->status == 1 ? 'text-success' : 'text-danger' }}">{{$season->status == 1 ? 'Active' : 'Inactive'}}</td>
                  <td class="text-center">
                      @if($season->premium_type == 0)
                         Free
                      @elseif($season->premium_type == 1)
                         Subscription
                      @else
                         Rental
                      @endif
                  </td>
                  <td class="text-center">Rs. {{ $season->total }}</td>
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
    $('#seasonTable').DataTable({
        dom: 'Bfrtip',
        paging: true,
        autoWidth: true,
       
        buttons: [
           // 'copyHtml5',
            // 'print',
            //'csvHtml5',
            // 'pdfHtml5',
            {
                extend: 'print',
                title: '<h4 style="text-align:center">Season Report</h4>',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                          '<img src="/assets/img/logo-bg.png" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%)" />'
                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );

                  }
            },
            {
              extend: 'excelHtml5',
              title: 'Season Report',
            },
            {
              extend: 'pdfHtml5',
              title: 'Season Report',
            }
           
        ],
        "columnDefs": [
        { "orderable": false, "targets": [4,5] }
        ]
    });
    });
</script>
@endpush
