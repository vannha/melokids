<?php
vc_map(
	array(
		'name' 			=> esc_html__('MeloKids Taxonomy', 'melokids'),
	    'base' 			=> 'zktaxonomy',
	    'icon'			=> 'icon-wpb-wp',
	    'category' 		=> esc_html__('MeloKids', 'melokids'),
	    'params' 		=> array_merge(
	    	array(
		    	array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__('Choose an Taxonomy','melokids'),
		            'param_name' 	=> 'taxonomy',
		            'value' 		=> melokids_get_taxonomy_for_vc(),
		            'std'			=> '',
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Separator','melokids'),
		            'param_name' 	=> 'separator',
		            'value' 		=> ', ',
		        )
			)
		)
	)
);
class WPBakeryShortCode_zktaxonomy extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		return parent::content($atts, $content);
	}
}