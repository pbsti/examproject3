<?php
function enqueue_theme_assets() {
    wp_enqueue_style('styles', get_template_directory_uri() . '/css/style.css', array(), filemtime(get_template_directory() . '/css/style.css'));
    wp_enqueue_script('scroll-to', get_template_directory_uri() . '/js/scrollTo.js', array(), filemtime(get_template_directory() . '/js/scrollTo.js'), true);
    add_theme_support('title-tag');
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
        pll_register_string('Date:', 'Date:');
        pll_register_string('Author:', 'Author:');
        pll_register_string('Leave a reply', 'Leave a reply');
}

add_action('init', 'plp_register_strings');


function handle_testimonial_submission() {
    if (
        !isset($_POST['testimonial_nonce']) ||
        !wp_verify_nonce($_POST['testimonial_nonce'], 'submit_testimonial_action')
    ) {
        wp_die('Security check failed');
    }

    $name = sanitize_text_field($_POST['testimonial_name']);
    $rating = intval($_POST['testimonial_rating']);
    $content = sanitize_textarea_field($_POST['testimonial_content']);

    $testimonial_id = wp_insert_post([
        'post_type'   => 'testimonial',
        'post_title'  => $name,
        'post_content'=> $content,
        'post_status' => 'pending'
    ]);

    if ($testimonial_id) {
        update_field('testimonial_name', $name, $testimonial_id);
        update_field('testimonial_rating', $rating, $testimonial_id);

        if (!empty($_FILES['testimonial_photo']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attachment_id = media_handle_upload('testimonial_photo', $testimonial_id);
            if (!is_wp_error($attachment_id)) {
                update_field('testimonial_photo', $attachment_id, $testimonial_id);
            }
        }
    }

    wp_redirect(add_query_arg('testimonial', 'success', wp_get_referer()));
    exit;
}

add_action('admin_post_nopriv_submit_testimonial', 'handle_testimonial_submission');
add_action('admin_post_submit_testimonial', 'handle_testimonial_submission');

function yumgo_register_testimonial_cpt() {
    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial'
        ],
        'public' => true,
        'has_archive' => false,
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'yumgo_register_testimonial_cpt');

add_filter('use_block_editor_for_post_type', function($use_block_editor, $post_type) {
    if ($post_type === 'testimonial') {
        return false;
    }
    return $use_block_editor;
}, 10, 2);
