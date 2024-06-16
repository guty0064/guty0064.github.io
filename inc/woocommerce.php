<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package blogger_buzz
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function blogger_buzz_woocommerce_setup() {

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}
add_action( 'after_setup_theme', 'blogger_buzz_woocommerce_setup' );


/**
 * Load woocommerce Action and Filter.
*/
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);


/**
 * Load woocommerce Action and Filter.
*/
if (!function_exists('blogger_buzz_woocommerce_breadcrumb')) {
  
  function blogger_buzz_woocommerce_breadcrumb(){

    do_action( 'blogger_buzz_woocommerce' );

  }
}
add_action( 'woocommerce_before_main_content','blogger_buzz_woocommerce_breadcrumb', 9 );

/**
 * WooCommerce add content primary div function
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

if (!function_exists('blogger_buzz_woocommerce_output_content_wrapper')) {
    function blogger_buzz_woocommerce_output_content_wrapper(){ ?>
    	<div class="container">
        <div class="row">
          <div id="primary" class="content-area col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <main id="main" class="site-main">
              <div class="blog-style single-page">
    <?php }
}
add_action( 'woocommerce_before_main_content', 'blogger_buzz_woocommerce_output_content_wrapper', 10 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if (!function_exists('blogger_buzz_woocommerce_output_content_wrapper_end')) {
    function blogger_buzz_woocommerce_output_content_wrapper_end(){ ?>
              </div>
            </main>
          </div>

          <?php get_sidebar('woocommerce'); ?>

        </div>
      </div>
    <?php }
}
add_action( 'woocommerce_after_main_content', 'blogger_buzz_woocommerce_output_content_wrapper_end', 10 );

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/**
 * Woo Commerce Number of row filter Function
*/
add_filter('loop_shop_columns', 'blogger_buzz_loop_columns');
if (!function_exists('blogger_buzz_loop_columns')) {
    function blogger_buzz_loop_columns() {
        return 3;
    }
}

add_action( 'body_class', 'blogger_buzz_woo_body_class');
if (!function_exists('blogger_buzz_woo_body_class')) {
    function blogger_buzz_woo_body_class( $class ) {
           $class[] = 'columns-'.intval(blogger_buzz_loop_columns());
           return $class;
    }
}

/**
 * WooCommerce display related product.
*/
if (!function_exists('blogger_buzz_related_products_args')) {
  function blogger_buzz_related_products_args( $args ) {
      $args['posts_per_page']   = 6;
      $args['columns']          = 3;
      return $args;
  }
}
add_filter( 'woocommerce_output_related_products_args', 'blogger_buzz_related_products_args' );

/**
 * WooCommerce display upsell product.
*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
if ( ! function_exists( 'blogger_buzz_woocommerce_upsell_display' ) ) {
  function blogger_buzz_woocommerce_upsell_display() {
      woocommerce_upsell_display( 6, 3 ); 
  }
}
add_action( 'woocommerce_after_single_product_summary', 'blogger_buzz_woocommerce_upsell_display', 15 );
