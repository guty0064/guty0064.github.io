<?php
/**
 * The template for displaying author bio on single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blogger Buzz
 */

$author_id         = get_the_author_meta( 'ID' );
$author_avatar     = get_avatar( $author_id, 180 );
$author_post_link  = get_the_author_posts_link();
$author_bio        = get_the_author_meta( 'description' );
$author_email      = get_the_author_meta('email');

?>
<div class="author-info">
	<?php 
		if ( $author_avatar ): 
			echo '<div class="'.esc_attr('author-left').'">'.wp_kses_post( $author_avatar ).'</div>'; 
		endif; 
	?>

    <div class="author-right">

    	<?php 
    	if ( $author_post_link ):
    		echo '<h2>'.wp_kses_post( $author_post_link ).'</h2>';
    	endif;

    	if ( $author_bio ):
    		echo '<p>'.wp_kses_post( $author_bio ).'</p>';
    	endif;

	    $author_social      = get_theme_mod( 'blogger_buzz_blog_author_social', true );
	    $author_facebook    = get_theme_mod( 'blogger_buzz_author_facebook');
	    $author_youtube     = get_theme_mod( 'blogger_buzz_author_youtube');
	    $author_twitter     = get_theme_mod( 'blogger_buzz_author_twitter');
	    $author_instagram   = get_theme_mod( 'blogger_buzz_author_instagram');


	    if ($author_social == true ):
	    	 ?>
	        <div class="social-link">
	            <ul>
	            	<?php 
		            	if (!empty($author_facebook)) {
		            		echo '<li><a href="'.esc_url($author_facebook).'" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>';
		            	}

		            	if (!empty($author_twitter)) {
		            		echo '<li><a href="'.esc_url($author_twitter).'" title="Twitter"><i class="fab fa-twitter"></i></a></li>';
		            	}

		            	if (!empty($author_youtube)) {
		            		echo '<li><a href="'.esc_url($author_youtube).'" title="Youtube"><i class="fab fa-youtube"></i> </a></li>';
		            	}

		            	if (!empty($author_instagram)) {
		            		echo '<li><a href="'.esc_url($author_instagram).'" title="Instagram"><i class="fab fa-instagram"></i></a></li>';
		            	}

	            	?>
	            </ul>
	        </div>
	    <?php endif; ?>
    </div>
</div>
