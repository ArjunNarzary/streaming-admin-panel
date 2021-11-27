
@extends('layouts.master')
@section('CSS')
<style>
    #DataTables_Table_0_wrapper, #DataTables_Table_1_wrapper, #DataTables_Table_2_wrapper{
        padding-top: 20px !important;
    }
    #DataTables_Table_0_wrapper .col-md-6, #DataTables_Table_1_wrapper .col-md-6, #DataTables_Table_2_wrapper .col-md-6{
        max-width: 100% !important;
    }
    .dataTables_filter{
      padding-left: 10px !important;
    }
    .dataTables_paginate{
        padding-right: 10px !important;
        padding-bottom: 10px !important;
        font-size: 0.6em !important;
    }
    .dataTables_info
    {
        display:none;
    }
    .is-invalid{
        border: solid red 0.5px;
    }
</style>

@endsection
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        {{ __('Manage Season') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('series.seasons', ['id' => $season->series->id ]) }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
                                @if($season->status == 1)
                                    <a class="dropdown-item" href="{{ route('season.deactivate',['season' => $season->id]) }}"><i class="fas fa-times-circle"></i> Deactivate Season</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('season.activate',['season' => $season->id]) }}"><i class="fas fa-check-circle"></i> Activate Season</a>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-left pb-3">
                            <div class="text-center py-1">
                                <img id="bannerShow" src="{{ asset('/storage/series/seasons/'.$season->cover) }}" style="max-height: 300px;">
                            </div>
                            <div class="py-1 pl-3">
                                <p class="font-weight-bold h5">Title - {{ $season->title }}</p>
                                <p class="font-weight-bold h5">Season No - {{ $season->season_no }}</p>
                                <p class="font-weight-bold h5">Language - {{ $season->series->language }}</p>
                                <input type="hidden" name="season_id" id="season_id" value="{{ $season->id }}">
                            </div>
                        </div>
                        <div class="border border-dark" style="height: 100%;">
                            <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Cast</h5>
                                <div class="row no-gutters">
                                    <div class="casts p-2 pb-4 col-12 col-md-6">
                                        @if(count($season->casts) > 0)
                                        @foreach($season->casts as $cast)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removeSeasonCast fa fa-times-circle" id="{{ $cast->id }}"></i>
                                            <img class="rounded-top" src="{{ asset('/storage/casts/'.$cast->photo) }}" style="max-width: 100px;">
                                            <div class="info px-1 mb-1">
                                                <p class="small">{{ $cast->name }}</p>
                                                <p class="small removeRole">{{ $cast->pivot->role }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Cast Added
                                            </div>
                                        @endif
                                        <div style="clear:both;"></div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <table class="datatableSmall table small">
                                            <thead>
                                                <th class="text-uppercase">Cast Name</th>
                                                <th class="text-center text-uppercase">Add</th>
                                            </thead>
                                            <tbody>
                                                @foreach($casts as $cast)
                                                <tr>
                                                    <td>{{ $cast->name }}</td>
                                                    <td class="text-center"><button class="btn btn-primary btn-sm castMovie" id="{{ $cast->id }}"><i class="fas fa-plus"></i> Add</button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>

                        <div class="border border-dark" style="height: 100%;">
                            <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Carousal</h5>
                            <div class="crews p-2 pb-4" style="width:100%">
                                @if($season->carousal != null )
                                <img src="{{ asset('storage/carousals/'.$season->carousal) }}" style="max-width: 100%;">
                                <div class="text-center p-2">
                                    <a href="{{ route('season.carousal.remove', ['season' => $season->id]) }}" onclick="return confirm('Are you sure?');">
                                        <button class="btn btn-danger">Remove</button>
                                    </a>
                                </div>
                                @else
                                    <div class="text-center text-danger">
                                        No carousal added
                                    </div>
                                @endif

                            </div>
                            <div style="clear:both;"></div>
                            <div class="p-2">
                                <div class="form-group">
                                    <input type="file" name="carousal" id="carousal">
                                    <label for="carousal" class="custom-file-label1">{{ $season->carousal == null ? 'Upload File' : 'Change' }}</label>
                                    <p class="text-danger" id="error"></p>
                                </div>
                                <p class="text-info">Recommended Carousal size 1280 x 500 pixels</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- MODELS --}}

    {{-- Model for add cast --}}
    <div class="modal fade" id="addCastCenter" tabindex="-1" role="dialog" aria-labelledby="addCastCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addCastLongTitle">Add Cast</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="pb-3">
                <img class="photo" src="" style="max-height: 300px">
                <p class="mt-3 text-uppercase">Name :  <span class="castName font-weight-bold"></span></p>
            </div>
            <div class="form-group row">
                <label class="col-4">Role</label>
                <div class="col-8">
                    <input class="cast_id" type="hidden" name="cast_id" value="">
                    <input class="col-8 form-control @error('role') is-invalid @enderror" name="role" required>

                    <div class="invalid-feedback" role="alert"></div>
                    @error('role')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary addCastSeason">Save</button>
            </div>
        </div>
        </div>
    </div>
    {{-- {{ Modal for cast }} --}}


     {{-- Model for adding carousal --}}
     <div class="modal fade" id="carousalModel" tabindex="-1" role="dialog" aria-labelledby="carousalModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="max-height: 100vh;">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Carousal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" id="category" name="category" value="2">
                <input type="hidden" id="carousal_id" name="carousal_id" value="{{ $season->id }}">
                <img id="showCarousal" style="max-height: 70vh; max-width: 90%; margin: 0 auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal_cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="carousalUpload">{{ $season->carousal == null ? 'Upload File' : 'Change' }}</button>
            </div>
          </div>
        </div>
      </div>
    {{-- Model for adding carousal End --}}

@endsection

@push('scripts')
    <script>

        $('.datatableSmall').DataTable({
            pageLength: 5,
            "lengthChange": false,
        });

        $("#release_date").datetimepicker({
            format: "yyyy-mm-dd"
        });

         $('#description').ckeditor();

         $(document).on('change', '#banner', function(){
            if(this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#bannerShow').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        $(document).on('change', '#carousal', function(){
             console.log("ok");
             var modal = $('#carousalModel');
            if(this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                   modal.find('#showCarousal').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
            modal.modal('show');
        });

        $('#carousalModel').on('hidden.bs.modal', function (e) {
           $('#carousal').val('');
        });

    </script>


@endpush

