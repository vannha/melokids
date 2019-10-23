<?php
    if(!class_exists('NewsletterWidget')) return;
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
?>
<div class="<?php echo trim(implode(' ', array('zk-newsletter',$layout_mode, $el_class, $layout_template)));?>">
    <?php switch ($layout_mode) {
    	case 'minimal':
    		the_widget(
                'NewsletterWidgetMinimal', 
                array(
                    'button'   => $btn_text,
                    'el_class' => $el_class
                ),
                array(
                    'before_widget' => '', 
                    'after_widget'  => ''
                )
            );
    		break;
    	default:
    		the_widget(
                'NewsletterWidget', 
                array(
                    'button'            => $btn_text,
                    'lists_layout'      => $lists_layout, 
                    'lists_empty_label' => $lists_empty_label, 
                    'lists_field_label' => $lists_field_label,
                    'el_class'          => $el_class
                ), 
                array(
                    'before_widget' => '', 
                    'after_widget'  => ''
                ) 
            );
    		break;
    } ?>
</div>