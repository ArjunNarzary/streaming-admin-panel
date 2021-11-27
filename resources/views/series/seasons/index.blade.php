@extends('layouts.master')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List of Seasons ({{ $series->title }})</h6>
      <input type="hidden" id="series_id" name="series_id" value="{{ $series->id }}">
    </div>
    <div class="text-right py-1 pr-1">
        <a href="{{ route('add.season', ['id' => $series->id]) }}"><button class="btn btn-primary px-3"><i class="fas fa-plus"></i> Add Season</button></a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered datatable"width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20%">Title</th>
              <th>Season No.</th>
              <th>Total Episodes</th>
              <th>Status</th>
              <th class="text-center">View</th>
              <th class="text-center">Edit</th>
              <th class="text-center">Manage Episodes</th>
            </tr>
          </thead>
          <tbody>
            @if($series->seasons != null)
                @foreach($series->seasons as $season)
                    <tr>
                        <td>{{$season->title}}</td>
                        <td>{{$season->season_no}}</td>
                        <td>{{$season->total_episodes}}</td>
                        <td class="{{ $season->status == 1 ? 'text-success' : 'text-danger' }}">{{$season->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td class="text-center"><a href="{{ route('season.edit', ['id' => $season->id]) }}"><i class="fas fa-eye"></i></a></td>
                        <td class="text-center"><a href="{{ route('season.manage', ['season' => $season->id]) }}"><i class="fas fa-edit"></i></a></td>
                        <td class="text-center"><a href="{{ route('season.episodes', ['id' => $season->id]) }}"><i class="fas fa-tasks"></i></td>
                    </tr>
                @endforeach
            @else
              <p class="pt-3 text-center">No seasons available</p>
            @endif
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
