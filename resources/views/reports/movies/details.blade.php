@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="text-right pb-2">
        <a href="{{ route('report.movies') }}"><button class="btn btn-sm btn-primary">Back</button></a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-12 col-md-2">
                <img style="width:100%" src="{{ asset('storage/movies/'.$movie->banner) }}">
            </div>
            <div class="col-6 col-md-7">
                <h5 class="font-weight-bold text-uppercase text-primary">{{ $movie->title }}</h5>
                <h6 class="font-weight-bold text-uppercase mb-0">Discription</h6>
                {!! $movie->description !!}
                <h6 class="font-weight-bold text-uppercase">Lenguage</h6>
                {{ $movie->language }}
            </div>
            <div class="col-6 col-md-3">
                <h6 class="font-weight-bold text-uppercase mb-0">Release Date</h6>
                {{  Carbon\Carbon::parse($movie->release_date)->format('d-m-Y')  }}
                <h6 class="font-weight-bold text-uppercase mb-0">Premium Status</h6>
                @if($movie->premium_status == 0)
                Free
                @elseif($movie->premium_status == 1)
                Subscription
                @else
                Rental
                <h6 class="font-weight-bold text-uppercase mb-0">Amount (per week)</h6>
                Rs {{ $movie->amount }}
                @endif

                <h6 class="font-weight-bold text-uppercase mb-0">Type</h6>
                @if($movie->type == 1)
                Long Movie
                @else
                Short Movie
                @endif

                <h6 class="font-weight-bold text-uppercase mb-0">Length</h6>
               {{ $movie->lenght }} Minutes
            </div>
        </div>
    </div>
    <div class="card-body">
      <h6 class="m-0 mb-2 font-weight-bold text-primary">List of Purchase (For the year {{ date('Y') }})</h6>
    <div class="d-flex justify-content-right">
      <div class="pb-3" style="width:40%;">
          <label class="text-danger" for="filter">Montly Filter</label>
          <select class="custom-select" name="filter" id="filter" movie-id="{{ $movie->id }}">
                @php $i = 1; @endphp
                @for($i== 1; $i<= 12; $i++)
                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
          </select>
      </div>
    </div>
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0" id="detailsTable">
          <thead>
            <tr>
            <th>#</th>
              <th width="20%">User Name</th>
              <th>Amount Paid</th>
              <th>Purchase Date</th>
            </tr>
          </thead>
          <tbody id="table-parchase-list">

          </tbody>
        </table>
      </div>
      <div class="float-right pt-3">
        <h5 class="font-weight-bold text-uppercase">Total Amount: Rs.<span id="total"></span></h5>
      </div>
    </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

       var table =  $('#detailsTable').DataTable({
        "processing": true,
        "pageLength": 25,

        "columns": [{
                "data": "slno"
            },
            {
                "data": "user_name"
            },
            {
                "data": "amount"
            },
            {
                "data": "update"
            },
        ],
        dom: 'Bfrtip',
        paging: true,
        autoWidth: true,
        buttons : [ 
              {
                    extend: 'print',
                    title: '<h4 style="text-align:center">Movie Report</h4> <h5 class="text-center">Movie Title - {{ $movie->title  }}</h5>',
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )
                            .prepend(
                              '<img src="/assets/img/logo-bg.png" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%)" />'
                            );
    
                        $(win.document.body).find( 'table' ).append('<tr><td colspan="4" class="text-right">Total : Rs. '+total+'</td></tr>');

                      }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Movie Report \n  Movie Title - {{ $movie->title  }}',
                    pageSize: 'A4', //Page format
                    // messageBottom: 'Total Rs. '+total,
                    customize: function ( doc ) {
                        doc.styles['table'] = 'font-size: 70px';
                        doc.content.splice( 2, 0, {
                            alignment: 'right',
                            fontSize: '15',
                            text: 'Total Rs. '+total,
                        } );
                        doc.pageMargins = [10, 20, 10, 10];
                        doc.styles.tableHeader.fontWeight = '900';   //table header align center
                        doc.content[1].table.widths = [50,'*','*','*'];  //table width
                        doc.styles.tableBodyEven.alignment = 'center';   //table header align center
                        doc.styles.tableBodyOdd.alignment = 'center';   //table header align center

                      }
                },
                // {
                //     extend: 'excelHtml5',
                //     // title: 'Movie Report \n  Movie Title - {{ $movie->title  }}',
                // },
        ],
        "ajax": {
            url: "{{ route('report.movie.montly') }}",
            type: 'POST',
            "dataSrc": "payments",
            data: function(d) {
                d.movie_id = $('#filter').attr('movie-id');
                d.month = $('#filter').val();
            },
            complete: function(data) {
              total = data.responseJSON.total;
                $('#total').text(total);
            }
        },
        });

        $(document).on('change', '#filter', function(){
            table.ajax.reload();
        });
    });
</script>
@endpush
