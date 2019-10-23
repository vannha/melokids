<?php
if(!class_exists('EF4Framework') && !class_exists('SWA_Import_Export')) return;
// docs: http://dev.joomexp.com/wordpress/cms-document/
// Theme document link 
add_filter('cms_documentation_link', 'function_add_documentation_link');
function function_add_documentation_link($url)
{
    $url = 'http://docs.zooka.io/melokids/';
    return $url;
}
// Ticket 
add_filter('cms_ticket_link', 'function_add_cms_ticket_link');
function function_add_cms_ticket_link($url)
{
    //type: email or url
    //if type is email => link is email address
    //$url = array('type' => 'email', 'link' => 'zooka.sp@gmail.com');
    $url = array('type' => 'link', 'link' => 'http://support.zooka.io/support/tickets/new');
    return $url;
}

// Enable Export Mode
add_filter('swa_ie_export_mode', 'function_enable_export_mode');
function function_enable_export_mode()
{
    return true;
}

// Replace theme option name
add_filter('swa_ie_options_name', 'function_options_name');
function function_options_name()
{
    //Example name of theme option is "cms_theme_options"
    return 'theme_options';
}

// Export Post type 
add_filter('swa_post_types', 'function_swa_post_types');
function function_swa_post_types($post_type)
{
    $theme_post_type = [
        'product'
    ];
    $post_type = array_merge($post_type, $theme_post_type);
    return $post_type;
}

// Extra option 
add_filter('swa_ie_extra_options', 'function_extra_options_name');
function function_extra_options_name($extra_options)
{
    $theme_extra_options = [
        'blogname',
        'blogdescription',
        'date_format',
        'time_format',
        'default_category',
        'thumbnail_size_w',
        'thumbnail_size_h',
        'medium_size_w',
        'medium_size_h',
        'large_size_w',
        'large_size_h',
        'page_on_front',
        'page_for_privacy_policy',
        'woocommerce_shop_page_id',
        'woocommerce_cart_page_id',
        'woocommerce_checkout_page_id',
        'woocommerce_myaccount_page_id',
        'woocommerce_terms_page_id',
        'vc_roles[administrator][post_types][_state]',
        'vc_roles[administrator][post_types][cms-mega-menu]',
        'vc_roles[administrator][post_types][header_banner]',
        'vc_roles[administrator][post_types][header_top]',
        'vc_roles[administrator][post_types][footer]',
    ];
    $extra_options = array_merge($extra_options, $theme_extra_options);
    return $extra_options;
}

/* Remove default widget Before import sample data */
add_action('swa-ie-import-start','melokids_removed_widgets', 10, 2);
function melokids_removed_widgets(){
    /* get all registered sidebars */
    global $wp_registered_sidebars;
    /*get saved widgets*/
    $widgets = get_option('sidebars_widgets');
    /*loop over the sidebars and remove all widgets*/
    foreach ($wp_registered_sidebars as $sidebar => $value) {
        unset($widgets[$sidebar]);
    }
    /*update with widgets removed*/
    update_option('sidebars_widgets',$widgets);
}

/* move default post / page to trash */
function melokids_get_id_by_title($post_title, $post_type = 'page'){
    $page = get_page_by_title( $post_title, OBJECT , $post_type );
    return $page->ID;
}
add_action('swa-ie-import-start', 'melokids_move_trash', 1);
if(!function_exists('melokids_move_trash')){
    function melokids_move_trash(){
        wp_trash_post(1);
        wp_trash_post(2);
        wp_trash_post(3);
        wp_trash_post(melokids_get_id_by_title('Cart'));
        wp_trash_post(melokids_get_id_by_title('Checkout'));
        wp_trash_post(melokids_get_id_by_title('My account'));
        wp_trash_post(melokids_get_id_by_title('Shop'));
        wp_trash_post(melokids_get_id_by_title('Wishlist'));
        wp_trash_post(melokids_get_id_by_title('Newsletter'));
    }
}
/* User and User Meta */
add_action('swa-ie-export-start','melokids_export_user_metadata',1,2);
function melokids_export_user_metadata($folder_dir){
    global $wp_filesystem;
    $file = $folder_dir . 'user_data.json';
    if (file_exists($file)){
        return;
    }
    $users = get_users(array(
        'exclude'=>array(1)
    ));
    $users_data = array();
    $user_data_field = array(
        'user_pass',
        'user_login',
        'user_nicename',
        'user_url',
        'user_email',
        'display_name',
        'nickname',
        'first_name',
        'last_name',
        'description',
    );
    foreach ($users as $user)
    {
        if(!$user instanceof WP_User)
            continue;
        $user_data = array(
            'insert'=>array(),
            'roles'=>$user->roles,
            'meta'=>get_user_meta($user->ID)
        );
        foreach ($user_data_field as $field)
        {
            $user_data['insert'][$field] = $user->$field;
        }
        $users_data[] = $user_data;
    }
    $file_contents = json_encode($users_data);
    $wp_filesystem->put_contents( $file, $file_contents, FS_CHMOD_FILE);
}
add_action('swa-ie-import-finish', 'melokids_import_user_metadata' ,1,2);
function melokids_import_user_metadata($folder_dir){

    if (file_exists($file = $folder_dir . 'user_data.json')){
        $users_data = json_decode(file_ef4_get_contents($file),true);
        foreach ($users_data as $user)
        {
            $insert = $user['insert'];
            $insert['role'] = $user['roles'][0];
            if(username_exists($insert['user_login']) || email_exists($insert['user_email']))
                continue;
            $id = wp_insert_user($insert);
            if(!$id)
                continue;
            $new_user = get_user_by('id',$id);
            if(!$new_user instanceof WP_User)
                continue;
            foreach ($user['roles'] as $role)
            {
                $new_user->add_role($role);
            }
            if(count($new_user->roles) !== count($user['roles']) )
                foreach ($user['roles'] as $role)
                {
                    $new_user->add_role($role);
                }
            foreach ($user['meta'] as $field=>$meta)
            {
                update_user_meta($new_user->ID,$field,$meta[0]);
            }
        }
    }
}
