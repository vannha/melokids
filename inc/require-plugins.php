<?php
add_action( 'tgmpa_register', 'melokids_required_plugins' );
function melokids_required_plugins() {
    $plugins = array(
        array(
            'name'               => esc_html__('EF4 Framework','melokids'),
            'slug'               => 'ef4-framework',
            'source'             => 'EF4-Framework.zip',
            'required'           => true,
        ),
       /* array(
            'name'               => esc_html__('SWA Import/Export','melokids'),
            'slug'               => 'swa-import-export',
            'source'             => 'swa-import-export.zip',
            'required'           => true,
        ),*/
        array(
            'name'               => esc_html__('EF5 Import/Export','melokids'),
            'slug'               => 'ef5-import-export',
            'source'             => 'ef5-import-export.zip',
            'required'           => true,
        ),
        array(
            'name'               => esc_html__('Visual Composer','melokids'),
            'slug'               => 'js_composer',
            'source'             => 'js_composer.zip',
            'required'           => true,
        ),
        array(
            'name'               => esc_html__('Revolution Slider','melokids'),
            'slug'               => 'revslider',
            'source'             => 'revslider.zip',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('Contact Form 7','melokids'),
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('NewsLetter','melokids'),
            'slug'               => 'newsletter',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('WooCommerce','melokids'),
            'slug'               => 'woocommerce',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('WPC Smart Wishlist for WooCommerce','melokids'),
            'slug'               => 'woo-smart-wishlist',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('WPC Smart Compare for WooCommerce','melokids'),
            'slug'               => 'woo-smart-compare',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__('WPC Smart Quick View for WooCommerce','melokids'),
            'slug'               => 'woo-smart-quick-view',
            'required'           => false,
        )
    );
    $config = array(
        'default_path' => 'http://zooka.io/plugins/'
    );

    tgmpa( $plugins, $config );

}