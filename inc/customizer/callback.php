<?php 
/*
 * Header Settings Active Callback Function.
*/
function blogger_buzz_header(){

  $header_layout = get_theme_mod('blogger_buzz_header_layout','layout_one');

  if ($header_layout !== 'layout_three') {

    return true;
  }
  else {
    return false;
  }
}

/*
 * Featured Posts Active Callback Function.
*/
function blogger_buzz_feature(){

  $feature_posts = get_theme_mod('blogger_buzz_enable_featured_posts','disable');

  if ($feature_posts == 'enable') {

    return true;
  }
  else {
    return false;
  }
}

/*
 * Home Page Blog Post Description Callback Function.
*/
function blogger_buzz_post_content(){

  $posts_description = get_theme_mod('blogger_buzz_posts_description','content_excerpt');

  if ($posts_description == 'content_excerpt') {

    return true;
  }
  else {
    return false;
  }
}
/*
 * Home Page Blog Meta Callback Function.
*/
function blogger_buzz_blog_meta(){

  $enable_posts_meta = get_theme_mod('blogger_buzz_enable_blog_meta','enable');

  if ($enable_posts_meta == 'enable') {

    return true;
  }
  else {
    return false;
  }
}

/*
 * Single Blog Posts Pagination Active Callback Function.
*/
function blogger_buzz_blog_pagination(){

  $single_blog_pagination = get_theme_mod('blogger_buzz_enable_pagination','enable');

  if ($single_blog_pagination == 'enable') {

    return true;
  }
  else {
    return false;
  }
}


/*
 *  Blog Posts Meta Active Callback Function.
*/
function blogger_buzz_blog_metas(){

  $blog_metas = get_theme_mod('blogger_buzz_enable_meta','enable');

  if ($blog_metas == 'enable') {

    return true;
  }
  else {
    return false;
  }
}

/*
 *  Blog Posts Author Active Callback Function.
*/
function blogger_buzz_blog_enable_author(){
  $author  = get_theme_mod('blogger_buzz_enable_author_description','enable');

  if ( $author == 'enable' ) {

    return true;
  }
  else {
    return false;
  }
}

/*
 *  Blog Posts Author Active Callback Function.
*/
function blogger_buzz_blog_author(){
  $enable_author  = get_theme_mod('blogger_buzz_enable_author_description','enable');
  $blog_author = get_theme_mod('blogger_buzz_blog_author_social',true);

  if ( $enable_author == 'enable' && $blog_author == true ) {

    return true;
  }
  else {
    return false;
  }
}

/*
 *  Instagram Feed Active Callback Function.
*/
function blogger_buzz_instagram_feed(){
  $instagram_feed  = get_theme_mod('blogger_buzz_enable_instagram_posts','disable');

  if ( $instagram_feed == 'enable' ) {

    return true;
  }
  else {
    return false;
  }
}
