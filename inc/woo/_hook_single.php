<?php

/**
 * Single Product 
 *
 * Wrap single product image and product summary
 *
**/
add_action('woocommerce_before_single_product_summary', function(){
    $gallery_layout = melokids_get_opts('single_product_gallery_layout', 'default');
    echo '<div class="zk-wc-img-summary"><div class="gallery-wraps flexslider-wrap '.esc_attr($gallery_layout).'">';
}, 0);
add_action('woocommerce_before_single_product_summary', function(){
    echo '</div>';
}, 9999);
add_action('woocommerce_after_single_product_summary', function(){
    echo '</div>';
}, 0);

/**
 * Single Product 
 *
 * Move sale flash to product badge 
 * Change Sale flash html output
 *
**/
remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10);

/**
 * Single Product 
 * Product gallery style 
 * $key = array_search('images', $wrapper_classes);
 * unset($wrapper_classes[$key]);
 * Remvove class images 
*/
if(!function_exists('melokids_wc_single_product_gallery_css_class')){
	add_filter('woocommerce_single_product_image_gallery_classes', 'melokids_wc_single_product_gallery_css_class');
	function melokids_wc_single_product_gallery_css_class($wrapper_classes){
	    $wrapper_classes[] = 'flexslider';
		return $wrapper_classes;
	}
}

/**
 * Single Product 
 *
 * Gallery style with thumbnail carousel in bottom
 *
*/
if(!function_exists('melokids_wc_single_product_gallery_layout')){
	add_filter('woocommerce_single_product_carousel_options', 'melokids_wc_single_product_gallery_layout' );
    function melokids_wc_single_product_gallery_layout($options){
        $gallery_layout = melokids_get_opts('single_product_gallery_layout', 'default');
        
        switch ($gallery_layout) {
	        case 'slick-v':
				$options['directionNav'] = true;
				$options['controlNav']   = false;
	            $options['sync'] = '.gallery-thumb-wrap';
	            break;
	    
	        case 'slick-h':
	            $options['directionNav'] = true;
				$options['controlNav']   = false;
	            $options['sync'] = '.gallery-thumb-wrap';
	            break;
	    }

	    return $options;
    }
}

/**
 * Single Product Gallery
 *
 * Add thumbnail product gallery 
 *
*/
if(!function_exists('melokids_product_gallery_thumbnail')){
	add_action('woocommerce_before_single_product_summary', 'melokids_product_gallery_thumbnail', 21);
	function melokids_product_gallery_thumbnail($args=[]){
		global $product;
		$gallery_layout = melokids_get_opts('single_product_gallery_layout', 'default');
        $args = wp_parse_args($args, [
            'gallery_layout' => $gallery_layout
        ]);
        $post_thumbnail_id = $product->get_image_id();
    	$attachment_ids = array_merge( (array)$post_thumbnail_id , $product->get_gallery_image_ids() );

        if('default' === $args['gallery_layout'] || empty($attachment_ids[0])) return;
        $flex_class = '';
        switch ($args['gallery_layout']) {
	        case 'slick-v':
	            $thumbnail_size = '180x239';
	            $large_size = '560x762';
	            $flex_class = 'flex-vertical';
	            break;
	    
	        case 'slick-h':
	            $thumbnail_size = '177x235';
	            $large_size = '560x762';
	            $flex_class = 'flex-horizontal';
	            break;
	    }
    ?>
    	<div class="gallery-thumb-wrap flexslider <?php echo esc_attr($flex_class);?>">
    		<div class="small-thumb">
	            <?php foreach ( $attachment_ids as $attachment_id ) { ?>
	                <div class="thumbnail flex-control-thumb" data-thumb="<?php echo melokids_get_image_url_by_size($attachment_id, $thumbnail_size);?>?>"><?php melokids_image_by_size(['id' => $attachment_id, 'size' => $thumbnail_size]);?></div>
	            <?php } ?>
	        </div>
        </div>
    <?php
	}
}


function melokids_woocommerce_show_product_gallery($html, $args = []){
    $gallery_layout = melokids_get_opts('single_product_gallery_layout', 'default');
    $args = wp_parse_args($args, [
        'gallery_layout' => $gallery_layout
    ]);
    switch ($args['gallery_layout']) {
        case 'slick-v':
            $thumbnail_size = '180x239';
            $large_size = '560x762';
            break;
    
        case 'slick-h':
            $thumbnail_size = '177x235';
            $large_size = '560x762';
            break;

        default : 
            $thumbnail_size = 'woocommerce_gallery_thumbnail';
            $large_size = 'woocommerce_thumbnail';
            break;
    }
    global $product;
    $post_thumbnail_id = $product->get_image_id();
    $attachment_ids = array_merge( (array)$post_thumbnail_id , $product->get_gallery_image_ids() );
    if ( $attachment_ids) {
    ?>
    <div class="zk-product-gallery">
        <div class="gallery-large-wrap">
            <?php do_action('melokids_woocommerce_show_product_thumbnails_attrs'); ?>
            <div class="gallery-thumb-wrap large-thumb">
                <?php foreach ( $attachment_ids as $attachment_id ) { 
                    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
                    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
                    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
                    $image             = wp_get_attachment_image( $attachment_id, $large_size, false, array(
                        'title'                   => get_post_field( 'post_title', $attachment_id ),
                        'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
                        'data-src'                => $full_src[0],
                        'data-large_image'        => $full_src[0],
                        'data-large_image_width'  => $full_src[1],
                        'data-large_image_height' => $full_src[2],
                    ) );
                    ?>
                    <div class="woocommerce-product-gallery__image"><a href="<?php echo esc_url( $full_src[0] );?>" class="full-img"><?php melokids_image_by_size(['id' => $attachment_id, 'size' => '560x762']);?></a></div>
                <?php } ?>
            </div>
        </div>
        <div class="gallery-thumb-wrap small-thumb">
            <?php foreach ( $attachment_ids as $attachment_id ) { ?>
                <div class="woocommerce-product-gallery__image"><?php melokids_image_by_size(['id' => $attachment_id, 'size' => $thumbnail_size]);?></div>
            <?php } ?>
        </div>
    </div>
    <?php
    }
}
//add_action('melokids_woocommerce_show_product_thumbnails_attrs','melokids_loop_product_thumnail_attrs');

/**
 * Single Product 
 *
 * Product rating 
 * Change position to before title
 *
*/
//remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
//add_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 3);

/**
 * Single Product 
 *
 * Product Brand 
 * Add Product Brand before title
 * Hook: woocommerce_single_product_summary
*/
if(!function_exists('melokids_woocommerce_single_product_brand')){
	add_action('woocommerce_single_product_summary','melokids_woocommerce_single_product_brand', 4);
	function melokids_woocommerce_single_product_brand($product_id = ''){
		global $post, $product;
		if(empty($product_id)) $product_id = $product->get_id();
        $terms = get_the_terms($product_id, 'pa_brand');
        if(!is_wp_error($terms)){
            $count = count($terms);
        } else {
            $count = 0;
        }
        $classes = [
        	'wc-brand'
        ];
        if($count > 1) $classes[] = 'mutils-brand';

        if(is_array($terms) && $count > 0) {
        	echo '<div class="wc-single-atts wc-single-brand">';       
            foreach ( $terms as $term ) {
            	$classes[] = strtolower(str_replace(array(' ','&','amp;'), '-', $term->name));
                echo '<div class="'.trim(implode(' ', $classes)).'">'.esc_html($term->name).'</div>';
            }
         	echo '</div>';
        }
	}
}

/**
 * Single Product 
 *
 * Customise the dropdown 'choose an option'
 * Displays the custom "Choose an option" on the front end
 *
*/
if(!function_exists('melokids_woocommerce_dropdown_variation_attribute_options_args')){
	add_filter('woocommerce_dropdown_variation_attribute_options_args', 'melokids_woocommerce_dropdown_variation_attribute_options_args', 10);
	function melokids_woocommerce_dropdown_variation_attribute_options_args( $args ){
		global $product;
		$args['show_option_none'] = esc_html__('Choose a','melokids') .' '. strtolower(wc_attribute_label($args['attribute'],$product));
		return $args;
	}
}

/**
 * Single Product
 *
 * Add stock message to product quantity form
 *
**/
if(!function_exists('melokids_wc_quantity_stock_message')){
	add_action('melokids_woocommerce_after_quantity_input','melokids_wc_quantity_stock_message');
	function melokids_wc_quantity_stock_message(){
		global $product;
		if(!is_single()) return;
		if($product->is_in_stock()){
			echo '<div class="stock in-stock">'.esc_html__('In Stock','melokids').'</div>';
		} else {
			echo '<div class="stock out-of-stock">'.esc_html__('Out of Stock','melokids').'</div>';
		}
	}
}

/**
 * Single Product 
 *
 * Change product meta output html
*/

if ( ! function_exists( 'woocommerce_template_single_meta' ) ) {

	/**
	 * Output the product meta.
	 */
	function woocommerce_template_single_meta() {
		global $product;
		$_sku = ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'melokids' ) ;
		?>
		<div class="product_meta">

			<?php do_action( 'woocommerce_product_meta_start' ); ?>

			<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

				<div class="wc-meta-item sku_wrapper"><span class="wc-meta-title"><?php esc_html_e( 'Sku', 'melokids' ); ?></span> <span class="sku"><?php echo esc_html($_sku); ?></span></div>

			<?php endif; ?>

			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="wc-meta-item  posted_in"><span class="wc-meta-title">' . _n( 'Category', 'Categories', count( $product->get_category_ids() ), 'melokids' ) . '</span>', '</div>' ); ?>

			<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="wc-meta-item tagged_as"><span class="wc-meta-title">' . _n( 'Tag', 'Tags', count( $product->get_tag_ids() ), 'melokids' ) . '</span>', '</div>' ); ?>

			<?php do_action( 'woocommerce_product_meta_end' ); ?>

		</div>
		<?php
	}
}

/**
 * Single Product 
 *
 * Add Share
*/
if(!function_exists('melokids_woocommerce_share')){
	add_action('woocommerce_product_meta_end','melokids_woocommerce_share');
	function melokids_woocommerce_share($args = []){
		if(!class_exists('EF4Framework')) return;
		$show_share = melokids_get_opts('single_product_share','1');
		if('0' === $show_share) return;
		$args = wp_parse_args($args,[
			'before'           => '',
			'after'            => '',
			'show_title'       => true,
			'title'            => esc_html__('Share','melokids'),   
			'title_share_more' => esc_html__('Share to other','melokids'),   
        ]);
		wp_enqueue_script('sharethis');
		global $product;
		$url = get_the_permalink();
        $image = get_the_post_thumbnail_url($product->get_id());
        $title = get_the_title();
		?>
		<div class="wc-meta-item meta-share">
			<span class="wc-meta-title"><?php esc_html_e('Share','melokids') ?></span>
			<span class="share-icons">
				<a href="javascript:void(0);" 
		            data-network="twitter" 
		            data-url="<?php echo esc_url($url);?>" 
		            data-short-url="<?php echo esc_url($url);?>" 
		            data-title="<?php echo esc_attr($title);?>" 
		            data-image="<?php echo esc_url($image); ?>" 
		            data-description="<?php echo get_the_excerpt(); ?>" 
		            data-username="" 
		            data-message="<?php echo bloginfo(); ?>" 
		            class="st-custom-button hint--bounce hint--top" data-hint="<?php esc_html_e('Share to Twitter','melokids');?>"><span class="fa fa-twitter"></span></a>
				<a href="javascript:void(0);" 
		            data-network="facebook" 
		            data-url="<?php echo esc_url($url);?>" 
		            data-short-url="<?php echo esc_url($url);?>" 
		            data-title="<?php echo esc_attr($title);?>" 
		            data-image="<?php echo esc_url($image); ?>" 
		            data-description="<?php echo get_the_excerpt(); ?>" 
		            data-username="" 
		            data-message="<?php echo bloginfo(); ?>" 
		            class="st-custom-button hint--bounce hint--top" data-hint="<?php esc_html_e('Share to Facebook','melokids');?>"><span class="fa fa-facebook"></span></a>
		        <a href="javascript:void(0);" 
		            data-network="googleplus" 
		            data-url="<?php echo esc_url($url);?>" 
		            data-short-url="<?php echo esc_url($url);?>" 
		            data-title="<?php echo esc_attr($title);?>" 
		            data-image="<?php echo esc_url($image); ?>" 
		            data-description="<?php echo get_the_excerpt(); ?>" 
		            data-username="" 
		            data-message="<?php echo bloginfo(); ?>" 
		            class="st-custom-button hint--bounce hint--top" data-hint="<?php esc_html_e('Share to Google Plus','melokids');?>"><span class="fa fa-google-plus"></span></a>
		        <a href="javascript:void(0);" 
		            data-network="pinterest" 
		            data-url="<?php echo esc_url($url);?>" 
		            data-short-url="<?php echo esc_url($url);?>" 
		            data-title="<?php echo esc_attr($title);?>" 
		            data-image="<?php echo esc_url($image); ?>" 
		            data-description="<?php echo get_the_excerpt(); ?>" 
		            data-username="" 
		            data-message="<?php echo bloginfo(); ?>" 
		            class="st-custom-button hint--bounce hint--top" data-hint="<?php esc_html_e('Share to Pinterest','melokids');?>"><span class="fa fa-pinterest"></span></a>
				<a href="javascript:void(0);" 
		            data-network="sharethis" 
		            data-url="<?php echo esc_url($url);?>" 
		            data-short-url="<?php echo esc_url($url);?>" 
		            data-title="<?php echo esc_attr($title);?>" 
		            data-image="<?php echo esc_url($image); ?>" 
		            data-description="<?php echo get_the_excerpt(); ?>" 
		            data-username="" 
		            data-message="<?php echo bloginfo(); ?>" 
		            class="st-custom-button hint--bounce hint--top" data-hint="<?php echo esc_attr($args['title_share_more']);?>"><span class="fa fa-share-alt"></span></a>
	        </span>
	    </div>
		<?php
	}
}
/**
 * Single Product
 * Rename product data tabs
 * @source https://docs.woocommerce.com/document/editing-product-data-tabs/
 *
 * add_filter('woocommerce_product_additional_information_tab_title', function(){return esc_html__('Additional infos','melokids');});
 * $tabs['description']['title'] = __( 'More Information' );		// Rename the description tab
 * $tabs['reviews']['title'] = __( 'Ratings' );				// Rename the reviews tab
 *
*/
if(!function_exists('melokids_woocommerce_rename_tabs')){
	add_filter( 'woocommerce_product_tabs', 'melokids_woocommerce_rename_tabs', 98 );
	function melokids_woocommerce_rename_tabs( $tabs ) {
		$tabs['additional_information']['title'] = esc_html__( 'Additional infos','melokids' );	// Rename the additional information tab
		return $tabs;
	}
}
/* Remove title in tab content */
add_filter('woocommerce_product_description_heading', function(){ return false;});
add_filter('woocommerce_product_additional_information_heading', function(){ return false;});

/**
 * Single Product 
 * 
 * Remove tab if no content
 * 
*/
if(!function_exists('melokids_remove_single_product_data_tabs_item')){
	add_filter('woocommerce_product_tabs','melokids_remove_single_product_data_tabs_item',98);
	function melokids_remove_single_product_data_tabs_item($tabs){
		global $product;
		if ( $product && ( !$product->has_attributes() || !apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
			unset( $tabs['additional_information'] );
		}
		return $tabs;
	}
}

/**
 * Single Product 
 *
 * Comment Avatar size
 *
*/
if ( ! function_exists( 'woocommerce_review_display_gravatar' ) ) {
	/**
	 * Display the review authors gravatar
	 *
	 * @param array $comment WP_Comment.
	 * @return void
	 */
	function woocommerce_review_display_gravatar( $comment ) {
		echo '<div class="comment-avatar col-auto">'.get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '90' ), '' ,'', array('class' => 'img-circle')).'</div>';
	}
}

/**
 * Single Product 
 *
 * Comment Rating
 * Move rating to below comment author
 *
*/
remove_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10);
add_action('woocommerce_review_meta', 'woocommerce_review_display_rating', 11);

/**
 * Single Product 
 *
 * Comment Author
 *
*/
if(!function_exists('melokids_woocommerce_review_author')){
	remove_action('woocommerce_review_meta','woocommerce_review_display_meta', 10);
	add_action('woocommerce_review_meta','melokids_woocommerce_review_author');
	function melokids_woocommerce_review_author(){
		global $comment;
		$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

		if ( '0' === $comment->comment_approved ) { ?>

			<div class="waiting">
				<em class="woocommerce-review__awaiting-approval">
					<?php esc_html_e( 'Your review is awaiting approval', 'melokids' ); ?>
				</em>
			</div>

		<?php } else { ?>
			<h5 class="comment-name"><?php comment_author(); ?> </h5>
			<?php
			if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
				echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'melokids' ) . ')</em> ';
			}

			?>
		<?php
		}
	}
}
/**
 * Single Product 
 *
 * Comment Text
 *
*/
if(!function_exists('melokids_woocommerce_review_comment_text')){
	remove_action('woocommerce_review_comment_text','woocommerce_review_display_comment_text',10);
	add_action('woocommerce_review_comment_text','melokids_woocommerce_review_comment_text',10);
	function melokids_woocommerce_review_comment_text(){
		?>
		<div class="comment-content">
            <?php comment_text(); ?>
        </div>
		<?php
	}
}
/**
 * Single Product 
 *
 * Comment Time
 *
*/
if(!function_exists('melokids_woocommerce_review_time')){
	add_action('woocommerce_review_after_comment_text', 'melokids_woocommerce_review_time', 10);
	function melokids_woocommerce_review_time(){
		global $comment;
		?><div class="comment-actions">
			<time datetime="<?php comment_time( 'c' ); ?>"><?php
                    /* translators: 1: comment date, 2: comment time */
                    printf( esc_html__( '%1$s at %2$s' , 'melokids'), get_comment_date( '', $comment ), get_comment_time() );
            ?></time></div>
		<?php
	}
}

/**
 * Single Product
 *
 * Comment Field
 *
*/
if(!function_exists('melokids_woocommerce_product_review_comment_form_args')){
	add_filter('woocommerce_product_review_comment_form_args','melokids_woocommerce_product_review_comment_form_args', 10, 1);
	function melokids_woocommerce_product_review_comment_form_args($comment_form){
		$commenter     = wp_get_current_commenter();
        $user          = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html_req = ( $req ? " required='required'" : '' );

        $name_placeholder = $req ? esc_html__('Your Name *','melokids') : esc_html__('Name','melokids');
        $mail_placeholder = $req ? esc_html__('Your Email *','melokids') : esc_html__('Email','melokids');

        $col_open  = '<div class="comment-field col-12 col-lg-4">';
        $col_close = '</div>';

        $rating = '';
        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$rating = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'melokids' ) . '</label><select name="rating" id="rating" aria-required="true" required>
				<option value="">' . esc_html__( 'Rate&hellip;', 'melokids' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'melokids' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'melokids' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'melokids' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'melokids' ) . '</option>
				<option value="1">' . esc_html__( 'Very poor', 'melokids' ) . '</option>
			</select></div>';
		}

        $fields = array(
        	'rating' => $rating,
            'open'   => '<div class="row cmt-fields">',
            'author' => $col_open.'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" placeholder ="'.esc_attr($name_placeholder).'" ' . $aria_req . ' />'.$col_close,
            'email'  => $col_open.'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" placeholder ="'.esc_attr($mail_placeholder).'" ' . $aria_req . ' />'.$col_close,
            'url'    => $col_open.'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '" placeholder="'.esc_attr__('Your website','melokids').'"/>'.$col_close,
            'close'  => '</div>',
            'empty' => ''
        );

        $comment_form['title_reply'] = have_comments() ? esc_html__( 'Leave your thoughts here', 'melokids' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'melokids' ), get_the_title() );
        $comment_form['label_submit']  = esc_html__( 'Submit Now', 'melokids' );

		$comment_form['fields'] = $fields;

		$comment_form['comment_field'] = '<div class="cmt-fields-text"><textarea placeholder="'.esc_attr__( 'Your Review *', 'melokids' ).'" id="comment" name="comment" maxlength="65525" aria-required="true" required="required"></textarea></div>';

		return $comment_form;
	}
}

/**
 * Single Product
 *
 * Change number of related products output
*/
if(!function_exists('melokids_related_products_args')){
	
	add_filter( 'woocommerce_output_related_products_args', 'melokids_related_products_args' );
  	function melokids_related_products_args( $args ) {
  		$show_related = melokids_get_opts('single_product_related', '1');
  		if(class_exists('EF4Framework')){
  			if($show_related === '1')
  				$limit = melokids_get_opts('single_product_related_item', '12');
  			else 
  				$limit = '0';
  		} else {
  			$limit = '4';
  		}
		$args['posts_per_page'] = $limit; // number related products
		//$args['columns'] = 2; // arranged in 2 columns
		return $args;
	}
	if(!function_exists('melokids_related_products_scripts')){
	    add_action('wp_enqueue_scripts', 'melokids_related_products_scripts');
	    function melokids_related_products_scripts(){
	        if(class_exists('VC_Manager')){
				wp_enqueue_script('vc_pageable_owl-carousel');
				wp_enqueue_style( 'vc_pageable_owl-carousel-css');
				wp_enqueue_script('zk-owlcarousel');
			}
	    }
	}
}


/**
 * Single Product Message
 *
 * Added to cart message 
*/
if(!function_exists('melokids_wc_add_to_cart_message_html')){
	add_filter('wc_add_to_cart_message_html','melokids_wc_add_to_cart_message_html', 10, 3);
	function melokids_wc_add_to_cart_message_html($message, $products, $show_qty){
		$titles = array();
		$count  = 0;

		if ( ! is_array( $products ) ) {
			$products = array( $products => 1 );
			$show_qty = false;
		}

		if ( ! $show_qty ) {
			$products = array_fill_keys( array_keys( $products ), 1 );
		}

		foreach ( $products as $product_id => $qty ) {
			/* translators: %s: product name */
			$titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'melokids' ), strip_tags( get_the_title( $product_id ) ) ), $product_id );
			$count   += $qty;
		}

		$titles = array_filter( $titles );
		/* translators: %s: product name */
		$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'melokids' ), wc_format_list_of_items( $titles ) );
		// Output success messages.
		if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
			$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
			$message   = sprintf( '<span class="text">%s</span> <a href="%s" tabindex="1" class="button wc-forward msg-viewcart">%s</a>',esc_html( $added_text ), esc_url( $return_to ), esc_html__( 'Continue shopping', 'melokids' ));
		} else {
			$message = sprintf( '<span class="text">%s</span> <a href="%s" tabindex="1" class="button wc-forward msg-viewcart">%s</a>',esc_html( $added_text ), esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View cart', 'melokids' ));
		}

		return $message;
	}
}