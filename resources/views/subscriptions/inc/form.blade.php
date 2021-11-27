<div class="form-group row">
    <label for="name" class="col-12 col-md-3 col-form-label text-dark">{{ __('Plan Name') }}</label>

    <div class="col-12 col-md-9">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $subPlan->name }}" required  autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-12 col-md-3 col-form-label text-dark">{{ __('Description') }}</label>

    <div class="col-12 col-md-9">
     <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required  autofocus>{{ old('description') ?? $subPlan->description }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="fee" class="col-12 col-md-3 col-form-label text-dark">{{ __('Subscription Fee (in Rs)') }}</label>

    <div class="col-12 col-md-4">
    <input id="fee" type="number" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ old('fee') ?? $subPlan->fee }}" required  autofocus step="0.01">

        @error('fee')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="tax" class="col-12 col-md-3 col-form-label text-dark">{{ __('Subscription Tax (in Rs)') }}</label>

    <div class="col-12 col-md-4">
    <input id="tax" type="number" class="form-control @error('tax') is-invalid @enderror" name="tax" value="{{ old('tax') ?? $subPlan->tax }}" required  autofocus step="0.01">

        @error('tax')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="time_period_type" class="col-12 col-md-3 col-form-label text-dark">{{ __('Time Period Type') }}</label>

    <div class="col-12 col-md-4">
    <select class="form-control" name="time_period_type" required  autofocus>
        <option value="" selected>Please Select your choice</option>
        <option value="day" {{ old('time_period_type') == 'day' || $subPlan->time_period_type == 'day' ? 'selected' : '' }}>Day</option>
        <option value="month" {{ old('time_period_type') == 'month' || $subPlan->time_period_type == 'month' ? 'selected' : '' }}>Month</option>
        <option value="year" {{ old('time_period_type') == 'year' || $subPlan->time_period_type == 'year' ? 'selected' : '' }}>Year</option>

    </select>
        @error('time_period_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="time_period" class="col-12 col-md-3 col-form-label text-dark">{{ __('Time Period') }}</label>

    <div class="col-12 col-md-4">
    <input id="time_period" type="number" class="form-control @error('time_period') is-invalid @enderror" name="time_period" value="{{ old('time_period') ?? $subPlan->time_period }}" required  autofocus>

        @error('time_period')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="status" class="col-12 col-md-3 col-form-label text-dark">{{ __('Status') }}</label>

    <div class="col-12 col-md-4">
    <select class="form-control" name="status" required  autofocus>
        <option value="" selected>Please Select your choice</option>
        <option value="1" {{ old('status') == '1' || $subPlan->status == '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status') == '0' || $subPlan->status == '0' ? 'selected' : '' }}>Inactive</option>

    </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row mb-0">
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary">
            {{ __('Submit') }}
        </button>
    </div>
</div>
