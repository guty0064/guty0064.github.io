<?php
/**
 * blogger buzz functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blogger_buzz
 */

if ( ! function_exists( 'blogger_buzz_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blogger_buzz_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on blogger buzz, use a find and replace
		 * to change 'blogger-buzz' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'blogger-buzz', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for post formats
		 *
		 * @link https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array( 'gallery', 'audio', 'image', 'video' ));

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'blogger-buzz' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'blogger_buzz_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'blogger_buzz_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blogger_buzz_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'blogger_buzz_content_width', 640 );
}
add_action( 'after_setup_theme', 'blogger_buzz_content_width', 0 );

/**
 * Enables the Excerpt meta box in Page edit screen.
 */
function blogger_buzz_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'blogger_buzz_add_excerpt_support_for_pages' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blogger_buzz_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar Widget Area', 'blogger-buzz' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar Widget Area', 'blogger-buzz' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Popup Sidebar Widget Area', 'blogger-buzz' ),
		'id'            => 'sidenav',
		'description'   => esc_html__( 'Add widgets here.[ Note: Displays Only In Header Layout One And Two. ]', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area One', 'blogger-buzz' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area Two', 'blogger-buzz' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area Three', 'blogger-buzz' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'blogger-buzz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'blogger_buzz_widgets_init' );

if ( ! function_exists( 'blogger_buzz_font_url' ) ) :

	/**
	 * Register Google fonts for Blogger Buzz
	 *
	 * Create your own blogger_buzz_font_url() function to override in a child theme.
	 *
	 * @since Blogger Buzz 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */

    function blogger_buzz_font_url() {

        $fonts_url = '';

        $font_families = array();

        if ( 'off' !== _x( 'on', 'Roboto: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Roboto:300,300i,400,400i,500,500i,700,700i';
        }

        if ( 'off' !== _x( 'on', 'Lato: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Lato:300,300i,400,400i,700,700i,900,900i';
        }

        if ( 'off' !== _x( 'on', 'Josefin+Sans: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Josefin+Sans:300,300i,400,400i,600,600i,700,700i';
        }

        if ( 'off' !== _x( 'on', 'Allura: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Allura';
        }

        if ( 'off' !== _x( 'on', 'Engagement: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Engagement';
        }

        if ( 'off' !== _x( 'on', 'Arizonia: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Arizonia';
        }

        if ( 'off' !== _x( 'on', 'Niconne: on or off', 'blogger-buzz' ) ) {
            $font_families[] = 'Niconne';
        }

        if( $font_families ) {

            $query_args = array(

                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url ( $fonts_url );
    }

endif;

/**
 * Enqueue scripts and styles.
 */
function blogger_buzz_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'blogger-buzz-fonts', blogger_buzz_font_url(), array(), null );

	// Load Font-awesome CSS Library File
	wp_enqueue_style( 'fontawesome', get_template_directory_uri(). '/assets/library/font-awesome/css/fontawesome.css' );

	// Load owlcarousel CSS Library File
	wp_enqueue_style( 'owlcarousel', get_template_directory_uri(). '/assets/library/owlcarousel/css/owl.carousel'. esc_attr ( $min ) .'.css' );

	// Load bootstrap CSS Library File
	wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/assets/library/bootstrap/css/bootstrap'. esc_attr ( $min ) .'.css' );


    //Load Lightslider CSS Library File
    wp_enqueue_style( 'lightslider', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/library/lightslider/css/lightslider' . esc_attr( $min ) . '.css' );

	wp_enqueue_style( 'blogger-buzz-style', get_stylesheet_uri() );

	if ( has_header_image() ) {
		$custom_css = '.bz_main_header{ background-image: url("' . esc_url( get_header_image() ) . '"); background-repeat: no-repeat; background-position: center center; background-size: cover; }';
		wp_add_inline_style( 'blogger-buzz-style', $custom_css );
	}

	//responsive
	wp_enqueue_style( 'responsive', get_template_directory_uri(). '/assets/css/responsive.css');

	//bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/library/bootstrap/js/bootstrap'. esc_attr ( $min ) .'.js', array('jquery'), '4.3.0', true );

	//owlcarousel
	wp_enqueue_script( 'owlcarousel', get_template_directory_uri() . '/assets/library/owlcarousel/js/owl.carousel'. esc_attr ( $min ) .'.js', array('jquery'), '2.3.4', true );
	
	// Load Lightslider JavScript Library File
    wp_enqueue_script( 'lightslider', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/library/lightslider/js/lightslider' . esc_attr( $min ) . '.js', array('jquery'), '1.1.6' );
	
	//theia-sticky
	wp_enqueue_script( 'theia-sticky', get_template_directory_uri() . '/assets/library/theia-sticky-sidebar/js/theia-sticky-sidebar.min.js', array('jquery'), true );

    //sticky-js
    wp_enqueue_script( 'sticky-nav', get_template_directory_uri() . '/assets/library/sticky-js/jquery.sticky.js', array('jquery'), true );

	//Main 
	wp_enqueue_script( 'blogger-buzz', get_template_directory_uri() . '/assets/js/blogger-buzz.js', array('jquery'), true );

	// Localize the script with new data
	$sticky_sidebar = get_theme_mod( 'blogger_buzz_sidebar','disable' );
	$slider_column = get_theme_mod('blogger_buzz_banner_slider_column', 3);

	wp_localize_script('blogger-buzz', 'blogger_buzz_script', array(
		'sticky_sidebar' => $sticky_sidebar,
		'home_banner_slider_column' => $slider_column
    ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blogger_buzz_scripts' );

/**
 * Admin Enqueue scripts and styles.
*/
if ( ! function_exists( 'blogger_buzz_admin_scripts' ) ) {

    function blogger_buzz_admin_scripts( $hook ) {

    	//if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' && 'widgets.php' != $hook )

        //return;
        
        wp_enqueue_style( 'blogger-buzz-admin', get_template_directory_uri() . '/assets/css/bloggerbuzz-admin.css'); 

        wp_enqueue_script('blogger-buzz-admin', get_template_directory_uri() . '/assets/js/bloggerbuzz-admin.js', array( 'jquery', 'customize-controls' ) );    
    }
}
add_action('admin_enqueue_scripts', 'blogger_buzz_admin_scripts');

/**
 * Load Files.
 */
require get_template_directory() . '/inc/init.php';

add_filter('sparkle_demo_import_config', function(){
	return array(
		'demo-one' => array(
			'name' => 'Blogger Buzz - Main',
			'external_url' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-one/demo-one.zip',
			'image' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-one/demo-one.png',
			'preview_url' => 'https://demo.sparklewpthemes.com/bloggerbuzz/',
			'menuArray' => array(
				'menu-1' => 'Main Menu'
			),
			'home_slug' => '',
			'tags' => array(
				'free'     => 'Free',
			),
			'categories' => array( 
				'woocommerce' => 'WooCommerce'
			),/*Categories*/
			'pagebuilder' => array(
				'widget' => "Widgets",
			),
			'plugins' => array(
				'contact-form-7' => array(
					'name' => 'Contact Form 7',
					'source' => 'wordpress',
					'file_path' => 'contact-form-7/wp-contact-form-7.php'
				),
				'woocommerce' => array(
					'name' => 'WooCommerce',
					'source' => 'wordpress',
					'file_path' => 'woocommerce/woocommerce.php',
				),
				'yith-woocommerce-compare' => array(
					'name' => 'YITH WooCommerce Compare',
					'source' => 'wordpress',
					'file_path' => 'yith-woocommerce-compare/init.php',
				),
				'yith-woocommerce-quick-view' => array(
					'name' => 'YITH WooCommerce Quick View',
					'file_path' => 'yith-woocommerce-quick-view/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				)
	
			),
		),
		'demo-two' => array(
			'name' => 'Blogger Buzz',
			'external_url' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-two/demo-two.zip',
			'image' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-two/demo-two.png',
			'preview_url' => 'https://demo.sparklewpthemes.com/bloggerbuzz/sample-v1/',
			'menuArray' => array(
				'menu-1' => 'Main Menu'
			),
			'home_slug' => '',
			'tags' => array(
				'free'     => 'Free',
			),
			'categories' => array( 
				'woocommerce' => 'WooCommerce'
			),/*Categories*/
			'pagebuilder' => array(
				'widget' => "Widgets",
			),
			'plugins' => array(
				'contact-form-7' => array(
					'name' => 'Contact Form 7',
					'source' => 'wordpress',
					'file_path' => 'contact-form-7/wp-contact-form-7.php'
				),
				'woocommerce' => array(
					'name' => 'WooCommerce',
					'source' => 'wordpress',
					'file_path' => 'woocommerce/woocommerce.php',
				),
				'yith-woocommerce-compare' => array(
					'name' => 'YITH WooCommerce Compare',
					'source' => 'wordpress',
					'file_path' => 'yith-woocommerce-compare/init.php',
				),
				'yith-woocommerce-quick-view' => array(
					'name' => 'YITH WooCommerce Quick View',
					'file_path' => 'yith-woocommerce-quick-view/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				)
	
			),
		),
		'demo-three' => array(
			'name' => 'Blogger Buzz',
			'external_url' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-three/demo-three.zip',
			'image' => 'https://demo.sparklewpthemes.com/demo-data/bloggerbuzz/demo-three/demo-three.png',
			'preview_url' => 'https://demo.sparklewpthemes.com/bloggerbuzz/sample-v2/',
			'menuArray' => array(
				'menu-1' => 'Main Menu'
			),
			'home_slug' => '',
			'tags' => array(
				'free'     => 'Free',
			),
			'categories' => array( 
				'woocommerce' => 'WooCommerce'
			),/*Categories*/
			'pagebuilder' => array(
				'widget' => "Widgets",
			),
			'plugins' => array(
				'contact-form-7' => array(
					'name' => 'Contact Form 7',
					'source' => 'wordpress',
					'file_path' => 'contact-form-7/wp-contact-form-7.php'
				),
				'woocommerce' => array(
					'name' => 'WooCommerce',
					'source' => 'wordpress',
					'file_path' => 'woocommerce/woocommerce.php',
				),
				'yith-woocommerce-compare' => array(
					'name' => 'YITH WooCommerce Compare',
					'source' => 'wordpress',
					'file_path' => 'yith-woocommerce-compare/init.php',
				),
				'yith-woocommerce-quick-view' => array(
					'name' => 'YITH WooCommerce Quick View',
					'file_path' => 'yith-woocommerce-quick-view/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				),
				'yith-woocommerce-wishlist' => array(
					'name' => 'YITH WooCommerce Wishlist',
					'file_path' => 'yith-woocommerce-wishlist/init.php',
					'source' => 'wordpress',
				)
	
			),
		),
	); // tested
});