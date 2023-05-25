<?php


function twor_flex_init() {
    wp_enqueue_script( 'twor-flex-init', twordivi_PLUGINURI . 'js/jquery.flexslider.init.js', array( 'jquery','flexslider' ), 1.0, true );
}

function remove_ph_flex_init() {
    wp_dequeue_script('flexslider-init');
}

add_action( 'wp_print_scripts', 'remove_ph_flex_init', 100 );
add_action( 'wp_enqueue_scripts', 'twor_flex_init', 100 );