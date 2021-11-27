<div class="form-group row">
    <label for="title" class="col-md-2 col-form-label text-dark">{{ __('Title') }}</label>

    <div class="col-md-10">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $season->title }}" required  autofocus>

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
        <option value="{{ $distributor->id }}" {{ old('distrbutor') == $distributor->id || $season->distributor_id == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
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
    <label for="description" class="col-md-2 col-form-label text-dark">{{ __('Description') }}</label>

    <div class="col-md-10">
     <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required  autofocus>{{ old('description') ?? $season->description }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="premium_type" class="col-md-2 col-form-label text-dark">{{ __('Premium_type') }}</label>

    <div class="col-md-10">
     <select class="form-control" name="premium_type" required>
         <option value="" selected>Select</option>
         <option value="0" {{ old('premium_type') == '0' || $season->premium_type == '0' ? 'selected' : ''}} option>Free</option>
         <option value="1" {{ old('premium_type') == '1' || $season->premium_type == '1' ? 'selected' : ''}} option>Subscription</option>
         <option value="2" {{ old('premium_type') == '2' || $season->premium_type == '2' ? 'selected' : ''}} option>Rental</option>
     </select>
        @error('premium_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="amount" class="col-md-2 col-form-label text-dark">{{ __('Amount') }}</label>

    <div class="col-md-4">
    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $season->amount }}" step=0.01 {{ old('premium_type') == '2' || $season->premium_type == '2' ? '' : 'readonly' }}  autofocus>

        @error('amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-6 text-info pt-1">!!! Rental per week !!!</div>
</div>

<div class="form-group row">
    <label for="season_no" class="col-md-2 col-form-label text-dark">{{ __('Season No') }}</label>

    <div class="col-md-4">
    <input id="season_no" type="number" class="form-control @error('season_no') is-invalid @enderror" name="season_no" value="{{ old('season_no') ?? $season->season_no }}" required  autofocus>

        @error('season_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="total_episodes" class="col-md-2 col-form-label text-dark">{{ __('Total Episodes') }}</label>

    <div class="col-md-4">
    <input id="total_episodes" type="number" class="form-control @error('total_episodes') is-invalid @enderror" name="total_episodes" value="{{ old('total_episodes') ?? $season->total_episodes }}"  autofocus>

        @error('total_episodes')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="release_date" class="col-md-2 col-form-label text-dark">{{ __('Release Date') }}</label>

    <div class="col-md-4">
    <input id="release_date" type="text" readonly class="form-control @error('release_date') is-invalid @enderror" name="release_date" value="{{ old('release_date') ?? $season->release_date }}" required  autofocus>

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
    <input id="revenue" type="number" class="form-control @error('revenue') is-invalid @enderror" name="revenue" step=".01" value="{{ old('revenue') ?? $season->revenue }}"  autofocus>

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
    <input id="budget" type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" step=".01" value="{{ old('budget') ?? $season->budget }}"  autofocus>

        @error('budget')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="text-center py-2">
    <img id="bannerShow" src="{{ $season->cover != null && $season->cover != 'default.jpg' ? asset('storage/series/seasons/'.$season->cover) : '' }}" style="max-height: 250px;">
</div>

<div class="form-group row ">
    <label for="banner" class="col-md-2 col-form-label text-dark">{{ __('Add Cover') }}</label>

    <div class="col-md-4">
        <input id="banner" type="file" class=" form-control @error('cover') is-invalid @enderror" name="cover" {{ $season->cover != null && $season->cover != 'default.jpg' ? '' : 'required' }}  autofocus>

        @error('cover')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <span class="text-info">Recommended cover size 534px X 799px</span>
    </div>
</div>
