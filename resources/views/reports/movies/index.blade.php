@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List of Movies</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0" id="moviesReportTable">
          <thead>
            <tr>
            <th>#</th>
              <th width="20%">Title</th>
              <th>Language</th>
              <th>Release Date</th>
              <th>Status</th>
              <th class="text-center">Premium Status</th>
              <th class="text-center">Type</th>
              <th class="text-center">Total Earned</th>
            </tr>
          </thead>
          <tbody>
            @foreach($movies as $key=>$movie)
              <tr>
                  <td>{{ $key+1 }}</td>
                  <td><a href="{{ route('report.movie.detail', ['id' => $movie->id]) }}">{{$movie->title}}</a></td>
                  <td>{{$movie->language}}</td>
                  <td>{{\Carbon\Carbon::parse($movie->release_date)->format('d-m-Y')}}</td>
                  <td class="{{ $movie->status == 1 ? 'text-success' : 'text-danger' }}">{{$movie->status == 1 ? 'Active' : 'Inactive'}}</td>
                  <td class="text-center">
                      @if($movie->premium_status == 0)
                         Free
                      @elseif($movie->premium_status == 1)
                         Subscription
                      @else
                         Rental
                      @endif
                  </td>
                  <td class="text-center">
                      @if($movie->type == 1)
                         Long Movie
                      @else
                         Short Movie
                      @endif
                  </td>
                  <td class="text-center">Rs. {{ $movie->total }}</td>

                  {{-- <td class="text-center"><a href="{{ route('movie.seasons',['id'=>$movie->id]) }}"><i class="fas fa-tasks"></i></td> --}}
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
    $('#moviesReportTable').DataTable({
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
                title: '<h4 style="text-align:center">Movie Report</h4>',
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
              title: 'Movie Report',
            },
            {
              extend: 'pdfHtml5',
              title: 'Movie Report',
            }
           
        ],
        "columnDefs": [
        { "orderable": false, "targets": [4,5] }
        ]
    });
    });
</script>
@endpush
