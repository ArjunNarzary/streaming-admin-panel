@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">List of Series ( {{ $season->title }} )</h6>
      <div class="dropdown no-arrow">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{ route('series.seasons', ['id' => $season->series->id ]) }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
        </div>

    </div>
    </div>
    <div class="text-right py-1 pr-1">
        <a href="{{ route('add.episode', ['id' => $season->id]) }}"><button class="btn btn-primary px-3"><i class="fas fa-plus"></i> Add Episode</button></a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20%">Title</th>
              <th>Episode No</th>
              <th>Length</th>
              <th>Release Date</th>
              <th>Status</th>
              <th class="text-center">View</th>
            </tr>
          </thead>
          <tbody>
            @foreach($season->episodes as $episode)
              <tr>
                  <td>{{$episode->title}}</td>
                  <td>{{$episode->episode_no}}</td>
                  <td>{{$episode->duration}}</td>
                  <td>{{\Carbon\Carbon::parse($episode->release_date)->format('d-m-Y')}}</td>
                  <td class="{{ $episode->status == 1 ? 'text-success' : 'text-danger' }}">{{$episode->status == 1 ? 'Active' : 'Inactive'}}</td>
                  <td class="text-center"><a href="{{ route('episode.view',['id'=>$episode->id]) }}"><i class="fas fa-eye"></i></a></td>
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
