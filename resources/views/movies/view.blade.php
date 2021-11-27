
@extends('layouts.master')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        {{ __('View / Update Movie') }}
                        <a href="{{ route('movies') }}"><button class="btn btn-danger btn-sm">Go Back</button> </a>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('movie.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-dark">{{ __('Title') }}</label>

                            <div class="col-md-10">
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $movie->title }}" required  autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="distributor" class="col-md-2 col-form-label text-dark">{{ __('Distributor') }}</label>

                            <div class="col-md-4">
                            <select class="form-control" name="distributor" required  autofocus>
                                <option value="" selected>Please Select your choice</option>
                                @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ old('distrbutor') == $distributor->id || $movie->distributor_id == $distributor->id  ? 'selected' : '' }}>{{ $distributor->name }}</option>
                                @endforeach

                            </select>
                                @error('distributor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label text-dark">{{ __('Movie Description') }}</label>

                            <div class="col-md-10">
                             <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required  autofocus>{{ old('description') ?? $movie->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="language" class="col-md-2 col-form-label text-dark">{{ __('Movie Language') }}</label>

                            <div class="col-md-4">
                            <input id="language" type="text" class="form-control @error('language') is-invalid @enderror" name="language" value="{{ old('language') ?? $movie->language }}" required  autofocus>

                                @error('language')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-2 col-form-label text-dark">{{ __('Movie Type') }}</label>

                            <div class="col-md-4">
                            <select class="form-control" name="type" required  autofocus>
                                <option value="" selected>Please Select your choice</option>
                                <option value="1" {{ old('type') == 1 || $movie->type == 1 ? 'selected' : '' }}>Short Movie</option>
                                <option value="2" {{ old('type') == 2 || $movie->type == 2 ? 'selected' : '' }}>Long Movie</option>

                            </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="premium_status" class="col-md-2 col-form-label text-dark">{{ __('Premium Status') }}</label>

                            <div class="col-md-4">
                            <select class="form-control" name="premium_status" required  autofocus>
                                <option value="0" {{ old('primium_staus') == 0 || $movie->premium_status == 0 ? 'selected' : '' }}>Free</option>
                                <option value="1" {{ old('primium_staus') == 1 || $movie->premium_status == 1 ? 'selected' : '' }}>Subscription</option>
                                <option value="2" {{ old('primium_staus') == 2 || $movie->premium_status == 2 ? 'selected' : '' }}>Rental</option>

                            </select>
                                @error('premium_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-2 col-form-label text-dark">{{ __('Amount') }}</label>

                            <div class="col-md-4">
                            <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $movie->amount }}" step=0.01 {{ old('premium_status') == '2' || $movie->premium_status == '2' ? '' : 'readonly' }}  autofocus>

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6 text-info pt-1">!!! Rental per week !!!</div>
                        </div>

                        <div class="form-group row">
                            <label for="length" class="col-md-2 col-form-label text-dark">{{ __('Movie Length (in minutes)') }}</label>

                            <div class="col-md-4">
                            <input id="length" type="number" class="form-control @error('length') is-invalid @enderror" name="length" value="{{ old('length') ?? $movie->length }}" required  autofocus>

                                @error('length')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="release_date" class="col-md-2 col-form-label text-dark">{{ __('Release Date') }}</label>

                            <div class="col-md-4">
                            <input id="release_date" type="text" readonly class="form-control @error('release_date') is-invalid @enderror" name="release_date" value="{{ old('release_date') ?? $movie->release_date }}" required  autofocus>

                                @error('release_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="revenue" class="col-md-2 col-form-label text-dark">{{ __('Revenue') }}</label>

                            <div class="col-md-4">
                            <input id="revenue" type="number" class="form-control @error('revenue') is-invalid @enderror" name="revenue" value="{{ old('revenue') ?? $movie->revenue }}" step=".01"  autofocus>

                                @error('revenue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="budget" class="col-md-2 col-form-label text-dark">{{ __('Budget') }}</label>

                            <div class="col-md-4">
                            <input id="budget" type="text" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ old('budget') ?? $movie->budget }}" step=".01"  autofocus>

                                @error('budget')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-md-2 col-form-label text-dark">{{ __('Movie Link') }}</label>

                            <div class="col-md-10">
                                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') ?? $movie->link }}"   autofocus>

                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center py-2">
                            <img id="bannerShow" src="{{ asset('/storage/movies/'.$movie->banner) }}" style="max-height: 250px;">
                        </div>

                        <div class="form-group row ">
                            <label for="banner" class="col-md-2 col-form-label text-dark">{{ __('Add Banner') }}</label>

                            <div class="col-md-4">
                                <input id="banner" type="file" class=" form-control @error('banner') is-invalid @enderror" name="banner" autofocus>

                                @error('banner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="text-info">Recommended banner size 534px X 799px</span>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Changes') }}
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

        $(document).on('change', 'select[name="premium_status"]', function(){
            var valOfSelect = $(this).val();
            var amountField = $('input[name="amount"]');

            if(valOfSelect == '0' || valOfSelect == '1' || valOfSelect == null){
                amountField.attr('readonly', true).val('0');
            }
            else{
                amountField.removeAttr('readonly');
            }
        });
    </script>


@endpush

