<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blogger_buzz
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
?>

    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'blogger-buzz'); ?></a>

    <div class="search-content ">
        <span class="search-close"><i class="far fa-times-circle"></i></span>
        <div class="search-inner">
            <?php get_search_form(); ?>
        </div>
    </div>

    <?php
        $header_layout  = get_theme_mod('blogger_buzz_header_layout', 'layout_one');
        $search_options = get_theme_mod('blogger_buzz_enable_search_icon', 'enable');
        $sidenav        = get_theme_mod('blogger_buzz_enable_sidenav', 'enable');

        $stickyHeader = get_theme_mod('blogger_buzz_enable_header_sticky', 'enable');

        if ($sidenav == 'enable' && $header_layout != 'layout_three' ):
    ?>
        <div class="sidenav ">
            <div class="side-menu-container">

                <span class="close-side-menu"><i class="far fa-times-circle"></i></span>

                <?php
                    if (is_active_sidebar('sidenav')):

                        echo '<div class="' . esc_attr('side-menu-widgets widget-area') . '">';
                            dynamic_sidebar('sidenav');
                        echo '</div>';
                        
                    endif; 
                ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="side-overlay"></div>


<div id="page" class="site">

    <header id="masthead" class="site-header <?php if ($header_layout == 'layout_two') { echo esc_attr('header_layout_three'); } ?>">

        <?php if ($header_layout == 'layout_two') { blogger_buzz_site_branding(); } ?>

        <?php if ($header_layout == 'layout_one' || $header_layout == 'layout_two'): ?>

            <div class="bz_top_header <?php if ($header_layout == 'layout_two' && $stickyHeader == 'enable'): ?> sticky-nav <?php endif; ?>">
                <div class="container">
                    <div class="row">

                        <?php if ($header_layout == 'layout_two') : ?>
                            <div class="col-lg-8 col-md-2 col-sm-4 col-4 top_header_left bz_main_nav">
                                <button class="main-menu-toggle"  aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i>
                                </button>
                                <?php blogger_buzz_navigation(); ?>
                            </div>
                        
                            <div class="col-lg-4 col-md-10 col-sm-8 col-8 <?php if ($header_layout == 'layout_one') { echo esc_attr('top_header_left'); } else { echo esc_attr('top_header_right'); } ?>">
                                <?php blogger_buzz_social_links(); ?>
                            </div>

                        <?php endif; ?>


                        <?php if ($header_layout == 'layout_one'): ?>

                            <div class="col-lg-6 col-md-6 col-sm-12 top_header_left">
                                <?php blogger_buzz_social_links(); ?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 top_header_right">
                                <ul class="side-menu-search">
                                    <?php
                                        if ($search_options == 'enable'):
                                            echo '<li><a href="#" class="' . esc_attr('search_main_menu') . '"><i class="fas fa-search"></i></a></li>';
                                        endif;

                                        if ($sidenav == 'enable'):
                                            echo '<li><a href="#" class="side-bar-toggler"><i class="fas fa-bars"></i></a></li>';
                                        endif;
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php 

            if ($header_layout == 'layout_one' || $header_layout == 'layout_three'):

                blogger_buzz_site_branding();
        ?>
            <div class="bz_main_nav <?php if ($stickyHeader == 'enable') { ?>sticky-nav <?php } ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 desktop-flex">
                            <div class='site-branding-menu'>
                                <div>
                                    <?php the_custom_logo(); ?>
                                    <h1 class="site-title">
                                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                                    </h1>
                                </div>


                                <button class="main-menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>
                            </div>

                            <?php blogger_buzz_navigation(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </header><!-- #masthead -->

    <?php
        $breadcrumbs_enable = get_theme_mod('blogger_buzz_enable_breadcrumbs', 'enable');

        if ($breadcrumbs_enable == 'enable') {

            if (!is_front_page() || !is_home()) {
                /**
                 * @hook blogger_buzz_breadcrumbs.
                 *
                 * @hooked blogger_buzz_breadcrumbs.
                 *
                 */
                do_action('blogger_buzz_breadcrumbs');
            }
        }
    ?>

<div id="content" class="site-content">
