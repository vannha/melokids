<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $shortcode_atts = array(
    	'ids="'.$product_id.'"',
    );
    $classes = ['zk-product','layout-'.$layout_template, $el_class];
    if($layout_template === '1') $classes[] = 'text-center';
    if($layout_template === '3') $classes[] = 'hoverbox-wrap text-center';

	$_product      = wc_get_product( $product_id );
	$regular_price = $_product->get_regular_price();
	$sale_price    = $_product->get_sale_price();
	$price         = $_product->get_price();
	$price_html    = $_product->get_price_html();
	global $post;

	$product_title = !empty($ctp_name) ? $ctp_name : get_the_title($product_id);
	$img_id = !empty($ctp_image) ? $ctp_image : get_post_thumbnail_id($product_id);
?>	
<div class="<?php echo trim(implode(' ', $classes));?>">
	<?php switch ($layout_template) {
		case '3':
	?>
		<a href="<?php the_permalink($product_id);?>">
			<?php
			    melokids_image_by_size([
					'id'    => $img_id,
					'size'  => '560x470',
					'class' => 'bg-scale'
			    ]);
			?>
		</a>
		<div class="hover-box static animated zoomIn" data-static-in="zoomOut" data-static-out="zoomIn">
			<div class="product-info on-static">
					<h5><a href="<?php the_permalink($product_id);?>"><?php echo apply_filters('melokids_title',$product_title); ?></a></h5>
					<?php 
					the_terms($product_id, 'melokids_product_brand','<div class="pterm"><span>'.esc_html__('by','melokids').'&nbsp;</span>',', ','</div>');
					$terms = get_the_terms($product_id, 'pa_brand');
			        $count = count($terms);
			        if(is_array($terms) && $count > 0) {
			        	echo '<div class="pterm">';       
			            foreach ( $terms as $term ) {
			            	the_terms($product_id, 'pa_brand','<div class="brand '.$term->slug.'"><span>'.esc_html__('by','melokids').'&nbsp;</span>',', ','</div>');
			            	$brand_logo = get_term_meta($term->term_id,'brand_logo',true);
			            	$brand_link = get_term_link($term->term_id,'pa_brand');
			            }	
			         	echo '</div>';
			        }
			?></div>
		</div>
		<div class="hover-box hover animated fadeOutUp" data-hover-in="fadeInUp" data-hover-out="fadeOutUp">
			<div class="on-hover">
				<div class="header">
					<?php 
						if(!empty($brand_logo)) echo '<a href="'.esc_url($brand_link).'"><img src="'.esc_url($brand_logo).'" alt="'.get_the_title($product_id).'" class="brand-logo" /></a>';
						melokids_entry_excerpt(['post' => $product_id,'length' => 10,'show_more' => false]);
					?>
				</div>
				<?php 

					switch ($btn_type) {
						case '2':
						?>
						<div class="product woocommerce add_to_cart_inline align-self-end">
							<a href="<?php the_permalink($product_id);?>" class="simple-link"><?php printf('%s %s',esc_html($btn_text), '<span class="fa fa-caret-'.esc_attr(is_rtl()?'left':'right').'"></span>'); ?></a>
						</div>
						<?php
							break;
						
						default:
							echo do_shortcode('[add_to_cart id="'.$product_id.'" style="" show_price="false" class="align-self-end"]');
							break;
					}
				?>
			</div>
		</div>
	<?php
			break;
		case '2':
	?>
		<a href="<?php the_permalink($product_id);?>">
			<?php
			    melokids_image_by_size([
					'id'    => $img_id,
					'size'  => '840x418',
					'class' => 'bg-scale'
			    ]);
			?>
		</a>
		<div class="product-info">
			<a href="<?php the_permalink($product_id);?>" class="overlay"></a>
			<div class="header">
				<h5><a href="<?php the_permalink($product_id);?>"><?php echo apply_filters('melokids_title',$product_title); ?></a></h5>
				<div class="p-price"><?php echo sprintf('%s',$price_html);?></div>
			</div>
			<?php 
			switch ($btn_type) {
				case '2':
				?>
				<div class="product woocommerce add_to_cart_inline align-self-end">
					<a href="<?php the_permalink($product_id);?>" class="simple-link"><?php printf('%s %s',esc_html($btn_text), '<span class="fa fa-caret-'.esc_attr(is_rtl()?'left':'right').'"></span>'); ?></a>
				</div>
				<?php
					break;
				
				default:
					echo do_shortcode('[add_to_cart id="'.$product_id.'" style="" show_price="false" class="align-self-end"]');
					break;
			}
			?>
		</div>
	<?php
			break;
		
		default:
	?>
		<a href="<?php the_permalink($product_id);?>">
			<?php
			    melokids_image_by_size([
					'id'    => $img_id,
					'size'  => '480x521',
					'class' => 'bg-scale'
			    ]);
			?>
		</a>
		<div class="product-info">
				<h5><a href="<?php the_permalink($product_id);?>"><?php echo apply_filters('melokids_title',$product_title); ?></a></h5>
				<?php 
				the_terms($product_id, 'melokids_product_brand','<div class="pterm"><span>'.esc_html__('by','melokids').'&nbsp;</span>',', ','</div>');
				$terms = get_the_terms($product_id, 'pa_brand');
		        $count = count($terms);
		        if(is_array($terms) && $count > 0) {
		        	echo '<div class="pterm">';       
		            foreach ( $terms as $term ) {
		            	the_terms($product_id, 'pa_brand','<div class="brand '.$term->slug.'"><span>'.esc_html__('by','melokids').'&nbsp;</span>',', ','</div>');
		            }
		         	echo '</div>';
		        }
		?></div>
	<?php 
		break;
	}
	?>
</div>
