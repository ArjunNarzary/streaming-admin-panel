<div class="form-group row">
    <label for="title" class="col-md-2 col-form-label text-dark">{{ __('Title') }}</label>

    <div class="col-md-10">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $series->title }}" required  autofocus>

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-2 col-form-label text-dark">{{ __('Description') }}</label>

    <div class="col-md-10">
     <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required  autofocus>{{ old('description') ?? $series->description }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="release_date" class="col-md-2 col-form-label text-dark">{{ __('Release Date') }}</label>

    <div class="col-md-4">
    <input id="release_date" type="text" readonly class="form-control @error('release_date') is-invalid @enderror" name="release_date" value="{{ old('release_date') ?? $series->release_date }}" required  autofocus>

        @error('release_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="language" class="col-md-2 col-form-label text-dark">{{ __('Language') }}</label>

    <div class="col-md-4">
    <input id="language" type="text" class="form-control @error('language') is-invalid @enderror" name="language" value="{{ old('language') ?? $series->language }}" required  autofocus>

        @error('language')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="revenue" class="col-md-2 col-form-label text-dark">{{ __('Revenue') }}</label>

    <div class="col-md-4">
    <input id="revenue" type="number" class="form-control @error('revenue') is-invalid @enderror" name="revenue" step=".01" value="{{ old('revenue') ?? $series->revenue }}"  autofocus>

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
    <input id="budget" type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" step=".01" value="{{ old('budget') ?? $series->budget }}"  autofocus>

        @error('budget')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="text-center py-2">
    <img id="bannerShow" src="{{ $series->banner != null && $series->banner != 'default.jpg' ? asset('storage/series/'.$series->banner) : '' }}" style="max-height: 250px;">
</div>

<div class="form-group row ">
    <label for="banner" class="col-md-2 col-form-label text-dark">{{ __('Add Banner') }}</label>

    <div class="col-md-4">
        <input id="banner" type="file" class=" form-control @error('banner') is-invalid @enderror" name="banner" {{ $series->banner != null && $series->banner != 'default.jpg' ? '' : 'required' }}  autofocus>

        @error('banner')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <span class="text-info">Recommended banner size 534px X 799px</span>
    </div>
</div>
