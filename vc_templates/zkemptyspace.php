<?php 
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $html_id = 'zk-empty-space-'.uniqid(true);
    $values = (array) vc_param_group_parse_atts( $atts['values'] );
    $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
    $class = $css_class = $zk_empty_space_css = '';
    foreach($values as $value){
        $screen_size = $value['screen_size'];
        $screen_size_height = $value['height'];
        if(isset($screen_size) && !empty($screen_size)){
            /* allowed metrics: http://www.w3schools.com/cssref/css_units.asp */
            /* get screen size width */
            $regexr_screen_size_width = preg_match( $pattern, $screen_size, $matches );
            $value_screen_size_width  = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'zk_empty_space', $screen_size );
            $unit_screen_size_width   = isset( $matches[2] ) ? $matches[2] : 'px';
            $screen_size_width        = $value_screen_size_width . $unit_screen_size_width;
            /* get space height on screen size */
            $regexr_screen_size_height = preg_match( $pattern, $screen_size_height, $matches );
            $value_screen_size_height  = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'zk_empty_space', $screen_size_height );
            $unit_screen_size_height   = isset( $matches[2] ) ? $matches[2] : 'px';
            $height_screen_size = $value_screen_size_height . $unit_screen_size_height;

            $class = 'w-'.$screen_size;
            $css_class .= 'w-'.$screen_size.' ';
            $height_screen_size_css = '#'.$html_id ;
            $zk_empty_space_css .= ' @media (max-width: '.$screen_size_width.'){'.$height_screen_size_css.' {height:'.$height_screen_size.';}}';
        }
    }
    ?>
<div id="<?php echo esc_attr($html_id);?>" class="<?php echo trim(esc_attr('zk-custom-css '.$css_class));?>" data-css="<?php echo trim($zk_empty_space_css);?>"></div>