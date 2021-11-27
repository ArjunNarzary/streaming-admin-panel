
@extends('layouts.master')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p class="h5 font-weight-bold">Series Title : {{ $title }}</p>
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        {{ __('Add Season') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('series.seasons', ['id' => $id ]) }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('season.post') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="series_id" value="{{ $id }}">

                        @include('series.seasons.form')

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
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

        $(document).on('change', 'select[name="premium_type"]', function(){
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

