<?php

 if (!defined('ABSPATH')) {
     exit;
 }
 
 function ct_add_woocommerce_support()
 {
    add_theme_support('woocommerce'); 
 }
add_action('after_setup_theme', 'ct_add_woocommerce_support');

 // include woocommerce customer registration file
 include_once "woocommerce-customer-registration.php";
 include_once "wc-functions.php";

 require_once "includes/vehicle-post-type.php";
 require_once "includes/floor-plan-post-type.php";

 require_once "includes/select-user-role-mb.php";
 require_once "includes/core/shortcodes.php";
 require_once "includes/tgmpa/class-tgm-plugin-activation.php";
 require_once "includes/tgmpa/tgmpa.php";

 require_once "includes/core/brewery.php";

 add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
 function my_theme_enqueue_styles()
 {
     $parentHandle = 'parent-style';
     $theme        = wp_get_theme();
     // wp_enqueue_style( $parentHandle, get_template_directory_uri() . '/style.css',
     //     array(),
     //     $theme->parent()->get( 'Version' )
     // );
     // wp_enqueue_style( 'child-style', get_stylesheet_uri(),
     //     array( $parentHandle ),
     //     $theme->get( 'Version' )
     // );

     // enqueue parent styles file using this get_stylesheet_uri() way
     wp_enqueue_style('twentytwentyone-style', get_stylesheet_uri());
     // wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css', array(), $theme->parent()->get( 'Version' ) );
     wp_enqueue_style('child-theme-css', get_stylesheet_directory_uri() . '/style.css', '1.0');
     wp_enqueue_style('woocommerce-style', get_stylesheet_directory_uri() . '/assets/css/woocommerce.css', '1.0');

     /**
      * Enqueue styles/ scripts for Owl Carousel
      */
     wp_enqueue_style('owl-carousel', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css', '1.0');
     wp_enqueue_script('owl-carousel', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), '1.0', true);
     wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), '1.0', true);
     wp_enqueue_script('ajax-filter', get_stylesheet_directory_uri() . '/assets/js/ajax-filter.js', array( 'jquery' ), '1.0', true);

     /**
      * this is for sorting taxonomy in frontend
      */
     wp_enqueue_script('sorting', get_stylesheet_directory_uri() . '/assets/js/sorting.js', array( 'jquery' ), '1.0', true);
 }

 // include_once "settings-api.php";
 // include_once "Class-Settings-API.php";
 add_shortcode('contact_form', 'ar_contact_form');
 function ar_contact_form()
 {
     $content = '';
     $content = '<div class="container">';
     $content .= '<form action="" method="post" class="contact-form">';

     $content .= '<div><label for="name">Name</label>';
     $content .= '<input value="" name="name" id="name" placeholder="Name" /></div>';

     $content .= '<div><label for="email">Email</label>';
     $content .= '<input value="" name="email" id="email" placeholder="Enter your name" /></div>';

     $content .= '<div><label for="phone">Phone</label>';
     $content .= '<input value="" name="phone" id="phone" placeholder="phone" /></div>';

     $content .= '<div><label for="message">message</label>';
     $content .= '<input value="" name="message" id="message" placeholder="message" /></div>';

     $content .= '<input type="submit" name="contact_submit" id="contact_submit" />';

     $content .= "</form></div>";

     return $content;
 }

 // User Meta Contacts
 add_filter('user_contactmethods', 'userMetaContactsmethod');
 function userMetaContactsmethod($meta)
 {
     $meta['twitter']  = __("Twitter", 'child-theme');
     $meta['facebook'] = __("Facebook", 'child-theme');
     $meta['linkedin'] = __("LinkedIn", 'child-theme');
     return $meta;
 }

 // retrieve data
 function author_bio($content)
 {
     global $post;

     // var_dump($post);
     // die();
     $author = get_user_by('id', $post->post_author);

     $bio      = get_user_meta($author->ID, 'description', true);
     $twitter  = get_user_meta($author->ID, 'twitter', true);
     $facebook = get_user_meta($author->ID, 'facebook', true);
     $linkedin = get_user_meta($author->ID, 'linkedin', true);

     ob_start(); ?>
<div class="bio-wrap d-none">
    <div class="avatar-image">
        <?php echo get_avatar($author->ID, 64); ?>
    </div>
    <div class="bio-content">
        <div class="author-name">
            <?php echo $author->display_name; ?>
        </div>
        <div class="bio">
            <?php echo wpautop(wp_kses_post($author->description)); ?>
        </div>
        <ul class="socials">
            <?php if ($twitter) {
         printf('<li><a href="%s">%s</a></li>', esc_url($twitter), __('Twitter', 'child-theme'));
     } ?>
            <?php if ($facebook) {
         printf('<li><a href="%s">%s</a></li>', esc_url($facebook), __('Facebook', 'child-theme'));
     } ?>
            <?php if ($linkedin) {
         printf('<li><a href="%s">%s</a></li>', esc_url($linkedin), __('LinkedIn', 'child-theme'));
     } ?>
        </ul>
    </div>
</div>
<?php

      $cleanObj = ob_get_clean();
     return $content . $cleanObj;
 }

     add_filter('the_content', 'author_bio');

     // $value = "Hello world";
     // apply_filters( 'hello_world', $value );

     function modify_filter($value)
     {
         // $value = "Hello world updated!";
         // var_dump($value);
         // die();
         // return $value;
         return "Hello world updated";
     }

     // $value = "Hello world updated!";

     add_filter('hello_world', 'modify_filter');

     // shortcode

     function ct_contact_form($atts, $content)
     {
         $atts = shortcode_atts(array(
       'email'   => get_option('email'),
       'subject' => __('Send Email', 'child-theme'),
      ), $atts);

         $submit = false;
         if (isset($_POST['form_submit'])) {
             $name    = $_POST['name'];
             $email   = $_POST['email'];
             $subject = $_POST['subject'];
             $message = $_POST['message'];

             // wp_mail($atts['email'], $subject, $message);
             $submit = true;
         }

         ob_start();
         if ($submit) {
             echo "<h1>Successfully submitted!</h1>";
         } ?>
<form action="" id="ct_contact" method="post">
    <p>
        <label for="name">name</label>
        <input type="text" name="name" value="" />
    </p>
    <p>
        <label for="email">email</label>
        <input type="text" name="email" value="" />
    </p>
    <p>
        <label for="message">message</label>
        <input type="text" name="message" value="" />
    </p>
    <p>
        <label for="subject">subject</label>
        <input type="text" name="subject" value="" />
    </p>
    <p>
        <input type="submit" name="form_submit"
            value="<?php echo esc_attr($atts['subject']); ?>" />
    </p>
</form>
<?php
     }

     add_shortcode('contact_form', 'ct_contact_form');

     // Shortcode
     function create__shortcode($atts, $content = null)
     {
         $atts = shortcode_atts(
             array(
        'name'  => 'Anisur',
        'phone' => '01749798294',
       ),
             $atts,
             'new_shortcode'
         );

         $name  = $atts['name'];
         $phone = $atts['phone'];

         $html = "";
         $html .= '<div>';
         $html .= '<h1>' . $name . '</h1>';
         $html .= '<p>$phone</p>';
         $html .= '</div>';

         return $html;
     }

     add_shortcode('new_shortcode', 'create__shortcode');

     $current_user = wp_get_current_user();

     function people_init()
     {
         register_taxonomy('people', 'post', array(
       'label'        => __('People', 'child-theme'),
       'rewrite'      => array( 'slug' => 'janu' ),
       'capabilities' => array(
        'assign_terms' => 'edit_guides',
        'edit_terms'   => 'publish_guides',
       ),
      ));
     }

     add_action('init', 'people_init');

     function wpdocs_my_plugin_menu()
     {
         add_media_page(
             __('My Plugin Posts Page', 'textdomain'),
             __('Custom Post', 'textdomain'),
             'read',
             'my-unique-identifier',
             'wpdocs_my_plugin_function'
         );
     }

     add_action('admin_menu', 'wpdocs_my_plugin_menu');

     function wpdocs_my_plugin_function()
     {
         echo "Test purpose";
     }

     /**
      * Class for registering a new settings page under Settings.
      */
     class WPDocs_Options_Page
     {

      /**
       * Constructor.
       */
         public function __construct()
         {
             add_action('admin_menu', array( $this, 'admin_menu' ));
         }

         /**
          * Registers a new settings page under Settings.
          */
         public function admin_menu()
         {
             add_options_page(
                 __('Page Title', 'textdomain'),
                 __('Circle Tree Login', 'textdomain'),
                 'manage_options',
                 'options_page_slug',
                 array(
         $this,
         'settings_page',
        )
             );
         }

         /**
          * Settings page display callback.
          */
         public function settings_page()
         {
             echo __('This is the page content', 'textdomain');
         }
     }

     new WPDocs_Options_Page;

     // mt_settings_page() displays the page content for the Test Settings submenu
     function mt_settings_page()
     {

      //must check that the user has the required capability
         if (!current_user_can('manage_options')) {
             wp_die(__('You do not have sufficient permissions to access this page.'));
         }

         // variables for the field and option names
         $opt_name          = 'mt_favorite_color';
         $hidden_field_name = 'mt_submit_hidden';
         $data_field_name   = 'mt_favorite_color';

         // Read in existing option value from database
         $opt_val = get_option($opt_name);

         // See if the user has posted us some information
         // If they did, this hidden field will be set to 'Y'
         if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
             // Read their posted value
             $opt_val = $_POST[$data_field_name];

             // Save the posted value in the database
             update_option($opt_name, $opt_val);

             // Put a "settings saved" message on the screen?>
<div class="updated">
    <p><strong><?php _e('settings saved.', 'menu-test'); ?></strong>
    </p>
</div>
<?php
         }

         // Now display the settings editing screen

         echo '<div class="wrap">';

         // header

         echo "<h2>" . __('Menu Test Plugin Settings', 'menu-test') . "</h2>";

         // settings form?>
<form name="form1" method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>"
        value="Y">
    <p><?php _e("Favorite Color:", 'menu-test'); ?>
        <input type="text" name="<?php echo $data_field_name; ?>"
            value="<?php echo $opt_val; ?>" size="20">
    </p>
    <hr />
    <p class="submit">
        <input type="submit" name="Submit" class="button-primary"
            value="<?php esc_attr_e('Save Changes')?>" />
    </p>
</form>
</div>
<?php
     }

 /**
  * trailingslashit is a method witch return slash end of the url and ensure there will only be one slash
  */
 $path = trailingslashit('/home/julien/bin');
 // echo $path;

 if (!is_admin()) {
     function the_dramatist_fire_on_wp_initialization()
     {
         // Do stuff. Say we will echo "Fired on the WordPress initialization".
   // echo 'Fired on the WordPress initialization';
     }

     add_action('init', 'the_dramatist_fire_on_wp_initialization');
 }

 /**
  * Admin Init hook inside Init hook
  *
  * will work fine
  *
  */
 add_action('init', 'test_init');
 function test_init()
 {
     add_action('admin_init', 'test_admin_init');
 }

 function test_admin_init()
 {
     // echo "Hello from Admin area!";
 }

 /**
  * Init hook inside Admin Init hook
  *
  * This wont work because of order - init runs first then run admin_init
  *
  */
 add_action('admin_init', 'test_admin_init_2');
 function test_admin_init_2()
 {
     add_action('init', 'test_init_2');
 }

 function test_init_2()
 {
     echo "Hello from Admin area!";
 }

 /**
  * Register custom meta box
  *
  * @return void
  */
 function ct_add_meta_boxes()
 {
     add_meta_box('movie_id', 'My Metabox', 'movie_metabox_callback', 'movie');
 }

 add_action('add_meta_boxes', 'ct_add_meta_boxes');

 function movie_metabox_callback($post)
 {
     $movie_name   = get_post_meta($post->ID, '_movie_name', true);
     $release_year = get_post_meta($post->ID, '_release_year', true);
     $movie_type   = get_post_meta($post->ID, '_movie_type', true);
     $actor_name   = get_post_meta($post->ID, '_actor_name', true); ?>
<table>
    <tr>
        <td>Teaser Url:</td>
        <td>
            <input type="text" name="movie_name"
                value="<?php echo ct_save_movie_metabox_value($movie_name); ?>" />
        </td>
    </tr>
    <tr>
        <td>Release Year:</td>
        <td>
            <input type="text" name="release_year"
                value="<?php echo ct_save_movie_metabox_value($release_year); ?>" />
        </td>
    </tr>
    <tr>
        <td>Actor:</td>
        <td>
            <input type="text" name="actor_name"
                value="<?php echo ct_save_movie_metabox_value($actor_name); ?>" />
        </td>
    </tr>
    <tr>
        <td>Video Type: </td>
        <td>
            <select name="movie_type">
                <option value="" disabled>Select One</option>
                <option value="Dh" <?php selected('HD', ct_save_movie_metabox_value($movie_type)); ?>>HD
                </option>
                <option value="Dh" <?php selected('HD', ct_save_movie_metabox_value($movie_type)); ?>>HD
                </option>
                <option value="SD">SD</option>
            </select>
        </td>
    </tr>
</table>
<?php
 }

  /**
   * Save movie meta box value
   *
   * @param [type] $post_id
   * @return void
   */
  function ct_save_movie_metabox($post_id)
  {
      if (isset($_POST['movie_name'])) {
          update_post_meta($post_id, '_movie_name', esc_url_raw($_POST['movie_name']));
      }
      if (isset($_POST['release_year'])) {
          update_post_meta($post_id, '_release_year', esc_url_raw($_POST['release_year']));
      }
      if (isset($_POST['actor_name'])) {
          update_post_meta($post_id, '_actor_name', esc_url_raw($_POST['actor_name']));
      }

      if (isset($_POST['movie_type'])) {
          update_post_meta($post_id, '_movie_type', true);
      } else {
          update_post_meta($post_id, '_movie_type', true);
      }
  }

  add_action('save_post', 'ct_save_movie_metabox');

  function ct_save_movie_metabox_value($value)
  {
      if (isset($value) && !empty($value)) {
          return $value;
      } else {
          return '';
      }
  }

  // Show a custom login message above the login form
  function ct_custom_login_message($message)
  {
      if (empty($message)) {
          $message = __('Hey, you are welcome here.', 'child-theme');
          return '<h4>' . $message . '</h4>';
      } else {
          return $message;
      }
  }

  add_filter('login_message', 'ct_custom_login_message');

  // Create a custom action hook
  add_action('ct_custom_action_hook', 'ct_custom_action_hook_cb');
  function ct_custom_action_hook_cb()
  {
      // echo '<h3>Hello from First Custom Action Hook!</h3>';
  }

  if (is_admin()) {
      do_action('ct_custom_action_hook');
  }

  // Deep of hook includes action and filter
  add_shortcode('ct_custom_hook_demo', 'ct_shortcode_cb');
  function ct_shortcode_cb($arguments)
  {
      ob_start();

      // set an action hook to run before you output anything
      do_action('the_topmost_custom_action');

      // define your variables which you want to allow to be filtered
      $quote_content = 'Z.E.R.O. That\'s the number of people who\'d like to have any website autoplay music on their browsers.';
      $quote_author  = "John Doe nuts";

      // create your custom filters after you've set the variables
      $quote_content = apply_filters('custom_quote_content', $quote_content);
      $quote_author  = apply_filters('custom_quote_author', $quote_author);

      // build the shortcode output template
      echo "<div style=\"border:3px solid #5333ed;\"><blockquote style=\"margin:20px;border-color:#5333ed;\">";
      echo $quote_content;
      echo "<br><br>";
      echo "― <strong>" . $quote_author . "</strong>";
      echo "</blockquote></div>";

      // set an action hook to run after you output everything
      do_action('the_ending_custom_action');

      return ob_get_clean();
  }

  add_filter('custom_quote_content', 'modify_custom_quote_content');
  function modify_custom_quote_content($quote_content)
  {
      $quote_content = '<strong>' . $quote_content . '</strong>';
      return $quote_content;
  }

  add_filter('custom_quote_author', 'modify_custom_quote_author');
  function modify_custom_quote_author($quote_author)
  {
      $quote_author = '<h5>' . $quote_author . '</h5>';
      return $quote_author;
  }

  // Add end action hook
  add_action('the_ending_custom_action', 'ct_the_ending_custom_action_cb');
  function ct_the_ending_custom_action_cb()
  {
      echo '<button>Get more quote.</button>';
  }

  /**
   * No need to run if/ while have post query
   *
   * TODO: [NOTE] be present $post word in foreach loop
   * Otherwise wont work
   * It's not true
   * Its confusing but its true
   */

 function ct_get_posts() {?>
<ul>
    <?php
   global $post; // this is an optional I found
    $myposts = get_posts(array(
     'posts_per_page' => 5,
     'offset'         => 2,
     'category'       => 1,
    ));

    if ($myposts) {
        foreach ($myposts as $myPost):
     setup_postdata($myPost); ?>
    <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <p><?php the_excerpt(); ?>
        </p>
    </li>
    <?php endforeach;
        wp_reset_postdata();
    }?>
</ul>
<?php }

  /**
   * Add a sidebar.
   */
  add_action('widgets_init', 'ct_slug_widgets_init');
  function ct_slug_widgets_init()
  {
      register_sidebar(array(
    'name'          => __('Blog Sidebar', 'textdomain'),
    'id'            => 'blog-sidebar',
    'description'   => __('Widgets in this area will be shown on all posts and pages.', 'textdomain'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>',
   ));

      register_sidebar(array(
    'name'          => __('Shop Sidebar', 'textdomain'),
    'id'            => 'shop-sidebar',
    'description'   => __('Widgets in this area will be shown on all shop pages.', 'textdomain'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="shop-widget-title">',
    'after_title'   => '</h2>',
   ));
  }

  $posts_to_exclude = array( 1, 2, 3 );
  $foo_query        = new WP_Query(array(
   'post_type'      => 'post',
   'posts_per_page' => 1 + count($posts_to_exclude),
  ));

  if ($foo_query->have_posts()):
   while ($foo_query->have_posts()):
    $foo_query->the_post();

    if (in_array(get_the_ID(), $posts_to_exclude)) {
        continue;
    }

    // the_title();

   endwhile;
  endif;

  // Change WooCommerce Shop page columns
  // add_filter('loop_shop_columns', 'ct_shop_loop_columns');
  function ct_shop_loop_columns($nc)
  {
      return 4; // number of columns - max 6 per columns
  }

  // exclude product/s from shop page with id
  add_filter('woocommerce_product_query', 'ct_exclude_product');
  function ct_exclude_product($wq)
  {
      $wq->set('post__not_in', array( 4057, 4049 ));
      return $wq;
  }

  // exclude product/s from specific category from shop page with id
  add_filter('woocommerce_product_query', 'ct_exclude_product_cat');
  function ct_exclude_product_cat($wq)
  {
      $tax_query   = (array) $wq->get('tax_query');
      $tax_query[] = array(
    'taxonomy' => 'product_cat',
    'field'    => 'slug',
    'terms'    => array( 'accessories' ),
    'operator' => 'NOT IN',
   );

      $wq->set('tax_query', $tax_query);
      return $wq;
  }
