<?php
function enqueue_theme_assets() {
    wp_enqueue_style('styles', get_template_directory_uri() . '/css/style.css', array(), filemtime(get_template_directory() . '/css/style.css'));
    add_theme_support('title-tag'); // Lets WordPress manage the <title> tag
}

add_action('wp_enqueue_scripts', 'enqueue_theme_assets');


function plp_disable_gutenberg() {
    remove_post_type_support('page', 'editor');
}

add_action('init', 'plp_disable_gutenberg');

function plp_register_strings() {
        pll_register_string('Home', 'Home');
        pll_register_string('Blogs', 'Yumgo Blogs');
        pll_register_string('Log In', 'Log In');
        pll_register_string('Cart', 'Cart');
}

add_action('init', 'plp_register_strings');