<?php
function twor_scripts() {
    wp_enqueue_script( 'twor_scripts', twordivi_PLUGINURI. 'js/twor_scripts.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'twor_scripts' );