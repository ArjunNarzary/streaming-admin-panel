
@extends('layouts.master')
@section('content')
<div class="container">
    <div class="text-right py-2">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addCrew"><i class="fa fa-plus"></i> Add Crew</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="crewTable">
            <thead>
                <tr>
                    <th class="text-center">Sl No</th>
                    <th>Name</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @if(count($crew) != 0)
                    @foreach($crew as $key => $crew)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $crew->name }}</td>
                            <td class="text-center"><a href="" onclick="return false"><i class="fas fa-eye viewCrew" id="{{ \encrypt($crew->id) }}"></i></a></td>
                            <td class="text-center"><a href="" onclick="return false"><i class="fas fa-edit editCrew" id="{{ \encrypt($crew->id) }}"></i></a></td>
                            <td class="text-center"><a class="text-danger" href="{{ route('crew.delete', ['crew' => \encrypt($crew->id)]) }}"  onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt deleteCast"></i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--Modal for adding crew-->
  <div class="modal fade" id="addCrew" tabindex="-1" role="dialog" aria-labelledby="addCrewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="addCrewLabel">Add New Crew</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="crewForm">
            @csrf
        <div class="modal-body px-5">
            <div class="form-group">
                <input type="hidden" name="id" id="crew_id" value="">
                <label for="name">Crew Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="custom-select" name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Femal</option>
                    <option value="Other">Other</option>
                </select>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="photo">Upload Photo</label>
                <input type="file" class="form-control" name="photo" id="photo">
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
                <p class="text-info small">Recommende photo dimention : 276 X 350 px</p>
            </div>
            <div>
                <img id="showPhoto" style="max-height: 200px; margin: 0 auto;">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addCrewbtn" class="btn btn-primary addCrewbtn">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--Modal for adding Crew END-->
<!--Modal for viewing Crew-->
<div class="modal fade" id="viewCrew" tabindex="-1" role="dialog" aria-labelledby="viewCrewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="viewCrewLabel">Crew Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-5">
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="name">Crew Name</label>
                <label id="name"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="gender">Gender</label>
                <label id="gender"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="photo">Crew Photo</label>
                <img id="photo" src="" style="max-height: 250px; width: auto">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--Modal for viewing Crew END-->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        //show photo on select
        $(document).on('change', '#photo', function(){
            if(this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#showPhoto').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

    }); //end of ready function
</script>
@endpush
