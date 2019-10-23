<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    $atts['layout_type'] = 'carousel';
    extract( $atts );
    global $wp_query;
	$query_args = [
		'post_type'     => 'product',
		'posts_per_page' => $limit,
		'order'         => $order,
		'orderby'       => $orderby,
		'tax_query'		=> array()
	];
	switch ($product_show) {
		case 'featured':
			$query_args['tax_query'] = array_merge( $query_args['tax_query'], WC()->query->get_tax_query() );
			$query_args['tax_query'][] = array(
				'taxonomy'         => 'product_visibility',
				'terms'            => 'featured',
				'field'            => 'name',
				'operator'         => 'IN',
				'include_children' => false
			);
			break;
		case 'on_sale':
			$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			break;
		case 'best_selling':
			$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'top_rated':
			$query_args['meta_key']       = '_wc_average_rating';
			$query_args['orderby']        = 'meta_value_num';
			$query_args['meta_query']     = WC()->query->get_meta_query();
			break;
	}
	$zkposts = $wp_query = new WP_Query($query_args);
	$wrap_css_class = array('zk-products-wrap','zk-owl-wrap', $el_id);
	$i=1;
	$j=0;
	$item_class = array('zk-carousel-item');
	$count_product = wp_count_posts('product');
	$total_product = $count_product->publish;
	if($total_product <= $limit) $limit = $total_product;
?>
<div class="<?php echo trim(implode(' ', $wrap_css_class));?>">
	<?php melokids_owl_dots_top($layout_type, $nav_style, $dot_pos, $dot_style); ?>
	<div class="zk-carousel owl-carousel" id="<?php echo esc_attr($el_id);?>">
		<?php 
			while ($zkposts->have_posts()): 
	            $zkposts->the_post();
	            $j++;
                if($i > $number_row) $i=1;
                if($i==1): 
                ?>
                <div class="<?php echo join(' ',$item_class) ?>">
                <?php endif;
	        ?>
				<div class="zk-product-item overlay-wrap"><?php
					do_action( 'woocommerce_before_shop_loop_item' ); 
					do_action( 'woocommerce_before_shop_loop_item_title' );
					do_action( 'woocommerce_shop_loop_item_title' );
					do_action( 'woocommerce_after_shop_loop_item_title' );
					do_action( 'woocommerce_after_shop_loop_item' );
				?></div>
			<?php
				if( ($i == $number_row || $j == $limit) ) : ?>
                </div>
                <?php endif; 
                $i ++; 
	       	endwhile;
		?>
	</div>
	<?php 
        melokids_owl_preload($layout_type);
        melokids_owl_dots($layout_type, $dot_style, $dot_pos);
        melokids_owl_nav($layout_type, $nav_style, $nav_pos);
        melokids_owl_dots_in_nav($layout_type, $nav_style);
    ?>
</div>