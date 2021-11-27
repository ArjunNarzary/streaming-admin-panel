<div class="form-group row">
    <label for="title" class="col-md-2 col-form-label text-dark">{{ __('Title') }}</label>

    <div class="col-md-10">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $episode->title }}" required  autofocus>

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
     <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required  autofocus>{{ old('description') ?? $episode->description }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="episode_no" class="col-md-2 col-form-label text-dark">{{ __('Episode No') }}</label>

    <div class="col-md-4">
    <input id="episode_no" type="number" class="form-control @error('episode_no') is-invalid @enderror" name="episode_no" value="{{ old('episode_no') ?? $episode->episode_no }}" required  autofocus>

        @error('episode_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="length" class="col-md-2 col-form-label text-dark">{{ __('Length (in minutes)') }}</label>

    <div class="col-md-4">
    <input id="length" type="number" class="form-control @error('length') is-invalid @enderror" name="length" value="{{ old('length') ?? $episode->length }}" required  autofocus>

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
    <input id="release_date" type="text" readonly class="form-control @error('release_date') is-invalid @enderror" name="release_date" value="{{ old('release_date') ?? $episode->release_date }}" required  autofocus>

        @error('release_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="link" class="col-md-2 col-form-label text-dark">{{ __('Episode Link') }}</label>

    <div class="col-md-10">
    <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') ?? $episode->link }}"  autofocus>

        @error('link')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="text-center py-2">
    <img id="bannerShow" src="{{ $episode->banner != null && $episode->banner != 'default.jpg' ? asset('storage/series/episodes/'.$episode->banner) : '' }}" style="max-height: 250px;">
</div>

<div class="form-group row ">
    <label for="banner" class="col-md-2 col-form-label text-dark">{{ __('Add Cover') }}</label>

    <div class="col-md-4">
        <input id="banner" type="file" class=" form-control @error('banner') is-invalid @enderror" name="banner" {{ $episode->banner != null && $episode->banner != 'default.jpg' ? '' : 'required' }}  autofocus>

        @error('banner')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <span class="text-info">Recommended banner size 534px X 799px</span>
    </div>
</div>
