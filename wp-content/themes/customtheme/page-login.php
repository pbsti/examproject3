<?php
/**
 * Template Name: Login Page
 */


get_header(); 
?>

<div class="container mx-auto px-4 py-8 max-w-5xl py-32">
    <?php 
    if (shortcode_exists('ultimatemember')) {
        echo do_shortcode('[ultimatemember form_id="238"]'); 
    } else {
        echo '<p>Login functionality is currently unavailable. Please try again later.</p>';
    }
    ?>
</div>

<?php get_footer(); ?>