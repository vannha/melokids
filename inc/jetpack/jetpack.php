<?php
if(!class_exists('Jetpack')) return;
if ( function_exists( 'remove_ef4_filter' ) && function_exists( 'sharing_display' ) ) {
	remove_ef4_filter( 'the_content', 'sharing_display', 19 );
	remove_ef4_filter( 'the_excerpt', 'sharing_display', 19 );
}