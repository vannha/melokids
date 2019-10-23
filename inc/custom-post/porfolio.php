<?php
if(!function_exists('EF4Framework')) return;
/**
 * Post Type: MeloKids Portfolios.
 */
function melokids_cpts_portfolio() {
	$labels = array(
		'name'          => esc_html__( 'MeloKids Portfolios', 'melokids' ),
		'singular_name' => esc_html__( 'MeloKids Portfolio', 'melokids' ),
		'menu_name'     => esc_html__( 'MeloKids Portfolios', 'melokids' ),
		'all_items'     => esc_html__( 'All Portfolios', 'melokids' ),
	);

	$args = array(
		'label'               => esc_html__( 'MeloKids Portfolios', 'melokids' ),
		'labels'              => $labels,
		'description'         => esc_html__('Add your porfolios','melokids'),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => false,
		'rest_base'           => '',
		'has_archive'         => false,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'hierarchical'        => true,
		'rewrite'             => array( 'slug' => 'portfolio', 'with_front' => true ),
		'query_var'           => true,
		'menu_icon'           => 'dashicons-portfolio',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
	);
	register_ef4_post_type( 'portfolio', $args );
}
if(class_exists('VC_Manager'))
	add_action( 'vc_before_init', 'melokids_cpts_portfolio' );
else 
	add_action( 'init', 'melokids_cpts_portfolio' );
/**
 * Taxonomy: Portfolio Categories.
 */
function melokids_taxes_portfolio_cat() {
	$labels = array(
		'name'          => esc_html__( 'Portfolio Categories', 'melokids' ),
		'singular_name' => esc_html__( 'Portfolio Category', 'melokids' ),
	);

	$args = array(
		'label'              => esc_html__( 'Portfolio Categories', 'melokids' ),
		'labels'             => $labels,
		'public'             => true,
		'hierarchical'       => true,
		'label'              => esc_html__( 'Portfolio Categories', 'melokids' ),
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio_cat', 'with_front' => true, ),
		'show_admin_column'  => false,
		'show_in_rest'       => false,
		'rest_base'          => 'portfolio_cat',
		'show_in_quick_edit' => false,
	);
	register_ef4_taxonomy( 'portfolio_cat', array( 'portfolio' ), $args );
}

if(class_exists('VC_Manager'))
	add_action( 'vc_before_init', 'melokids_taxes_portfolio_cat' );
else 
	add_action( 'init', 'melokids_taxes_portfolio_cat' );


/** Portfolio Content */
if(!function_exists('melokids_get_portfolio_opts')){
    function melokids_get_portfolio_opts($opt_id, $default = ''){
        global $post;
        return $options = '' != get_post_meta($post->ID, $opt_id, true) ? get_post_meta($post->ID, $opt_id, true) : $default;
    }
}
if(!function_exists('melokids_portfolio_gallery')){
    function melokids_portfolio_gallery($args = []){
    	global $post;
    	if(get_post_type() !== 'portfolio') return;

        if(empty(melokids_get_opts('gallery')) && !has_post_thumbnail()) 
            return;
        $args = wp_parse_args($args, array(
            'size' => melokids_get_opts('gallery_size','medium'),
        ));
        $gallery_layout = melokids_get_opts('gallery_layout');
        $galleris = explode(',', melokids_get_opts('gallery'));

        ob_start();
        if(empty(melokids_get_opts('gallery'))){
            ?>
                <div class="p-gallery-item default-thumb">
                    <a class="light-box" data-rel="prettyPhoto[rel-<?php echo get_the_ID();?>]" href="<?php the_post_thumbnail_url('full');?>" title="<?php the_title_attribute() ?>">
                        <?php the_post_thumbnail($args['size']); ?>
                    </a>
                </div>
            <?php
        } else {
            foreach ($galleris as $gallery):
                $alt_text = !empty(get_post_meta( $gallery, '_wp_attachment_image_alt', true )) ? get_post_meta( $gallery, '_wp_attachment_image_alt', true ) : get_the_title() ;
                ?>
                <div class="p-gallery-item">
                    <a class="light-box" data-rel="prettyPhoto[rel-<?php echo get_the_ID();?>]" href="<?php echo esc_url(wp_get_attachment_image_url($gallery, 'full' ));?>" title="<?php echo esc_attr($alt_text); ?>">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url($gallery, $args['size'] ));?>" alt="<?php echo esc_attr($alt_text); ?>" />
                    </a>
                </div>
                <?php
            endforeach;
        }
        $gallery_item = ob_get_clean();

        /* Print Galelry */
        switch ($gallery_layout) {
            default:
            ?>
            <div class="p-gal-wrap <?php echo esc_attr($gallery_layout);?> images-light-box">
                <?php echo wp_kses_post($gallery_item); ?>
            </div>
            <?php
                break;
        }
    }
}
if(!function_exists('melokids_portfolio_atts')){
    function melokids_portfolio_atts(){
    	if(get_post_type() !== 'portfolio') return;
        global $post;
        $clients  = melokids_get_opts('client','A&J Co.');
        $url = melokids_get_opts('url','http://themeforest.net/user/zookastudio');
        $d = melokids_get_opts('date', get_the_date());
        if(!empty($d)){
            $_date    = date_create($d);
            $date     = date_format($_date, get_option('date_format'));
        } else {
            $date = get_the_date();
        }
    ?>
        <div class="p-atts">
            <?php if(!empty($clients)): ?>
                <div class="att-item client"><span class="att-title"><?php esc_html_e('Client','melokids');?>:</span> <?php echo esc_html($clients);?></div>
            <?php endif; ?>
            <?php if(!empty($url)): ?>
                <div class="att-item url"><span class="att-title"><?php esc_html_e('URL','melokids');?>:</span> <?php echo esc_url($url);?></div>
            <?php endif; ?>
            <?php if(!empty($date)): ?>
                <div class="att-item date"><span class="att-title"><?php esc_html_e('Date','melokids');?>:</span> <?php echo esc_html($date);?></div>
            <?php endif; 
                the_terms(get_the_ID(), 'portfolio_cat','<div class="att-item cat"><span class="att-title">'.esc_html__('Category','melokids').':</span> ',', ','</div>');
            ?>
        </div>
    <?php
    }
}