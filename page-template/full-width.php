<?php
    /*
    Template Name: Full Width layout
    Template Post Type: post, page, event
     */
    // Page code here...

    get_header();

?>
<div class="section">
		<?php
            the_content();
        ?>
</div>

<?php
get_footer();