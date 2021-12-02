<?php
    /*
    Template Name: Right Sidebar layout
    Template Post Type: post, page, event
     */
    // Page code here...

    get_header();

?>
<div class="section">
	<div class="container">
		<?php
            the_content();
        ?>
	</div>
</div>

<?php
get_footer();