<?php
/**
 * blogger buzz Theme Customizer
 *
 * @package blogger_buzz
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogger_buzz_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	if ( isset( $wp_customize->selective_refresh ) ) {
		
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'blogger_buzz_customize_partial_blogname',
		) );
		
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'blogger_buzz_customize_partial_blogdescription',
		) );
	}



	// List All Category
	$categories = get_categories();
	$blog_cat = array();

	foreach ($categories as $category) {
	    $blog_cat[$category->term_id] = $category->name;
	}

	/**
	 * Site Identity Typography.
	*/
	$wp_customize->add_setting('blogger_buzz_site_title_font_family', array(
		'default' => 'arizonia',
		'sanitize_callback' => 'blogger_buzz_sanitize_select'         //done
	));

	$wp_customize->add_control('blogger_buzz_site_title_font_family', array(
		'label'   => esc_html__('Site Title Font Family','blogger-buzz'),
		'section' => 'title_tagline',
		'type'    => 'select',
		'choices' => array(
			'arizonia'     => esc_html__('Arizonia','blogger-buzz'),
			'engagement'   => esc_html__('Engagement','blogger-buzz'),
			'allura'       => esc_html__('Allura','blogger-buzz'),
			'niconne'      => esc_html__('Niconne','blogger-buzz'),	

	)));

	//site title font size.
	$wp_customize->add_setting( 'blogger_buzz_site_title_font_size', array(
		'default'  => 80,
		'sanitize_callback' => 'sanitize_text_field', 	 //done	
	));

	$wp_customize->add_control( 'blogger_buzz_site_title_font_size', array(
		'label'		  => esc_html__( 'Enter Site Title Font Size', 'blogger-buzz' ),
		'section'	  => 'title_tagline',
		'type' 		  => 'number',
	    'input_attrs' => array('min' => 20, 'max' => 200, 'step' => 1 ),
	));

	$wp_customize->add_setting('title_tagline_upgrade_text', array(
        'sanitize_callback' => 'blogger_buzz_sanitize_text'
    	));

    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'title_tagline_upgrade_text', array(
	'section' => 'title_tagline',
	'label' => esc_html__('For more settings,', 'blogger-buzz'),
	'choices' => array(
	    esc_html__('Change Title color', 'blogger-buzz'),
	    esc_html__('Change Tagline color', 'blogger-buzz'),
	),
	'priority' => 100
    )));

	/**
	 * Social Links.
	*/
	$wp_customize->add_section('blogger_buzz_theme_layout_section', array(
		'title'		=>	esc_html__('Theme Layout Settings','blogger-buzz'),
		'priority'	=> 2,
	));

		// Enable or Disable Blog Meta.
		$wp_customize->add_setting('blogger_buzz_sidebar', array(
		    'default'           => 'disable',
		    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_sidebar', array(
		    'label'        => esc_html__('Enable Sticky Sidebar', 'blogger-buzz'),
		    'section'      => 'blogger_buzz_theme_layout_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'blogger-buzz'),
		        'disable' => esc_html__('Disable', 'blogger-buzz'),
		    ),
		)));

		$wp_customize->add_setting('blogger_buzz_theme_layout_section_upgrade_text', array(
	        'sanitize_callback' => 'blogger_buzz_sanitize_text'
	    ));

	    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_theme_layout_section_upgrade_text', array(
	        'section' => 'blogger_buzz_theme_layout_section',
	        'label' => esc_html__('For more settings,', 'blogger-buzz'),
	        'choices' => array(
	            esc_html__('Change Theme Layout', 'blogger-buzz'),
	            esc_html__('Customize Single Post Page Sidebar', 'blogger-buzz'),
	            esc_html__('Customize Search Page Sidebar', 'blogger-buzz'),
	            esc_html__('Customize Page Sidebar', 'blogger-buzz'),
	        ),
	        'priority' => 100
	    )));

	/**
	 * Header layout.
	*/
	$wp_customize->add_panel('blogger_buzz_header_panel', array(
        'priority'       => 3,
        'title'          => esc_html__( 'Header Settings', 'blogger-buzz' ),
	));

		/* Site Identity. */
		$wp_customize->get_section( 'title_tagline' )->panel = 'blogger_buzz_header_panel';
		$wp_customize->get_section( 'title_tagline' )->priority = 1;


		/* Header Layout. */
		$wp_customize->add_section('blogger_buzz_header_section', array(
			'title'		=>	esc_html__('Header Layout Settings','blogger-buzz'),
			'panel'     => 'blogger_buzz_header_panel',
			'priority'	=> 2,
		));


			// Header Layout.
			$wp_customize->add_setting('blogger_buzz_header_layout', array(
				'default' => 'layout_one',
				'sanitize_callback' => 'blogger_buzz_sanitize_select'         //done
			));

			$wp_customize->add_control('blogger_buzz_header_layout', array(
				'label'   => esc_html__('Header Layout','blogger-buzz'),
				'section' => 'blogger_buzz_header_section',
				'type'    => 'select',
				'choices' => array(
					'layout_one'   => esc_html__('Layout One','blogger-buzz'),
					'layout_two'   => esc_html__('Layout Two','blogger-buzz'),
					'layout_three' => esc_html__('Layout Three','blogger-buzz'),	
			)));

			// Enable or Disable Header Sticky.
			$wp_customize->add_setting('blogger_buzz_enable_header_sticky', array(
			    'default'           => 'enable',
			    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_header_sticky', array(
			    'label'           => esc_html__('Enable Header Sticky', 'blogger-buzz'),
			    'section'         => 'blogger_buzz_header_section',
			    'switch_label'    => array(
			        'enable'  => esc_html__('Enable', 'blogger-buzz'),
			        'disable' => esc_html__('Disable', 'blogger-buzz'),
			    ),
			)));

			// Enable or Disable Search Icon.
			$wp_customize->add_setting('blogger_buzz_enable_search_icon', array(
			    'default'           => 'enable',
			    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_search_icon', array(
			    'label'           => esc_html__('Enable Search Icon', 'blogger-buzz'),
			    'section'         => 'blogger_buzz_header_section',
			    'active_callback' => 'blogger_buzz_header',
			    'switch_label'    => array(
			        'enable'  => esc_html__('Enable', 'blogger-buzz'),
			        'disable' => esc_html__('Disable', 'blogger-buzz'),
			    ),
			)));

			// Enable or Disable Sidenav.
			$wp_customize->add_setting('blogger_buzz_enable_sidenav', array(
			    'default'           => 'enable',
			    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_sidenav', array(
			    'label'           => esc_html__('Enable Sidenav', 'blogger-buzz'),
			    'section'         => 'blogger_buzz_header_section',
			    'active_callback' => 'blogger_buzz_header',
			    'switch_label'    => array(
			        'enable'  => esc_html__('Enable', 'blogger-buzz'),
			        'disable' => esc_html__('Disable', 'blogger-buzz'),
			    ),
			)));

			$wp_customize->add_setting('blogger_buzz_header_section_upgrade_text', array(
		        'sanitize_callback' => 'blogger_buzz_sanitize_text'
		    ));

		    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_header_section_upgrade_text', array(
		        'section' => 'blogger_buzz_header_section',
		        'label' => esc_html__('For more settings and controls,', 'blogger-buzz'),
		        'choices' => array(
		        	esc_html__('Two More Header Layouts', 'blogger-buzz'),
		            esc_html__('Upload Ads Image', 'blogger-buzz'),
		            esc_html__('Change Top Header Background Color', 'blogger-buzz'),
		            esc_html__('Change Top Header Text and Hover Color', 'blogger-buzz'),
		            esc_html__('Change Main Menu Background Color', 'blogger-buzz'),
		            esc_html__('Change Main Menu Font and Hover/Active Color', 'blogger-buzz'),
		        ),
		        'priority' => 100
		    )));

		/**
		 * Header Image
		*/
		$wp_customize->get_section( 'header_image' )->panel = 'blogger_buzz_header_panel';
		$wp_customize->get_section( 'header_image' )->priority = 3;
		$wp_customize->get_section( 'header_image' )->title = esc_html__('Header Background Image', 'blogger-buzz');

		$wp_customize->add_setting('header_image_upgrade_text', array(
	        'sanitize_callback' => 'blogger_buzz_sanitize_text'
	    ));

	    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'header_image_upgrade_text', array(
	        'section' => 'header_image',
	        'label' => esc_html__('For more settings,', 'blogger-buzz'),
	        'choices' => array(
	            esc_html__('Adjust Header Height', 'blogger-buzz'),
	            esc_html__('Customize Header Background Color', 'blogger-buzz'),
	        ),
	        'priority' => 100
	    )));

	/**
	 * Theme Default Color
	*/
	//$wp_customize->get_section( 'colors' )->panel = 'blogger_buzz_general_settings';
	$wp_customize->get_section( 'colors' )->priority = 4;
	$wp_customize->get_section( 'colors' )->title = esc_html__('Primary Color Settings', 'blogger-buzz');

	/**
	 * Social Links.
	*/
	$wp_customize->add_section('blogger_buzz_social_links_section', array(
		'title'		=>	esc_html__('Social Media Links Settings','blogger-buzz'),
		'priority'	=> 5,
	));

		$wp_customize->add_setting('blogger_buzz_social_links', array(
		    'sanitize_callback' => 'blogger_buzz_sanitize_repeater',		//done
		    'default' => json_encode(array(
		        array(
		            'social_icon' =>'fab fa-facebook-f',
		            'social_link'   => '',
		        )
		    ))
		));

		$wp_customize->add_control( new Blogger_Buzz_Repeater_Control( $wp_customize, 
			'blogger_buzz_social_links', 

			array(
			    'label' 	   => esc_html__('Social Links Settings', 'blogger-buzz'),
			    'section' 	   => 'blogger_buzz_social_links_section',
			    'bb_box_label' => esc_html__('Social Links Options', 'blogger-buzz'),
			    'bb_box_add_control' => esc_html__('Add New', 'blogger-buzz'),
			),

		    array(

		        'social_icon' => array(
		            'type' => 'icons',
		            'label' => esc_html__('Choose Icon', 'blogger-buzz'),
		            'default' => 'fab fa-facebook-f'
		        ),
		        
		        'social_link' => array(
		            'type' => 'url',
		            'label' => esc_html__('Enter Social Link', 'blogger-buzz'),
		            'default' => ''
		        )
		)));


	/**
	 * Main Banner Slider Settings
	*/
	$wp_customize->add_section('blogger_buzz_banner_section', array(
		'title'		=>	esc_html__('Main Slider Posts Settings','blogger-buzz'),
		'priority'  => 6
	));

		//Banner Slider.
		$wp_customize->add_setting( 'blogger_buzz_banner', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
		));

		$wp_customize->add_control( new Blogger_Buzz_Multiple_Check_Control($wp_customize, 
			'blogger_buzz_banner', array(
				'label'		=> esc_html__( 'Select Multiple Category', 'blogger-buzz' ),
				'section'	=> 'blogger_buzz_banner_section',
				'choices'	=> $blog_cat,
		)));

		// Slider Button.
		$wp_customize->add_setting( 'blogger_buzz_banner_button', array(
			'sanitize_callback' => 'sanitize_text_field', 	 //done	
			'default' => 'Read More'
		));

		$wp_customize->add_control( 'blogger_buzz_banner_button', array(
				'label'		=> esc_html__( 'Enter Button Text', 'blogger-buzz' ),
				'section'	=> 'blogger_buzz_banner_section',
				'type'	    => 'text',
		));
		
		$wp_customize->add_setting( 'blogger_buzz_banner_slider_column', array(
			'sanitize_callback' => 'blogger_buzz_sanitize_select', 	 //done	
			'default' => 3
		));

		$wp_customize->add_control( 'blogger_buzz_banner_slider_column', array(
				'label'		=> esc_html__( 'Slider Column', 'blogger-buzz' ),
				'section'	=> 'blogger_buzz_banner_section',
				'type'	    => 'select',
				'choices'	=> array(
					'1'		=> esc_html__( '1 Column', 'blogger-buzz' ),
					'2'		=> esc_html__( '2 Column', 'blogger-buzz' ),
					'3'		=> esc_html__( '3 Column', 'blogger-buzz' ),
				)
		));

		$wp_customize->selective_refresh->add_partial( 'blogger_buzz_banner_button', array(
			'selector'        => '.bz_slider .transparent_button',
		) );

		$wp_customize->add_setting('blogger_buzz_banner_section_upgrade_text', array(
	        'sanitize_callback' => 'blogger_buzz_sanitize_text'
	    ));

	    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_banner_section_upgrade_text', array(
	        'section' => 'blogger_buzz_banner_section',
	        'label' => esc_html__('For more layouts and controls,', 'blogger-buzz'),
	        'choices' => array(
	            esc_html__('Enable/Disable Main Slider', 'blogger-buzz'),
	            esc_html__('Select Banner Layout', 'blogger-buzz'),
	            esc_html__('Change main slider width', 'blogger-buzz'),
	            esc_html__('Display Posts by a specific category or all', 'blogger-buzz'),
	            esc_html__('Change number of display slider posts', 'blogger-buzz'),
	            esc_html__('Change posts information display position', 'blogger-buzz'),
	            esc_html__('Change main slider arrow layout', 'blogger-buzz'),
	        ),
	        'priority' => 100
	    )));		


	/**
	 * Homepage Blog Posts.
	*/
	$wp_customize->add_panel('blogger_buzz_homepage_blog_posts', array(
		'title'		=>	esc_html__('Home / Category Posts Settings','blogger-buzz'),
		'priority'	=> 7,
	));

		/**
		 * Featured Blog Posts.
		*/
		$wp_customize->add_section('blogger_buzz_featured_blog_section', array(
			'title'		=>	esc_html__('Featured Posts Settings','blogger-buzz'),
			'panel'     => 'blogger_buzz_homepage_blog_posts',
			'priority'	=> 1,
		));

			// Enable or Disable Featured Blog Posts.
			$wp_customize->add_setting('blogger_buzz_enable_featured_posts', array(
			    'default'           => 'disable',
			    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_featured_posts', array(
			    'label'        => esc_html__('Enable Featured Posts To Display', 'blogger-buzz'),
			    'section'      => 'blogger_buzz_featured_blog_section',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'blogger-buzz'),
			        'disable' => esc_html__('Disable', 'blogger-buzz'),
			    ),
			)));


			// Featured Blog Posts.
			$wp_customize->add_setting( 'blogger_buzz_featured_blog', array(
				'sanitize_callback' => 'sanitize_text_field', 	 //done	
			));

			$wp_customize->add_control( new Blogger_Buzz_Multiple_Check_Control($wp_customize, 
				'blogger_buzz_featured_blog', array(
					'label'			  => esc_html__( 'Select Multiple Category', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_featured_blog_section',
					'choices'		  => $blog_cat,
					'active_callback' => 'blogger_buzz_feature'
			)));

			$wp_customize->selective_refresh->add_partial( 'blogger_buzz_featured_blog', array(
				'selector'        => '.bz_feature .feature_inner',
			) );


		/* General Posts Settings. */
		$wp_customize->add_section('blogger_buzz_blog_layout_general_settings', array(
			'title'		=>	esc_html__('General Posts Settings','blogger-buzz'),
			'panel'	    => 'blogger_buzz_homepage_blog_posts',
			'priority'  => 2
		));


			//Posts Description.
			$wp_customize->add_setting('blogger_buzz_posts_description', array(
				'default' => 'content_excerpt',
				'sanitize_callback' => 'blogger_buzz_sanitize_select'         //done
			));

			$wp_customize->add_control('blogger_buzz_posts_description', array(
				'label'   => esc_html__('Blog Posts Content','blogger-buzz'),
				'section' => 'blogger_buzz_blog_layout_general_settings',
				'type'    => 'select',
				'choices' => array(
					'content_excerpt' => esc_html__('Content Excerpt','blogger-buzz'),
					'no_content'      => esc_html__('No Content','blogger-buzz'),		
			)));
			$wp_customize->selective_refresh->add_partial( 'blogger_buzz_posts_description', array(
				'selector'        => 'article .post_content',
			) );

			// Blog Posts Button Text.
			$wp_customize->add_setting( 'blogger_buzz_post_button_text', array(
				'default' => 'Read More',
				'sanitize_callback' => 'sanitize_text_field', 	 //done	
			));

			$wp_customize->add_control( 'blogger_buzz_post_button_text', array(
				'label'			  => esc_html__( 'Enter Button Text', 'blogger-buzz' ),
				'section'		  => 'blogger_buzz_blog_layout_general_settings',
				'type'	    	  => 'text',
				'active_callback' => 'blogger_buzz_post_content'
			));

			$wp_customize->selective_refresh->add_partial( 'blogger_buzz_post_button_text', array(
				'selector'        => 'article .more-link',
			) );
			// Enable or Disable Blog Posts Meta.
			$wp_customize->add_setting('blogger_buzz_enable_blog_meta', array(
			    'default'           => 'enable',
			    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
			));

			$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_blog_meta', array(
			    'label'        => esc_html__('Enable Post Meta', 'blogger-buzz'),
			    'section'      => 'blogger_buzz_blog_layout_general_settings',
			    'switch_label' => array(
			        'enable' => esc_html__('Enable', 'blogger-buzz'),
			        'disable' => esc_html__('Disable', 'blogger-buzz'),
			    ),
			)));

			//Enable Meta Category.
			$wp_customize->add_setting( 'blogger_buzz_posts_category', array(
				'default' => true,
				'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
			));

			$wp_customize->add_control('blogger_buzz_posts_category', array(
				'label'			  => esc_html__( 'Show Post Meta Category', 'blogger-buzz' ),
				'section'		  => 'blogger_buzz_blog_layout_general_settings',
				'type' 			  => 'checkbox',
				'active_callback' => 'blogger_buzz_blog_meta'
			));

			//Enable Meta Date.
			$wp_customize->add_setting( 'blogger_buzz_posts_date', array(
				'default' => true,
				'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
			));

			$wp_customize->add_control('blogger_buzz_posts_date', array(
				'label'			  => esc_html__( 'Show Post Meta Date', 'blogger-buzz' ),
				'section'		  => 'blogger_buzz_blog_layout_general_settings',
				'type' 			  => 'checkbox',
				'active_callback' => 'blogger_buzz_blog_meta'
			));

			//Enable Meta Author.
			$wp_customize->add_setting( 'blogger_buzz_posts_author', array(
				'default' => true,
				'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
			));

			$wp_customize->add_control('blogger_buzz_posts_author', array(
				'label'			  => esc_html__( 'Show Post Meta Author', 'blogger-buzz' ),
				'section'		  => 'blogger_buzz_blog_layout_general_settings',
				'type' 			  => 'checkbox',
				'active_callback' => 'blogger_buzz_blog_meta'
			));

			//Enable Meta Comments.
			$wp_customize->add_setting( 'blogger_buzz_posts_comments', array(
				'default' => true,
				'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
			));

			$wp_customize->add_control('blogger_buzz_posts_comments', array(
				'label'			  => esc_html__( 'Show Post Meta Comments', 'blogger-buzz' ),
				'section'		  => 'blogger_buzz_blog_layout_general_settings',
				'type' 			  => 'checkbox',
				'active_callback' => 'blogger_buzz_blog_meta'
			));

			$wp_customize->add_setting('blogger_buzz_blog_layout_general_settings_upgrade_text', array(
		        'sanitize_callback' => 'blogger_buzz_sanitize_text'
		    ));

		    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_blog_layout_general_settings_upgrade_text', array(
		        'section' => 'blogger_buzz_blog_layout_general_settings',
		        'label' => esc_html__('For more settings,', 'blogger-buzz'),
		        'choices' => array(
		            esc_html__('Change Image Border', 'blogger-buzz'),
		            esc_html__('Customize Posts Excerpt Length', 'blogger-buzz'),
		            esc_html__('Select Posts Content Alignment', 'blogger-buzz'),
		            esc_html__('Select Posts Title Position', 'blogger-buzz'),
		            esc_html__('Show/Hide Posts View Count', 'blogger-buzz'),
		            esc_html__('Enable/Disable Social Share', 'blogger-buzz'),
		        ),
		        'priority' => 100
		    )));

		/**
		 * Blog Posts Layout
		*/
		$wp_customize->add_section('blogger_buzz_blog_layout_section', array(
			'title'		=>	esc_html__('HomePage Posts Settings','blogger-buzz'),
			'panel'	    => 'blogger_buzz_homepage_blog_posts',
			'priority'  => 3
		));

			// Posts Layout.
			$wp_customize->add_setting('blogger_buzz_blog_layout', array(
				'default' => 'grid_right_sidebar',
				'sanitize_callback' => 'blogger_buzz_sanitize_select'         //done
			));

			$wp_customize->add_control('blogger_buzz_blog_layout', array(
				'label'   => esc_html__('Home Blog Posts Layout','blogger-buzz'),
				'section' => 'blogger_buzz_blog_layout_section',
				'type'    => 'select',
				'choices' => array(
					'grid_right_sidebar'=> esc_html__('List Style / Right Sidebar','blogger-buzz'),
					'grid_left_sidebar' => esc_html__('List Style / Left Sidebar','blogger-buzz'),
					'grid_no_sidebar'   => esc_html__('List Style / No Sidebar','blogger-buzz'),
					'grid_two_rsidebar' => esc_html__('Grid Layout ( Two Columns) / Right Sidebar','blogger-buzz'),
					'grid_two_lsidebar' => esc_html__('Grid Layout ( Two Columns) / Left Sidebar','blogger-buzz'),
					'grid_two_nsidebar' => esc_html__('Grid Layout ( Two Columns) / No Sidebar','blogger-buzz'),
					'split'             => esc_html__('Split Layout','blogger-buzz'),
				)
			));

			$wp_customize->add_setting('blogger_buzz_blog_layout_section_upgrade_text', array(
		        'sanitize_callback' => 'blogger_buzz_sanitize_text'
		    ));

		    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_blog_layout_section_upgrade_text', array(
		        'section' => 'blogger_buzz_blog_layout_section',
		        'label' => esc_html__('For more layouts,', 'blogger-buzz'),
		        'choices' => array(
		            esc_html__('Fifteen Different Layouts to Choose from', 'blogger-buzz'),
		        ),
		        'priority' => 100
		    )));


		/* Archive/Category posts layout. */
		$wp_customize->add_section('blogger_buzz_category_layout_section', array(
			'title'		=>	esc_html__('Category Posts Settings','blogger-buzz'),
			'panel'	    => 'blogger_buzz_homepage_blog_posts',
			'priority'  => 4
		));

		$wp_customize->add_setting('blogger_buzz_category_layout_section_upgrade_text', array(
	        'sanitize_callback' => 'blogger_buzz_sanitize_text'
	    ));

	    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_category_layout_section_upgrade_text', array(
	        'section' => 'blogger_buzz_category_layout_section',
	        'label' => esc_html__('For more settings and controls,', 'blogger-buzz'),
	        'choices' => array(
	            esc_html__('Change Category Posts Layout', 'blogger-buzz'),
	            esc_html__('Change Category Posts Excerpt Length', 'blogger-buzz'),
	        ),
	        'priority' => 100
	    )));			


	/**
	 * Instagram Posts. 
	*/
	$wp_customize->add_section('blogger_buzz_instgram_posts_section', array(
		'title'		=>	esc_html__('Instagram Feed Settings','blogger-buzz'),
		'priority'  => 8
	));

		// Enable or Disable Instagram Feed .
		$wp_customize->add_setting('blogger_buzz_enable_instagram_posts', array(
		    'default'           => 'disable',
		    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_instagram_posts', array(
		    'label'        => esc_html__('Enable Instagram Feed To Display', 'blogger-buzz'),
		    'section'      => 'blogger_buzz_instgram_posts_section',
		    'switch_label' => array(
		        'enable' => esc_html__('Enable', 'blogger-buzz'),
		        'disable' => esc_html__('Disable', 'blogger-buzz'),
		    ),
		)));

		// Enable or Disable Instagram Feed Shortcode.
		$wp_customize->add_setting('blogger_buzz_instagram_feed_shortcode', array(
		    'sanitize_callback' => 'sanitize_text_field',     //done
		));

		$wp_customize->add_control('blogger_buzz_instagram_feed_shortcode', array(
		    'label'           => esc_html__('Enter Instagram Feed Shortcode', 'blogger-buzz'),
		    'description'     => sprintf(__( 'Install Instagram Feed Plugin Connect An Instagram Account, Set Number Of Photos And Number Columns To 10 And Padding Around Images to 0 And paste The Shortcode ([instagram-feed])  %1$s', 'blogger-buzz'), '<a class="pro-implink" href="https://wordpress.org/plugins/instagram-feed/" target="_blank">'.esc_html__('Custom Feeds for Instagram','blogger-buzz').'</a>' ),
		    'section'         => 'blogger_buzz_instgram_posts_section',
		    'active_callback' => 'blogger_buzz_instagram_feed',
		    'switch_label'    => array(
		        'enable' => esc_html__('Enable', 'blogger-buzz'),
		        'disable' => esc_html__('Disable', 'blogger-buzz'),
		    ),
		));

		$wp_customize->selective_refresh->add_partial( 'blogger_buzz_instagram_feed_shortcode', array(
			'selector'        => '.instagram',
		) );

		/**
		 * Themes Options.
		*/
		$wp_customize->add_panel('blogger_buzz_theme_options', array(
			'title'		=>	esc_html__('Themes Options','blogger-buzz'),
			'priority'  => 9
		));

			/* Excerpt Settings. */ 
			$wp_customize->add_section('blogger_buzz_excerpt_section', array(
				'title'		=>	esc_html__('Excerpt Settings','blogger-buzz'),
				'panel'     => 'blogger_buzz_theme_options',
				'priority'  => 5
			));

				// Excerpt Length.
				$wp_customize->add_setting( 'blogger_buzz_excerpt', array(
					'default'  => 30,
					'sanitize_callback' => 'sanitize_text_field', 	 //done	
				));

				$wp_customize->add_control( 'blogger_buzz_excerpt', array(
						'label'		  => esc_html__( 'Enter Excerpt Length', 'blogger-buzz' ),
						'description' => esc_html__('Applied To Home Page, Archive Page, Search Page','blogger-buzz'),
						'section'	  => 'blogger_buzz_excerpt_section',
						'type' 		  => 'number',
			    	    'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1 ),
				));

				// Excerpt Text. 
				$wp_customize->add_setting( 'blogger_buzz_excerpt_text', array(
					'default'  => 'Read More',
					'sanitize_callback' => 'sanitize_text_field', 	 //done	
				));

				$wp_customize->add_control( 'blogger_buzz_excerpt_text', array(
					'label'		  => esc_html__( 'Enter Excerpt Text', 'blogger-buzz' ),
					'description' => esc_html__('Applied To Archive Page, Search Page','blogger-buzz'),
					'section'	  => 'blogger_buzz_excerpt_section',
					'type' 		  => 'text',
				));



			/* Pagination. */
			$wp_customize->add_section('blogger_buzz_pagination_section', array(
				'title'		=>	esc_html__('Pagination Settings','blogger-buzz'),
				'panel'		=> 'blogger_buzz_theme_options',
				'priority'  => 30
			));

				// Pagination Option.
				$wp_customize->add_setting('blogger_buzz_pagination_option', array(
					'default' => 'numeric',
					'sanitize_callback' => 'blogger_buzz_sanitize_select'         //done
				));

				$wp_customize->add_control('blogger_buzz_pagination_option', array(
					'label'   => esc_html__('Previous Label','blogger-buzz'),
					'section' => 'blogger_buzz_pagination_section',
					'type'    => 'select',
					'choices' => array(
						'numeric'     => esc_html__('Numeric','blogger-buzz'),
						'older_newer' => esc_html__('Older / Newer','blogger-buzz'),			
					)
				));

				//Pagination Prev label.
				$wp_customize->add_setting('blogger_buzz_pagination_prev', array(
					'sanitize_callback' => 'sanitize_text_field'         //done
				));

				$wp_customize->add_control('blogger_buzz_pagination_prev', array(
					'label'   => esc_html__('Previous Label','blogger-buzz'),
					'section' => 'blogger_buzz_pagination_section',
					'type'    => 'text',
				));

				//Pagination next label.
				$wp_customize->add_setting('blogger_buzz_pagination_next', array(
					'sanitize_callback' => 'sanitize_text_field'         //done
				));

				$wp_customize->add_control('blogger_buzz_pagination_next', array(
					'label'   => esc_html__('Next Label','blogger-buzz'),
					'section' => 'blogger_buzz_pagination_section',
					'type'    => 'text',
				));




			/* Breadcrumbs. */
			$wp_customize->add_section('blogger_buzz_breadcrumbs_section', array(
				'title'		=>	esc_html__('Breadcrumbs Settings','blogger-buzz'),
				'panel'		=> 'blogger_buzz_theme_options',
				'priority'  => 50
			));

				// Enable or Disable Blog Posts Meta.
				$wp_customize->add_setting('blogger_buzz_enable_breadcrumbs', array(
				    'default'           => 'enable',
				    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
				));

				$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_breadcrumbs', array(
				    'label'        => esc_html__('Enable Breadcrumbs', 'blogger-buzz'),
				    'section'      => 'blogger_buzz_breadcrumbs_section',
				    'switch_label' => array(
				        'enable' => esc_html__('Enable', 'blogger-buzz'),
				        'disable' => esc_html__('Disable', 'blogger-buzz'),
				    ),
				)));

				$wp_customize->add_setting('blogger_buzz_breadcrumbs_section_upgrade_text', array(
			        'sanitize_callback' => 'blogger_buzz_sanitize_text'
			    ));

			    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_breadcrumbs_section_upgrade_text', array(
			        'section' => 'blogger_buzz_breadcrumbs_section',
			        'label' => esc_html__('For more settings,', 'blogger-buzz'),
			        'choices' => array(
			            esc_html__('Adjust Header Height', 'blogger-buzz'),
			            esc_html__('Enable/Disable Breadcrumbs Menu', 'blogger-buzz'),
			            esc_html__('Customize Breadcrumbs Menu Alignment', 'blogger-buzz'),
			            esc_html__('Upload Image for Breadcrumbs Section', 'blogger-buzz'),
			            esc_html__('Choose Breadcrumbs Background Color', 'blogger-buzz'),
			            esc_html__('Choose Breadcrumbs Font Color', 'blogger-buzz'),
			        ),
			        'priority' => 100
			    )));


			/* Single Blog posts. */
			$wp_customize->add_section('blogger_buzz_single_posts_section', array(
				'title'		=>	esc_html__('Single Post Page Settings','blogger-buzz'),
				'panel'		=> 'blogger_buzz_theme_options',
				'priority'  => 70
			));

				// Enable or Disable Blog Posts Pagination.
				$wp_customize->add_setting('blogger_buzz_enable_pagination', array(
				    'default'           => 'enable',
				    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
				));

				$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_pagination', array(
				    'label'        => esc_html__('Enable Prev/Next Link', 'blogger-buzz'),
				    'section'      => 'blogger_buzz_single_posts_section',
				    'switch_label' => array(
				        'enable' => esc_html__('Enable', 'blogger-buzz'),
				        'disable' => esc_html__('Disable', 'blogger-buzz'),
				    ),
				)));

				// Single Page Pagination Prev label.
				$wp_customize->add_setting('blogger_buzz_singlepost_prev', array(
					'sanitize_callback' => 'sanitize_text_field'         //done
				));

				$wp_customize->add_control('blogger_buzz_singlepost_prev', array(
					'label'   => esc_html__('Previous Label','blogger-buzz'),
					'section' => 'blogger_buzz_single_posts_section',
					'type'    => 'text',
					'active_callback' =>'blogger_buzz_blog_pagination'
				));

				// Single Page Pagination Next label.
				$wp_customize->add_setting('blogger_buzz_singlepost_next', array(
					'sanitize_callback' => 'sanitize_text_field'         //done
				));

				$wp_customize->add_control('blogger_buzz_singlepost_next', array(
					'label'   => esc_html__('Next Label','blogger-buzz'),
					'section' => 'blogger_buzz_single_posts_section',
					'type'    => 'text',
					'active_callback' =>'blogger_buzz_blog_pagination'
				));

				// Enable or Disable Blog Posts Author Description.
				$wp_customize->add_setting('blogger_buzz_enable_author_description', array(
				    'default'           => 'enable',
				    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
				));

				$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_author_description', array(
				    'label'        => esc_html__('Enable Author Description', 'blogger-buzz'),
				    'section'      => 'blogger_buzz_single_posts_section',
				    'switch_label' => array(
				        'enable' => esc_html__('Enable', 'blogger-buzz'),
				        'disable' => esc_html__('Disable', 'blogger-buzz'),
				    ),
				)));

				//Show Author Social Media.
				$wp_customize->add_setting( 'blogger_buzz_blog_author_social', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_author_social', array(
					'label'			  => esc_html__( 'Show Author Social Media', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_enable_author'
				));	

				//Author Facebook Link.
				$wp_customize->add_setting( 'blogger_buzz_author_facebook', array(
					'sanitize_callback' => 'sanitize_text_field',			//done
				));

				$wp_customize->add_control('blogger_buzz_author_facebook', array(
					'label'			  => esc_html__( 'Enter Author Facebook Link', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'text',
					'active_callback' => 'blogger_buzz_blog_author'
				));

				//Author Youtube Link.
				$wp_customize->add_setting( 'blogger_buzz_author_youtube', array(
					'sanitize_callback' => 'sanitize_text_field',			//done
				));

				$wp_customize->add_control('blogger_buzz_author_youtube', array(
					'label'			  => esc_html__( 'Enter Author Youtube Link', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'text',
					'active_callback' => 'blogger_buzz_blog_author'
				));

				//Author Twitter Link.
				$wp_customize->add_setting( 'blogger_buzz_author_twitter', array(
					'sanitize_callback' => 'sanitize_text_field',			//done
				));

				$wp_customize->add_control('blogger_buzz_author_twitter', array(
					'label'			  => esc_html__( 'Enter Author Twitter Link', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'text',
					'active_callback' => 'blogger_buzz_blog_author'
				));

				//Author Instagram Link.
				$wp_customize->add_setting( 'blogger_buzz_author_instagram', array(
					'sanitize_callback' => 'sanitize_text_field',			//done
				));

				$wp_customize->add_control('blogger_buzz_author_instagram', array(
					'label'			  => esc_html__( 'Enter Author Instagram Link', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'text',
					'active_callback' => 'blogger_buzz_blog_author'
				));

				// Enable or Disable Blog Meta.
				$wp_customize->add_setting('blogger_buzz_enable_meta', array(
				    'default'           => 'enable',
				    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
				));

				$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_meta', array(
				    'label'        => esc_html__('Enable Meta', 'blogger-buzz'),
				    'description'  => esc_html__('Applied To Single Page, Archive Page, Search Page','blogger-buzz'),
				    'section'      => 'blogger_buzz_single_posts_section',
				    'switch_label' => array(
				        'enable' => esc_html__('Enable', 'blogger-buzz'),
				        'disable' => esc_html__('Disable', 'blogger-buzz'),
				    ),
				)));

				//Enable Meta Comments.
				$wp_customize->add_setting( 'blogger_buzz_blog_comments', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_comments', array(
					'label'			  => esc_html__( 'Show Post Meta Comments', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_metas'
				));

				//Enable Meta Date.
				$wp_customize->add_setting( 'blogger_buzz_blog_date', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_date', array(
					'label'			  => esc_html__( 'Show Post Meta Date', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_metas'
				));

				//Enable Meta Author.
				$wp_customize->add_setting( 'blogger_buzz_blog_author', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_author', array(
					'label'			  => esc_html__( 'Show Post Meta Author', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_metas'
				));

				//Enable Meta Category.
				$wp_customize->add_setting( 'blogger_buzz_blog_category', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_category', array(
					'label'			  => esc_html__( 'Show Post Meta Category', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_metas'
				));

				//Enable Meta Tags.
				$wp_customize->add_setting( 'blogger_buzz_blog_tags', array(
					'default' => true,
					'sanitize_callback' => 'blogger_buzz_sanitize_checkbox',			//done
				));

				$wp_customize->add_control('blogger_buzz_blog_tags', array(
					'label'			  => esc_html__( 'Show Post Meta Tags', 'blogger-buzz' ),
					'section'		  => 'blogger_buzz_single_posts_section',
					'type' 			  => 'checkbox',
					'active_callback' => 'blogger_buzz_blog_metas'
				));

				$wp_customize->add_setting('blogger_buzz_single_posts_section_upgrade_text', array(
			        'sanitize_callback' => 'blogger_buzz_sanitize_text'
			    ));

			    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_single_posts_section_upgrade_text', array(
			        'section' => 'blogger_buzz_single_posts_section',
			        'label' => esc_html__('For more settings,', 'blogger-buzz'),
			        'choices' => array(
			            esc_html__('Enable/Disable Social Sharing', 'blogger-buzz'),
			        ),
			        'priority' => 100
			    )));


			/* Preloader. */
			$wp_customize->add_section('blogger_buzz_preloader_section', array(
				'title'		=>	esc_html__('Preloader Settings','blogger-buzz'),
				'panel'		=> 'blogger_buzz_theme_options',
				'priority'  => 110
			));

				// Enable or Disable Blog Meta.
				$wp_customize->add_setting('blogger_buzz_enable_preloader', array(
				    'default'           => 'enable',
				    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
				));

				$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_preloader', array(
				    'label'        => esc_html__('Enable Preloader', 'blogger-buzz'),
				    'section'      => 'blogger_buzz_preloader_section',
				    'switch_label' => array(
				        'enable' => esc_html__('Enable', 'blogger-buzz'),
				        'disable' => esc_html__('Disable', 'blogger-buzz'),
				    ),
				)));

				$wp_customize->add_setting('blogger_buzz_preloader_section_upgrade_text', array(
			        'sanitize_callback' => 'blogger_buzz_sanitize_text'
			    ));

			    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_preloader_section_upgrade_text', array(
			        'section' => 'blogger_buzz_preloader_section',
			        'label' => esc_html__('For more settings,', 'blogger-buzz'),
			        'choices' => array(
			            esc_html__('Select from numerous preloader images', 'blogger-buzz'),
			        ),
			        'priority' => 100
			    )));


	/**
	 * General Settings Panel
	*/
	$wp_customize->add_panel('blogger_buzz_general_settings', array(
	   'priority' => 10,
	   'title' => esc_html__('General Settings', 'blogger-buzz')
	));

		/**
	     * Background Settings
	    */
		$wp_customize->add_section( 'background_image', array(
		     'title'    => esc_html__( 'Background Image', 'blogger-buzz' ),
		     'panel'    => 'blogger_buzz_general_settings',
		     'priority' => 2,
		) );


		$wp_customize->get_section( 'static_front_page' )->panel = 'blogger_buzz_general_settings';
    	$wp_customize->get_section( 'static_front_page' )->priority = 3;

	
	/**
	 * Main Footer Settings.
	*/
	$wp_customize->add_section('blogger_buzz_footer', array(
		'title'		=>	esc_html__('Main Footer Settings','blogger-buzz'),
		'priority'  => 11
	));

		//Footer Copyright.
		$wp_customize->add_setting('blogger_buzz_footer_copyright', array(
		    'sanitize_callback' => 'sanitize_text_field',     //done
		));

		$wp_customize->add_control('blogger_buzz_footer_copyright', array(
		    'label'    => esc_html__('Enter Footer Copyright Text', 'blogger-buzz'),
		    'section'  => 'blogger_buzz_footer',
		    'type'     => 'text'
		));

		// Enable or Disable Footer Widgets.
		$wp_customize->add_setting('blogger_buzz_enable_footer_widget', array(
		    'default'           => 'disable',
		    'sanitize_callback' => 'blogger_buzz_sanitize_switch',     //done
		));

		$wp_customize->add_control(new Blogger_Buzz_Switch_Control($wp_customize, 'blogger_buzz_enable_footer_widget', array(
		    'label'        => esc_html__('Enable Footer Widgets', 'blogger-buzz'),
		    'section'      => 'blogger_buzz_footer',
		    'switch_label' => array(
		        'enable'  => esc_html__('Enable', 'blogger-buzz'),
		        'disable' => esc_html__('Disable', 'blogger-buzz'),
		    ),
		)));

		$wp_customize->add_setting('blogger_buzz_footer_upgrade_text', array(
	        'sanitize_callback' => 'blogger_buzz_sanitize_text'
	    ));

	    $wp_customize->add_control(new Blogger_Buzz_Upgrade_Text($wp_customize, 'blogger_buzz_footer_upgrade_text', array(
	        'section' => 'blogger_buzz_footer',
	        'label' => esc_html__('For more settings,', 'blogger-buzz'),
	        'choices' => array(
	            esc_html__('Change Footer Background Color', 'blogger-buzz'),
	            esc_html__('Change Footer Font and Hover Color', 'blogger-buzz'),
	            esc_html__('Change Footer Copyright Background Color', 'blogger-buzz'),
	            esc_html__('Change Footer Copyright Font and Hover Color', 'blogger-buzz'),
	            esc_html__('Enable/Disable Footer Scroll to Top Button', 'blogger-buzz'),
	        ),
	        'priority' => 100
	    )));

}
add_action( 'customize_register', 'blogger_buzz_customize_register' );

//SANITIZATION FUNCTIONS
function blogger_buzz_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogger_buzz_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogger_buzz_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 *
 */
function blogger_buzz_customize_scripts(){

    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/fontawesome.css', array(), '5.5.0');

    wp_enqueue_style('blogger-buzz-customizer', get_template_directory_uri() . '/assets/css/customizer.css');

    wp_enqueue_script('blogger-buzz-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('jquery', 'jquery-ui-sortable', 'customize-controls'), true);
}
add_action('customize_controls_enqueue_scripts', 'blogger_buzz_customize_scripts');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogger_buzz_customize_preview_js() {
	wp_enqueue_script( 'blogger-buzz-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview', 'jquery-ui-sortable' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blogger_buzz_customize_preview_js' );
