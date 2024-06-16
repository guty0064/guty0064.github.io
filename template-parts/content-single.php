<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogger_buzz
 */

$postformat  = get_post_format();
$enable_meta = get_theme_mod('blogger_buzz_enable_meta', 'enable');
$category    = get_theme_mod('blogger_buzz_blog_category', true);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-list'); ?>">

    <div class="row">
        <?php if ($enable_meta == 'enable' && $category == true): ?>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <ul class="meta-catagory center">
                    <?php blogger_buzz_category(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <?php 

        the_title('<h2 class="blog-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');

        blogger_buzz_blog_post_meta();

        blogger_buzz_post_format_media($postformat);

    ?>

    <div class="post_content">
        <?php the_content(); ?>
    </div>
</article>
