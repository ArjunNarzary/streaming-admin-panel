
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
                        {{ __('Manage Series') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('series') }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
                                @if($series->status == 1)
                                    <a class="dropdown-item" href="{{ route('series.deactivate',['id' => $series->id]) }}"><i class="fas fa-times-circle"></i> Deactivate Series</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('series.activate',['id' => $series->id]) }}"><i class="fas fa-check-circle"></i> Activate Series</a>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-left pb-3">
                            <div class="text-center py-1">
                                <img id="bannerShow" src="{{ asset('/storage/series/'.$series->banner) }}" style="max-height: 300px;">
                            </div>
                            <div class="py-1 pl-3">
                                <p class="font-weight-bold h5">Title - {{ $series->title }}</p>
                                <p class="font-weight-bold h5">Language - {{ $series->language }}</p>
                                <p class="font-weight-bold h5">Release Date - {{ \Carbon\Carbon::parse($series->release_date)->format('d-m-Y') }}</p>
                                <input type="hidden" name="series_id" id="series_id" value="{{ $series->id }}">
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-12 col-md-6">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Crew</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($series->crews) > 0)
                                        @foreach($series->crews as $seriesCrew)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removeSeriesCrew fa fa-times-circle" data-id="{{ $seriesCrew->id }}"></i>
                                            <img class="rounded-top" src="{{ asset('/storage/crews/'.$seriesCrew->photo) }}" style="max-width: 100px;">
                                            <div class="info px-1 mb-1">
                                                <p class="small">{{ $seriesCrew->name }}</p>
                                                <p class="small removeDesignation">{{ $seriesCrew->pivot->designation }}</p>
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

                            <div class="col-12 col-md-6 pr-md-1 pl-md-1">
                                <div class="border border-dark" style="height: 100%;">
                                    <h5 class="text-uppercase text-light font-weight-bold bg-dark p-1">Add Genre</h5>
                                    <div class="crews p-2 pb-4">
                                        @if(count($series->genres) > 0)
                                        @foreach($series->genres as $seriesGenre)
                                        <div class="genrebox float-left p-1 bg-secondary rounded text-light pr-4 mr-2">
                                            <i class="removeGenreSeries fa fa-times text-danger"  data-id="{{ $seriesGenre->id }}"></i>
                                            {{ $seriesGenre->name }}
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
                                                    <td><button class="btn btn-primary btn-sm genreSeries" data-id="{{ $genre->id }}"><i class="fas fa-plus"></i> Add</button></td>
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
                                        @if(count($series->posters) > 0)
                                        @foreach($series->posters as $poster)
                                        <div class="movie_adds rounded rounded-bottom-0 mb-2">
                                            <i class="removeSeriesPoster fa fa-times-circle" data-id="{{ $poster->id }}"></i>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- MODELS --}}

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
            <button type="button" class="btn btn-primary addCrewSeries">Save</button>
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
                <button type="button" class="btn btn-primary" id="SeriesPosterUpload">Add</button>
            </div>
          </div>
        </div>
      </div>
    {{-- Model for adding posters End --}}

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

    </script>


@endpush

