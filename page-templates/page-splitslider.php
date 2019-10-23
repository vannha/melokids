<?php
/**
 * Template Name: SplitSlider
 *
 * This is the template that displays page content with VC.
 *
 * @package Biger
 * @subpackage Biger
 * @author Biger
 * @since 1.0.0
*/
/* MultiScroll */
if(!function_exists('biger_multiscroll')){
    function biger_multiscroll(){
        wp_enqueue_script('multiscroll', get_template_directory_uri() . '/assets/libs/multiscroll/jquery.multiscroll.js', array('jquery'), '0.2.2', true);
        wp_enqueue_script('easings', get_template_directory_uri() . '/assets/libs/multiscroll/jquery.easings.min.js', array('jquery'), '1.9.2', true);
        wp_enqueue_script('biger-multiscroll', get_template_directory_uri() . '/assets/libs/multiscroll/biger.multiscroll.js', array('multiscroll'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'biger_multiscroll');
get_header();
?>
<div class="col-12">
<?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
?>
</div>
<?php
get_footer();