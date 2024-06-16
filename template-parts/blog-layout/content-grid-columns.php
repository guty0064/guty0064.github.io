<?php 
/**
 * Template part for displaying grid layout posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogger_buzz
 */

$postformat   = get_post_format();
$enable_meta  = get_theme_mod('blogger_buzz_enable_blog_meta','enable');
$category     = get_theme_mod('blogger_buzz_posts_category',true);
$post_content = get_theme_mod('blogger_buzz_posts_description','content_excerpt');

if (!empty($postformat) || has_post_thumbnail() ):
	?>
	<div class="list-post-media">
	    <?php blogger_buzz_post_format_media( $postformat ); ?>
	</div>
<?php endif; ?>

<div class="list-post-content">
	<?php if( $enable_meta == 'enable' && $category == true ): ?>

	    <ul class="meta-catagory"><?php blogger_buzz_category(); ?></ul>

    <?php endif;
    
    the_title( '<h2 class="blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 

    blogger_buzz_post_meta(); 

    if ($post_content == 'content_excerpt'):

    	echo '<div class="'.esc_attr('post_content').'">';

        	the_excerpt();

        echo '</div>';

    endif;

	$button = get_theme_mod('blogger_buzz_post_button_text','Read More');

    if (!empty($button) && $post_content == 'content_excerpt'):

		echo '<div class="'.esc_attr('more-link').'"><a href="'.esc_url( get_permalink()).'">'.esc_html($button).'</a></div>';

	endif; ?>
</div>
