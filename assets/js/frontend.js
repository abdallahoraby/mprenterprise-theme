(function($) {

    $(document).ready( function() {
        var file_frame; // variable for the wp.media file_frame

        // attach a click event (or whatever you want) to some element on your page
        // $( '.frontend-button' ).on( 'click', function( event ) {
        $("body").delegate(".frontend-button", "click", function(event){
            event.preventDefault();
            let attachment_id = $('.attachment-ids');
            // if the file_frame has already been created, just reuse it
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
                title: $( this ).data( 'uploader_title' ),
                button: {
                    text: $( this ).data( 'uploader_button_text' ),
                },
                multiple: true, // set this to true for multiple file selection
                library: {
                    type: [ 'video' ]
                },
            });

            file_frame.on( 'select', function() {
                //attachment = file_frame.state().get('selection').first().toJSON();
                attachment = file_frame.state().get('selection').toJSON();
                let selected_attachment_ids = [];
                let file_names = [];
                let file_urls = [];
                let video_previews = $('.video-previews');
                $('.video-previews').html('');
                attachment.forEach(function(obj) {
                    selected_attachment_ids.push(obj.id);
                    file_names.push(obj.filename);
                    file_urls.push(obj.url)

                    // preview selected attachment name and size
                    video_previews.append('<div class="single-preview"> <video width="100%" height="120px" controlsList="nodownload" oncontextmenu="return false;" ><source src="'+ obj.url +'" type="video/mp4" /></video> <p>'+ obj.filename +'</p></div>');
                });



                // do something with the file here
                // $( '.frontend-button' ).hide();
                // $( '#frontend-image' ).attr('src', attachment.url);

                // Send the attachment id to our hidden input
                attachment_id.val( selected_attachment_ids );
            });

            file_frame.open();
        });



    });

})(jQuery);