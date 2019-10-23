<?php
/**
 * Meta box config file
 */
if (! class_exists('MetaFramework')) {
    return;
}
$args =  array(
    'opt_name'           => apply_filters('opt_meta', 'meta_options'),
    'admin_bar'          => false,
    'dev_mode'           => false,
    'open_expanded'      => false,
    'disable_save_warn'  => true,
    'save_defaults'      => true,
    'ajax_save'          => false,
    'update_notice'      => false,
    'allow_sub_menu'     => false,
    'customizer'         => true,
    'show_import_export' => false,
    'use_cdn'            => true,
    'meta_mode'          => 'multiple',
    'async_typography'   => false,
    'output'             => true,
    'output_tag'         => true,
);

// -> Set Option To Panel.
MetaFramework::setArgs($args);

if(melokids_is_front_page())
    melokids_page_metas();
add_action('admin_init', 'melokids_page_metas');


function melokids_page_metas(){
    global $melokids_metabox_enqued;
    if(!empty($melokids_metabox_enqued))
        return;
    $melokids_metabox_enqued = true;
    if (!melokids_is_admin_edit_post()
        || melokids_is_front_page()
        || (melokids_is_admin_edit_post() && !empty($_GET['post']) && get_post_type($_GET['post']) == "page")
        || (melokids_is_admin_edit_post() && empty($_GET['post']))
    ) 
    {
        MetaFramework::setMetabox(array(
            'id'            => 'page_settings',
            'label'         => esc_html__('Page Setting', 'melokids'),
            'post_type'     => 'page',
            'context'       => 'advanced',
            'priority'      => 'high',
            'open_expanded' => false,
            'sections'      => array(
                array(
                    'title'  => esc_html__('General', 'melokids'),
                    'icon'   => 'dashicons dashicons-admin-home',
                    'fields' => array_merge(
                        melokids_general_opts(array('default' => 'true'))
                    )
                ),
                array(
                    'title'      => esc_html__('Page Layout', 'melokids'),
                    'icon'       => 'el el-credit-card',
                    'subsection' => false,
                    'fields'     => melokids_page_layout_opts(array('default' => 'true'))
                ),
                melokids_header_banner_opts(true),
                melokids_header_top_opts(true),
                array(
                    'title'  => esc_html__('Header', 'melokids'),
                    'icon'   => 'el el-credit-card',
                    'fields' => array_merge(
                        melokids_header_layout_opts(true)
                    )
                ),
                array(
                    'title'      => esc_html__('Logo', 'melokids'),
                    'icon'       => 'el el-picture',
                    'subsection' => false,
                    'fields'     => array_merge(
                        array(
                            array(
                                'title'     => esc_html__('Add custom logo for this page', 'melokids'),
                                'subtitle'  => esc_html__('Select an image file for your logo.', 'melokids'),
                                'id'        => 'page_logo',
                                'type'      => 'media',
                            ),
                            array(
                                'title'    => esc_html__('Show Logo On Desktop', 'melokids'),
                                'subtitle' => esc_html__('Show/Hide logo of this page on desktop view', 'melokids'),
                                'id'       => 'page_show_logo',
                                'type'     => 'switch',
                                'default'  => '1',
                            ),
                            array(
                                'title'    => esc_html__('Logo Size', 'melokids'),
                                'subtitle' => esc_html__('Custom logo size on this page', 'melokids'),
                                'id'       => 'logo_size',
                                'type'     => 'dimensions',
                                'height'   => false,
                                'default'  => array()
                            ),
                            array(
                                'title'    => esc_html__('Logo Spacing', 'melokids'),
                                'subtitle' => esc_html__('Custom logo spacing on this page', 'melokids'),
                                'id'       => 'logo_spacing',
                                'type'     => 'spacing',
                                'mode'     => 'padding',
                                'units'    => array('px'),
                                'output'   => array('#zk-logo')
                            )
                        )
                    )
                ),
                array(
                    'title'      => esc_html__('Header Attribute', 'melokids'),
                    'icon'       => 'el el-plus',
                    'subsection' => false,
                    'fields'     => array_merge(
                        melokids_header_atts_opts(true)
                    )
                ),
                array(
                    'title'  => esc_html__('Header OnTop', 'melokids'),
                    'icon'   => 'el el-credit-card',
                    'fields' => array_merge(
                        melokids_header_ontop_opts(['default' => true])
                    )
                ),
                array(
                    'title'  => esc_html__('Header Sticky', 'melokids'),
                    'icon'   => 'el el-credit-card',
                    'fields' => array_merge(
                        melokids_header_sticky_opts(['default' => true])
                    )
                ),
                array(
                    'title'      => esc_html__('Page Title & BC', 'melokids'),
                    'icon'       => 'el el-credit-card',
                    'subsection' => false,
                    'fields'     => array_merge(
                        melokids_pagetitle_opts(true)
                    )
                ),
                array(
                    'title'      => esc_html__('Page Title', 'melokids'),
                    'icon'       => 'el el-text-width',
                    'subsection' => false,
                    'fields'     => array_merge(
                        array(
                            array(
                                'id'       => 'page_title_text',
                                'type'     => 'textarea',
                                'validate' => 'no_html',
                                'title'    => esc_html__('Custom Page Title','melokids'),
                                'subtitle' => esc_html__('This text will replace default title','melokids'),
                                'desc'     => esc_html__('Hit ENTER to add line break! Hit double ENTER to add paragraph!','melokids'),
                                'required' => array(
                                    array('page_title', '!=', '0')
                                ) 
                            ),
                            array(
                                'title'     => esc_html__('Typography for Title', 'melokids'),
                                'id'        => 'pagetitle_typo',
                                'type'      => 'typography',
                                'text-transform'    => true,
                                'letter-spacing'    => true,
                                'text-align'        => false,
                                'default'   => array(),
                                'output'    => array('.zk-page-title-text')
                            ),
                            array(
                                'id'       => 'page_title_subtext',
                                'type'     => 'textarea',
                                'validate' => 'no_html',
                                'title'    => esc_html__('Custom Page Subtitle','melokids'),
                                'subtitle' => esc_html__('This text will show as description of page title','melokids'),
                                'desc'     => esc_html__('Hit ENTER to add line break! Hit double ENTER to add paragraph!','melokids'),
                                'required' => array(
                                    array('page_title', '!=', '0')
                                )  
                            ),
                            array(
                                'title'          => esc_html__('Typography for Subtitle', 'melokids'),
                                'id'             => 'pagetitle_subtypo',
                                'type'           => 'typography',
                                'text-transform' => true,
                                'letter-spacing' => true,
                                'text-align'     => false,
                                'default'        => array(),
                                'output'         => array('.zk-page-title-text .sub-title')
                            )
                        )
                    )
                ),
                array(
                    'icon'       => 'el-icon-random',
                    'title'      => esc_html__('Breadcrumb', 'melokids'),
                    'subsection' => false,
                    'fields'     => array_merge(
                        melokids_pagetitle_breadcrumb_opts()
                    )
                ),
                array(
                    'title'   => esc_html__('Content', 'melokids'),
                    'heading' => esc_html__('Main Content Settings','melokids'),
                    'icon'    => 'el el-website',
                    'fields'  => array_merge(
                        melokids_main_content_opts(array('default' => 'true'))
                    )
                ),
                melokids_footer_opts(true)
            )
        ));
    }
    /**
     * Post Settings
    */
    if (melokids_is_admin_edit_post() || melokids_is_front_page()) 
    {
        MetaFramework::setMetabox(array(
            'id'            => 'post_settings',
            'label'         => esc_html__('Post Setting', 'melokids'),
            'post_type'     => 'post',
            'context'       => 'advanced',
            'priority'      => 'high',
            'open_expanded' => false,
            'sections'      => array(
                array(
                    'id'         => 'post_layout', 
                    'title'      => esc_html__('Post Layout', 'melokids'),
                    'icon'       => 'el el-credit-card',
                    'fields'     => melokids_post_layout_opts(array('default' => 'true'))
                )
            )
        ));
    }
    /**
     * Portfolio Settings
    */
    if (melokids_is_admin_edit_post() || melokids_is_front_page()) 
    {
        MetaFramework::setMetabox(array(
            'id'            => 'portfilio_meta_options',
            'label'         => esc_html__('Portfolio Options', 'melokids'),
            'post_type'     => 'portfolio',
            'context'       => 'advanced',
            'priority'      => 'default',
            'open_expanded' => false,
            'sections'      => array(
                array(
                    'title'   => esc_html__('General', 'melokids'),
                    'heading' => '',
                    'id'      => 'portfolio_subtitle',
                    'icon'    => 'el el-font',
                    'fields'  => array(
                        array(
                            'id'       => 'portfolio_subtitle',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Add subtitle', 'melokids' ),
                            'subtitle'    => esc_html__( 'Add your subtitle', 'melokids' ),
                        ),
                        array(
                            'title'     => esc_html__('Single Layout', 'melokids'),
                            'subtitle'  => esc_html__('Choose default layout for single Portfolio page', 'melokids'),
                            'id'        => 'portfolio_layout',
                            'type'      => 'button_set',
                            'options'   => array(
                                ''      => esc_html__('Default','melokids'),
                            ),
                            'default'   => '',
                        )
                    )
                ),
                array(
                    'title'   => esc_html__('Gallery', 'melokids'),
                    'heading' => '',
                    'id'      => 'portfolio_gallery',
                    'icon'    => 'el el-picture',
                    'fields'  => array(
                        array(
                            'id'       => 'gallery',
                            'type'     => 'gallery',
                            'title'    => esc_html__( 'Add/Edit Gallery', 'melokids' ),
                            'subtitle' => esc_html__( 'Create a new Gallery by selecting existing or uploading new images using the WordPress native uploader', 'melokids' ),
                        ),
                        array(
                            'title'     => esc_html__('Gallery Layout', 'melokids'),
                            'subtitle'  => esc_html__('Choose a gallery layout for single Portfolio page', 'melokids'),
                            'id'        => 'gallery_layout',
                            'type'      => 'button_set',
                            'options'   => array(
                                '-1'     => esc_html__('Default','melokids'),
                            ),
                            'default'   => '-1',
                            'required'    => array( 0 => 'gallery', 1 => '!=', 2 => '')
                        ),
                    )
                ),
                array(
                    'title'   => esc_html__('Additional Infomations', 'melokids'),
                    'heading' => '',
                    'id'      => 'portfolio_additional',
                    'icon'    => 'el el-info-circle',
                    'fields'  => array(
                        array(
                            'id'       => 'client',
                            'type'     => 'text',
                            'placeholder'   => esc_html__('A&J Co.','melokids'),
                            'title'    => esc_html__( 'Clients', 'melokids' ),
                            'subtitle' => esc_html__( 'Enter client name', 'melokids' ),
                        ),
                        array(
                            'id'       => 'date',
                            'type'     => 'date',
                            'placeholder'   => esc_html__('Click to enter a date','melokids'),
                            'title'    => esc_html__( 'Date', 'melokids' ),
                            'subtitle' => esc_html__( 'Enter Date', 'melokids' ),
                        ),
                        array(
                            'id'       => 'url',
                            'type'     => 'text',
                            'placeholder'   => 'http://your-client-site.com',
                            'title'    => esc_html__( 'Client Site', 'melokids' ),
                            'subtitle' => esc_html__( 'Enter client site', 'melokids' ),
                        ),
                        array(
                            'id'       => 'recent',
                            'title'    => esc_html__( 'Recent Project', 'melokids' ),
                            'subtitle' => esc_html__( 'Show/Hide recent project', 'melokids' ),
                            'type'      => 'button_set',
                            'options'   => array(
                                '-1'      => esc_html__('Default','melokids'),
                                '1'     => esc_html__('Yes','melokids'),
                                '0'     => esc_html__('No','melokids'),
                            ),
                            'default'   => '-1',
                        ),
                    )
                ),
            )
        ));
    }

    /* Single Product Settings */
    if (melokids_is_admin_edit_post() || melokids_is_front_page()) 
    {
        MetaFramework::setMetabox(array(
            'id'            => 'product_meta_options',
            'label'         => esc_html__('Product Options', 'melokids'),
            'post_type'     => 'product',
            'context'       => 'advanced',
            'priority'      => 'default',
            'open_expanded' => false,
            'sections'      => array(
                melokids_woocommerce_single_opts([
                    'subsection' => false,
                    'default'    => true
                ])
            )
        ));
    }

    MetaFramework::init();
}

function melokids_is_admin_edit_post()
{
    global $pagenow;
    return strpos($pagenow, "post.php") !== false || strpos($pagenow, "post-new.php") !== false;
}

function melokids_is_front_page()
{
    global $pagenow;
    return strpos($pagenow, "index.php") !== false;
}

add_filter('redux/field/theme_options/output_css','melokids_ignore_duplicate_ouput_css_redux');
function melokids_ignore_duplicate_ouput_css_redux($field)
{
    global $theme_options,$meta_options;
    if(empty($meta_options[$field['id']]))
        return $field;
    $field_config_in_page = $meta_options[$field['id']];
    if(!melokids_is_config_not_set($field_config_in_page))
        $field['output'] = '';
    return $field;
}

function melokids_is_config_not_set($config)
{
    $check = true;
    if(!is_array($config))
        return empty($config);
    $key_ignore = ['units','google','alpha'];
    $value_ignore = [-1];
    foreach ($config as $key => $field)
    {
        if(in_array($key,$key_ignore) || in_array($field,$value_ignore))
            continue;
        if(!melokids_is_config_not_set($field))
        {
            $check = false;
            break;
        }
    }
    return $check;
}