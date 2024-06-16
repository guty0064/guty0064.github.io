<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package blogger_buzz
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blogger_buzz_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'blogger_buzz_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function blogger_buzz_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'blogger_buzz_pingback_header' );

/**
 * Breadcrumbs.
 */

function blogger_buzz_breadcrumbs(){ ?>
    <div class="breadcrumb">

	    <div class="thin_layer" style="background: #000; opacity: 0.4"></div>

	    <div class="container">
	        <div class="row">
	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 breadcrumb_wrapper">
	                <?php
	                    if (is_single() || is_page()) {

	                        the_title('<h2 class="entry-title">', '</h2>');

	                    } elseif (is_archive()) {

	                        the_archive_title('<h2 class="page-title">', '</h2>');

	                    } elseif (is_search()) { ?>

	                        <h2 class="page-title">
	                            <?php printf(esc_html__('Search Results for:', 'blogger-buzz'), '%s', '<span>' . get_search_query() . '</span>'); ?>
	                        </h2>

	                    <?php } elseif (is_404()) {

	                        echo '<h2 class="entry-title">' . esc_html('404 Error', 'blogger-buzz') . '</h2>';

	                    } elseif (is_home()) {

	                        $page_for_posts_id = get_option('page_for_posts');
	                        $page_title = get_the_title($page_for_posts_id);
	                    ?>
	                        <h1 class="entry-title"><?php echo esc_html( $page_title ); ?></h1>

                    <?php } ?>

                    <nav id="breadcrumb" class="fitness-park-breadcrumb">
                        <?php
	                        breadcrumb_trail(array(
	                            'container' => 'div',
	                            'show_browse' => false,
	                        ));
                        ?>
                    </nav>
	            </div>
	        </div>
	    </div>
	</div>
    <?php
}

add_action('blogger_buzz_breadcrumbs', 'blogger_buzz_breadcrumbs', 100);


/**
 * Banner Slider.
 */
function blogger_buzz_banner(){

	$banner = get_theme_mod('blogger_buzz_banner');

	$cat_id = explode(',', $banner);

	$button = get_theme_mod('blogger_buzz_banner_button','Read More');

	?>
	<div class="bz_slider">
	    <div class="owl-carousel banner-slider">
	    	<?php 
		    	$banner_args = array(
	                'post_type'      => 'post',
	                'tax_query'      => array(

	                    array(
	                        'taxonomy' => 'category',
	                        'field'    => 'term_id',
	                        'terms'    => $cat_id
	                    ),
	                ),
	            );

	            $banner_query = new WP_Query ($banner_args);

	            if ($banner_query->have_posts()):

	            	while ($banner_query->have_posts()) : $banner_query->the_post();

            ?>
    			<div class="item" style="background-image: url(<?php the_post_thumbnail_url(); ?>);">
		            <div class="thin_layer" style="opacity: 0;background: #000;"></div>
		            <div class="banner_overlay">
		                <div class="banner_overlay_inner">

		                	<ul><?php blogger_buzz_category(); ?></ul>
		                    
		                    <h3 class="banner-title">
		                    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                    </h3>

		                    <?php 
		                    if (!empty($button)):
		                    	echo '<a class="'.esc_attr('transparent_button').'" href="'.esc_url( get_permalink() ).'">'.esc_html( $button ).'</a>';
		                    endif;
		                    ?>
		                    
		                </div>
		            </div>
		        </div>
            <?php endwhile; endif; wp_reset_postdata(); ?>
	    </div>
	</div>
	<?php

}
add_action('blogger_buzz_action_banner','blogger_buzz_banner',20);

/**
 * Featured Blog posts.
 */
function blogger_buzz_featured_blog_posts(){

	$enable_featured_post = get_theme_mod('blogger_buzz_enable_featured_posts','disable');
	$featured_blog        = get_theme_mod('blogger_buzz_featured_blog');
	$featured_cat         = explode(',', $featured_blog);

	if ($enable_featured_post == 'enable'): ?>
		<section class="bz_feature">
		    <div class="container">
		        <div class="row">
					<?php 
						$count=0;
						foreach($featured_cat as $cat_id): 
					
							$count++;

				        	$featured_args = array(
				                'posts_per_page' => 1,
				                'post_type'      => 'post',
				                'tax_query'      => array(
				                    array(
				                        'taxonomy' => 'category',
				                        'field'    => 'term_id',
				                        'terms'    => $cat_id
				                    ),
				                ),
				            );

			            $featured_query = new WP_Query ($featured_args);

			            if ($featured_query->have_posts()):

							$cat_id_list = array() ;

			            	while ( $featured_query->have_posts()): $featured_query->the_post();
			        ?>
	            			<div class="col-lg-4 col-md-6 col-sm-12">
				                <article class="feature_inner">
				                	<a href="<?php the_permalink(); ?>">
				                    	<div class="image_bg" style="background-image: url(<?php the_post_thumbnail_url(); ?>);"></div>
				                    </a>
				                    
				                    <div class="article_description">
				                        <ul class="meta-catagory">
				                            <?php blogger_buzz_category(); ?>
				                        </ul>
				                        <h3 class="post-title">
				                        	<a href="<?php the_permalink(); ?>" rel="bookmark" tabindex="0"><?php the_title(); ?></a>
				                        </h3>
				                    </div>
				                </article>
				            </div>

			        <?php endwhile;  endif; 
			            
			            if ($count == 3){
			            	break;
			            }

		            endforeach; ?>
		        </div>
		    </div>
		</section>
	<?php endif;
}
add_action('blogger_buzz_action_featured_blog_posts','blogger_buzz_featured_blog_posts',40);



/**
 *	Add Metabox.
*/
if( !function_exists( 'blogger_buzz_page_layout_metabox' ) ):

    function blogger_buzz_page_layout_metabox() {

        add_meta_box('blogger_buzz_display_layout', 
            esc_html__( 'Display Layout Options', 'blogger-buzz' ), 
            'blogger_buzz_display_layout_callback', 
            array('page','post'), 
            'normal', 
            'high'
        );
    }
endif;
add_action('add_meta_boxes', 'blogger_buzz_page_layout_metabox');

/**
 * Page and Post Page Display Layout Metabox function
*/

$blogger_buzz_page_layouts =array(

    'leftsidebar' => array(
        'value'     => 'leftsidebar',
        'label'     => esc_html__( 'Left Sidebar', 'blogger-buzz' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
    ),

    'rightsidebar' => array(
        'value'     => 'rightsidebar',
        'label'     => esc_html__( 'Right (Default)', 'blogger-buzz' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
    ),

     'nosidebar' => array(
        'value'     => 'nosidebar',
        'label'     => esc_html__( 'Full width', 'blogger-buzz' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/no-sidebar.png',
    )
);

/**
 * Function for Page layout meta box
*/

if ( ! function_exists( 'blogger_buzz_display_layout_callback' ) ) {
    function blogger_buzz_display_layout_callback(){
        global $post, $blogger_buzz_page_layouts;
        wp_nonce_field( basename( __FILE__ ), 'blogger_buzz_settings_nonce' ); ?>
        <table>
            <tr>
              <td>            
                <?php
                  $i = 0;  
                  foreach ($blogger_buzz_page_layouts as $field) {  
                  $blogger_buzz_page_metalayouts = esc_attr( get_post_meta( $post->ID, 'blogger_buzz_page_layouts', true ) ); 
                ?>            
                  <div class="radio-image-wrapper slidercat" id="slider-<?php echo intval( $i ); ?>" style="float: right; margin-right: 25px;">
                    <label class="description">
                        <span>
                          <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" />
                        </span></br>
                        <input type="radio" name="blogger_buzz_page_layouts" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( esc_html( $field['value'] ), 
                            $blogger_buzz_page_metalayouts ); if(empty($blogger_buzz_page_metalayouts) && esc_html( $field['value'] ) =='rightsidebar'){ echo "checked='checked'";  } ?>/>
                         <?php echo esc_html( $field['label'] ); ?>
                    </label>
                  </div>
                <?php  $i++; }  ?>
              </td>
            </tr>            
        </table>
    <?php
    }
}

/**
 * Save the custom metabox data
*/
if ( ! function_exists( 'blogger_buzz_save_page_settings' ) ) {
    function blogger_buzz_save_page_settings( $post_id ) { 
        global $blogger_buzz_page_layouts, $post;
         if ( !isset( $_POST[ 'blogger_buzz_settings_nonce' ] ) || !wp_verify_nonce( sanitize_key( $_POST[ 'blogger_buzz_settings_nonce' ] ) , basename( __FILE__ ) ) ) 
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
            return;        
        if (isset( $_POST['post_type'] ) && 'page' == $_POST['post_type']) {  
            if (!current_user_can( 'edit_page', $post_id ) )  
                return $post_id;  
        } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
                return $post_id;  
        }  

        foreach ($blogger_buzz_page_layouts as $field) {  
            $old = esc_attr( get_post_meta( $post_id, 'blogger_buzz_page_layouts', true) );
            if ( isset( $_POST['blogger_buzz_page_layouts']) ) { 
                $new = sanitize_text_field( wp_unslash( $_POST['blogger_buzz_page_layouts'] ) );
            }
            if ($new && $new != $old) {  
                update_post_meta($post_id, 'blogger_buzz_page_layouts', $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id,'blogger_buzz_page_layouts', $old);  
            } 
         } 
    }
}
add_action('save_post', 'blogger_buzz_save_page_settings');