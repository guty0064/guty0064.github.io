<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package blogger_buzz
 */

get_header(); 

$sidebar = esc_attr( get_post_meta($post->ID, 'blogger_buzz_page_layouts', true ) );

if(!$sidebar){
    $sidebar = 'rightsidebar';
}

if ($sidebar == 'nosidebar') {
	$col = 12;
}
else{
	$col = 9;
}

?>

<div class="container">
    <div class="row">

    	<?php if ($sidebar == 'leftsidebar') { get_sidebar('left'); } ?>

		<div id="primary" class="content-area col-lg-<?php echo intval( $col ); ?> col-md-12 col-sm-12 col-xs-12">
			<main id="main" class="site-main">
				<div class="blog-style single-page">
					<?php
						while ( have_posts() ) : the_post();
							
							get_template_part( 'template-parts/content', 'single' );

							$pagination = get_theme_mod('blogger_buzz_enable_pagination','enable');

							if ( $pagination == 'enable'):

								$prev = get_theme_mod('blogger_buzz_singlepost_prev');
								$next = get_theme_mod('blogger_buzz_singlepost_next');

								if (!empty($prev) || !empty($next)):
									the_post_navigation( 
						              array(
						                    'prev_text' => esc_html( $prev, 'blogger-buzz'),
						                    'next_text' => esc_html( $next, 'blogger-buzz'),
						                )
						            );

								else:
									the_post_navigation(array(
							            'prev_text' => esc_html__( 'Previous', 'blogger-buzz'),
			                            'next_text' => esc_html__( 'Next', 'blogger-buzz'),
							        ));

								endif;

							endif;

							$author_description = get_theme_mod( 'blogger_buzz_enable_author_description', 'enable' );
								
							if( !empty( $author_description ) && $author_description == 'enable' ){

								/**
								 * displaying author bio
								 */
								get_template_part( 'template-parts/content', 'author' );
								
							}

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endwhile; // End of the loop.
					?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->
		
		<?php if ($sidebar == 'rightsidebar') { get_sidebar(); } ?>

	</div>
</div>

<?php get_footer();
