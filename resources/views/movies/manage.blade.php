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
        <table class="table table-bordered datatable"width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20%">Title</th>
              <th>Language</th>
              <th>Length</th>
              <th>Release Date</th>
              <th>Premium Status</th>
              <th>Status</th>
              <th class="text-center">View</th>
              <th class="text-center">Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($movies as $movie)
              <tr>
                  <td>{{$movie->title}}</td>
                  <td>{{$movie->language}}</td>
                  <td>{{$movie->duration}}</td>
                  <td>{{\Carbon\Carbon::parse($movie->release_date)->format('d-m-Y')}}</td>
                  <td>{{$movie->premium_status == 2 ? 'Premium' : 'Free'}}</td>
                  <td class="{{ $movie->status == 1 ? 'text-success' : 'text-danger' }}">{{$movie->status == 1 ? 'Active' : 'Inactive'}}</td>
                  <td class="text-center"><a href="{{route('movie.view',['id'=>$movie->id])}}"><i class="fas fa-eye"></i></a></td>
                  <td class="text-center"><a href="{{route('movie.edit',['id'=>$movie->id])}}"><i class="fas fa-edit"></i></td>
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
