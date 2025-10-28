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
        pll_register_string('Sustainability', 'SUSTAINABILITY');
        pll_register_string('Blogs', 'Blogs');
        pll_register_string('Testimonial', 'Submit');
        pll_register_string('Testimonial', 'Name');
        pll_register_string('Testimonial', 'Rating');
        pll_register_string('Testimonial', 'Photo');
        pll_register_string('Testimonial', 'Text');
        pll_register_string('Testimonial', 'Button');
        pll_register_string('Testimonial', 'Submition');
        pll_register_string('Testimonial', 'Register');
        pll_register_string('All categories', 'All categories');
        pll_register_string('Survey Title', 'Survey Title');
        pll_register_string('Gender Q', 'Gender Q');
        pll_register_string('Select', 'Select');
        pll_register_string('Woman', 'Woman');
        pll_register_string('Man', 'Man');
        pll_register_string('Other', 'Other');
        pll_register_string('Age Q', 'Age Q');
        pll_register_string('Motivations', 'Motivations');
        pll_register_string('Motivations', 'Physical wellbeing');
        pll_register_string('Motivations', 'Appearance/fitness');
        pll_register_string('Motivations', 'Environmental impact');
        pll_register_string('Motivations', 'Saving money');
        pll_register_string('Motivations', 'Family influence');
        pll_register_string('Motivations', 'Other...');
        pll_register_string('Gender Q', 'Gender Q');
        pll_register_string('Select', 'Select');
        pll_register_string('Woman', 'Woman');
        pll_register_string('Man', 'Man');
        pll_register_string('Other', 'Other');
        pll_register_string('Age Q', 'Age Q');
        pll_register_string('How important', 'How important');
        pll_register_string('Very important', 'Very important');
        pll_register_string('Somewhat important', 'Somewhat important');
        pll_register_string('Not very important', 'Not very important');
        pll_register_string('Not important at all', 'Not important at all');
        pll_register_string('Author:', 'Author:');
        pll_register_string('Leave a reply', 'Leave a reply');
        pll_register_string('Sustainability', 'SUSTAINABILITY');
        pll_register_string('Blogs', 'Blogs');
        pll_register_string('All categories', 'All categories');
        pll_register_string('How often', 'Never');
        pll_register_string('How often', 'Rarely');
        pll_register_string('How often', 'Sometimes');
        pll_register_string('How often', 'Often');
        pll_register_string('Main reasons', 'Main reasons');
        pll_register_string('Main reasons', 'Buying too much');
        pll_register_string('Main reasons', 'Forgetting what is in the fridge');
        pll_register_string('Main reasons', 'Cooking too much');
        pll_register_string('Main reasons', 'Food spoiling before use');
        pll_register_string('Main reasons', 'Confusion about expiry dates');
        pll_register_string('Reduce food waste', 'Reduce food waste');
        pll_register_string('Reduce food waste', 'Economic benefits');
        pll_register_string('Reduce food waste', 'Helping the environment');
        pll_register_string('Reduce food waste', 'Feeling responsible');
        pll_register_string('Reduce food waste', 'Social pressure (family, friends)');
        pll_register_string('Reduce food waste', 'Better meal planning');
        pll_register_string('Message', 'Message');
        pll_register_string('Message', 'Financial savings');
        pll_register_string('Message', 'Ecological footprint');
        pll_register_string('Message', 'Health benefits');
        pll_register_string('Message', 'Moral responsibility');
        pll_register_string('Message', 'Community/collective action');
        pll_register_string('Submit survey', 'Submit survey');
        pll_register_string('Submit survey', 'Thank you survey');
        pll_register_string('Home', 'Meet our vendors');
        pll_register_string('Home', 'About us');

}

add_action('init', 'plp_register_strings');


function handle_testimonial_submission() {
    if ( ! is_user_logged_in() ) {
        $login_url    = wp_login_url( wp_get_referer() ?: home_url() );
        $register_url = wp_registration_url();
        wp_die(
            sprintf(
                'You must be logged in to submit a testimonial. <a href="%1$s">Log in</a> or <a href="%2$s">Register</a>.',
                esc_url( $login_url ),
                esc_url( $register_url )
            ),
            'Login required',
            array( 'response' => 403 )
        );
    }

    if (
        ! isset( $_POST['testimonial_nonce'] ) ||
        ! wp_verify_nonce( $_POST['testimonial_nonce'], 'submit_testimonial_action' )
    ) {
        wp_die( 'Security check failed', 'Invalid request', array( 'response' => 403 ) );
    }

    $name    = isset( $_POST['testimonial_name'] ) ? sanitize_text_field( wp_strip_all_tags( $_POST['testimonial_name'] ) ) : '';
    $rating  = isset( $_POST['testimonial_rating'] ) ? intval( $_POST['testimonial_rating'] ) : 5;
    $rating  = min( 5, max( 1, $rating ) );
    $content = isset( $_POST['testimonial_content'] ) ? wp_kses_post( $_POST['testimonial_content'] ) : '';

    $current_user = wp_get_current_user();

    $testimonial_id = wp_insert_post( array(
        'post_type'    => 'testimonial',
        'post_title'   => $name ?: 'Anonymous',
        'post_content' => $content,
        'post_status'  => 'pending',
        'post_author'  => $current_user->ID,
    ) );

    if ( $testimonial_id && ! is_wp_error( $testimonial_id ) ) {
        if ( function_exists( 'update_field' ) ) {
            update_field( 'testimonial_name', $name, $testimonial_id );
            update_field( 'testimonial_rating', $rating, $testimonial_id );
        } else {
            update_post_meta( $testimonial_id, 'testimonial_name', $name );
            update_post_meta( $testimonial_id, 'testimonial_rating', $rating );
        }

        if ( ! empty( $_FILES['testimonial_photo']['name'] ) && ! empty( $_FILES['testimonial_photo']['tmp_name'] ) ) {
            $file = $_FILES['testimonial_photo'];
            $max_file_size = 1 * 1024 * 1024; // 1MB

            if ( $file['size'] <= $max_file_size ) {
                $check = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );
                $allowed_exts = array( 'jpg', 'jpeg', 'png', 'gif', 'webp' );

                if ( ! empty( $check['ext'] ) && in_array( strtolower( $check['ext'] ), $allowed_exts, true ) && strpos( $check['type'], 'image/' ) === 0 ) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $attachment_id = media_handle_upload( 'testimonial_photo', $testimonial_id );

                    if ( ! is_wp_error( $attachment_id ) ) {
                        if ( function_exists( 'update_field' ) ) {
                            update_field( 'testimonial_photo', $attachment_id, $testimonial_id );
                        } else {
                            set_post_thumbnail( $testimonial_id, $attachment_id );
                            update_post_meta( $testimonial_id, 'testimonial_photo', $attachment_id );
                        }
                    }
                }
            }
        }
    }

    $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    wp_safe_redirect( add_query_arg( 'testimonial', 'success', $redirect ) );
    exit;
}

add_action('admin_post_nopriv_submit_testimonial', 'handle_testimonial_submission');
add_action('admin_post_submit_testimonial', 'handle_testimonial_submission');

// Food Survey
function handle_food_survey_submission() {
    if (isset($_POST['survey_submit'])) {

        $post_id = wp_insert_post(array(
            'post_type'   => 'survey_response',
            'post_status' => 'publish',
            'post_title'  => 'Survey Response - ' . date('Y-m-d H:i:s'),
        ));

        if ($post_id) {
            update_field('survey_gender', sanitize_text_field($_POST['survey_gender']),$post_id);
            update_field('survey_age', sanitize_text_field($_POST['survey_age']), $post_id);
            update_field('survey_health_importance', sanitize_text_field($_POST['survey_healthy_eating']));
            update_field('survey_food_waste_frequency', sanitize_text_field($_POST['survey_food_waste_frequency']), $post_id);

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

            wp_redirect(add_query_arg('survey_submitted', 'true', get_permalink()));
            exit;
        }
    }
}
add_action('admin_post_nopriv_submit_food_survey', 'handle_food_survey_submission');
add_action('admin_post_submit_food_survey', 'handle_food_survey_submission');


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

function yumgo_grant_testimonial_caps() {
    $roles = ['administrator', 'um_testimonials-checker'];
    
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

    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if (! $role) {
            continue;
        }

        foreach ($caps as $cap) {
            $role->add_cap($cap);
        }
    }
}
add_action('init', 'yumgo_grant_testimonial_caps');

function shop_enable_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'shop_enable_woocommerce_support');

function rename_dokan_vendor_to_restaurant( $translated_text ) {
    $translated_text = str_ireplace( 'Store', 'Restaurant', $translated_text );
    $translated_text = str_ireplace( 'store', 'restaurant', $translated_text );
    $translated_text = str_ireplace( 'Vendor', 'Restaurant', $translated_text );
    $translated_text = str_ireplace( 'vendor', 'restaurant', $translated_text );
    return $translated_text;
}
add_filter( 'gettext', 'rename_dokan_vendor_to_restaurant' );