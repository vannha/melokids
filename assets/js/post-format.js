/**
 * Created by FOX on 2/22/2016.
 */
jQuery(document).ready(function($) {
    "use strict";
    $('#post-formats-select').on('click', '.post-format', function () {
        var post_format = $(this).val();
        get_post_fields(post_format);
    });

    $(window).on('load', function(){
        setTimeout(function(){
            $('.post-format').each(function(){
                if($(this).prop( "checked" )){
                    get_post_fields($(this).val());
                }
            });
        }, 0);
    });

    function get_post_fields(_format){
        switch (_format){
            case 'video':
                $('#_box_post_format_options').css('display', 'block');
                $('#_box_post_format_options').find('table tr').css('display', 'none');
                $('#video_type-select').val($('#video_type-select').val());
                $('#video_type-select').trigger('change');
                $('fieldset[data-id="video_type"]').parents('tr').css('display', 'table-row');
                break;
            case 'audio':
                $('#_box_post_format_options').css('display', 'block');
                $('#_box_post_format_options').find('table tr').css('display', 'none');
                $('#audio_type-select').val($('#audio_type-select').val());
                $('#audio_type-select').trigger('change');
                $('fieldset[data-id="audio_type"]').parents('tr').css('display', 'table-row');
                break;
            case 'gallery':
                $('#_box_post_format_options').css('display', 'block');
                $('#_box_post_format_options').find('table tr').css('display', 'none');
                $('fieldset[data-id="gallery_layout"]').parents('tr').css('display', 'table-row');
                $('fieldset[data-id="gallery_size"]').parents('tr').css('display', 'table-row');
                $('fieldset[data-id="gallery_ids"]').parents('tr').css('display', 'table-row');
                $('fieldset[data-id="gallery_grid_col"]').parents('tr:not(.hide)').css('display', 'table-row');
                $('fieldset[data-id="gallery_size_custom"]').parents('tr:not(.hide)').css('display', 'table-row');
                break;
            case 'quote':
                $('#_box_post_format_options').css('display', 'block');
                $('#_box_post_format_options').find('table tr').css('display', 'none');
                $('fieldset[data-id="quote_title"]').parents('tr').css('display', 'table-row');
                $('fieldset[data-id="quote_content"]').parents('tr').css('display', 'table-row');
                break;
            case 'link':
                $('#_box_post_format_options').css('display', 'block');
                $('#_box_post_format_options').find('table tr').css('display', 'none');
                $('fieldset[data-id="link_text"]').parents('tr').css('display', 'table-row');
                $('fieldset[data-id="link_url"]').parents('tr').css('display', 'table-row');
                break;
            default:
                $('#_box_post_format_options').css('display', 'none');
        }
    }
});