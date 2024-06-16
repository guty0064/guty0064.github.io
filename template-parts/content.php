<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogger_buzz
 */

$page_layout = get_theme_mod('blogger_buzz_blog_layout','grid_right_sidebar');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-list'); ?>>
	<?php 
		if($page_layout == 'grid_right_sidebar' || $page_layout == 'grid_left_sidebar' || $page_layout == 'grid_no_sidebar'):

			get_template_part( 'template-parts/blog-layout/content', 'grid-layout' );

		elseif( $page_layout == 'split' ):

			get_template_part( 'template-parts/blog-layout/content', 'split' );

		else:

			get_template_part( 'template-parts/blog-layout/content', 'grid-columns' );

		endif;

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogger-buzz' ),
			'after'  => '</div>',
		) );

	?>
</article><!-- #post-<?php the_ID(); ?> -->
