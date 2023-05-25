<?php


function twor_bootstrap() {
    wp_enqueue_style('twor_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css', array(), '1.0.1', 'all');
}

//add_action( 'wp_enqueue_scripts', 'twor_bootstrap', 100 );