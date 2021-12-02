<?php
    get_header();
?>
    <h1>Test Search Result::</h1>

    <?php
    $term = $_POST['s'];
    $expTerm = explode(" ", $term);

    $search = '(';
        foreach($expTerm as $ek => $ev) {
            if($ek == 0) {
                $search .= " post_title LIKE '%" .$ev. "%' ";
            }else {
                $search .= " OR post_title LIKE '%" .$ev. "%' ";
            }
        }

    $search .= ')';

    $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix."posts WHERE post_status = 'publish' AND $search" );
    // echo '<pre>';
    // print_r($query);
    // echo '</pre>';
    
    foreach($query as $qk => $qv) {
        $link = get_permalink( $qv->ID );
        ?>
        <h3><a href="<?php print $link; ?>"><?php print $qv->post_title ?></h3></a>
        <p><?php print wp_trim_words( $qv->post_content, 40, '... <a href="'.$link .'">continue reading</a>'); ?></p>
        
        <?php
    }


?>



<?php get_footer();