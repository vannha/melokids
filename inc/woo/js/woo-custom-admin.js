jQuery(document).ready(function($){
    $('.config_woo_color_field').each(function(){
        $(this).wpColorPicker({palettes: true});
    });
    $(document).on( 'click', '.upload_image_button', upload_image_button )
        .on( 'click', '.remove_image_button', remove_image_button );
    function upload_image_button(e) {
        e.preventDefault();
        var $this = $( e.currentTarget );
        var $input_field = $this.prev();
        var $image = $this.parent().find( '.uploaded_image' );
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Add Image',
            button: {
                text: 'Add Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
            $input_field.val( attachment.url );
            $image.html( '<img src="' + attachment.url + '" />' );
        });
        custom_uploader.open();
    }
    function remove_image_button(e) {
        e.preventDefault();
        var $this = $( e.currentTarget );
        var $input_field = $this.parent().find( '.featured_image_upload' );
        var $image = $this.parent().find( '.uploaded_image' );

        $input_field.val( '' );
        $image.html( '' );
    }
});