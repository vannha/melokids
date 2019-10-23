<?php
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
?>
<div class="zk-business-time">
	<?php 
		$html = $output = '';
		ob_start();
		for ($i=2; $i <= 8; $i++) { 
			$week_day{$i} = $atts['week_day'.$i];
			$open_hour{$i} = $atts['open_hour'.$i];
			$close_hour{$i} = $atts['close_hour'.$i];

	        if(!empty($week_day{$i})){
	        	$html = '<div class="col weekday">'.esc_html($week_day{$i}).'</div>';
	        	if(!empty($open_hour{$i}) && !empty($close_hour{$i}))
	        		$html .= '<div class="col time">'.esc_html($open_hour{$i}).' - '.esc_html($close_hour{$i}).'</div>';
	        	else 
	        		$html .= '<div class="col closed required">'.esc_html__('Closed','melokids').'</div>';
	        } else {
	        	$html = '';
	        }
	        echo '<div class="row">'.wp_kses_post($html).'</div>';
    	}
    	$output = ob_get_clean();
	?>
	<div class="zk-business-msg">
		<span class="far fa-smile"></span> <span class="msg"><?php esc_html_e('We\'re Closed','melokids' );?></span> <a href="#<?php echo esc_attr($atts['el_id']);?>" class="mfp-inline"><?php esc_html_e('( See best time to call )','melokids'); ?></a>
	</div>
	<div id="<?php echo esc_attr($atts['el_id']);?>" class="mfp-hide zk-business-time zk-business-time-popup text-<?php echo melokids_align();?>">
		<?php echo wp_kses_post($output) ?>
	</div>
</div>