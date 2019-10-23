<?php
	/*! http://keith-wood.name/countdown.html
	 * Countdown for jQuery v2.1.0.
	 * Written by Keith Wood (wood.keith{at}optusnet.com.au) January 2008.
	 * Available under the MIT (http://keith-wood.name/licence.html) license. 
	*/
    wp_enqueue_script('zk-countdown', get_template_directory_uri() . '/assets/js/jquery-countdown.min.js', array( 'jquery' ), '2.1.0', true);

	extract(shortcode_atts(array(
		'time'       =>'',
		'time_label' => 'Years, Month, Week, Days, Hours, Mins, Secs',
		'time_format'=> '4',
		'color_mode' => ''
	), $atts));
	$time = strtotime($time);
	$date_sever = date_i18n('Y-m-d G:i:s');   
	$gmt_offset = get_option( 'gmt_offset' );
	/* check if current time from config is older than current time */
	if(empty($time) && (strtotime($time) < strtotime('now'))) $time = strtotime("+2 week 0 days 8 hours 32 minutes 50 seconds");
?>
	<div class="zk-countdown">
		<div class="zk-countdown-bar zk-countdown-time <?php echo esc_attr($color_mode); ?>" data-count="<?php echo esc_attr(date('Y,m,d,H,i,s', $time)); ?>" data-format="<?php echo esc_attr($time_format);?>" data-label="<?php echo esc_attr($time_label);?>" data-timezone="<?php echo esc_attr($gmt_offset); ?>"></div>
    </div>

         


