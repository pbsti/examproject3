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

// Food Survey
function handle_food_survey_submission() {
    if (isset($_POST['survey_submit'])) {


        print_r($_POST); // For debugging purposes
        $post_id = wp_insert_post(array(
            'post_type'   => 'survey_response',
            'post_status' => 'publish',
            'post_title'  => 'Survey Response - ' . date('Y-m-d H:i:s'),
        ));

        if ($post_id) {
            // Simple fields
            update_post_meta($post_id, 'gender', sanitize_text_field($_POST['survey_gender']));
            update_post_meta($post_id, 'age', sanitize_text_field($_POST['survey_age']));
            update_post_meta($post_id, 'health_importance', sanitize_text_field($_POST['survey_healthy_eating']));
            update_post_meta($post_id, 'food_waste_frequency', sanitize_text_field($_POST['survey_food_waste_frequency']));

            // Checkbox fields
            if (!empty($_POST['survey_health_motives'])) {
                $health_motives = array_map('sanitize_text_field', $_POST['survey_health_motives']);
                update_post_meta($post_id, 'health_motives', $health_motives);
            }

            if (!empty($_POST['survey_food_waste_reasons'])) {
                $food_waste_reasons = array_map('sanitize_text_field', $_POST['survey_food_waste_reasons']);
                update_post_meta($post_id, 'food_waste_reasons', $food_waste_reasons);
            }

            if (!empty($_POST['survey_food_waste_motives'])) {
                $food_waste_motives = array_map('sanitize_text_field', $_POST['survey_food_waste_motives']);
                update_post_meta($post_id, 'food_waste_motives', $food_waste_motives);
            }

            if (!empty($_POST['survey_message_types'])) {
                $message_types = array_map('sanitize_text_field', $_POST['survey_message_types']);
                update_post_meta($post_id, 'message_types', $message_types);
            }

            // Thank you
            wp_redirect(add_query_arg('survey_submitted', 'true', get_permalink()));
            exit;
        }
    }
}
add_action('init', 'handle_food_survey_submission');


function yumgo_register_testimonial_cpt() {
    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial'
        ],
        'public' => true,
        'capability_type' => 'testimonial',
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

register_post_type('ability', array(
    'label' => 'Abilities',
    'public' => true,
    'capability_type' => 'ability',
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
));

function add_ability_caps_to_um_members() {
    $role = get_role('administrator');
    if ($role) {
        $role->add_cap('read');
        $role->add_cap('edit_abilities');
        $role->add_cap('edit_others_abilities');
        $role->add_cap('publish_abilities');
        $role->add_cap('delete_abilities');

        $role->add_cap('edit_responses');
        $role->add_cap('edit_others_responses');
        $role->add_cap('publish_responses');
        $role->add_cap('delete_responses');
    }
}
add_action('init', 'add_ability_caps_to_um_members');

function enhance_um_comment_editor_role() {
    $role = get_role('um_comment-editor');

    if ($role) {
        $role->add_cap('read');
        $role->add_cap('moderate_comments');
        $role->add_cap('edit_posts');
        $role->add_cap('edit_others_posts');
        $role->add_cap('delete_posts');
        $role->add_cap('delete_others_posts');
    }
}
add_action('init', 'enhance_um_comment_editor_role');

function um_comment_editor_meta_caps($caps, $cap, $user_id, $args) {
    if (in_array($cap, array('edit_comment', 'delete_comment', 'moderate_comment'))) {
        $user = get_userdata($user_id);
        if (in_array('um_comment-editor', (array) $user->roles)) {
            $caps = array('moderate_comments');
        }
    }
    return $caps;
}
add_filter('map_meta_cap', 'um_comment_editor_meta_caps', 10, 4);

function yumgo_grant_admin_testimonial_caps() {
    $role = get_role('administrator');
    if (! $role) {
        return;
    }

    $caps = [
        'edit_testimonial',
        'read_testimonial',
        'delete_testimonial',
        'edit_testimonials',
        'edit_others_testimonials',
        'publish_testimonials',
        'read_private_testimonials',
        'delete_testimonials',
        'delete_private_testimonials',
        'delete_published_testimonials',
        'delete_others_testimonials',
        'edit_private_testimonials',
        'edit_published_testimonials',
    ];

    foreach ($caps as $cap) {
        $role->add_cap($cap);
    }
}
add_action('init', 'yumgo_grant_admin_testimonial_caps');