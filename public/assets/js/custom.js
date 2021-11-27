
$(document).ready(function(){

    $(function (){
        $('.datatable').DataTable();
    });

    //upload doc
    $(document).on('change', '.custom-file-input1', function () {
        //get the file name
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });

    //Display image on upload
    function readURL(input, n) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.show_upload'+n).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputGroupFile1").change(function () {
        readURL(this, 1);
    });
    $("#inputGroupFile2").change(function () {
        readURL(this, 2);
    });

    //Cast addition
    $(document).on('click', '#addCastbtn', function(){
        var castName = $('#name').val();
        var gender = $('#gender').val();
        var input_field = $("#photo");
        var photo = input_field.val();

        if(castName == null || castName == ''){
            $('#name').addClass('is-invalid');
            $('#name').next().children().text('Please enter cast name');
        }else{
            $('#name').removeClass('is-invalid');
        }
        if(gender == null || gender == ''){
            $('#gender').addClass('is-invalid');
            $('#gender').next().children().text('Please select cast gender');
        }else{
            $('#gender').removeClass('is-invalid');
        }
        if(photo == null || photo == ''){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Please upload cast photo');
        }else{
            input_field.removeClass('is-invalid');
        }

        var property = input_field.prop('files')[0];
        var image_name = property.name;
        var image_ext = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;

        if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Please upload only image file');
        }
        if(image_size > 200000){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Photo size must not be grater than 200kb');
        }
        else
        {
            $('#addCast').find('is-invalid').removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("castName", castName);
            form_data.append("gender", gender);
            $.ajax({
                url : "/casts",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#addCastbtn').addClass('btn-info')
                    $('#addCastbtn').html("Saving...");
                },
                success: function(data)
                {
                    alert('Cast added');
                    window.location.href = '/casts';
                },
                error: function(response){
                    $('#addCastbtn').addClass('btn-primary')
                    $('#addCastbtn').html("Add Cast");
                    $.each(response.error, function( index, value ) {
                        var elm = $("input[name="+index+"]");
                        elm.addClass("is-invalid");
                        elm.next(".invalid-feedback").html(value);
                    });
                }
            });
        }

    });

    //View Cast
    $(document).on('click', '.viewCast', function(){
        var id = $(this).attr('id');

        $.post("/cast/view", {id: id}, function(data) {
            if(data.status == true){
                var modal = $('#viewCast');
                modal.find('#name').text(data.name);
                modal.find('#gender').text(data.gender);
                modal.find('#photo').attr('src', '/storage/casts/'+data.photo);
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    })

    //Edit Cast
    $(document).on('click', '.editCast', function(){
        var id = $(this).attr('id');

        $.post("/cast/view", {id: id}, function(data) {
            if(data.status == true){
                var modal = $('#addCast');
                modal.find('#cast_id').val(data.id);
                modal.find('#name').val(data.name);
                modal.find('#gender').val(data.gender);
                modal.find('#showPhoto').attr('src', '/storage/casts/'+data.photo);
                modal.find('#addCastbtn').attr('id', 'editCastbtn');
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    })


  //Edit Cast Post
    $(document).on('click', '#editCastbtn', function(){
        var id = $('#cast_id').val();
        var castName = $('#name').val();
        var gender = $('#gender').val();
        var input_field = $("#photo");
        var photo = input_field.val();

        if(castName == null || castName == ''){
            $('#name').addClass('is-invalid');
            $('#name').next().children().text('Please enter cast name');
        }else{
            $('#name').removeClass('is-invalid');
        }
        if(gender == null || gender == ''){
            $('#gender').addClass('is-invalid');
            $('#gender').next().children().text('Please select cast gender');
        }else{
            $('#gender').removeClass('is-invalid');
        }
        if(photo != ''){
            var property = input_field.prop('files')[0];
            var image_name = property.name;
            var image_ext = image_name.split('.').pop().toLowerCase();
            var image_size = property.size;

            if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
                input_field.addClass('is-invalid');
                input_field.next().children().text('Please upload only image file');
            }
            if(image_size > 200000){
                input_field.addClass('is-invalid');
                input_field.next().children().text('Photo size must not be grater than 200kb');
            }
        }else{
            var property = '0';
        }

            $('#addCast').find('is-invalid').removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("file", property);
            form_data.append("castName", castName);
            form_data.append("gender", gender);
            $.ajax({
                url : "/cast/edit",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#editCastbtn').addClass('btn-info')
                    $('#editCastbtn').html("Saving...");
                },
                success: function(data)
                {
                    alert('Cast Updated Successfully.');
                    window.location.href = '/casts';
                },
                error: function(response){
                    $('#editCastbtn').addClass('btn-primary')
                    $('#editCastbtn').html("Save Changes");
                    $.each(response.error, function( index, value ) {
                        var elm = $("input[name="+index+"]");
                        elm.addClass("is-invalid");
                        elm.next(".invalid-feedback").html(value);
                    });
                }
            });
        });

        $('#addCast').on('hidden.bs.modal', function (e) {
            $('#cast_id').val('');
            $('#name').val('');
            $('#gender').val('');
            $("#photo").val('');
            $(this).find('.addCastbtn').attr('id', 'addCastbtn');
            $(this).find('#showPhoto').removeAttr('src');
          })


          //CAST JS END

          //JS FOR CREW CRUD
          //Crew addition
    $(document).on('click', '#addCrewbtn', function(){
        var crewName = $('#name').val();
        var gender = $('#gender').val();
        var input_field = $("#photo");
        var photo = input_field.val();

        if(crewName == null || crewName == ''){
            $('#name').addClass('is-invalid');
            $('#name').next().children().text('Please enter crew name');
        }else{
            $('#name').removeClass('is-invalid');
        }
        if(gender == null || gender == ''){
            $('#gender').addClass('is-invalid');
            $('#gender').next().children().text('Please select crew gender');
        }else{
            $('#gender').removeClass('is-invalid');
        }
        if(photo == null || photo == ''){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Please upload crew photo');
        }else{
            input_field.removeClass('is-invalid');
        }

        var property = input_field.prop('files')[0];
        var image_name = property.name;
        var image_ext = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;

        if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Please upload only image file');
        }
        if(image_size > 200000){
            input_field.addClass('is-invalid');
            input_field.next().children().text('Photo size must not be grater than 200kb');
        }
        else
        {
            $('#addCrew').find('is-invalid').removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("crewName", crewName);
            form_data.append("gender", gender);
            $.ajax({
                url : "/crew",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#addCrewbtn').addClass('btn-info')
                    $('#addCrewbtn').html("Saving...");
                },
                success: function(data)
                {
                    alert('Crew added');
                    window.location.href = '/crew';
                },
                error: function(response){
                    $('#addCrewbtn').addClass('btn-primary')
                    $('#addCrewbtn').html("Add Crew");
                    $.each(response.error, function( index, value ) {
                        var elm = $("input[name="+index+"]");
                        elm.addClass("is-invalid");
                        elm.next(".invalid-feedback").html(value);
                    });
                }
            });
        }

    });

    //View Crew
    $(document).on('click', '.viewCrew', function(){
        var id = $(this).attr('id');

        $.post("/crew/view", {id: id}, function(data) {
            if(data.status == true){
                var modal = $('#viewCrew');
                modal.find('#name').text(data.name);
                modal.find('#gender').text(data.gender);
                modal.find('#photo').attr('src', '/storage/crews/'+data.photo);
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    })

    //Edit Crew
    $(document).on('click', '.editCrew', function(){
        var id = $(this).attr('id');

        $.post("/crew/view", {id: id}, function(data) {
            if(data.status == true){
                var modal = $('#addCrew');
                modal.find('#crew_id').val(data.id);
                modal.find('#name').val(data.name);
                modal.find('#gender').val(data.gender);
                modal.find('#showPhoto').attr('src', '/storage/crews/'+data.photo);
                modal.find('#addCrewbtn').attr('id', 'editCrewbtn');
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    })

    //Edit Crew Post
    $(document).on('click', '#editCrewbtn', function(){
        var id = $('#crew_id').val();
        var crewName = $('#name').val();
        var gender = $('#gender').val();
        var input_field = $("#photo");
        var photo = input_field.val();

        if(crewName == null || crewName == ''){
            $('#name').addClass('is-invalid');
            $('#name').next().children().text('Please enter crew name');
        }else{
            $('#name').removeClass('is-invalid');
        }
        if(gender == null || gender == ''){
            $('#gender').addClass('is-invalid');
            $('#gender').next().children().text('Please select crew gender');
        }else{
            $('#gender').removeClass('is-invalid');
        }
        if(photo != ''){
            var property = input_field.prop('files')[0];
            var image_name = property.name;
            var image_ext = image_name.split('.').pop().toLowerCase();
            var image_size = property.size;

            if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
                input_field.addClass('is-invalid');
                input_field.next().children().text('Please upload only image file');
            }
            if(image_size > 200000){
                input_field.addClass('is-invalid');
                input_field.next().children().text('Photo size must not be grater than 200kb');
            }
        }else{
            var property = '0';
        }

            $('#addCrew').find('is-invalid').removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("file", property);
            form_data.append("crewName", crewName);
            form_data.append("gender", gender);
            $.ajax({
                url : "/crew/edit",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#editCrewbtn').addClass('btn-info')
                    $('#editCrewbtn').html("Saving...");
                },
                success: function(data)
                {
                    alert('Crew Updated Successfully.');
                    window.location.href = '/crew';
                },
                error: function(response){
                    $('#editCrewbtn').addClass('btn-primary')
                    $('#editCrewbtn').html("Save Changes");
                    $.each(response.error, function( index, value ) {
                        var elm = $("input[name="+index+"]");
                        elm.addClass("is-invalid");
                        elm.next(".invalid-feedback").html(value);
                    });
                }
            });
        });

        //END OF CREW FUNCTIONS

        //START OF GENRE FUNCTIONS
        $(document).on('click', '#addGenrebtn', function(){
            var genreName = $('#name').val();

            if(genreName == null || genreName == ''){
                $('#name').addClass('is-invalid');
                $('#name').next().children().text('Please enter genre name');
            }else{
                $('#addGenre').find('is-invalid').removeClass('is-invalid');
                var form_data = new FormData();
                form_data.append("name", genreName);
                $.ajax({
                    url : "/genre",
                    type : "post",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $('#addGenrebtn').addClass('btn-info')
                        $('#addGenrebtn').html("Saving...");
                    },
                    success: function(data)
                    {
                        alert('Genre added');
                        window.location.href = '/genres';
                    },
                    error: function(response){
                        $('#addGenrebtn').addClass('btn-primary')
                        $('#addGenrebtn').html("Add Genre");
                        $.each(response.error, function( index, value ) {
                            var elm = $("input[name="+index+"]");
                            elm.addClass("is-invalid");
                            elm.next(".invalid-feedback").html(value);
                        });
                    }
                });
            }

        });

         //Edit Store Genre
         $(document).on('click', '.editGenre', function(){
            var id = $(this).attr('id');
            $.post("/genre/edit", {id: id}, function(data) {
                if(data.status == true){
                    var modal = $('#addGenre');
                    modal.find('#addGenreLabel').html('Edit Genre');
                    modal.find('#genre_id').val(data.id);
                    modal.find('#name').val(data.name);
                    modal.find('.addGenrebtn').attr('id', 'editGenrebtn');
                    modal.find('.addGenrebtn').html('Save Change');
                    modal.modal('show');
                }else{
                    alert('Please try again');
                }
            });
        });

        //Edit Genre
        $(document).on('click', '#editGenrebtn', function(){
            var id = $('#genre_id').val();
            var genreName = $('#name').val();
            if(genreName == null || genreName == ''){
                $('#name').addClass('is-invalid');
                $('#name').next().children().text('Please enter genre name');
            }else{
                $('#addGenre').find('is-invalid').removeClass('is-invalid');
                var form_data = new FormData();
                form_data.append("name", genreName);
                form_data.append("id", id);
                $.ajax({
                    url : "/genre/edit/store",
                    type : "post",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $('#addGenrebtn').addClass('btn-info')
                        $('#addGenrebtn').html("Saving...");
                    },
                    success: function(data)
                    {
                        if(data = true){
                            alert('Genre Updated Successfully');
                            window.location.href = '/genres';
                        }else{
                            alert('Please try again !');
                            window.location.href = '/genres';
                        }
                    },
                    error: function(response){
                        $('#addGenrebtn').addClass('btn-primary')
                        $('#addGenrebtn').html("Save Changes");
                        $.each(response.error, function( index, value ) {
                            var elm = $("input[name="+index+"]");
                            elm.addClass("is-invalid");
                            elm.next(".invalid-feedback").html(value);
                        });
                    }
                });
            }

        });

        $('#addGenre').on('hidden.bs.modal', function (e) {
            $(this).find('#addGenreLabel').html('Add New Genre');
            $('#genre_id').val('');
            $('#name').val('');
            $(this).find('.addGenrebtn').attr('id', 'addGenrebtn');
            $(this).find('.addGenrebtn').html('Save');
          })


    //Connect Movie and Cast
    $(document).on('click', '.castMovie', function(){
        var cast = $(this).attr('id');
        var movie = $('#movie_id').val();

        $.post("/movie/cast", {id: cast}, function(data) {
            if(data.status == true){
                var modal = $('#addCastCenter');
                modal.find('.photo').attr('src', '/storage/casts/'+data.photo);
                modal.find('.castName').text(data.name);
                modal.find('.cast_id').val(cast);
                modal.find('.movie_id').val(movie);
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    });

    //Add movie cast relationship
    $(document).on('click', '.addCastMovie', function(){
        var modal = $('#addCastCenter');
        var cast_id = modal.find('.cast_id').val();
        var movie_id = modal.find('.movie_id').val();
        var roleInput = modal.find('input[name = "role"]');
        var role = roleInput.val();

        if(role == null || role == ''){
            roleInput.addClass('is-invalid');
            roleInput.siblings('.invalid-feedback').text('Please insert role.');
        }else{
            roleInput.removeClass('is-invalid');
            roleInput.siblings('.invalid-feedback').text('');
            $(this).text('Saving....');
            $.post("/movie/cast/add", {cast_id: cast_id, movie_id : movie_id, role: role}, function(data) {
                if(data.status == true){
                    window.location.href = '/movies/edit/'+movie_id;
                }else{
                    $(this).text('Save');
                    alert('Please try again');
                }
            });
        }
    })

    //Remove Cast
    $(document).on('click', '.removeCast', function(){
        var movie_id = $('#movie_id').val();
        var cast = $(this).attr('id');
        var role = $(this).siblings('.info').find('.removeRole').text();
        $.post("/movie/cast/remove", {movie_id:movie_id, cast: cast, role: role}, function(data) {
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
            }else{
                alert('Please try again');
            }
        });
    })

    //Connect Movie and Crew
    $(document).on('click', '.crewMovie', function(){
        var crew = $(this).attr('id');
        var movie = $('#movie_id').val();

        $.post("/movie/crew", {id: crew}, function(data) {
            if(data.status == true){
                var modal = $('#addCrewCenter');
                modal.find('.photo').attr('src', '/storage/crews/'+data.photo);
                modal.find('.crewName').text(data.name);
                modal.find('.crew_id').val(crew);
                modal.find('.movie_id').val(movie);
                modal.modal('show');
            }else{
                alert('Please try again');
            }
        });
    });

    //Add movie crew relationship
    $(document).on('click', '.addCrewMovie', function(){
        var modal = $('#addCrewCenter');
        var crew_id = modal.find('.crew_id').val();
        var movie_id = modal.find('.movie_id').val();
        var designationInput = modal.find('input[name = "designation"]');
        var designation = designationInput.val();

        if(designation == null || designation == ''){
            designationInput.addClass('is-invalid');
            designationInput.siblings('.invalid-feedback').text('Please insert crew designation.');
        }else{
            designationInput.removeClass('is-invalid');
            designationInput.siblings('.invalid-feedback').text('');
            $(this).text('Saving....');
            $.post("/movie/crew/add", {crew_id: crew_id, movie_id : movie_id, designation: designation}, function(data) {
                if(data.status == true){
                    window.location.href = '/movies/edit/'+movie_id;
                }else{
                    $(this).text('Save');
                    alert('Please try again');
                }
            });
        }
    })

    //Remove Crew
    $(document).on('click', '.removeCrew', function(){
        var movie_id = $('#movie_id').val();
        var crew = $(this).attr('id');
        var designation = $(this).siblings('.info').find('.removeDesignation').text();
        $.post("/movie/crew/remove", {movie_id:movie_id, crew: crew, designation: designation}, function(data) {
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
            }else{
                alert('Please try again');
            }
        });
    })

    //Add Genre
    $(document).on('click', '.genreMovie', function(){
        var movie_id = $('#movie_id').val();
        var genre = $(this).attr('id');

        $(this).text('Adding....');
        $.post("/movie/genre/add", {movie_id:movie_id, genre: genre}, function(data) {
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
                $(this).html('<i class="fas fa-plus"></i> Add');
            }else{
                alert('Please try again');
               $(this).html('<i class="fas fa-plus"></i> Add');
            }
        });
    });

    //Remove Genre
    $(document).on('click', '.removeGenre', function(){
        var movie_id = $('#movie_id').val();
        var genre = $(this).attr('id');
        $.post("/movie/genre/remove", {movie_id:movie_id, genre: genre}, function(data) {
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
            }else{
                alert('Please try again');
            }
        });
    })

    //Add Posters
    $(document).on('change', '.posterInput', function(){
        var input_id = $(this).attr('name');
        $('#posterModel').modal('show');
        $('#posterModel').find('#input').text(input_id);
          if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showposter')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
        $('#input').val(input_id);

    });

    //Upload Posters
    $(document).on('click', '#posterUpload', function(){
        var movie_id = $('#movie_id').val();
        var input = $('#input').val();
        var input_field = $("input[name='"+input+"']");
        var property = input_field.prop('files')[0];
        var image_name = property.name;
        var image_ext = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
            input_field.parent().siblings('.poster_error').text('Selected file must be in png, jpg, or jpeg format.');
            $('#modal-box').modal('hide');
        }
        if(image_size > 750000){
            input_field.parent().siblings('.poster_error').text('Selected file size must not exceed 750Kb.');
            $('#modal-box').modal('hide');
        }
        else
        {
            input_field.parent().siblings('.poster_error').text('');
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("movie_id", movie_id);

            $.ajax({
                url : "/movie/poster",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#posterUpload').addClass('btn-info')
                    $('#posterUpload').html("Poster Uploading...");
                },
                success: function(data)
                {
                    window.location.href = '/movies/edit/'+movie_id;
                },
                error: function(response){
                    alert('Please try again.');
                    $('#posterUpload').html("Add");
                }
            })
        }
    });

    $(document).on('click', '.removePoster', function(){
        var movie_id = $('#movie_id').val();
        var poster_id = $(this).attr('id');

        $.post("/movie/remove/poster", { movie_id:movie_id, poster_id:poster_id},
        function(data){
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
            }else{
                alert('Please try again');
            }
        }
        )
    });

    //Add Iframe Tag
    $(document).on('click', '#addIframe', function(){
        var movie_id = $('#movie_id').val();
        var tag = $('#iframe').val();
        var input_field = $("input[name='iframe']");

        if(tag == null || tag == ''){
            input_field.addClass('is-invalid');
            input_field.siblings('.iframe_error').text('Please insert iframe tag');
        }
        else
        {
            input_field.siblings('.iframe_error').text('');
            input_field.removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("iframe_tag", tag);
            form_data.append("movie_id", movie_id);

            $.ajax({
                url : "/movie/iframe",
                type : "post",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#addIframe').html('Adding..');
                },
                success: function(data)
                {
                    window.location.href = '/movies/edit/'+movie_id;
                },
                error: function(response){
                    alert('Please try again.');
                    $('#addIframe').text('Add');
                }
            })
        }
    });

    //Remove iframe
    $(document).on('click', '.removeIframe', function(){
        var movie_id = $('#movie_id').val();
        var tag_id = $(this).attr('data-id');

        $.post("/movie/remove/iframe", { movie_id:movie_id, tag_id:tag_id},
        function(data){
            if(data.status == true){
                window.location.href = '/movies/edit/'+movie_id;
            }else{
                alert('Please try again');
            }
        }
        )
    });

    //JS for SERIES--------------------------

     //Add series crew relationship
     $(document).on('click', '.addCrewSeries', function(){
        var modal = $('#addCrewCenter');
        var crew_id = modal.find('.crew_id').val();
        var series_id = $('#series_id').val();
        var designationInput = modal.find('input[name = "designation"]');
        var designation = designationInput.val();

        if(designation == null || designation == ''){
            designationInput.addClass('is-invalid');
            designationInput.siblings('.invalid-feedback').text('Please insert crew designation.');
        }else{
            designationInput.removeClass('is-invalid');
            designationInput.siblings('.invalid-feedback').text('');
            $(this).text('Saving....');
            $.post("/series/crew/add", {crew_id: crew_id, series_id : series_id, designation: designation}, function(data) {
                if(data.status == true){
                    window.location.href = '/series/manage/'+series_id;
                }else{
                    $(this).text('Save');
                    alert('Please try again');
                }
            });
        }
    })

    //Remove Crew
    $(document).on('click', '.removeSeriesCrew', function(){
        var series_id = $('#series_id').val();
        var crew = $(this).attr('data-id');
        var designation = $(this).siblings('.info').find('.removeDesignation').text();
        $.post("/series/crew/remove", {series_id:series_id, crew: crew, designation: designation}, function(data) {
            if(data.status == true){
                window.location.href = '/series/manage/'+series_id;
            }else{
                alert('Please try again');
            }
        });
    })

    //Add Genre
    $(document).on('click', '.genreSeries', function(){
        var series_id = $('#series_id').val();
        var genre = $(this).attr('data-id');

        $(this).text('Adding....');
        $.post("/series/genre/add", {series_id:series_id, genre: genre}, function(data) {
            if(data.status == true){
                window.location.href = '/series/manage/'+series_id;
                //$(this).html('<i class="fas fa-plus"></i> Add');
            }else{
                alert('Please try again');
               $(this).html('<i class="fas fa-plus"></i> Add');
            }
        });
    });

    //Remove Genre
    $(document).on('click', '.removeGenreSeries', function(){
        var series_id = $('#series_id').val();
        var genre = $(this).attr('data-id');
        $.post("/series/genre/remove", {series_id:series_id, genre: genre}, function(data) {
            if(data.status == true){
                window.location.href = '/series/manage/'+series_id;
            }else{
                alert('Please try again');
            }
        });
    })

    //Upload Posters
    $(document).on('click', '#SeriesPosterUpload', function(){
        var series_id = $('#series_id').val();
        var input = $('#input').val();
        var input_field = $("input[name='"+input+"']");
        var property = input_field.prop('files')[0];
        var image_name = property.name;
        var image_ext = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
            input_field.parent().siblings('.poster_error').text('Selected file must be in png, jpg, or jpeg format.');
            $('#modal-box').modal('hide');
        }
        if(image_size > 750000){
            input_field.parent().siblings('.poster_error').text('Selected file size must not exceed 750Kb.');
            $('#modal-box').modal('hide');
        }
        else
        {
            input_field.parent().siblings('.poster_error').text('');
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("series_id", series_id);

            $.ajax({
                url : "/series/add/poster",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#SeriesPosterUpload').addClass('btn-info')
                    $('#SeriesPosterUpload').html("Poster Uploading...");
                },
                success: function(data)
                {
                    alert('Poster has been added successfully')
                    window.location.href = '/series/manage/'+series_id;
                },
                error: function(response){
                    alert('Please try again.');
                    $('#SeriesPosterUpload').html("Add");
                }
            })
        }
    });

    $(document).on('click', '.removeSeriesPoster', function(){
        var series_id = $('#series_id').val();
        var poster_id = $(this).attr('data-id');

        $.post("/series/remove/poster", { series_id:series_id, poster_id:poster_id},
        function(data){
            if(data.status == true){
                window.location.href = '/series/manage/'+series_id;
            }else{
                alert('Please try again');
            }
        }
        )
    });


    //<!-----------------------------JS FOR SEASONS---------------------------!>

    //Add season cast relationship
    $(document).on('click', '.addCastSeason', function(){
        var modal = $('#addCastCenter');
        var cast_id = modal.find('.cast_id').val();
        var season_id = $(document).find('#season_id').val();
        var roleInput = modal.find('input[name = "role"]');
        var role = roleInput.val();

        if(role == null || role == ''){
            roleInput.addClass('is-invalid');
            roleInput.siblings('.invalid-feedback').text('Please insert role.');
        }else{
            roleInput.removeClass('is-invalid');
            roleInput.siblings('.invalid-feedback').text('');
            $(this).text('Saving....');
            $.post("/season/cast/add", {cast_id: cast_id, season_id : season_id, role: role}, function(data) {
                if(data.status == true){
                    window.location.href = '/seasons/manage/'+season_id;
                }else{
                    $(this).text('Save');
                    alert('Please try again');
                }
            });
        }
    })

    //Remove Cast
    $(document).on('click', '.removeSeasonCast', function(){
        var season_id = $('#season_id').val();
        var cast = $(this).attr('id');
        var role = $(this).siblings('.info').find('.removeRole').text();
        $.post("/season/cast/remove", {season_id:season_id, cast: cast, role: role}, function(data) {
            if(data.status == true){
                window.location.href = '/seasons/manage/'+season_id;
            }else{
                alert('Please try again');
            }
        });
    });

    //Carousal Upload for both Season and Movie
    $(document).on('click', '#carousalUpload', function(){
        var btn_text = $(this).text();
        var id = $('#carousalModel').find('#carousal_id').val();
        var category = $('#carousalModel').find('#category').val();
        var input_field = $("#carousal");
        var property = input_field.prop('files')[0];
        var image_name = property.name;
        var image_ext = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        if($.inArray(image_ext, ['png', 'jpg', 'jpeg']) == -1){
            console.log("ok");
            input_field.siblings('#error').text('Selected file must be in png, jpg, or jpeg format.');
            $('#carousalModel').modal('hide');
        }else if(image_size > 750000){
            input_field.siblings('#error').text('Selected file size must not exceed 750Kb.');
            $('#carousalModel').modal('hide');
        }
        else
        {
            input_field.siblings('#error').text('');
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("id", id);
            form_data.append("category", category);

            $.ajax({
                url : "/carousal",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#carousalUpload').addClass('btn-info')
                    $('#carousalUpload').html("Uploading File...");
                },
                success: function(data)
                {
                    window.location.href = data;
                },
                error: function(response){
                    alert('Please try again.');
                    $('#carousalUpload').html(btn_text);
                }
            })
        }
    });


    //JS FOR Distributor CRUD
    //Distributor addition
    $(document).on('click', '#addDistributorbtn', function(){
    var name = $('#name').val();
    var email = $('#email').val();
    var gender = $('#gender').val();
    var company = $('#company_name').val();
    var status = $('#status').val();

    if(name == null || name == ''){
        $('#name').addClass('is-invalid');
        $('#name').next().children().text('Please enter distributor name');
    }
    else if(email == null || email == ''){
        $('#name').removeClass('is-invalid');
        $('#email').addClass('is-invalid');
        $('#email').next().children().text('Please enter distributor email address');
    }
    else if( !validateEmail(email)) {
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#email').addClass('is-invalid');
        $('#email').next().children().text('Invalid email address');
    }
    else if(gender == null || gender == ''){
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#gender').addClass('is-invalid');
        $('#gender').next().children().text('Please select distributor gender');
    }
    else if(status == null || status == ''){
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#gender').removeClass('is-invalid');
        $('#status').addClass('is-invalid');
        $('#status').next().children().text('Please select distributor status');
    }else{
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#gender').removeClass('is-invalid');
        $('#status').removeClass('is-invalid');

        $('#addDistributor').find('is-invalid').removeClass('is-invalid');
            var form_data = new FormData();
            form_data.append("name", name);
            form_data.append("email", email);
            form_data.append("gender", gender);
            form_data.append("company_name", company);
            form_data.append("status", status);
            $.ajax({
                url : "/distributor/store",
                type : "post",
                data: form_data,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('#addDistributorbtn').addClass('btn-info')
                    $('#addDistributorbtn').html("Saving...");
                },
                success: function(data)
                {
                    alert('Distributor added');
                    window.location.href = '/distributors';
                },
                error: function(response){
                    $('#addDistributorbtn').addClass('btn-primary')
                    $('#addDistributorbtn').html("Add Distributor");
                    $.each(response.responseJSON.errors, function( index, value ) {
                        console.log("value");
                        var elm = $("input[name="+index+"]");
                        elm.addClass("is-invalid");
                        elm.next(".invalid-feedback").html(value);
                    });
                }
            });
    }




});

//View Distributor
$(document).on('click', '.viewDistributor', function(){
    var id = $(this).attr('id');

    $.post("/distributor/view", {id: id}, function(data) {
        if(data.status == true){
            var modal = $('#viewDistributor');
            modal.find('#name').text(data.name);
            modal.find('#email').text(data.email);
            modal.find('#gender').text(data.gender);
            modal.find('#company').text(data.company);
            if(data.admin_status == 1){
                modal.find('#status').text('Active');
            }else{
                modal.find('#status').text('Inactive');
            }
            modal.modal('show');
        }else{
            alert('Please try again');
        }
    });
})

//Edit Distributor
$(document).on('click', '.editDistributor', function(){
    var id = $(this).attr('id');

    $.post("/distributor/view", {id: id}, function(data) {
        if(data.status == true){
            var modal = $('#addDistributor');
            modal.find('#distributor_id').val(data.id);
            modal.find('#name').val(data.name);
            modal.find('#email').val(data.email);
            modal.find('#gender').val(data.gender);
            modal.find('#company_name').val(data.company);
            modal.find('#status').val(data.admin_status);
            modal.find('#addDistributorbtn').attr('id', 'editDistributorbtn');
            modal.modal('show');
        }else{
            alert('Please try again');
        }
    });
})

//Edit Distributor Post
$(document).on('click', '#editDistributorbtn', function(){
    var id = $('#distributor_id').val();
    var name = $('#name').val();
    var email = $('#email').val();
    var gender = $('#gender').val();
    var company = $('#company_name').val();
    var status = $('#status').val();

    if(name == null || name == ''){
        $('#name').addClass('is-invalid');
        $('#name').next().children().text('Please enter distributor name');
    }
    else if(email == null || email == ''){
        $('#name').removeClass('is-invalid');
        $('#email').addClass('is-invalid');
        $('#email').next().children().text('Please enter distributor email address');
    }
    else if( !validateEmail(email)) {
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#email').addClass('is-invalid');
        $('#email').next().children().text('Invalid email address');
    }
    else if(gender == null || gender == ''){
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#gender').addClass('is-invalid');
        $('#gender').next().children().text('Please select distributor gender');
    }
    else if(status == null || status == ''){
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#gender').removeClass('is-invalid');
        $('#status').addClass('is-invalid');
        $('#status').next().children().text('Please select distributor status');
    }else{

        $('#addDistributor').find('is-invalid').removeClass('is-invalid');
        var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("name", name);
            form_data.append("email", email);
            form_data.append("gender", gender);
            form_data.append("company_name", company);
            form_data.append("status", status);
        $.ajax({
            url : "/distributor/edit",
            type : "post",
            data: form_data,
            contentType: false,
            enctype: 'multipart/form-data',
            cache: false,
            processData: false,
            beforeSend: function(){
                $('#editDistributorbtn').addClass('btn-info')
                $('#editDistributorbtn').html("Saving...");
            },
            success: function(data)
            {
                alert('Distributor Updated Successfully.');
                window.location.href = '/distributors';
            },
            error: function(response){
                $('#editDistributorbtn').addClass('btn-primary')
                $('#editDistributorbtn').html("Save Changes");
                $.each(response.responseJSON.errors, function( index, value ) {
                    var elm = $("input[name="+index+"]");
                    elm.addClass("is-invalid");
                    elm.next(".invalid-feedback").html(value);
                });
            }
        });
    }
})

    //END OF CREW FUNCTIONS

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }


});  //End of ready function
