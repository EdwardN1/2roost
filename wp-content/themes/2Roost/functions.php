<?php
function divi__two_roost_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'divi__two_roost_enqueue_styles' );
 
 
//you can add custom functions below this line:
