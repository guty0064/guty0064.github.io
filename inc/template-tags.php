<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package blogger_buzz
 */

if (!function_exists('blogger_buzz_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function blogger_buzz_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            '<a class="banner-date" href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<li>' . $posted_on . '</li>'; // WPCS: XSS OK.

    }
endif;

if (!function_exists('blogger_buzz_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function blogger_buzz_posted_by()
    {

        echo '<li class = "' . esc_attr('author-meta') . '"><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></li>'; // WPCS: XSS OK.

    }
endif;

if (!function_exists('blogger_buzz_comments')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function blogger_buzz_comments()
    {

        echo '<li>';

        comments_popup_link(
            sprintf(
                wp_kses(
                /* translators: %s: post title */
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'blogger-buzz'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );

        echo '</li>'; // WPCS: XSS OK.

    }
endif;

/**
 * Category Lists.
 */
if (!function_exists('blogger_buzz_category')) :

    function blogger_buzz_category()
    {

        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category();

        foreach ($categories_list as $category) {

            echo '<li class="cat-links"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li> ';
        }
    }

endif;

if (!function_exists('blogger_buzz_tags')) :
    function blogger_buzz_tags()
    {
        /* translators: used between list items, there is a space after the comma */
        $posttags = get_the_tags();

        $count = 0;

        $sep = '<li>';

        if ($posttags) {

            foreach ($posttags as $tag) {
                $count++;
                echo $sep . '<a class="meta-tags" href="' . esc_url(get_tag_link($tag->term_id)) . '">' . '#' . esc_attr($tag->name) . '</a>';
                $sep = ', ';
                if ($count > 10) break;
            }
            echo '</li>';
        }
    }
endif;

if (!function_exists('blogger_buzz_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function blogger_buzz_entry_footer()
    {
        edit_post_link(
            sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'blogger-buzz'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('blogger_buzz_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function blogger_buzz_post_thumbnail(){

        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) : ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                    the_post_thumbnail('post-thumbnail', array(
                        'alt' => the_title_attribute(array(
                            'echo' => false,
                        )),
                    ));
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('blogger_buzz_social_links')) :

    /**
     *
     * Displays Social Links.
     *
     */
    function blogger_buzz_social_links(){

        $social_icon = get_theme_mod('blogger_buzz_social_links');
        $header_layout = get_theme_mod('blogger_buzz_header_layout', 'layout_one');
        $search = get_theme_mod('blogger_buzz_enable_search_icon', 'enable');
        $sidenav = get_theme_mod('blogger_buzz_enable_sidenav', 'enable');

        echo '<ul class="top_social_with_search">';

            if (!empty($social_icon)) :

                $social_icon = json_decode($social_icon);

                foreach ($social_icon as $icon):
                    echo '<li><a href="' . esc_url($icon->social_link) . '"><i class="' . esc_attr($icon->social_icon) . '"></i></a></li>';
                endforeach;

            endif;

            if ($header_layout == 'layout_two' && $search == 'enable'):

                echo '<li><a href="#" class="' . esc_attr('search_main_menu') . '"><i class="fas fa-search"></i></a></li>';
            
            endif;

            if ($header_layout == 'layout_two' && $sidenav == 'enable'):

                echo '<li><a href="#" class="' . esc_attr('side-bar-toggler') . '"><i class="fas fa-bars"></i></a></li>';
            
            endif;

        echo '</ul>';

        
    }
endif;

if (!function_exists('blogger_buzz_site_branding')):

    /**
     * Site Branding.
    */
    function blogger_buzz_site_branding(){

        $header_layout = get_theme_mod('blogger_buzz_header_layout','layout_one');

        ?>
        <div class="bz_main_header <?php if ($header_layout == 'layout_three'){ echo esc_attr(' layout_type_three_header'); }?>">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="site-branding">
                            <?php
                                the_custom_logo();
                            ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                            <?php
                                $blogger_buzz_description = get_bloginfo('description', 'display');

                                if ($blogger_buzz_description || is_customize_preview()) :
                            ?>
                                <p class="site-description"><?php echo $blogger_buzz_description; /* WPCS: xss ok. */ ?></p>
                            <?php endif; ?>

                        </div><!-- .site-branding -->
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;


if (!function_exists('blogger_buzz_navigation')):
    /**
     * Navigation.
    */
    function blogger_buzz_navigation() { ?>

        <nav id="site-navigation" class="main-navigation">
            <div class="main-menu-container-collapse">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-1',
                    'container' => 'ul',
                    'menu_id' => 'primary-menu',
                    'menu_class' => 'menu nav-menu',
                ));
                ?>
            </div>
        </nav>
        <?php
    }
endif;

/**
 * Posts format declaration function.
 *
 * @since 1.0.0
 */
if (!function_exists('blogger_buzz_post_format_media')) :

    function blogger_buzz_post_format_media()
    {
        global $post;
        $postformat = get_post_format();
        $post_layout = get_theme_mod('blogger_buzz_blog_layout', 'grid_right_sidebar');

        $imagesize = 'post-thumbnail';

        if ($postformat == "gallery") {

            if (function_exists('has_block') && has_block('gallery', $post->post_content)) {

                $post_blocks = parse_blocks($post->post_content);
                $key = array_search('core/gallery', array_column($post_blocks, 'blockName'));
                $gallery_attachment_ids = $post_blocks[$key]['attrs']['ids'];

            }else {
                // gets the gallery info
                $gallery = get_post_gallery( $post->ID, false );
                $gallery_attachment_ids = array();
                if( is_array($gallery) && count($gallery) and isset($gallery['ids'])) {
                    // makes an array of image ids
                    $gallery_attachment_ids = explode ( ",", $gallery['ids'] );
                }
            }

            if ( ! empty( $gallery_attachment_ids ) ){ ?>
                <figure>
                    <div class="postgallery-carousel cS-hidden">
                        <?php foreach ( $gallery_attachment_ids as $gallery_attachment_id ) { ?>
                            <div class="list">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="image_bg" style="background-image: url(<?php echo esc_url(wp_get_attachment_image_url($gallery_attachment_id, $imagesize)); ?>);"></div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </figure>
                
            <?php } else { ?>
                
                <a href="<?php the_permalink(); ?>">
                    <div class="image_bg" style="background-image: url(<?php echo esc_url(the_post_thumbnail_url()); ?>);"></div>
                </a>
                <?php
            }

        } elseif ($postformat == "video") {

            $get_content = apply_filters('the_content', get_the_content());

            $get_video = get_media_embedded_in_content($get_content, array('video', 'object', 'embed', 'iframe'));

            if (!empty($get_video)) {

                ?>
                <div class="embed-responsive embed-responsive-16by9">
                    <?php echo $get_video[0]; // WPCS xss ok. ?>
                </div>

            <?php } else {
                ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="image_bg" style="background-image: url(<?php echo esc_url(the_post_thumbnail_url()); ?>);"></div>
                </a>
                <?php
            }

        } elseif ($postformat == "audio") {

            $get_content = apply_filters('the_content', get_the_content());

            $get_audio = get_media_embedded_in_content($get_content, array('audio', 'iframe'));

            if (!empty($get_audio)) {
        ?>
                <div class="audio">
                    <?php echo $get_audio[0]; // WPCS xss ok. ?>
                </div>
            <?php } else { ?>

                <a href="<?php the_permalink(); ?>">
                    <div class="image_bg" style="background-image: url(<?php echo esc_url(the_post_thumbnail_url()); ?>);"></div>
                </a>

            <?php } }else {

            if(has_post_thumbnail()){

            if ($post_layout == 'split' || is_archive() || is_search()) {

                ?>
                    <a href="<?php the_permalink(); ?>">
                        <div class="image_bg" style="background-image: url(<?php the_post_thumbnail_url(); ?>);"></div>
                    </a>

                <?php } else { ?>

                <a href="<?php the_permalink(); ?>">
                    <div class="image_bg" style="background-image: url(<?php echo esc_url(the_post_thumbnail_url()); ?>);"></div>
                </a>
            <?php }
            }
        }
    }

endif;

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function blogger_buzz_excerpt_length($length)
{

    $excerpt_length = get_theme_mod('blogger_buzz_excerpt', 30);

    if (is_admin()) {

        return $length;

    } else {

        return $excerpt_length;

    }

}

add_filter('excerpt_length', 'blogger_buzz_excerpt_length', 999);

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $text "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function blogger_buzz_excerpt_more($text)
{

    if (is_admin()) {

        return $text;
    }

    return '&hellip;';
}

add_filter('excerpt_more', 'blogger_buzz_excerpt_more');

/**
 * Pagination
 */

if (!function_exists('blogger_buzz_posts_navigation')):

    function blogger_buzz_posts_navigation()
    {

        $prev = get_theme_mod('blogger_buzz_pagination_prev');
        $next = get_theme_mod('blogger_buzz_pagination_next');

        if (get_theme_mod('blogger_buzz_pagination_option', 'numeric') == 'numeric'):

            if (!empty($prev) || !empty($next)):

                the_posts_pagination(

                    array(
                        'prev_text' => esc_html($prev, 'blogger-buzz'),
                        'next_text' => esc_html($next, 'blogger-buzz'),
                    )
                );
            else:

                the_posts_pagination(

                    array(
                        'prev_text' => esc_html__('Previous', 'blogger-buzz'),
                        'next_text' => esc_html__('Next', 'blogger-buzz'),
                    )
                );

            endif;

        else:

            if (!empty($prev) || !empty($next)):

                the_posts_navigation(

                    array(
                        'prev_text' => esc_html($prev, 'blogger-buzz'),
                        'next_text' => esc_html($next, 'blogger-buzz'),
                    )
                );
            else:

                the_posts_navigation(

                    array(
                        'prev_text' => esc_html__('Older Posts', 'blogger-buzz'),
                        'next_text' => esc_html__('Newer Posts', 'blogger-buzz'),
                    )
                );

            endif;

        endif;

    }
endif;

/**
 *
 * Home Page Blog Posts Meta.
 *
 */
function blogger_buzz_post_meta(){

    $enable_meta = get_theme_mod('blogger_buzz_enable_blog_meta', 'enable');
    $date = get_theme_mod('blogger_buzz_posts_date', true);
    $author = get_theme_mod('blogger_buzz_posts_author', true);
    $comments = get_theme_mod('blogger_buzz_posts_comments', true);

    if ($enable_meta == 'enable') : ?>
        <div class="post-meta">
            <ul>
                <?php
                if ($date == true) {
                    blogger_buzz_posted_on();
                }

                if ($comments == true) {
                    blogger_buzz_comments();
                }

                if ($author == true) {
                    blogger_buzz_posted_by();
                }

                ?>
            </ul>
        </div><!-- .entry-meta -->
    <?php endif;
}


/**
 * Footer Copyright Information
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'blogger_buzz_footer_copyright' ) ){

    function blogger_buzz_footer_copyright() {

        $copyright = get_theme_mod( 'blogger_buzz_footer_copyright' ); 

        if( !empty( $copyright ) ) { 

            echo wp_kses_post( apply_filters( 'blogger_buzz_copyright_text', $copyright ) ); 

        } else { 

            echo esc_html( apply_filters( 'blogger_buzz_copyright_text', $content = esc_html__('Copyright  &copy; ','blogger-buzz') . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) .' - ' ) );
        }
        
        printf( ' WordPress Theme : by %1$s', '<a href=" ' . esc_url('https://www.templatemonster.com/authors/sparklewpthemes/') . ' " rel="designer" target="_blank">'.esc_html__('Sparkle Themes','blogger-buzz').'</a>' );
        
    }
}
add_action( 'blogger_buzz_copyright', 'blogger_buzz_footer_copyright', 5 );



/**
 *
 * Blog Posts Meta.
 *
 */
function blogger_buzz_blog_post_meta(){

    $enable_meta = get_theme_mod('blogger_buzz_enable_meta', 'enable');
    $date = get_theme_mod('blogger_buzz_blog_date', true);
    $author = get_theme_mod('blogger_buzz_blog_author', true);
    $comments = get_theme_mod('blogger_buzz_blog_comments', true);
    $tags = get_theme_mod('blogger_buzz_blog_tags', true);


    if ($enable_meta == 'enable') : ?>
        <div class="post-meta">
            <ul>
                <?php
                    if ($date == true) {
                        blogger_buzz_posted_on();
                    }

                    if ($author == true) {
                        blogger_buzz_posted_by();
                    }

                    if ($comments == true) {
                        blogger_buzz_comments();
                    }

                    if ($tags == true) {
                        blogger_buzz_tags();
                    }
                ?>
            </ul>
        </div><!-- .entry-meta -->
    <?php endif;
}


if (!function_exists('blogger_buzz_preloader')):
    /**
     * Pre Loader Load on Front
     */
    function blogger_buzz_preloader(){

        $preloader = esc_attr(get_theme_mod('blogger_buzz_enable_preloader', 'enable'));

        if ($preloader == 'enable') {
            echo '<div class="preloader"></div>';
        }

    }
endif;
add_action('wp_head', 'blogger_buzz_preloader', 25);

if (!function_exists('blogger_buzz_dynamic_preloader')) {

    /**
     * Preloader Frontend Section area
     */
    function blogger_buzz_dynamic_preloader(){

        ?>
        <style type='text/css'>
            .no-js #loader {
                display: none;
            }

            .js #loader {
                display: block;
                position: absolute;
                left: 100px;
                top: 0;
            }

            .preloader {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999999;
                background: url('<?php echo esc_url( get_template_directory_uri() )."/assets/images/preloader.gif"; ?>') center no-repeat #fff;
            }
        </style>
    <?php }
}
add_action('wp_head', 'blogger_buzz_dynamic_preloader');