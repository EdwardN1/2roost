<?php

function twor_prefix_register_footer_styles() {
    wp_register_style('twor_styles', twordivi_PLUGINURI.'css/style.css', array(), '1.0.1', 'all');
};

function twor_prefix_add_footer_styles() {
    wp_enqueue_style('twor_styles', twordivi_PLUGINURI.'css/style.css', array(), '1.0.1', 'all');
};
add_action( 'init', 'twor_prefix_register_footer_styles' );
add_action( 'get_footer', 'twor_prefix_add_footer_styles' );
//add_action( 'wp_enqueue_scripts', 'teor_prefix_add_footer_styles' );