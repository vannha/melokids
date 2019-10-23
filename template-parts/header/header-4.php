<?php
/**
 * Header Default
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 */
$header_custom = melokids_get_opts('header_custom_value','');
?>
<div class="zk-mousewheel">
	<div class="zk-mousewheel-inner">
		<div class="row align-items-center justify-content-between">
		<?php 
			if(empty($header_custom)){
				melokids_logo(['class' => 'col-12 text-center']);
			    melokids_header_atts(['class' => 'col-12 text-center']);
			    melokids_header_navigation(['class' => 'col-12','walker' => '']);
			} else {
				melokids_header_custom(['class' => 'col-12']);
			}
		?>
		</div>
	</div>
</div>
