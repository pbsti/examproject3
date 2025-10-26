<?php get_header(); ?>

    <div class="container mx-auto px-4 py-8 max-w-5xl py-20">
        <?php 
        $page_id = 310;
        $page_content = apply_filters('the_content', get_post($page_id)->post_content);
        echo $page_content;
        ?>
    </div>

<?php get_footer(); ?>