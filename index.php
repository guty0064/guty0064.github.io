<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogger_buzz
 */

$page_layout = get_theme_mod('blogger_buzz_blog_layout','grid_right_sidebar');

if ($page_layout == 'grid_no_sidebar' || $page_layout == 'grid_two_nsidebar') { 

	$col = 12 ;

}else{

	$col = 9 ;

}

if ($page_layout == 'grid_two_rsidebar' || $page_layout == 'grid_two_lsidebar' || $page_layout == 'grid_two_nsidebar' ) {

	$class = 'blog-style-three' ;

}elseif ( $page_layout == 'split' ) {
	
	$class = 'blog-style-two' ;
}

get_header();

	/**
     * Hook -  blogger_buzz_action_banner
     *
     * @hooked blogger_buzz_banner - 20
     */

    do_action('blogger_buzz_action_banner');

    /**
     * Hook -  blogger_buzz_action_featured_blog_posts
     *
     * @hooked blogger_buzz_featured_blog_posts - 40
     */

    do_action('blogger_buzz_action_featured_blog_posts');
?>

<div class="container">
    <div class="row">

    	<?php if ( $page_layout == 'grid_left_sidebar' || $page_layout == 'grid_two_lsidebar' ) { get_sidebar ( 'left' ) ; } ?>

		<div id="primary" class="content-area col-lg-<?php echo intval($col); ?> col-md-12 col-sm-12">

			<main id="main" class="site-main">
				<div class = "blog-style <?php echo esc_attr( $class ); ?>">

					<?php
						if ( have_posts() ) :

	                        echo '<div class="'.esc_attr('blog_style_inner').'">';

								/* Start the Loop */
								while ( have_posts() ) :
									the_post();

									/*
									 * Include the Post-Type-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', get_post_format() );

								endwhile;

	                        echo '</div>';
	                        
							blogger_buzz_posts_navigation();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
					?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php if ( $page_layout == 'grid_right_sidebar' || $page_layout == 'grid_two_rsidebar' || $page_layout == 'split' ) { get_sidebar () ; } ?>

	</div>
</div>

<?php 
	$enable_instagram  = get_theme_mod('blogger_buzz_enable_instagram_posts','disable');
	if ( $enable_instagram == 'enable' ):
?>
    <section class="instagram">

        <?php echo do_shortcode( get_theme_mod( 'blogger_buzz_instagram_feed_shortcode' ) ); ?>

    </section>

<?php endif; 
    
get_footer();
