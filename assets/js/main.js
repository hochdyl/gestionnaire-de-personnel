// BARRE DE RECHERCHE

$(document).ready(function(){

    // SEARCH BAR
    $("#search-bar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".maincol-member").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    

    
    
    
    
    
    
    
    // POPUP NOTIFICATION
    $('.popup-info-visibility.notification').delay(1250).fadeOut(200);

    
    
    
    
    // IMAGE PREVIEW FOR UPLOAD
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#upload-file").change(function() {
        readURL(this);
    });
    
    
    
    // SHOW / HIDE POPUP INFO UPLOAD DOC
    $('.popup-info-uploaddoc-trigger').click(function(){
       $('.popup-info-visibility.uploaddoc, .popup-info-overlay').removeClass('a-fadeout');
       $('.popup-info-visibility.uploaddoc, .popup-info-overlay').addClass('a-fadein');
    });
    
    // SHOW POPUP INFO DELETE DOC
    $('.popup-info-delete-trigger').click(function(){
       $('.popup-info-visibility.delete, .popup-info-overlay').removeClass('a-fadeout');
       $('.popup-info-visibility.delete, .popup-info-overlay').addClass('a-fadein');
    });
    
    // HIDE POPUP INFO
    $('.popup-info-overlay, .popup-info-close').click(function(){
       $('.popup-info-visibility, .popup-info-overlay').removeClass('a-fadein');
       $('.popup-info-visibility, .popup-info-overlay').addClass('a-fadeout');
    });

    
    
    
    
    
    
        
    // SEND UPLOAD FORM
    $(".send-upload-form").click(function(){  
        $('#upload-form').find('[type="submit"]').trigger('click');
    });
    
    $(".send-uploadbis-form").click(function(){  
        $('#uploadbis-form').submit();
    });
    
    $("#upload-file").change(function(){
        if ($('#upload-file').get(0).files.length === 0) {
            $('.send-upload-form,.send-uploadbis-form').addClass('locked');
        }
        else {
            $('.send-upload-form,.send-uploadbis-form').removeClass('locked');
        }
    });
    
    
    
    
    // FORMS
    $('#send-form').click(function() {
        $('#form').find('[type="submit"]').trigger('click');
    });
    
    $('#send-update-info-form').click(function() {
        $('#update-info-form').find('[type="submit"]').trigger('click');
    });
    
    $('#send-deletemem-form').click(function() {
        $('#deletemem-form').find('[type="submit"]').trigger('click');
    });
});
