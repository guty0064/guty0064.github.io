<?php 
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Customizer Control additions.
 */
require get_template_directory() . '/inc/customizer/custom-control.php';

/**
 * Customizer Sanitize additions.
 */
require get_template_directory() . '/inc/customizer/sanitize.php';

/**
 * Customizer Callback additions.
 */
require get_template_directory() . '/inc/customizer/callback.php';

/**
 * Customizer Dynamic additions.
 */
require get_template_directory() . '/inc/customizer/dynamic.php';

/**
 * Recent Posts Widget.
 */
require get_template_directory() . '/inc/widgets/recent-posts.php';

/**
 * About Widget.
 */
require get_template_directory() . '/inc/widgets/about.php';

/**
 * Fontawesome.
 */
require get_template_directory() . '/inc/customizer/fontawesome.php';

/**
 * Breadcrumbs.
 */
require get_template_directory() . '/inc/breadcrumbs/breadcrumbs.php';


/**
 * Load in customizer upgrade to pro
*/
require get_template_directory() .'/inc/customizer-pro/class-customize.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {

    require get_theme_file_path('inc/woocommerce.php');

}

/**
 * Load Admin Welcome Page.
 */
if ( is_admin() ) {
	require get_template_directory() . '/welcome/welcome.php';
}

/**
 * Load TMG libraries.
 */
require get_template_directory() .'/inc/tgm/tgm.php';
require get_template_directory() .'/inc/tgm/class-tgm-plugin-activation.php';