
@extends('layouts.master')
@section('CSS')
<style>
    .video-box i{
        font-size: 8rem;
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
                        {{ __('Add Videos') }}

                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('movie.edit', ['id' => $movie->id]) }}"><i class="fas fa-chevron-circle-left"></i> Go Back</a>
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
                                <input type="hidden" name="movie_id" id="movie_id" value="{{ $movie->id }}">
                            </div>
                        </div>
                        <div class="text-center border border-dark p-2">
                            <h4 class="text-center text-uppercase font-weight-bold bg-primary text-light p-1">Movie Video</h4>
                            {{-- If movie video uploaded --}}

                            <div id="video-section" class="text-center {{ $movie->link == null ? 'd-none' : '' }}">
                                <div class="video-box">
                                    <i class="fas fa-photo-video"></i>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('movie.video.delete', ['movie' => $movie->id]) }}" onclick="return confirm('Are you sure you want to delete ?');">
                                        <button class="btn btn-danger px-5"> <i class="far fa-trash-alt"></i> Delete</button>
                                    </a>
                                </div>
                            </div>

                            {{-- else --}}
                            <div class="container-fluid text-center">
                                <form id="video-upload" action="{{ route('movie.upload', ['id' => encrypt($movie->id)]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-8">
                                        <input type="file" class="form-control @error('video') is-invalid @enderror" name="video" id="video" required>

                                        @error('video')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <div class="errors text-danger"></div>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" id="upload_btn" class="btn btn-success text-light px-3">Upload</button>
                                        <button type="button" id="uploading_btn" class="btn btn-primary text-light px-3 d-none">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Uploading..</button>
                                    </div>
                                </div>

                                </form>
                            </div>
                            <div class="progress d-none" style="height: 1.5rem;">
                                <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">0 %</div>
                            </div>
                            <div class="text-center py-2" id="success"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <script>

        $(document).ready(function() {
            // $('form').ajaxForm({
            //     beforeSend: function(){
            //         $('#success').empty();
            //         $('.progress-bar').addClass('bg-primary');
            //         $('.progress-bar').removeClass('d-none');
            //         $('#video').removeClass('is-invalid');
            //         $('#video').siblings('.errors').text('');
            //     },
            //     uploadProgress:function(event, position, total, percentComplete){
            //         $('.progress-bar').text((percentComplete - 1) + ' %');
            //         $('.progress-bar').css('width', percentComplete + '%');
            //     },
            //     success: function(data){
            //         if(data.errors)
            //         {
            //             $('.progress-bar').text('0 %');
            //             $('.progress-bar').css('width', '0%');
            //             $('#success').html('<span class="text-danger"><b>Video could not be uploaded please try again.</b></span>');
            //         }
            //         if(data.success)
            //         {
            //             $('#video-section').removeClass('d-none');
            //             $('.progress-bar').text('Uploaded');
            //             $('.progress-bar').addClass('bg-success');
            //             $('#success').html('<span class="text-success"><b>Video has been successfully uploaded.</b></span>');

            //         }
            //     },
            //     error: function(data){
            //         $('.progress-bar').text('0 %');
            //         $('.progress-bar').css('width', '0%');
            //         $('#success').html('<span class="text-danger"><b>Video could not be uploaded please try again.</b></span>');

            //         var errors = data.responseJSON.errors.video;
            //         $('#video').addClass('is-invalid');
            //         errors.forEach(function(element, index){
            //             $('#video').siblings('.errors').text(element);
            //         });

            //     }
            // });

            var upload_btn       = $('#upload_btn');
            var uploading_btn    = $('#uploading_btn');
            var input_field      = $('#video');
            var error            = $('.errors');
            var progress_box     = $('.progress');
            var progress_bar     = $('.progress-bar');
            var success          = $('#success');

            $(document).on('click', '#upload_btn', function(e){
                console.log("ok");
                e.preventDefault();
                var input = input_field.val();
                if(input == null || input == ''){
                    input_field.addClass('is-invalid');
                    error.text('Please select video to upload');
                }

                var property = input_field.prop('files')[0];
                var file_name = property.name;
                var file_ext = file_name.split('.').pop().toLowerCase();
                var file_size = property.size;

                if($.inArray(file_ext, ['mp4', 'mkv']) == -1){
                    input_field.addClass('is-invalid');
                    error.text('Only mp4 and mkv format allowed.');
                }
                else{
                    input_field.removeClass('is-invalid');
                    error.text('');

                    var formData = new FormData();
                    formData.append('video', property);

                    $.ajax({
                        xhr : function() {
                            var xhr = new window.XMLHttpRequest();

                            //return preogress
                            xhr.upload.addEventListener('progress', function(r) {

                                if(r.lengthComputable) {    //Check if length of file is calculatable
                                    // console.log('Bytes Loaded :'  + r.loaded);
                                    // console.log('Total Size :  ' +r.total);
                                    // console.log('Percentage Uploaded :'  +(r.loaded / r.total));
                                    var percent = Math.round((r.loaded / r.total) * 100);

                                    progress_box.removeClass('d-none');
                                    progress_bar.attr('aria-valuenow', percent).css('width', percent+'%').text('Uploaded '+ percent + '%');
                                    upload_btn.addClass('d-none');
                                    uploading_btn.removeClass('d-none');
                                }

                            });

                            return xhr;
                        },
                        url         : '{{ route("movie.upload", ["id" => encrypt($movie->id)]) }}',
                        type        :'POST',
                        data        : formData,
                        enctype     : 'multipart/form-data',
                        processData : false,
                        contentType : false,

                        success: function(data){
                            if(data.errors)
                            {
                                reset();
                                $('#success').html('<span class="text-danger"><b>Video could not be uploaded please try again.</b></span>');
                            }
                            if(data.success)
                            {
                                uploading_btn.addClass('d-none');
                                upload_btn.removeClass('d-none');
                                $('#video-section').removeClass('d-none');
                                $('.progress-bar').text('Uploaded');
                                $('.progress-bar').addClass('bg-success');
                                $('#success').html('<span class="text-success"><b>Video has been successfully uploaded.</b></span>');

                            }
                        },
                        error: function(data){
                            reset();
                            $('#success').html('<span class="text-danger"><b>Video could not be uploaded please try again.</b></span>');

                            var errors_response = data.responseJSON.errors.video;
                            $('#video').addClass('is-invalid');
                            errors_response.forEach(function(element, index){
                               error.text(element);
                            });

                        }

                    }) //end of ajax

                }

            }) //end of upload function

            function reset(){
                uploading_btn.addClass('d-none');
                upload_btn.removeClass('d-none');
                progress_box.addClass('d-none');
                progress_bar.attr('aria-valuenow', '0').css('width', '0%').text('0%');
            }




        }); //Ready function

    </script>


@endpush

