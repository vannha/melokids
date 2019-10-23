<?php
function melokids_wc_admin_scripts()
{
    $melokids_ver = wp_get_theme()->get('Version');
    if(class_exists('Woocommerce')) {
        wp_enqueue_script('melokids-woo-custom', get_template_directory_uri() . '/inc/woo/js/woo-custom-admin.js', array(), $melokids_ver, true);
    }
}
add_action('admin_enqueue_scripts', 'melokids_wc_admin_scripts');

// Product Attibute Color pa_color
// Add custom metabox to edit product attribute color
add_action( 'pa_color_edit_form_fields', 'melokids_pa_color_taxonomy_edit_meta_field', 11, 2 );
function melokids_pa_color_taxonomy_edit_meta_field($term) {
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_media();
    $term_id = $term->term_id;
    $term_custom_meta = melokids_get_custom_meta_pa_color($term_id);
    $color_value = !empty($term_custom_meta['color_value']) ? $term_custom_meta['color_value'] : '';
    $color_image = !empty($term_custom_meta['color_image']) ? $term_custom_meta['color_image'] : '';
    ?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="color_value"><?php esc_html_e( 'Choosse a color', 'melokids' ); ?></label>
        </th>
        <td>
            <div class="pagebox">
                <input class="config_woo_color_field" type="text" name="color_value" value="<?php echo esc_attr( $color_value ); ?>"/>
            </div>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="color_image"><?php echo esc_html__( 'Color Image','melokids' ); ?></label>
        </th>
        <td>
            <div class="pagebox">
                <span class="uploaded_image">
                    <?php if ( !empty($color_image) ) : ?>
                        <img src="<?php echo esc_url( $color_image ); ?>" />
                    <?php endif; ?>
                    </span>
                <input type="text" name="color_image" value="<?php echo esc_url( $color_image ); ?>" class="featured_image_upload"/>
                <input type="button" name="image_upload" value="<?php echo esc_html__( 'Upload Image','melokids' ); ?>" class="button upload_image_button"/>
                <input type="button" name="remove_image_upload" value="<?php echo esc_html__( 'Remove Image','melokids' ); ?>" class="button remove_image_button"/>
            </div>
        </td>
    </tr>
    <?php
}
function melokids_get_custom_meta_pa_color($term_id)
{
    $term_meta = array(
        'color_value'=>get_term_meta($term_id,'color_value',true),
        'color_image'=>get_term_meta($term_id,'color_image',true)
    );
    if(empty($term_meta['color_image']) && empty($term_meta['color_value']))
    {
        $option_name =  "wc_pa_color_{$term_id}_custom_meta";
        $term_meta = get_option( $option_name ,array('color_value'=>'','color_img'=>''));
    }
    return $term_meta;
}
function melokids_set_custom_meta_pa_color($term_id,$data)
{
    $data = wp_parse_args($data,array(
        'color_value'=>'',
        'color_image'=>''
    ));
    update_term_meta($term_id,'color_value',$data['color_value']);
    update_term_meta($term_id,'color_image',$data['color_image']);
}
function melokids_save_pa_color_custom_meta( $term_id ) {
    if ( isset( $_POST['color_value'] ) && isset( $_POST['color_image'] )   ) {
        $term_meta = array(
            'color_value'=>'',
            'color_image'=>''
        );
        $term_meta['color_value'] = $_POST['color_value'];
        $term_meta['color_image'] = $_POST['color_image'];
        melokids_set_custom_meta_pa_color($term_id,$term_meta);
    }
}
add_action( 'edited_pa_color', 'melokids_save_pa_color_custom_meta', 10, 2 );
add_action( 'create_pa_color', 'melokids_save_pa_color_custom_meta', 10, 2 );

// Product Attribute:  Brand pa_brand
// Add custom metabox to edit product attribute Brand
add_action( 'pa_brand_edit_form_fields', 'melokids_pa_brand_taxonomy_edit_meta_field', 11, 2 );
function melokids_pa_brand_taxonomy_edit_meta_field($term) {
    wp_enqueue_media();
    $term_id = $term->term_id;
    $term_custom_meta = melokids_get_custom_meta_pa_brand($term_id);
    $brand_logo = !empty($term_custom_meta['brand_logo']) ? $term_custom_meta['brand_logo'] : '';
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="brand_logo"><?php echo esc_html__( 'Brand Logo','melokids' ); ?></label>
        </th>
        <td>
            <div class="pagebox">
                <span class="uploaded_image">
                    <?php if ( !empty($brand_logo) ) : ?>
                        <img src="<?php echo esc_url( $brand_logo ); ?>" />
                    <?php endif; ?>
                    </span>
                <input type="text" name="brand_logo" value="<?php echo esc_url( $brand_logo ); ?>" class="featured_image_upload"/>
                <input type="button" name="image_upload" value="<?php echo esc_html__( 'Upload Image','melokids' ); ?>" class="button upload_image_button"/>
                <input type="button" name="remove_image_upload" value="<?php echo esc_html__( 'Remove Image','melokids' ); ?>" class="button remove_image_button"/>
            </div>
        </td>
    </tr>
    <?php
}
function melokids_get_custom_meta_pa_brand($term_id)
{
    $term_meta = array(
        'brand_logo'=>get_term_meta($term_id,'brand_logo',true)
    );
    if(empty($term_meta['brand_logo']))
    {
        //old data
        $option_name =  "wc_pa_brand_{$term_id}_custom_meta";
        $term_meta = get_option( $option_name ,array('brand_logo'=>''));
    }
    return $term_meta;
}
function melokids_set_custom_meta_pa_brand($term_id,$data)
{
    $data = wp_parse_args($data,array(
        'brand_logo'=>''
    ));
    //new
    update_term_meta($term_id,'brand_logo',$data['brand_logo']);
}
function melokids_save_pa_brand_custom_meta( $term_id ) {
    if ( isset( $_POST['brand_logo'] )   ) {
        $term_meta = array(
            'brand_logo'=>''
        );
        $term_meta['brand_logo'] = $_POST['brand_logo'];
        melokids_set_custom_meta_pa_brand($term_id,$term_meta);
    }
}
add_action( 'edited_pa_brand', 'melokids_save_pa_brand_custom_meta', 10, 2 );
add_action( 'create_pa_brand', 'melokids_save_pa_brand_custom_meta', 10, 2 );