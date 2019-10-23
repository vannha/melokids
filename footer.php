<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @author Chinh Duong Manh
 * @since 1.0.0
 *
 */
?>
            </div>
        </main>
        <?php 
        	if(function_exists('melokids_footer')) {
        		melokids_footer();
        	} else {
        		echo '<footer id="zk-footer" class="default"><div class="container">';
                echo '<div id="open-footer"></div>';
        		melokids_footer_default();
        		echo '</div></footer>';
        	}
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>