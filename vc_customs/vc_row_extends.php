<?php
if (!class_exists('VC_Manager') || !class_exists('EF4Framework')) return;

$vertical_align = array(
    esc_html__('Top','melokids')    => 'start',
    esc_html__('Middle','melokids') => 'center',
    esc_html__('Bottom','melokids') => 'end',
);
$screen = array(
    esc_html__('Large (992)','melokids')        => 'lg',
    esc_html__('Extra Large (1200)','melokids') => 'xl',
);
vc_add_params('vc_row', array(
    array(
        'type'        => 'checkbox',
        'param_name'  => 'row_full_image_left',
        'value'       => array(
            esc_html__('Add image on left', 'melokids')       => 'true',
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
		'type'       => 'attach_image',
		'param_name' => 'row_full_image_left_img',
		'heading'    => esc_html__('Choose an image','melokids'),
		'dependency' => array(
            'element' => 'row_full_image_left',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'       => 'dropdown',
        'param_name' => 'row_full_image_left_img_align',
        'heading'    => esc_html__('Vertical Align','melokids'),
        'value'      => $vertical_align,
        'std'        => 'center',
        'dependency' => array(
            'element' => 'row_full_image_left',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'       => 'dropdown',
        'param_name' => 'row_full_image_left_img_screen',
        'heading'    => esc_html__('Apply on Screen','melokids'),
        'value'      => $screen,
        'std'        => 'xl',
        'dependency' => array(
            'element' => 'row_full_image_left',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'checkbox',
        'param_name'  => 'row_full_image_right',
        'value'       => array(
            esc_html__('Add image on right', 'melokids')      => 'true',
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
		'type'       => 'attach_image',
		'param_name' => 'row_full_image_right_img',
		'heading'    => esc_html__('Choose an image','melokids'),
		'dependency' => array(
            'element' => 'row_full_image_right',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'       => 'dropdown',
        'param_name' => 'row_full_image_right_img_align',
        'heading'    => esc_html__('Vertical Align','melokids'),
        'value'      => $vertical_align,
        'std'        => 'center',
        'dependency' => array(
            'element' => 'row_full_image_right',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'       => 'dropdown',
        'param_name' => 'row_full_image_right_img_screen',
        'heading'    => esc_html__('Apply on Screen','melokids'),
        'value'      => $screen,
        'std'        => 'xl',
        'dependency' => array(
            'element' => 'row_full_image_left',
            'value'   => 'true'
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
));