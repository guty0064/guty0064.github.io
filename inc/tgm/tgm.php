<?php
/**
 * Recommended plugins
 *
 * @package Blogger Buzz
 */

if ( ! function_exists( 'blogger_buzz_recommended_plugins' ) ) :

	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function blogger_buzz_recommended_plugins() {

		$plugins = array(

			array(
				'name'     => esc_html__( 'Custom Feeds for Instagram', 'blogger-buzz' ),
				'slug'     => 'instagram-feed',
				'required' => false,
			),
			
            array(
				'name'     => esc_html__( 'Contact Form 7', 'blogger-buzz' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'Regenerate Thumbnails', 'blogger-buzz' ),
				'slug'     => 'regenerate-thumbnails',
				'required' => false,
			),

			array(
	            'name' => esc_html__( 'Loco Translate', 'blogger-buzz' ),
	            'slug' => 'loco-translate',
	            'required' => false,
            ),

			array(
				'name'     => esc_html__( 'WooCommerce', 'blogger-buzz' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),

			array(
				'name' => esc_html__( 'AccessPress Social Share', 'blogger-buzz' ),
				'slug' => 'accesspress-social-share',
				'required' => false,
            )
            
		);

		tgmpa( $plugins );

	}

endif;

add_action( 'tgmpa_register', 'blogger_buzz_recommended_plugins' );
