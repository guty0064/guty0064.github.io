<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogger_buzz
 */

$postformat   = get_post_format();
$enable_meta  = get_theme_mod('blogger_buzz_enable_meta','enable');
$category     = get_theme_mod('blogger_buzz_blog_category',true);
$excerpt_text = get_theme_mod('blogger_buzz_excerpt_text','Read More');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-list'); ?>">
	<div class="archive_inner_wrapper">
 	    <?php 
	 	    if (!empty($postformat) || has_post_thumbnail()):

	 	    	echo '<div class="list-post-media">' ;
	 	    		
	 	    		blogger_buzz_post_format_media( $postformat );

	 	    	echo '</div>' ;
			
	    	endif; 
    	?>

	    <div class="list-post-content">
	    	<?php if ($enable_meta == 'enable' && $category == true): ?>
	            <ul class="meta-catagory">
	                <?php blogger_buzz_category(); ?>
	            </ul>
		    <?php endif; 

			    the_title( '<h2 class="blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

			    blogger_buzz_blog_post_meta();

			    $post_content = get_theme_mod('blogger_buzz_post_description','excerpt');

		    if ($post_content == 'excerpt' ): ?>

		    	<div class="post_content"><?php the_excerpt() ?></div>

		    <?php  endif;
		    
	        if($post_content == 'excerpt' && !empty($excerpt_text)):

	        	echo '<div class="'.esc_attr('more-link').'"><a href="'.esc_url(get_permalink()).'">'.esc_html($excerpt_text).'</a></div>';
	       
	        endif;

		    ?>
	    </div>
	   
	</div>
</article>
