
$(document).ready(function(){

    $.validator.setDefaults({
        debug: true,
        success: "valid",
        // ignore: [],
        errorClass: 'invalid-feedback font-weight-normal text-lowercase',
        highlight: function(element){
            $(element)
                .addClass('is-invalid');
            $(element).parent().find('.invalid-feedback').remove();
        },
        unhighlight: function(element){
            $(element)
            .removeClass('is-invalid');
            $(element)
                .removeClass('is-invalid');
        },
        errorPlacement: function (error, element) {

            if (element.hasClass('fname')) {
                error.insertAfter(element.parent());
            }
            else if (element.hasClass('nccs') || element.hasClass('option-input')){
                error.insertAfter(element.next());
            }
            else if(element.hasClass('custom-file-input')){
                error.insertAfter(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        }
    });


    $.validator.addMethod('filesize', function (value, element, param) {
        // param = size (in bytes)
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param)
    });

    // $('#castForm').validate({
    //     debug: false,
    //     rules:
    // })


}); //End of ready function
