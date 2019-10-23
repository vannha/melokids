<?php
/**
 * Add new option avatar to admin
 * add_action('after_setup_theme', 'melokids_update_avatar');
 *
*/

function melokids_update_avatar(){
	$cms_avatar = get_template_directory_uri() . '/assets/images/avatar.png';
	if (get_option($cms_avatar, '') != $cms_avatar)
		update_option( 'avatar_default' , $cms_avatar );
}
 
// add a new default avatar to the list in WordPress admin
function melokids_default_avatar( $avatar_defaults ) {
	$cms_avatar = get_template_directory_uri() . '/assets/images/avatar.png';
	$avatar_defaults[$cms_avatar] = esc_html__('MeloKids Avatar','melokids');
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'melokids_default_avatar' );

/**
 * An example to use filter get_avatar
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/get_avatar
 *
*/
if(!function_exists('melokids_custom_avatar')){
	add_filter( 'get_avatar' , 'melokids_custom_avatar' , 1 , 6 );
	function melokids_custom_avatar($avatar, $id_or_email, $size, $default, $alt, $args) {
	    if ( is_object( $id_or_email )) {
			$alt = $id_or_email->comment_author;
		} elseif ( is_numeric( $id_or_email ) ) {
	        $id = (int) $id_or_email;
	        $user = get_user_by( 'id' , $id );
	        $alt = $user->user_nicename;
    	} else {
    		$user = get_user_by( 'email', $id_or_email );
    		if(!$user){
    			$alt = $id_or_email;
    		}else{
	        	$alt = $user->data->user_nicename;
    		}
    	}
		$url = $args['url'];
		$url2x = get_avatar_url( $id_or_email, array_merge( $args, array( 'size' => $args['size'] * 2 ) ) );
		$classes = trim(implode(' ', ['zk-avatar', 'zk-avatar-'.$size, $args['class']]));
		
		$avatar = "<img alt='{$alt}' src='{$url}' srcset='{$url2x}' class='{$classes}' height='{$size}' width='{$size}' {$args['extra_attr']} />";
	    return $avatar;
	}
}