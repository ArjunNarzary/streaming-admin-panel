
@extends('layouts.master')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p class="h5 font-weight-bold">Series Title : {{ $episode->season->title }}</p>
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        {{ __('Edit Episode') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('season.episodes', ['id' => $episode->season->id ]) }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
                                @if($episode->status == 1)
                                    <a class="dropdown-item" href="{{ route('episode.deactivate',['episode' => $episode->id]) }}"><i class="fas fa-times-circle"></i> Deactivate Episode</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('episode.activate',['episode' => $episode->id]) }}"><i class="fas fa-check-circle"></i> Activate Episode</a>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('episode.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="episode_id" value="{{ $episode->id}}">

                        @include('series.episodes.form');

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

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

