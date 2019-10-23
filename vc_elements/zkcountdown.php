<?php
vc_map(array(
    'name'        => 'MeloKids CountDown',
    'base'        => 'zkcountdown',
    'icon'        => 'zkel-icon-countdown',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Choose your time remaining', 'melokids'),
    'params'      => array(
        array(
            'type'        => 'ef4_datetime', 
            'param_name'  => 'time',
            'value'       => '',
            'heading'     => esc_html__( 'Target Time For Countdown', 'melokids' ),
            'description' => esc_html__( 'Choose your time remaining. Date and time format (yyyy/mm/dd hh:mm:ss). Default will is next : 2 week 0 days 8 hours 32 minutes 50 seconds', 'melokids' ),
            'holder'      => 'div',
            'dependency'    => array(
                'callback'   => 'ef4_active_datetime_picker',
            ),
        ),
        array(
            'type'        => 'textfield',
            'param_name'  => 'time_label',
            'value'       => 'Years, Month, Week, Days, Hours, Mins, Secs',
            'heading'     => esc_html__( 'Lable Time For Countdown', 'melokids' ),
            'description' => esc_html__( 'Enter your time for label. Separated by Comma \',\'! IMPORTANT: You need fill all label value for: Year, Month, Week, Day, Hour, Minute, Second', 'melokids' ),
            'admin_label' => true,
        ),
        array(
            'type'        => 'dropdown',
            'param_name'  => 'time_format',
            'value'       => array(
                'Years, Month, Week, Days, Hours, Minute, Second' => '1',
                'Month, Week, Days, Hours, Minute, Second'        => '2',
                'Month, Days, Hours, Minute, Second'              => '3',
                'Week, Days, Hours, Minute, Second'               => '4',
                'Days, Hours, Minute, Second'                     => '5',
                'Hours, Minute, Second'                           => '6',
            ),
            'std'         => '4',
            'heading'     => esc_html__( 'Format Time For Countdown', 'melokids' ),
            'description' => esc_html__( 'Choose time format you want!', 'melokids' ),
        ),
        array(
            'type'        => 'dropdown',
            'param_name'  => 'color_mode',
            'heading'     => esc_html__( 'Color Mode', 'melokids' ),
            'description' => esc_html__( 'Choose color mode.', 'melokids' ),
            'group'       => 'Designs',
            'value'       => array(
                esc_html__( 'Default', 'melokids' ) => '',
            ),
            'std' => ''
        ),
    )
));

class WPBakeryShortCode_zkcountdown extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}