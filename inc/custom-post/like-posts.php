<?php
class MeloKids_Like_Post {
	 function __construct()   {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_like-post', array($this, 'ajax'));
		add_action('wp_ajax_nopriv_like-post', array($this, 'ajax'));
	}

	function enqueue_scripts() {
		wp_register_script( 'melokids-likepost', get_template_directory_uri() . '/inc/custom-post/like-posts.js', 'jquery', '1.0', TRUE );
		global $post;
		wp_localize_script('melokids-likepost', 'MeloKids_Like_Post', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'postID' => $post ? $post->ID : 0,
			'rooturl' => home_url('/')
		));
		wp_enqueue_script('melokids-likepost');
	}

	function ajax($post_id) {
		//update
		if( isset($_POST['loves_id']) ) {
			$post_id = str_replace('like-post-', '', $_POST['loves_id']);
			echo ''.$this->love_post($post_id, 'update');
		}
		//get
		else {
			$post_id = str_replace('like-post-', '', $_POST['loves_id']);
			echo ''.$this->love_post($post_id, 'get');
		}
		exit;
	}

	function love_post($post_id, $action = 'get')
	{
		if(!is_numeric($post_id)) return;
		$love_count = (int)get_post_meta($post_id, '_like_post', true);
		switch($action) {

			case 'get':
				if( !$love_count ){
					$love_count = 0;
					add_post_meta($post_id, '_like_post', $love_count, true);
				}
				return $love_count;
				break;

			case 'update':
				
				if( isset($_COOKIE['like'. $post_id]) ) return $love_count;
				$love_count++;				
				update_post_meta($post_id, '_like_post', $love_count);
				setcookie('like_post_'. $post_id, $post_id, time()*5, '/');

				return  $love_count ;
				break;

		}
	}

	function add_love($args = []) {

        $args = wp_parse_args($args, [
            'title'       => esc_html__('Like this?', 'melokids'),
            'title_liked' => esc_html__('You already liked this!', 'melokids'),
            'show_text'   => true, 
            'show_icon'   => true,
            'text'        => esc_html__('Like','melokids'),
            'texts'       => esc_html__('Likes','melokids'),
            'text_liked'  => esc_html__('Liked!','melokids'),
            'icon'        => '<span class="meta-icon fa fa-heart-o"></span>',
            'icon_liked'  => '<span class="meta-icon fa fa-heart"></span>'
        ]);

		global $post;

		$output = $this->love_post($post->ID);

  		$class = 'like-post';
        $icon = '';
        if($args['show_icon']) $icon = $args['icon'];
  		$title = $args['title'];
  		
  		$love_count = (int)get_post_meta($post->ID, '_like_post', true);
  		if($love_count > 1){
  			$text = $args['texts'];
  		} else {
  			$text = $args['text'];
  		}
		if( isset($_COOKIE['like_post_'. $post->ID]) ){
			$class = 'like-post liked unselected';
			if($args['show_icon']) $icon  = $args['icon_liked'];
			$title = $args['title_liked'];
			if($args['show_text']) $text = $args['text_liked'];
		}

		return '<a href="javascript:void(0)" class="'. esc_attr($class) .'" id="like-post-'. esc_attr($post->ID) .'" title="'. esc_attr($title) .'" data-title-liked="'.esc_attr($args['title_liked']).'" data-like-icon="'.esc_attr($args['icon']).'" data-liked-icon="'.esc_attr($args['icon_liked']).'"><span class="icon-like">'.$icon.'</span><span class="like-post-count">' . esc_html($output) .'</span> '.esc_html($text).'</a>';
	}

}
global $melokids_like_post;
$melokids_like_post = new MeloKids_Like_Post();

function melokids_like_post($args = [], $return = false) {
    $args = wp_parse_args($args, [
        'before'      => '',
        'after'       => '',
        'title'       => esc_html__('Like this?', 'melokids'),
        'title_liked' => esc_html__('You already liked this!', 'melokids'),
        'show_text'   => true, 
        'show_icon'   => true,
        'text'        => esc_html__('Like','melokids'),
        'texts'       => esc_html__('Likes','melokids'),
        'text_liked'  => esc_html__('Liked!','melokids'),
        'icon'        => '<span class="meta-icon fa fa-heart-o"></span>',
        'icon_liked'  => '<span class="meta-icon fa fa-heart"></span>'
    ]);
	global $melokids_like_post;
	if($return) {
		return $args['before'].$melokids_like_post->add_love(['icon' => $args['icon'],'icon_liked' => $args['icon_liked'] ]).$args['after'];
	} else {
		echo '' . $args['before'] . $melokids_like_post->add_love(['icon' => $args['icon'],'icon_liked' => $args['icon_liked'] ]).$args['after'];
	}
}

/** ===== CUSTOM POST META =====**/
/**
 * Add Post view count
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
function melokids_set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function melokids_track_post_views($post_id)
{
    if (!is_single()) return;
    if (empty ($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    melokids_set_post_views($post_id);
}
add_action('wp_head', 'melokids_track_post_views');

function melokids_get_post_views($args = [])
{
    $args = wp_parse_args($args, [
        'before'        => '',
        'after'         => '',
        'show_text'     => true,
        'text'          => esc_html__('Views','melokids'),
        'show_icon'     => true,
        'icon'          => '<span class="meta-icon fa fa-eye"></span>',
        'echo'          => true
    ]);

    global $post;
    $postID = $post->ID;
    $count_key = 'post_views_count';
    $count = convert_unit_number(get_post_meta($postID, $count_key, true));
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    $html = '';
    if($args['show_icon'])
        $html .=  $args['icon'];

    $html .= $count.' ';

    if($args['show_text'])
        $html .= $args['text'];
    
    if($args['echo'])
        echo wp_kses_post($args['before'].$html.$args['after']);
    else
        return $args['before'].$html.$args['after'];
}

function convert_unit_number($number)
{
    if (!is_numeric($number))
        return '0';
    $units = array(
        '1000'    => array(
            'add'      => 'K',
            'decimals' => 1,
        ),
        '1000000' => array(
            'add'      => 'M',
            'decimals' => 2
        )
    );
    $result = $number;
    foreach ($units as $unit => $option) {
        if ($number < $unit)
            break;
        $decimals_val = pow(10, $option['decimals']);
        $number_use = intval(($number / $unit) * $decimals_val);
        $result = $number_use / $decimals_val;
        $result .= $option['add'];
    }
    return $result;
}
?>
