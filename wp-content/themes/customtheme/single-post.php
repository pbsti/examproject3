<?php get_header(); ?>

<main class="container mx-auto px-4 py-8 max-w-5xl">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                foreach ($categories as $index => $cat) {
                    echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="text-emerald-500 font-bold text-sm uppercase cursor-pointer hover:text-green-600 transition-colors">' . esc_html($cat->name) . '</a>';
                    if ($index < count($categories) - 1) {
                        echo '<span class="text-emerald-500">,&nbsp</span>';
                    }
                }
            }
            ?>
        </div>

        <h1 class="text-4xl font-extrabold mb-2"><?php the_title(); ?></h1>

        <div class="flex items-start justify-between mb-2">
            <div class="mb-2 flex flex-wrap">
                <?php
                $tags = get_the_tags();
                if (!empty($tags)) {
                    foreach ($tags as $index => $tag) {
                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="text-black text-xs uppercase cursor-pointer hover:text-green-600 transition-colors">' . esc_html($tag->name) . '</a>';
                        if ($index < count($tags) - 1) {
                            echo '<span class="text-xs text-black">,&nbsp </span>';
                        }
                    }
                }
                ?>
            </div>

            <div class="flex flex-col text-xs text-black min-w-38 pl-6 items-end">
                <span>
                    <?php pll_e('Date:') ?>
                    <time datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date(); ?>
                    </time>
                </span>
                <span>
                    <?php pll_e('Author:') ?>
                    <?php the_author(); ?>
                </span>
            </div>
        </div>

        <div class="prose max-w-none text-base mb-8">
            <?php the_content(); ?>
        </div>

        <?php comments_template(); ?>



    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>