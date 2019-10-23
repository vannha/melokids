<?php
/* Custom Widget */
melokids_require_folder('inc/widgets',get_template_directory());


if(class_exists('EF4Framework')){
	/* Call SCSS */
	melokids_require_folder('inc/dynamic',get_template_directory());

	/* Mega Menu */
	if(!function_exists('melokids_enable_megamenu')){
		add_filter('cms_enable_megamenu', 'melokids_enable_megamenu');
		function melokids_enable_megamenu(){
			$enable_mega_menu = melokids_get_opts('enable_mega_menu','0');
			if('1' === $enable_mega_menu)
				return true;
			else 
				return false;
		}
	}
	/* Custom Post Type */
	melokids_require_folder('inc/custom-post',get_template_directory());

	/* Custom VC */
	melokids_require_folder('vc_customs',get_template_directory());

	/**
	 * Add new elements for VC
	*/
	add_action('vc_before_init', 'melokids_vc_elements');
	function melokids_vc_elements()
	{
	    melokids_require_folder('vc_elements', get_template_directory());
	}
}