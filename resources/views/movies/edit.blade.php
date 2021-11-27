
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
                        {{ __('Manage Movie') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('movies') }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
                                @if($movie->status == 1)
                                    <a class="dropdown-item" href="{{ route('movie.deactivate',['movie' => $movie->id]) }}"><i class="fas fa-times-circle"></i> Deactivate Movie</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('movie.activate',['movie' => $movie->id]) }}"><i class="fas fa-check-circle"></i> Activate Movie</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('movies.videos', ['movie' => $movie->id]) }}"><i class="fas fa-play-circle"></i> Manage Videos</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-left pb-3">
                            <div class="text-center py-1">
                                <img id="bannerShow" src="{{ asset('/storage/movies/'.$movie->banner) }}" style="max-height: 300px;">
                            </div>
                            <div class="py-1 pl-3">
                                <p class="font-weight-bold h5">Title - {{ $movie->title }}</p>
                                <p class="font-weight-bold h5">Language - {{ $movie->language }}</p>
                                <p class="font-weight-bold h5">Duration - {{ $duration }}</p>
                                <input type="hidden" name="movie_id" id="movie_id" value="{{ $movie->id }}">
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-12 col-md-6 pr-md-1">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Cast</h5>
                                    <div class="casts p-2 pb-4">
                                        @if(count($movie->casts) > 0)
                                        @foreach($movie->casts as $castMovie)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removeCast fa fa-times-circle" id="{{ $castMovie->id }}"></i>
                                            <img class="rounded-top" src="{{ asset('/storage/casts/'.$castMovie->photo) }}" style="max-width: 100px;">
                                            <div class="info px-1 mb-1">
                                                <p class="small">{{ $castMovie->name }}</p>
                                                <p class="small removeRole">{{ $castMovie->pivot->role }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Cast Added
                                            </div>
                                        @endif
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div pt-3>
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
                            <div class="col-12 col-md-6 pl-md-1">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Crew</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($movie->crews) > 0)
                                        @foreach($movie->crews as $crewMovie)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removeCrew fa fa-times-circle" id="{{ $crewMovie->id }}"></i>
                                            <img class="rounded-top" src="{{ asset('/storage/crews/'.$crewMovie->photo) }}" style="max-width: 100px;">
                                            <div class="info px-1 mb-1">
                                                <p class="small">{{ $crewMovie->name }}</p>
                                                <p class="small removeDesignation">{{ $crewMovie->pivot->designation }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Crew Added
                                            </div>
                                        @endif
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div>
                                        <table class="datatableSmall table small">
                                            <thead>
                                                <th class="text-uppercase">Crew Name</th>
                                                <th class="text-center text-uppercase">Add</th>
                                            </thead>
                                            <tbody>
                                                @foreach($crews as $crew)
                                                <tr>
                                                    <td>{{ $crew->name }}</td>
                                                    <td class="text-center"><button class="btn btn-primary btn-sm crewMovie" id="{{ $crew->id }}"><i class="fas fa-plus"></i> Add</button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 pr-md-1 pt-md-2">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Genre</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($movie->genres) > 0)
                                        @foreach($movie->genres as $genreMovie)
                                        <div class="genrebox float-left p-1 bg-secondary rounded text-light pr-4 mr-2">
                                            <i class="removeGenre fa fa-times text-danger"  id="{{ $genreMovie->id }}"></i>
                                            {{ $genreMovie->name }}
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Genre Added
                                            </div>
                                        @endif
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div>
                                        <table class="datatableSmall table small">
                                            <thead>
                                                <th>Genre Name</th>
                                                <th>Add</th>
                                            </thead>
                                            <tbody>
                                                @foreach($genres as $genre)
                                                <tr>
                                                    <td>{{ $genre->name }}</td>
                                                    <td><button class="btn btn-primary btn-sm genreMovie" id="{{ $genre->id }}"><i class="fas fa-plus"></i> Add</button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 pr-md-1 pt-md-2">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Posters</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($movie->posters) > 0)
                                        @foreach($movie->posters as $poster)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removePoster fa fa-times-circle" id="{{ $poster->id }}"></i>
                                            <img class="rounded" src="{{ asset('/storage/posters/'.$poster->poster) }}" style="max-width: 100px;">
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Poster Added
                                            </div>
                                        @endif
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="text-center">
                                        <div class="custom-file" style="position: relative;">
                                            <input id="inputGroupFile1" type="file" name="poster" class="custom-file-input12 posterInput" style="z-index: 5 !important; height: 2.5rem; opacity: 0 !important; position:relative;">
                                            <label for="inputGroupFile1" style="position: absolute; top:0; left: 50%; transform: translateX(-50%); z-index: 1;"><button type="button" class="btn btn-primary work @error('work') is-invalid @enderror work_option">Add Poster</button></label>
                                        </div>
                                        <p class="text-info">Recommended poster size 534x799 px</p>
                                        <p class="poster_error text-danger"></p>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 pr-md-1 pt-md-2">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Iframe Tags</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($movie->iframes) > 0)
                                        @foreach($movie->iframes as $iframe)
                                        <div class="genrebox float-left p-1 bg-secondary rounded text-light pr-4 mr-2">
                                            <i class="removeIframe fa fa-times text-danger"  data-id="{{ $iframe->id }}"></i>
                                            {{ $iframe->iframe_tag }}
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="text-center text-danger">
                                                No Iframe Tag Added
                                            </div>
                                        @endif
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="p-2">
                                        <div class="row">
                                            <div class="col-10 form-group">
                                                <input type="text" name="iframe" id="iframe" class="form-control">
                                                <div class="text-danger iframe_error"></div>
                                            </div>
                                            <div class="col-2 text-center">
                                                <button type="button" class="btn btn-primary btn-sm" id="addIframe"><i class="fas fa-plus"></i>  Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 pr-md-1 pt-md-2">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Carousal</h5>
                                    <div class="crews p-2 pb-4" style="width:100%">
                                        @if($movie->carousal != null )
                                        <img src="{{ asset('storage/carousals/'.$movie->carousal) }}" style="max-width: 100%;">
                                        <div class="text-center p-2">
                                            <a href="{{ route('movie.carousal.remove', ['movie' => $movie->id]) }}" onclick="return confirm('Are you sure?');">
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
                                            <label for="carousal" class="custom-file-label1">{{ $movie->carousal == null ? 'Upload File' : 'Change' }}</label>
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
                    <input class="movie_id" type="hidden" name="movie_id" value="">
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
            <button type="button" class="btn btn-primary addCastMovie">Save</button>
            </div>
        </div>
        </div>
    </div>

    {{-- Model for adding crew --}}
    <div class="modal fade" id="addCrewCenter" tabindex="-1" role="dialog" aria-labelledby="addCrewCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addCrewLongTitle">Add Crew</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="pb-3">
                <img class="photo" src="" style="max-height: 300px">
                <p class="mt-3 text-uppercase">Name :  <span class="crewName font-weight-bold"></span></p>
            </div>
            <div class="form-group row">
                <label class="col-4">Designation</label>
                <div class="col-8">
                    <input class="crew_id" type="hidden" name="crew_id" value="">
                    <input class="movie_id" type="hidden" name="movie_id" value="">
                    <input class="col-8 form-control @error('designation') is-invalid @enderror" name="designation" required>

                    <div class="invalid-feedback" designation="alert"></div>
                    @error('designation')
                    <div class="invalid-feedback" designation="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary addCrewMovie">Save</button>
            </div>
        </div>
        </div>
    </div>

    {{-- Model for adding crew End --}}

    {{-- Model for adding posters --}}
    <div class="modal fade" id="posterModel" tabindex="-1" role="dialog" aria-labelledby="posterModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="max-height: 100vh;">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Poster</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
                <span id="input" style="display:none;"></span>
                <img id="showposter" style="max-height: 70vh; max-width: 90%; margin: 0 auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal_cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="posterUpload">Add</button>
            </div>
          </div>
        </div>
      </div>
    {{-- Model for adding posters End --}}

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
                <input type="hidden" id="category" name="category" value="1">
                <input type="hidden" id="carousal_id" name="carousal_id" value="{{ $movie->id }}">
                <img id="showCarousal" style="max-height: 70vh; max-width: 90%; margin: 0 auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal_cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="carousalUpload">{{ $movie->carousal == null ? 'Upload File' : 'Change' }}</button>
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

