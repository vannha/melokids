<?php
if(!class_exists('EF4Framework')) return;
/* Remove default widget Before import sample data */
add_action('ef3-import-start','melokids_removed_widgets', 10, 2);
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

/* Replace dev site url with curren site url 
 * replace in content options, post meta
 * 
*/
add_action('ef3-import-start', 'melokids_import_start', 10, 2);
function melokids_import_start($id, $part){
    global $wp_filesystem;
    /* replace content url */
    $file_content = $part . 'content/content-data.xml';
    $data_content = file_ef4_get_contents($file_content);
    $data_content = preg_replace(
        array(
            '/http:\/\/dev\.joomexp\.com\/wordpress\/melokids/',
        ), 
        site_url(), 
        $data_content
    );
    $wp_filesystem ->put_contents($file_content, $data_content);
    /* replace attach file url */
    $file_attach = $part . 'content/attachment-data.xml';
    $data_attach = file_ef4_get_contents($file_attach);
    $data_attach = preg_replace(
        array(
            '/http:\/\/dev\.joomexp\.com\/wordpress\/melokids/',
        ), 
        site_url(), 
        $data_attach
    );
    $wp_filesystem ->put_contents($file_attach, $data_attach);
}

/**
 * Replace Content
 * remove query
 * Replace dev site url with curren site url in content
*/
function str_replace_assoc( $replace, $subject) { 
   return str_replace(array_keys($replace), array_values($replace), $subject);    
}
function melokids_replace_content($replaces, $attachment){
    /**
     * $replace
     * fixed vc_link param when use in VC Param
    */
    $replace = array( 
        ':' => '%3A', 
        '/' => '%2F' 
    );
    /**
     * $replace2
     * fixed vc_link param when use in VC Param Group
    */
    $replace2 = array( 
        ':' => '%253A', 
        '/' => '%252F' 
    );
    $new_site_url = get_site_url();
    $btn_link_url = str_replace_assoc($replace, $new_site_url);
    $btn_link_url2 = str_replace_assoc($replace2, $new_site_url);
    return array(
        //'/category="(.+?)"/'                                               => 'category=""',
        //'/category:"(.+?)"/'                                               => '',
        //'/tax_query:/'                                                     => 'remove_query:',
        //'/categories:/'                                                    => 'remove_query:',
        '/http%3A%2F%2Fdev.joomexp.com%2Fwordpress%2Fmelokids%2F/'         => $btn_link_url.'%2F',
        '/http%253A%252F%252Fdev.joomexp.com%252Fwordpress%252Fmelokids/'  => $btn_link_url2
    );
}
add_filter('ef3-replace-content', 'melokids_replace_content', 10 , 2);

/** 
 * Replace Theme Option Name 
 * Replace theme option name with default theme option name from framework
*/
add_filter('ef3-theme-options-opt-name', 'melokids_set_demo_opt_name');
function melokids_set_demo_opt_name(){
    return 'theme_options';
}

/* Replace Theme Option 
 * replace default theme option after import sample data
*/
add_filter('ef3-replace-theme-options', 'melokids_replace_theme_options');
function melokids_replace_theme_options(){
    return array(
        'dev_mode' => 0,
    );
}
/** 
 * Remove Create Demo
 * remove create demo content screen
*/
add_filter('ef3-enable-create-demo', 'melokids_enable_create_demo');
function melokids_enable_create_demo(){
    return true;
}
/**
 * update widget custom menu at import sample data time 
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
add_action('ef3-import-finish','melokids_update_widget_data_for_menu');
function melokids_update_widget_data_for_menu() { 
$settings = array(
    'zk-sidebar-menu'                      => array('Main Menu'),  
);
 if(!empty($settings)){
  foreach($settings as  $sbarid =>$nav_arr_name){
   // get menu id unassign
   $sidebars_widgets = wp_get_sidebars_widgets();
   $widget_ids = $sidebars_widgets[$sbarid];
   if( !$widget_ids ) {
    return ;
   }
   $icr=0;
   foreach( $widget_ids as $id ) {
    $wdgtvar  = 'widget_'._get_widget_id_base( $id );
    $idvar    = _get_widget_id_base( $id );
    $instance = get_option( $wdgtvar );
    $idbs     = str_replace( $idvar.'-', '', $id );
    if(isset($instance[$idbs]['nav_menu'])){
     // get current menu id
     $nav = wp_get_nav_menu_object($nav_arr_name[$icr]);
     $mn_id = $nav->term_id;
     // update menu id to widget
     $instance[$idbs]['nav_menu'] = $mn_id;
     update_option( $wdgtvar, $instance );
     $icr++;
    }
   }   
  }   
 }
}

/**
 * Set woo page.
 *
 * get array woo page title and update options.
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
function melokids_set_woo_page(){
    $woo_pages = array(
        'woocommerce_shop_page_id'      => 'Shop',
        'woocommerce_cart_page_id'      => 'Cart',
        'woocommerce_checkout_page_id'  => 'Checkout',
        'woocommerce_myaccount_page_id' => 'My Account',
        'woocommerce_terms_page_id'     => 'Terms and conditions'
    );
    foreach ($woo_pages as $key => $woo_page){
        $page = get_page_by_title($woo_page);
        if(!isset($page->ID))
            return ;
        update_option($key, $page->ID);
    }
}
add_action('ef3-import-finish', 'melokids_set_woo_page');


/**
 * Resize / Crop Image 
*/
add_action('ef3-import-finish', 'melokids_sample_data_resize_images', 1);
function melokids_sample_data_resize_images(){
    $query = array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_status'    => 'inherit',
    );

    $media = new WP_Query($query);
    if ($media->have_posts()) {
        foreach ($media->posts as $image) {
            if (strpos($image->post_mime_type, 'image/') !== false) {
                $image_path = get_attached_file($image->ID);
                $metadata = wp_generate_attachment_metadata($image->ID, $image_path);
                wp_update_attachment_metadata($image->ID, $metadata);
            }
        }
    }
}

/* move default post / page to trash */
add_action('ef3-import-finish', 'melokids_move_trash', 1);
if(!function_exists('melokids_move_trash')){
    function melokids_move_trash(){
        wp_trash_post(1);
        wp_trash_post(2);
    }
}
/* Update Blog Name / Blog Description  */
add_action('ef3-import-finish', 'melokids_update_bloginfo', 1);
if(!function_exists('melokids_update_bloginfo')){
    function melokids_update_bloginfo(){
        update_option( 'blogname', 'MeloKids' );
        update_option( 'blogdescription', 'Store & Kids Shop WooCommerce Theme' );
    }
}

/* User and User Meta */
add_action('ef3-import-finish', 'melokids_import_user_metadata' ,1,2);
function melokids_import_user_metadata($id,$folder_dir){

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
add_action('ef3-export','melokids_export_user_metadata',1,2);
function melokids_export_user_metadata($id='',$folder_dir=''){
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
/**
 * WooCommerce Product Attributes
 * export and import WooCommerce Product attributes like: color, size, ....
 * 
*/
add_action('swa-ie-export-start','melokids_export_product_attribute_data',1,2);
function melokids_export_product_attribute_data($folder_dir){
    global $wp_filesystem;
    $tax_termmeta_file = $folder_dir . 'woo_product_attributes.json';
    if (!file_exists($tax_termmeta_file)){
        $attributes = wc_get_attribute_taxonomies();
        $atts_data = array();
        $att_fields = ["attribute_id","attribute_name","attribute_label","attribute_type","attribute_orderby","attribute_public"];
        $term_fields = array(
            "term_id","name","slug","term_group","term_taxonomy_id",
            "taxonomy","description","parent","count","filter","meta_value"
        );
        foreach ($attributes as $attribute)
        {
            $att_data = array(
                'data'=>array(),
                'terms'=>array()
            );
            foreach ($att_fields as $field)
            {
                if(!isset($attribute->$field))
                    continue;
                $att_data['data'][$field] = $attribute->$field;
            }
            $att_name = wc_attribute_taxonomy_name($attribute->attribute_name);
            $terms = get_terms(array(
                'taxonomy'   => $att_name,
                'hide_empty' => false,
            ));
            foreach ($terms as $term) {
                if (!$term instanceof WP_Term)
                    continue;
                $term_data = array(
                    'fields'=>array(),
                    'meta'=>array()
                );
                foreach ($term_fields as $field)
                {
                    $term_data['fields'][$field] = $term->$field;
                }
                $term_meta = get_term_meta($term->term_id);
                foreach ($term_meta as $meta_slug => $meta)
                {
                    $term_data['meta'][$meta_slug] = $meta[0];
                }
                $att_data['terms'][$term->slug] = $term_data;
            }
            $atts_data[$att_name] = $att_data;
        }
        //get attributes attach products
        $products = wc_get_products(array('limit'=>-1));
        $products_data  = [];
        foreach ($products as $product)
        {
            if(!$product instanceof WC_Product)
                continue;
            $product_data = array(
                'product_id'=>$product->get_id(),
                'attributes'=>[]
            );
            $atts =  $product->get_attributes( 'edit' );
            foreach ($atts as $att_slug =>$att)
            {
                if(!$att instanceof WC_Product_Attribute)
                    continue;
                if(strpos($att_slug,'pa_')!== 0)
                    continue;
                $options = $att->get_options();
                $options = ! empty( $options ) ? $options : array();
                foreach ($options as $key => $term_id)
                {
                    $term = get_term($term_id);
                    if(!$term instanceof WP_Term)
                        continue;
                    $options[$key] = $term->slug;
                }
                $product_data['attributes'][$att_slug] = [
                    'options'=>$options,
                    'name'=>$att->get_name(),
                    'positions'=>$att->get_position(),
                    'visible'=>$att->get_visible(),
                    'variation'=>$att->get_variation(),
                ];
                $product_data['variations'] =[];
                $variations     = wc_get_products( array(
                    'status'         => array( 'private', 'publish' ),
                    'type'           => 'variation',
                    'parent'         => $product->get_id(),
                    'limit'          => -1,
                    'page'           => 1,
                    'orderby'        => array(
                        'menu_order' => 'ASC',
                        'ID'         => 'DESC',
                    ),
                    'return'         => 'objects',
                ) );
                if(is_array($variations))
                    foreach ($variations as $variation)
                    {
                        if(!$variation instanceof WC_Product_Variation)
                            continue;
                        $var_post = get_post($variation->get_id());
                        if(!$var_post instanceof WP_Post)
                            continue;
                        $product_data['variations'][] = $var_post->post_name;
                    }
            }
            $products_data[] = $product_data;
        }
        $atts_data['products']= $products_data;
        $file_contents = json_encode($atts_data);
        $wp_filesystem->put_contents( $tax_termmeta_file, $file_contents, FS_CHMOD_FILE);
    }
}
add_action('swa-ie-import-start', 'melokids_import_product_attribute_data' ,1,2);
function melokids_import_product_attribute_data($folder_dir){
    if (file_exists($folder_dir . 'woo_product_attributes.json')){
        $atts_data = json_decode(file_get_contents($folder_dir . 'woo_product_attributes.json'),true);
        if(!is_array($atts_data))
            return;
        $queue = array(
            'threads'=>array(
                'create_attribute'      =>false,
                'insert_attribute_term' =>false,
                'fix_product_attribute' =>false
            ),
            'data'=>$atts_data
        );
        update_option('melokids_queue_install_demo',$queue);
    }
}

add_action('swa-ie-export-finish','melokids_run_queue_install_data');
function melokids_run_queue_install_data()
{
    $queue = get_option('melokids_queue_install_demo',false);
    if(!is_array($queue))
        return;
    if(!class_exists('WooCommerce'))
        return;
    $atts_data = $queue['data'];
    $current_thread = 'create_attribute';
    if($queue['threads']['create_attribute'] === true)
        $current_thread = 'insert_attribute_term';
    if($queue['threads']['insert_attribute_term'] === true)
        $current_thread = 'fix_product_attribute';
    if($queue['threads']['fix_product_attribute'] === true)
    {
        //all thread complete, delete queue
        update_option('melokids_queue_install_demo',false);
        return;
    }
    switch ($current_thread)
    {
        case 'create_attribute':
            $result = [];
            $attributes = wc_get_attribute_taxonomies();
            if(is_array($attributes))
            {
                foreach ($attributes as $attribute)
                {
                    if(array_key_exists($attribute->attribute_name,$atts_data))
                        unset($atts_data[$attribute->attribute_name]);
                }
            }
            foreach ($atts_data as $slug => $att)
            {
                if(empty($att['data']))
                    continue;
                $woo_atts = $att['data'];
                //insert attributes;
                $result[] = wc_create_attribute(array(
                    'name'=>$woo_atts['attribute_label'],
                    'slug'=>$woo_atts['attribute_name'],
                    'type'=>$woo_atts['attribute_type'],
                    'order_by'=>$woo_atts['attribute_orderby'],
                    'has_archives'=>$woo_atts['attribute_public']
                ));
            }
            $queue['threads'][$current_thread] = true;
            update_option('melokids_queue_install_demo',$queue);
            return;
            break;
        case 'insert_attribute_term':
            $result = [];
            foreach ($atts_data as $slug => $att)
            {
                if(empty($att['terms']))
                    continue;
                foreach ($att['terms'] as $term)
                {
                    if(empty($term['fields']) || empty($term['fields']['taxonomy']))
                        continue;
                    $tax = get_taxonomy($term['fields']['taxonomy']);
                    if(!$tax instanceof WP_Taxonomy)
                        return;
                    $result[] = $result_insert_term = wp_insert_term($term['fields']['name'],$term['fields']['taxonomy'],array(
                        'description'=>$term['fields']['description'],
                        'parent'=>$term['fields']['parent'],
                        'slug'=>$term['fields']['slug'],
                    ));
                    if(is_array($result_insert_term))
                    {
                        $term_id = $result_insert_term['term_id'];
                        foreach ($term['meta'] as $key => $value)
                        {
                            update_term_meta($term_id,$key,$value);
                        }
                    }
                }
            }
            $queue['threads'][$current_thread] = true;
            update_option('melokids_queue_install_demo',$queue);
            return;
            break;
        case 'fix_product_attribute':
            $products_data = $atts_data['products'];
            $log = [
                'products'=>[],
                'terms'=>[],
                'options'=>[]
            ];
            foreach ($products_data as $product_data)
            {
                $product= wc_get_product($product_data['product_id']);
                if($log['products'][$product_data['product_id']] = (!$product instanceof WC_Product))
                    continue;
                $atts =  $product->get_attributes( 'edit' );
                $log['terms']=[];
                $log['options'][$product_data['product_id']]=[];
                foreach ($atts as $att_slug =>$att)
                {
                    if(empty($product_data['attributes']))
                        continue;
                    if(!$att instanceof WC_Product_Attribute)
                        continue;
                    if(!array_key_exists($att_slug,$product_data['attributes']))
                        continue;
                    $options =  $product_data['attributes'][$att_slug]['options'];
                    foreach ($options as $key => $term_slug)
                    {
                        $term = get_term_by('slug',$term_slug,$att_slug);
                        $log['terms'][$term_slug] =  ($term) ? true : false;
                        if(!$term instanceof WP_Term)
                            continue;
                        $options[$key] = $term->term_id;
                    }
                    $log['options'][$product_data['product_id']][] = $options;
                    $att->set_options($options);
                    $log['options'][$product_data['product_id']][] = $att->get_options();
                }
                $classname    = WC_Product_Factory::get_product_classname( $product->get_id(), $product->get_type() );
                $product      = new $classname( $product->get_id() );
                $product->set_attributes($atts);
                $product->save();
                //fix product variation
                $variations = get_posts(array('post_name__in'=>$product_data['variations'],'limit'=>-1));
                foreach ($variations as $variation)
                {
                    wp_update_post([
                        'ID' => $variation->ID,
                        'post_parent' => $product->get_id()
                    ]);
                }
            }
            $queue['threads'][$current_thread] = true;
            update_option('melokids_queue_install_demo',$queue);
            return;
            break;
    }
    $queue['threads'][$current_thread] = true;
    update_option('melokids_queue_install_demo',$queue);
    return;
}