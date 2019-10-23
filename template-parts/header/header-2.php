<?php
/**
 * Header 2
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 */
$align = melokids_get_opts('header_justify_content','center');
?>

<div class="row align-items-center justify-content-between justify-content-xl-<?php echo esc_attr($align);?>"><?php 
    melokids_header_navigation_left(['class' => 'col-auto']);
    melokids_logo(['class' => 'col-auto']);
?><div class="zk-navigation-right col-auto"><div class="row align-items-center"><?php
    melokids_header_navigation_right(['class' => 'col-auto']);
    melokids_header_atts(['class' => 'col-auto']);
?></div></div></div>
<div id="zk-navigation" class="join-menu col-12"><div class="zk-main-navigation"></div></div>



