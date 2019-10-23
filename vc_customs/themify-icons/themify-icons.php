<?php 
/**
 * Themify Icon from https://themify.me/themify-icons
 *
 * @param $icons - taken from filter - vc_map param field settings['source'] provided icons (default empty array).
 * If array categorized it will auto-enable category dropdown
 *
 * @since 1.0
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
add_filter( 'vc_iconpicker-type-themify', 'vc_iconpicker_type_themify' );

function vc_iconpicker_type_themify( $icons ) {

	$themify_icons = array(
		array( 'ti-arrow-up' => esc_html__( 'arrow-up', 'melokids' ) ),
		array( 'ti-arrow-right' => esc_html__( 'arrow-right', 'melokids' ) ),
		array( 'ti-arrow-left' => esc_html__( 'arrow-left', 'melokids' ) ),
		array( 'ti-arrow-down' => esc_html__( 'arrow-down', 'melokids' ) ),
		array( 'ti-arrows-vertical' => esc_html__( 'arrows-vertical', 'melokids' ) ),
		array( 'ti-arrows-horizontal' => esc_html__( 'arrows-horizontal', 'melokids' ) ),
		array( 'ti-angle-up' => esc_html__( 'angle-up', 'melokids' ) ),
		array( 'ti-angle-right' => esc_html__( 'angle-right', 'melokids' ) ),
		array( 'ti-angle-left' => esc_html__( 'angle-left', 'melokids' ) ),
		array( 'ti-angle-down' => esc_html__( 'angle-down', 'melokids' ) ),	
		array( 'ti-angle-double-up' => esc_html__( 'angle-double-up', 'melokids' ) ),
		array( 'ti-angle-double-right' => esc_html__( 'angle-double-right', 'melokids' ) ),
		array( 'ti-angle-double-left' => esc_html__( 'angle-double-left', 'melokids' ) ),
		array( 'ti-angle-double-down' => esc_html__( 'angle-double-down', 'melokids' ) ),
		array( 'ti-move' => esc_html__( 'move', 'melokids' ) ),
		array( 'ti-fullscreen' => esc_html__( 'fullscreen', 'melokids' ) ),
		array( 'ti-arrow-top-right' => esc_html__( 'arrow-top-right', 'melokids' ) ),
		array( 'ti-arrow-top-left' => esc_html__( 'arrow-top-left', 'melokids' ) ),
		array( 'ti-arrow-circle-up' => esc_html__( 'arrow-circle-up', 'melokids' ) ),
		array( 'ti-arrow-circle-right' => esc_html__( 'arrow-circle-right', 'melokids' ) ),
		array( 'ti-arrow-circle-left' => esc_html__( 'arrow-circle-left', 'melokids' ) ),
		array( 'ti-arrow-circle-down' => esc_html__( 'arrow-circle-down', 'melokids' ) ),
		array( 'ti-arrows-corner' => esc_html__( 'arrows-corner', 'melokids' ) ),
		array( 'ti-split-v' => esc_html__( 'split-v', 'melokids' ) ),

		array( 'ti-split-v-alt' => esc_html__( 'split-v-alt', 'melokids' ) ),
		array( 'ti-split-h' => esc_html__( 'split-h', 'melokids' ) ),
		array( 'ti-hand-point-up' => esc_html__( 'hand-point-up', 'melokids' ) ),
		array( 'ti-hand-point-right' => esc_html__( 'hand-point-right', 'melokids' ) ),
		array( 'ti-hand-point-left' => esc_html__( 'hand-point-left', 'melokids' ) ),
		array( 'ti-hand-point-down' => esc_html__( 'hand-point-down', 'melokids' ) ),
		array( 'ti-back-right' => esc_html__( 'back-right', 'melokids' ) ),
		array( 'ti-back-left' => esc_html__( 'back-left', 'melokids' ) ),
		array( 'ti-exchange-vertical' => esc_html__( 'exchange-vertical', 'melokids' ) ),
		array( 'ti-wand' => esc_html__( 'wand', 'melokids' ) ),
		array( 'ti-save' => esc_html__( 'save', 'melokids' ) ),
		array( 'ti-save-alt' => esc_html__( 'save-alt', 'melokids' ) ),

		array( 'ti-direction' => esc_html__( 'direction', 'melokids' ) ),
		array( 'ti-direction-alt' => esc_html__( 'direction-alt', 'melokids' ) ),
		array( 'ti-user' => esc_html__( 'user', 'melokids' ) ),
		array( 'ti-link' => esc_html__( 'link', 'melokids' ) ),
		array( 'ti-unlink' => esc_html__( 'unlink', 'melokids' ) ),
		array( 'ti-trash' => esc_html__( 'trash', 'melokids' ) ),
		array( 'ti-target' => esc_html__( 'target', 'melokids' ) ),
		array( 'ti-tag' => esc_html__( 'tag', 'melokids' ) ),
		array( 'ti-desktop' => esc_html__( 'desktop', 'melokids' ) ),
		array( 'ti-tablet' => esc_html__( 'tablet', 'melokids' ) ),
		array( 'ti-mobile' => esc_html__( 'mobile', 'melokids' ) ),
		array( 'ti-email' => esc_html__( 'email', 'melokids' ) ),
		array( 'ti-star' => esc_html__( 'star', 'melokids' ) ),
		array( 'ti-spray' => esc_html__( 'spray', 'melokids' ) ),
		array( 'ti-signal' => esc_html__( 'signal', 'melokids' ) ),
		array( 'ti-shopping-cart' => esc_html__( 'shopping-cart', 'melokids' ) ),
		array( 'ti-shopping-cart-full' => esc_html__( 'shopping-cart-full', 'melokids' ) ),
		array( 'ti-settings' => esc_html__( 'settings', 'melokids' ) ),
		array( 'ti-search' => esc_html__( 'search', 'melokids' ) ),
		array( 'ti-zoom-in' => esc_html__( 'zoom-in', 'melokids' ) ),
		array( 'ti-zoom-out' => esc_html__( 'zoom-out', 'melokids' ) ),
		array( 'ti-cut' => esc_html__( 'cut', 'melokids' ) ),
		array( 'ti-ruler' => esc_html__( 'ruler', 'melokids' ) ),
		array( 'ti-ruler-alt-2' => esc_html__( 'ruler-alt-2', 'melokids' ) ),			
		array( 'ti-ruler-pencil' => esc_html__( 'ruler-pencil', 'melokids' ) ),
		array( 'ti-ruler-alt' => esc_html__( 'ruler-alt', 'melokids' ) ),
		array( 'ti-bookmark' => esc_html__( 'bookmark', 'melokids' ) ),
		array( 'ti-bookmark-alt' => esc_html__( 'bookmark-alt', 'melokids' ) ),
		array( 'ti-reload' => esc_html__( 'reload', 'melokids' ) ),
		array( 'ti-plus' => esc_html__( 'plus', 'melokids' ) ),
		array( 'ti-minus' => esc_html__( 'minus', 'melokids' ) ),
		array( 'ti-close' => esc_html__( 'close', 'melokids' ) ),			
		array( 'ti-pin' => esc_html__( 'pin', 'melokids' ) ),
		array( 'ti-pencil' => esc_html__( 'pencil', 'melokids' ) ),
				
		array( 'ti-pencil-alt' => esc_html__( 'pencil-alt', 'melokids' ) ),
		array( 'ti-paint-roller' => esc_html__( 'paint-roller', 'melokids' ) ),
		array( 'ti-paint-bucket' => esc_html__( 'paint-bucket', 'melokids' ) ),
		array( 'ti-na' => esc_html__( 'na', 'melokids' ) ),
		array( 'ti-medall' => esc_html__( 'medall', 'melokids' ) ),
		array( 'ti-medall-alt' => esc_html__( 'medall-alt', 'melokids' ) ),
		array( 'ti-marker' => esc_html__( 'marker', 'melokids' ) ),
		array( 'ti-marker-alt' => esc_html__( 'marker-alt', 'melokids' ) ),

		array( 'ti-lock' => esc_html__( 'lock', 'melokids' ) ),
		array( 'ti-unlock' => esc_html__( 'unlock', 'melokids' ) ),
		array( 'ti-location-arrow' => esc_html__( 'location-arrow', 'melokids' ) ),
		array( 'ti-layout' => esc_html__( 'layout', 'melokids' ) ),
		array( 'ti-layers' => esc_html__( 'layers', 'melokids' ) ),
		array( 'ti-layers-alt' => esc_html__( 'layers-alt', 'melokids' ) ),
		array( 'ti-key' => esc_html__( 'key', 'melokids' ) ),
		array( 'ti-image' => esc_html__( 'image', 'melokids' ) ),
		array( 'ti-heart' => esc_html__( 'heart', 'melokids' ) ),
		array( 'ti-heart-broken' => esc_html__( 'heart-broken', 'melokids' ) ),
		array( 'ti-hand-stop' => esc_html__( 'hand-stop', 'melokids' ) ),
		array( 'ti-hand-open' => esc_html__( 'hand-open', 'melokids' ) ),
		array( 'ti-hand-drag' => esc_html__( 'hand-drag', 'melokids' ) ),
		array( 'ti-flag' => esc_html__( 'flag', 'melokids' ) ),
		array( 'ti-flag-alt' => esc_html__( 'flag-alt', 'melokids' ) ),
		array( 'ti-flag-alt-2' => esc_html__( 'flag-alt-2', 'melokids' ) ),
		array( 'ti-eye' => esc_html__( 'eye', 'melokids' ) ),
		array( 'ti-import' => esc_html__( 'import', 'melokids' ) ),			
		array( 'ti-export' => esc_html__( 'export', 'melokids' ) ),
		array( 'ti-cup' => esc_html__( 'cup', 'melokids' ) ),
		array( 'ti-crown' => esc_html__( 'crown', 'melokids' ) ),
		array( 'ti-comments' => esc_html__( 'comments', 'melokids' ) ),
		array( 'ti-comment' => esc_html__( 'comment', 'melokids' ) ),
		array( 'ti-comment-alt' => esc_html__( 'comment-alt', 'melokids' ) ),
		array( 'ti-thought' => esc_html__( 'thought', 'melokids' ) ),			
		array( 'ti-clip' => esc_html__( 'clip', 'melokids' ) ),

		array( 'ti-check' => esc_html__( 'check', 'melokids' ) ),
		array( 'ti-check-box' => esc_html__( 'check-box', 'melokids' ) ),
		array( 'ti-camera' => esc_html__( 'camera', 'melokids' ) ),
		array( 'ti-announcement' => esc_html__( 'announcement', 'melokids' ) ),
		array( 'ti-brush' => esc_html__( 'brush', 'melokids' ) ),
		array( 'ti-brush-alt' => esc_html__( 'brush-alt', 'melokids' ) ),
		array( 'ti-palette' => esc_html__( 'palette', 'melokids' ) ),			
		array( 'ti-briefcase' => esc_html__( 'briefcase', 'melokids' ) ),
		array( 'ti-bolt' => esc_html__( 'bolt', 'melokids' ) ),
		array( 'ti-bolt-alt' => esc_html__( 'bolt-alt', 'melokids' ) ),
		array( 'ti-blackboard' => esc_html__( 'blackboard', 'melokids' ) ),
		array( 'ti-bag' => esc_html__( 'bag', 'melokids' ) ),
		array( 'ti-world' => esc_html__( 'world', 'melokids' ) ),
		array( 'ti-wheelchair' => esc_html__( 'wheelchair', 'melokids' ) ),
		array( 'ti-car' => esc_html__( 'car', 'melokids' ) ),
		array( 'ti-truck' => esc_html__( 'truck', 'melokids' ) ),
		array( 'ti-timer' => esc_html__( 'timer', 'melokids' ) ),
		array( 'ti-ticket' => esc_html__( 'ticket', 'melokids' ) ),
		array( 'ti-thumb-up' => esc_html__( 'thumb-up', 'melokids' ) ),
		array( 'ti-thumb-down' => esc_html__( 'thumb-down', 'melokids' ) ),

		array( 'ti-stats-up' => esc_html__( 'stats-up', 'melokids' ) ),
		array( 'ti-stats-down' => esc_html__( 'stats-down', 'melokids' ) ),
		array( 'ti-shine' => esc_html__( 'shine', 'melokids' ) ),
		array( 'ti-shift-right' => esc_html__( 'shift-right', 'melokids' ) ),
		array( 'ti-shift-left' => esc_html__( 'shift-left', 'melokids' ) ),

		array( 'ti-shift-right-alt' => esc_html__( 'shift-right-alt', 'melokids' ) ),
		array( 'ti-shift-left-alt' => esc_html__( 'shift-left-alt', 'melokids' ) ),
		array( 'ti-shield' => esc_html__( 'shield', 'melokids' ) ),
		array( 'ti-notepad' => esc_html__( 'notepad', 'melokids' ) ),
		array( 'ti-server' => esc_html__( 'server', 'melokids' ) ),

		array( 'ti-pulse' => esc_html__( 'pulse', 'melokids' ) ),
		array( 'ti-printer' => esc_html__( 'printer', 'melokids' ) ),
		array( 'ti-power-off' => esc_html__( 'power-off', 'melokids' ) ),
		array( 'ti-plug' => esc_html__( 'plug', 'melokids' ) ),
		array( 'ti-pie-chart' => esc_html__( 'pie-chart', 'melokids' ) ),

		array( 'ti-panel' => esc_html__( 'panel', 'melokids' ) ),
		array( 'ti-package' => esc_html__( 'package', 'melokids' ) ),
		array( 'ti-music' => esc_html__( 'music', 'melokids' ) ),
		array( 'ti-music-alt' => esc_html__( 'music-alt', 'melokids' ) ),
		array( 'ti-mouse' => esc_html__( 'mouse', 'melokids' ) ),
		array( 'ti-mouse-alt' => esc_html__( 'mouse-alt', 'melokids' ) ),
		array( 'ti-money' => esc_html__( 'money', 'melokids' ) ),
		array( 'ti-microphone' => esc_html__( 'microphone', 'melokids' ) ),
		array( 'ti-menu' => esc_html__( 'menu', 'melokids' ) ),
		array( 'ti-menu-alt' => esc_html__( 'menu-alt', 'melokids' ) ),
		array( 'ti-map' => esc_html__( 'map', 'melokids' ) ),
		array( 'ti-map-alt' => esc_html__( 'map-alt', 'melokids' ) ),

		array( 'ti-location-pin' => esc_html__( 'location-pin', 'melokids' ) ),

		array( 'ti-light-bulb' => esc_html__( 'light-bulb', 'melokids' ) ),
		array( 'ti-info' => esc_html__( 'info', 'melokids' ) ),
		array( 'ti-infinite' => esc_html__( 'infinite', 'melokids' ) ),
		array( 'ti-id-badge' => esc_html__( 'id-badge', 'melokids' ) ),
		array( 'ti-hummer' => esc_html__( 'hummer', 'melokids' ) ),
		array( 'ti-home' => esc_html__( 'home', 'melokids' ) ),
		array( 'ti-help' => esc_html__( 'help', 'melokids' ) ),
		array( 'ti-headphone' => esc_html__( 'headphone', 'melokids' ) ),
		array( 'ti-harddrives' => esc_html__( 'harddrives', 'melokids' ) ),
		array( 'ti-harddrive' => esc_html__( 'harddrive', 'melokids' ) ),
		array( 'ti-gift' => esc_html__( 'gift', 'melokids' ) ),
		array( 'ti-game' => esc_html__( 'game', 'melokids' ) ),
		array( 'ti-filter' => esc_html__( 'filter', 'melokids' ) ),
		array( 'ti-files' => esc_html__( 'files', 'melokids' ) ),
		array( 'ti-file' => esc_html__( 'file', 'melokids' ) ),
		array( 'ti-zip' => esc_html__( 'zip', 'melokids' ) ),
		array( 'ti-folder' => esc_html__( 'folder', 'melokids' ) ),			
		array( 'ti-envelope' => esc_html__( 'envelope', 'melokids' ) ),


		array( 'ti-dashboard' => esc_html__( 'dashboard', 'melokids' ) ),
		array( 'ti-cloud' => esc_html__( 'cloud', 'melokids' ) ),
		array( 'ti-cloud-up' => esc_html__( 'cloud-up', 'melokids' ) ),
		array( 'ti-cloud-down' => esc_html__( 'cloud-down', 'melokids' ) ),
		array( 'ti-clipboard' => esc_html__( 'clipboard', 'melokids' ) ),
		array( 'ti-calendar' => esc_html__( 'calendar', 'melokids' ) ),
		array( 'ti-book' => esc_html__( 'book', 'melokids' ) ),
		array( 'ti-bell' => esc_html__( 'bell', 'melokids' ) ),
		array( 'ti-basketball' => esc_html__( 'basketball', 'melokids' ) ),
		array( 'ti-bar-chart' => esc_html__( 'bar-chart', 'melokids' ) ),
		array( 'ti-bar-chart-alt' => esc_html__( 'bar-chart-alt', 'melokids' ) ),


		array( 'ti-archive' => esc_html__( 'archive', 'melokids' ) ),
		array( 'ti-anchor' => esc_html__( 'anchor', 'melokids' ) ),

		array( 'ti-alert' => esc_html__( 'alert', 'melokids' ) ),
		array( 'ti-alarm-clock' => esc_html__( 'alarm-clock', 'melokids' ) ),
		array( 'ti-agenda' => esc_html__( 'agenda', 'melokids' ) ),
		array( 'ti-write' => esc_html__( 'write', 'melokids' ) ),

		array( 'ti-wallet' => esc_html__( 'wallet', 'melokids' ) ),
		array( 'ti-video-clapper' => esc_html__( 'video-clapper', 'melokids' ) ),
		array( 'ti-video-camera' => esc_html__( 'video-camera', 'melokids' ) ),
		array( 'ti-vector' => esc_html__( 'vector', 'melokids' ) ),

		array( 'ti-support' => esc_html__( 'support', 'melokids' ) ),
		array( 'ti-stamp' => esc_html__( 'stamp', 'melokids' ) ),
		array( 'ti-slice' => esc_html__( 'slice', 'melokids' ) ),
		array( 'ti-shortcode' => esc_html__( 'shortcode', 'melokids' ) ),
		array( 'ti-receipt' => esc_html__( 'receipt', 'melokids' ) ),
		array( 'ti-pin2' => esc_html__( 'pin2', 'melokids' ) ),
		array( 'ti-pin-alt' => esc_html__( 'pin-alt', 'melokids' ) ),
		array( 'ti-pencil-alt2' => esc_html__( 'pencil-alt2', 'melokids' ) ),
		array( 'ti-eraser' => esc_html__( 'eraser', 'melokids' ) ),			
		array( 'ti-more' => esc_html__( 'more', 'melokids' ) ),
		array( 'ti-more-alt' => esc_html__( 'more-alt', 'melokids' ) ),
		array( 'ti-microphone-alt' => esc_html__( 'microphone-alt', 'melokids' ) ),
		array( 'ti-magnet' => esc_html__( 'magnet', 'melokids' ) ),
		array( 'ti-line-double' => esc_html__( 'line-double', 'melokids' ) ),
		array( 'ti-line-dotted' => esc_html__( 'line-dotted', 'melokids' ) ),
		array( 'ti-line-dashed' => esc_html__( 'line-dashed', 'melokids' ) ),

		array( 'ti-ink-pen' => esc_html__( 'ink-pen', 'melokids' ) ),
		array( 'ti-info-alt' => esc_html__( 'info-alt', 'melokids' ) ),
		array( 'ti-help-alt' => esc_html__( 'help-alt', 'melokids' ) ),
		array( 'ti-headphone-alt' => esc_html__( 'headphone-alt', 'melokids' ) ),

		array( 'ti-gallery' => esc_html__( 'gallery', 'melokids' ) ),
		array( 'ti-face-smile' => esc_html__( 'face-smile', 'melokids' ) ),
		array( 'ti-face-sad' => esc_html__( 'face-sad', 'melokids' ) ),
		array( 'ti-credit-card' => esc_html__( 'credit-card', 'melokids' ) ),
		array( 'ti-comments-smiley' => esc_html__( 'comments-smiley', 'melokids' ) ),
		array( 'ti-time' => esc_html__( 'time', 'melokids' ) ),
		array( 'ti-share' => esc_html__( 'share', 'melokids' ) ),
		array( 'ti-share-alt' => esc_html__( 'share-alt', 'melokids' ) ),
		array( 'ti-rocket' => esc_html__( 'rocket', 'melokids' ) ),

		array( 'ti-new-window' => esc_html__( 'new-window', 'melokids' ) ),

		array( 'ti-rss' => esc_html__( 'rss', 'melokids' ) ),

		array( 'ti-rss-alt' => esc_html__( 'rss-alt', 'melokids' ) ),
		array( 'ti-control-stop' => esc_html__( 'control-stop', 'melokids' ) ),
		array( 'ti-control-shuffle' => esc_html__( 'control-shuffle', 'melokids' ) ),
		array( 'ti-control-play' => esc_html__( 'control-play', 'melokids' ) ),
		array( 'ti-control-pause' => esc_html__( 'control-pause', 'melokids' ) ),
		array( 'ti-control-forward' => esc_html__( 'control-forward', 'melokids' ) ),
		array( 'ti-control-backward' => esc_html__( 'control-backward', 'melokids' ) ),	
		array( 'ti-volume' => esc_html__( 'volume', 'melokids' ) ),
		array( 'ti-control-skip-forward' => esc_html__( 'control-skip-forward', 'melokids' ) ),
		array( 'ti-control-skip-backward' => esc_html__( 'control-skip-backward', 'melokids' ) ),
		array( 'ti-control-record' => esc_html__( 'control-record', 'melokids' ) ),
		array( 'ti-control-eject' => esc_html__( 'control-eject', 'melokids' ) ),
		array( 'ti-paragraph' => esc_html__( 'paragraph', 'melokids' ) ),
		array( 'ti-uppercase' => esc_html__( 'uppercase', 'melokids' ) ),

		array( 'ti-underline' => esc_html__( 'underline', 'melokids' ) ),
		array( 'ti-text' => esc_html__( 'ti-text', 'melokids' ) ),
		array( 'ti-Italic' => esc_html__( 'Italic', 'melokids' ) ),
		array( 'ti-smallcap' => esc_html__( 'smallcap', 'melokids' ) ),
		array( 'ti-list' => esc_html__( 'list', 'melokids' ) ),
		array( 'ti-list-ol' => esc_html__( 'list-ol', 'melokids' ) ),
		array( 'ti-align-right' => esc_html__( 'align-right', 'melokids' ) ),
		array( 'ti-align-left' => esc_html__( 'align-left', 'melokids' ) ),
		array( 'ti-align-justify' => esc_html__( 'align-justify', 'melokids' ) ),
		array( 'ti-align-center' => esc_html__( 'align-center', 'melokids' ) ),
		array( 'ti-quote-right' => esc_html__( 'quote-right', 'melokids' ) ),
		array( 'ti-quote-left' => esc_html__( 'quote-left', 'melokids' ) ),
		array( 'ti-layout-width-full' => esc_html__( 'layout-width-full', 'melokids' ) ),
		array( 'ti-layout-width-default' => esc_html__( 'layout-width-default', 'melokids' ) ),
		array( 'ti-layout-width-default-alt' => esc_html__( 'layout-width-default-alt', 'melokids' ) ),
		array( 'ti-layout-tab' => esc_html__( 'layout-tab', 'melokids' ) ),
		array( 'ti-layout-tab-window' => esc_html__( 'layout-tab-window', 'melokids' ) ),
		array( 'ti-layout-tab-v' => esc_html__( 'layout-tab-v', 'melokids' ) ),
		array( 'ti-layout-tab-min' => esc_html__( 'layout-tab-min', 'melokids' ) ),
		array( 'ti-layout-slider' => esc_html__( 'layout-slider', 'melokids' ) ),
		array( 'ti-layout-slider-alt' => esc_html__( 'layout-slider-alt', 'melokids' ) ),
		array( 'ti-layout-sidebar-right' => esc_html__( 'layout-sidebar-right', 'melokids' ) ),
		array( 'ti-layout-sidebar-none' => esc_html__( 'layout-sidebar-none', 'melokids' ) ),
		array( 'ti-layout-sidebar-left' => esc_html__( 'layout-sidebar-left', 'melokids' ) ),
		array( 'ti-layout-placeholder' => esc_html__( 'layout-placeholder', 'melokids' ) ),
		array( 'ti-layout-menu' => esc_html__( 'layout-menu', 'melokids' ) ),
		array( 'ti-layout-menu-v' => esc_html__( 'layout-menu-v', 'melokids' ) ),
		array( 'ti-layout-menu-separated' => esc_html__( 'layout-menu-separated', 'melokids' ) ),
		array( 'ti-layout-menu-full' => esc_html__( 'layout-menu-full', 'melokids' ) ),
		array( 'ti-layout-media-right' => esc_html__( 'layout-media-right', 'melokids' ) ),
		array( 'ti-layout-media-right-alt' => esc_html__( 'layout-media-right-alt', 'melokids' ) ),
		array( 'ti-layout-media-overlay' => esc_html__( 'layout-media-overlay', 'melokids' ) ),
		array( 'ti-layout-media-overlay-alt' => esc_html__( 'layout-media-overlay-alt', 'melokids' ) ),
		array( 'ti-layout-media-overlay-alt-2' => esc_html__( 'layout-media-overlay-alt-2', 'melokids' ) ),
		array( 'ti-layout-media-left' => esc_html__( 'layout-media-left', 'melokids' ) ),
		array( 'ti-layout-media-left-alt' => esc_html__( 'layout-media-left-alt', 'melokids' ) ),
		array( 'ti-layout-media-center' => esc_html__( 'layout-media-center', 'melokids' ) ),
		array( 'ti-layout-media-center-alt' => esc_html__( 'layout-media-center-alt', 'melokids' ) ),
		array( 'ti-layout-list-thumb' => esc_html__( 'layout-list-thumb', 'melokids' ) ),
		array( 'ti-layout-list-thumb-alt' => esc_html__( 'layout-list-thumb-alt', 'melokids' ) ),
		array( 'ti-layout-list-post' => esc_html__( 'layout-list-post', 'melokids' ) ),
		array( 'ti-layout-list-large-image' => esc_html__( 'layout-list-large-image', 'melokids' ) ),
		array( 'ti-layout-line-solid' => esc_html__( 'layout-line-solid', 'melokids' ) ),
		array( 'ti-layout-grid4' => esc_html__( 'layout-grid4', 'melokids' ) ),
		array( 'ti-layout-grid3' => esc_html__( 'layout-grid3', 'melokids' ) ),
		array( 'ti-layout-grid2' => esc_html__( 'layout-grid2', 'melokids' ) ),
		array( 'ti-layout-grid2-thumb' => esc_html__( 'layout-grid2-thumb', 'melokids' ) ),
		array( 'ti-layout-cta-right' => esc_html__( 'layout-cta-right', 'melokids' ) ),
		array( 'ti-layout-cta-left' => esc_html__( 'layout-cta-left', 'melokids' ) ),
		array( 'ti-layout-cta-center' => esc_html__( 'layout-cta-center', 'melokids' ) ),
		array( 'ti-layout-cta-btn-right' => esc_html__( 'layout-cta-btn-right', 'melokids' ) ),
		array( 'ti-layout-cta-btn-left' => esc_html__( 'layout-cta-btn-left', 'melokids' ) ),
		array( 'ti-layout-column4' => esc_html__( 'layout-column4', 'melokids' ) ),
		array( 'ti-layout-column3' => esc_html__( 'layout-column3', 'melokids' ) ),
		array( 'ti-layout-column2' => esc_html__( 'layout-column2', 'melokids' ) ),
		array( 'ti-layout-accordion-separated' => esc_html__( 'layout-accordion-separated', 'melokids' ) ),
		array( 'ti-layout-accordion-merged' => esc_html__( 'layout-accordion-merged', 'melokids' ) ),
		array( 'ti-layout-accordion-list' => esc_html__( 'layout-accordion-list', 'melokids' ) ),
		array( 'ti-widgetized' => esc_html__( 'widgetized', 'melokids' ) ),
		array( 'ti-widget' => esc_html__( 'widget', 'melokids' ) ),
		array( 'ti-widget-alt' => esc_html__( 'widget-alt', 'melokids' ) ),
		array( 'ti-view-list' => esc_html__( 'view-list', 'melokids' ) ),
		array( 'ti-view-list-alt' => esc_html__( 'view-list-alt', 'melokids' ) ),
		array( 'ti-view-grid' => esc_html__( 'view-grid', 'melokids' ) ),
		array( 'ti-upload' => esc_html__( 'upload', 'melokids' ) ),
		array( 'ti-download' => esc_html__( 'download', 'melokids' ) ),	
		array( 'ti-loop' => esc_html__( 'loop', 'melokids' ) ),
		array( 'ti-layout-sidebar-2' => esc_html__( 'layout-sidebar-2', 'melokids' ) ),
		array( 'ti-layout-grid4-alt' => esc_html__( 'layout-grid4-alt', 'melokids' ) ),
		array( 'ti-layout-grid3-alt' => esc_html__( 'layout-grid3-alt', 'melokids' ) ),
		array( 'ti-layout-grid2-alt' => esc_html__( 'layout-grid2-alt', 'melokids' ) ),
		array( 'ti-layout-column4-alt' => esc_html__( 'layout-column4-alt', 'melokids' ) ),
		array( 'ti-layout-column3-alt' => esc_html__( 'layout-column3-alt', 'melokids' ) ),
		array( 'ti-layout-column2-alt' => esc_html__( 'layout-column2-alt', 'melokids' ) ),
		array( 'ti-flickr' => esc_html__( 'flickr', 'melokids' ) ),
		array( 'ti-flickr-alt' => esc_html__( 'flickr-alt', 'melokids' ) ),			
		array( 'ti-instagram' => esc_html__( 'instagram', 'melokids' ) ),
		array( 'ti-google' => esc_html__( 'google', 'melokids' ) ),
		array( 'ti-github' => esc_html__( 'github', 'melokids' ) ),

		array( 'ti-facebook' => esc_html__( 'facebook', 'melokids' ) ),
		array( 'ti-dropbox' => esc_html__( 'dropbox', 'melokids' ) ),
		array( 'ti-dropbox-alt' => esc_html__( 'dropbox-alt', 'melokids' ) ),
		array( 'ti-dribbble' => esc_html__( 'dribbble', 'melokids' ) ),
		array( 'ti-apple' => esc_html__( 'apple', 'melokids' ) ),
		array( 'ti-android' => esc_html__( 'android', 'melokids' ) ),
		array( 'ti-yahoo' => esc_html__( 'yahoo', 'melokids' ) ),
		array( 'ti-trello' => esc_html__( 'trello', 'melokids' ) ),
		array( 'ti-stack-overflow' => esc_html__( 'stack-overflow', 'melokids' ) ),
		array( 'ti-soundcloud' => esc_html__( 'soundcloud', 'melokids' ) ),
		array( 'ti-sharethis' => esc_html__( 'sharethis', 'melokids' ) ),
		array( 'ti-sharethis-alt' => esc_html__( 'sharethis-alt', 'melokids' ) ),
		array( 'ti-reddit' => esc_html__( 'reddit', 'melokids' ) ),

		array( 'ti-microsoft' => esc_html__( 'microsoft', 'melokids' ) ),
		array( 'ti-microsoft-alt' => esc_html__( 'microsoft-alt', 'melokids' ) ),
		array( 'ti-linux' => esc_html__( 'linux', 'melokids' ) ),
		array( 'ti-jsfiddle' => esc_html__( 'jsfiddle', 'melokids' ) ),
		array( 'ti-joomla' => esc_html__( 'joomla', 'melokids' ) ),
		array( 'ti-html5' => esc_html__( 'html5', 'melokids' ) ),
		array( 'ti-css3' => esc_html__( 'css3', 'melokids' ) ),	
		array( 'ti-drupal' => esc_html__( 'drupal', 'melokids' ) ),
		array( 'ti-wordpress' => esc_html__( 'wordpress', 'melokids' ) ),		
		array( 'ti-tumblr' => esc_html__( 'tumblr', 'melokids' ) ),
		array( 'ti-tumblr-alt' => esc_html__( 'tumblr-alt', 'melokids' ) ),
		array( 'ti-skype' => esc_html__( 'skype', 'melokids' ) ),
		array( 'ti-youtube' => esc_html__( 'youtube', 'melokids' ) ),
		array( 'ti-vimeo' => esc_html__( 'vimeo', 'melokids' ) ),
		array( 'ti-vimeo-alt' => esc_html__( 'vimeo-alt', 'melokids' ) ),			
		array( 'ti-twitter' => esc_html__( 'twitter', 'melokids' ) ),
		array( 'ti-twitter-alt' => esc_html__( 'twitter-alt', 'melokids' ) ),
		array( 'ti-linkedin' => esc_html__( 'linkedin', 'melokids' ) ),
		array( 'ti-pinterest' => esc_html__( 'pinterest', 'melokids' ) ),

		array( 'ti-pinterest-alt' => esc_html__( 'pinterest-alt', 'melokids' ) ),
		array( 'ti-themify-logo' => esc_html__( 'themify-logo', 'melokids' ) ),
		array( 'ti-themify-favicon' => esc_html__( 'themify-favicon', 'melokids' ) ),
		array( 'ti-themify-favicon-alt' => esc_html__( 'themify-favicon-alt', 'melokids' ) ),
	);
	return array_merge( $icons, $themify_icons );
}
 ?>