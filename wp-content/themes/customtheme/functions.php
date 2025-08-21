<?php
function enqueue_theme_assets() {
    wp_enqueue_style('styles', get_template_directory_uri() . '/css/style.css', array(), filemtime(get_template_directory() . '/css/style.css'));
    add_theme_support('title-tag'); // Lets WordPress manage the <title> tag
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');