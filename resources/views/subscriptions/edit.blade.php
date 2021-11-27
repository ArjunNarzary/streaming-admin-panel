
@extends('layouts.master')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <div>{{ __('Edit Subscription Plan') }}</div>
                        <a href="{{ route('subscription.plan') }}"><button class="btn btn-light btn-sm px-md-4">Back</button> </a>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('subscription.plan.update', ['id' => \encrypt($subPlan->id)]) }}">
                        @csrf
                        <input type="hidden" name="sub_id" value="{{ $subPlan->id }}">
                        @include('subscriptions.inc.form')

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

