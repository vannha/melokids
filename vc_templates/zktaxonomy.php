<?php 
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
?>
<div class="zk-taxonomies"> 
    <?php wp_list_categories(['taxonomy' => $taxonomy,'style' => '','separator' => $separator]); ?>
</div>
