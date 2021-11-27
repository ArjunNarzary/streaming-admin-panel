@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List of Series</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20%">Title</th>
              <th>Language</th>
              <th>Release Date</th>
              <th>Status</th>
              <th class="text-center">View</th>
              <th class="text-center">Edit</th>
              <th class="text-center">Manage Season</th>
            </tr>
          </thead>
          <tbody>
            @foreach($serieses as $series)
              <tr>
                  <td>{{$series->title}}</td>
                  <td>{{$series->language}}</td>
                  <td>{{\Carbon\Carbon::parse($series->release_date)->format('d-m-Y')}}</td>
                  <td class="{{ $series->status == 1 ? 'text-success' : 'text-danger' }}">{{$series->status == 1 ? 'Active' : 'Inactive'}}</td>
                  <td class="text-center"><a href="{{ route('series.view',['id'=>$series->id]) }}"><i class="fas fa-eye"></i></a></td>
                  <td class="text-center"><a href="{{ route('series.manage',['id'=>$series->id]) }}"><i class="fas fa-edit"></i></a></td>
                  <td class="text-center"><a href="{{ route('series.seasons',['id'=>$series->id]) }}"><i class="fas fa-tasks"></i></td>
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
