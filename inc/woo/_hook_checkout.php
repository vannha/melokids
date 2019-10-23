<?php
/**
 * Check out page 
 * Remove form label, 
 * Add form label as placeholder
*/
/**
 * Remove field label
 * use filter: woocommerce_form_field_args
 * 
 */
if(!function_exists('melokids_woocommerce_form_field_args')){
	add_filter( 'woocommerce_form_field_args' , 'melokids_woocommerce_form_field_args' );
	function melokids_woocommerce_form_field_args($args) {
	    $args['label'] = false;
	    return $args;
	}
}
/**
 * Add placeholder text
 * Our hooked in function - $fields is passed via the filter!
 * use filter: woocommerce_checkout_fields
 * 
 */

if(!function_exists('melokids_woocommerce_checkout_fields')){
	add_filter( 'woocommerce_checkout_fields' , 'melokids_woocommerce_checkout_fields' );
	function melokids_woocommerce_checkout_fields($fields) {

		// Billing
		$fields['billing']['billing_first_name']['placeholder'] = esc_html__('First Name *', 'melokids');
		$fields['billing']['billing_last_name']['placeholder']  = esc_html__('Last Name *', 'melokids');
		$fields['billing']['billing_company']['placeholder']    = esc_html__('Company Name', 'melokids');
		$fields['billing']['billing_email']['placeholder']      = esc_html__('Email Address *', 'melokids');
		$fields['billing']['billing_phone']['placeholder']      = esc_html__('Phone *', 'melokids');
		$fields['billing']['billing_city']['placeholder']       = esc_html__('Town / City *', 'melokids');
		$fields['billing']['billing_postcode']['placeholder']   = esc_html__('Postcode/ Zip *', 'melokids');
		$fields['billing']['billing_state']['placeholder']      = esc_html__('State/ Country *', 'melokids');
		$fields['billing']['billing_country']['placeholder']    = esc_html__('Country *', 'melokids');
		$fields['billing']['billing_address_1']['placeholder']  = esc_html__('Street address *', 'melokids');

	    // Shipping
		$fields['shipping']['shipping_first_name']['placeholder'] = esc_html__('First Name *', 'melokids');
		$fields['shipping']['shipping_last_name']['placeholder']  = esc_html__('Last Name *', 'melokids');
		$fields['shipping']['shipping_company']['placeholder']    = esc_html__('Company Name', 'melokids');
		$fields['shipping']['shipping_city']['placeholder']       = esc_html__('Town / City *', 'melokids');
		$fields['shipping']['shipping_postcode']['placeholder']   = esc_html__('Postcode/ Zip *', 'melokids');
		$fields['shipping']['shipping_state']['placeholder']      = esc_html__('State/ Country *', 'melokids');
		$fields['shipping']['shipping_country']['placeholder']    = esc_html__('Country *', 'melokids');
		$fields['shipping']['shipping_address_1']['placeholder']  = esc_html__('Street address *', 'melokids');

	    // Account 
		
	    // Order
	    $fields['order']['order_comments']['placeholder'] = esc_html__('Order Notes', 'melokids');

	    /* Custom class State / Postcode billing fields */
	    $fields['billing']['billing_state']['class'] = array('form-row-first');
	    $fields['billing']['billing_postcode']['class'] = array('form-row-last');
	    $fields['billing']['billing_email']['class'] = array('form-row-first');
	    $fields['billing']['billing_phone']['class'] = array('form-row-last');

	    /* Custom class State / Postcode billing fields */
	    $fields['shipping']['shipping_state']['class'] = array('form-row-first');
	    $fields['shipping']['shipping_postcode']['class'] = array('form-row-last');

	    /* Add Email/ Phone on Shipping fields*/
	    $fields['shipping']['shipping_email'] = array(
	        'label'       => esc_html__('Email Address', 'melokids'),
	        'placeholder' => _x('Email Address *', 'placeholder', 'melokids'),
	        'required'    => true,
	        'class'       => array('form-row-first'),
	    );
	    $fields['shipping']['shipping_phone'] = array(
	        'label'       => esc_html__('Phone', 'melokids'),
	        'placeholder' => _x('Phone *', 'placeholder', 'melokids'),
	        'required'    => true,
	        'class'       => array('form-row-last'),
	    );

	    return $fields;
	}
}
/**
 * Reordering Checkout form field 
*/
add_filter("woocommerce_default_address_fields", "melokids_woocommerce_default_address_fields");
if(!function_exists('melokids_woocommerce_default_address_fields')){
	function melokids_woocommerce_default_address_fields($fields)
	{
	    $fields['country']['priority'] = 1;
	    $fields['first_name']['placeholder'] = esc_html__('First Name *', 'melokids');
	    $fields['last_name']['placeholder'] = esc_html__('Last Name *', 'melokids');
	    $fields['company']['placeholder'] = esc_html__('Company Name', 'melokids');
	    return $fields;
	}
}