<?php
/**
 * Dynamic css
*/
if (! function_exists('blogger_buzz_dynamic_css')){
    function blogger_buzz_dynamic_css(){

        $title_font = get_theme_mod('blogger_buzz_site_title_font_family','arizonia');  
        $font_size  = get_theme_mod('blogger_buzz_site_title_font_size',80);
        $px = 'px';

        $blogger_buzz_dynamic = '';

        // Title Fonts Typography.
        $blogger_buzz_dynamic .= "
        .bz_main_nav .site-title a{
            font-family: $title_font, cursive;
        }
        .bz_main_header .site-branding h1 a{
            font-family: $title_font, cursive;
            font-size: $font_size$px;
            
        }\n";


        wp_add_inline_style( 'blogger-buzz-style', $blogger_buzz_dynamic );
    }
}
add_action( 'wp_enqueue_scripts', 'blogger_buzz_dynamic_css', 99 );