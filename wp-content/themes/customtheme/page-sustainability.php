<?php get_header(); ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post();?>

        <?php
        /**
         * Template Name: Sustainability
         * Template Post Type: page
         */

        defined('ABSPATH') || exit;
        get_header();

        $hero_image   = get_field('sdg_hero_image');   // image (array | ID | URL)
        $hero_heading = get_field('sdg_hero_heading'); // text

        // Normalize image URL
        $hero_url = '';
        if ($hero_image) {
        if (is_array($hero_image) && isset($hero_image['url'])) $hero_url = esc_url($hero_image['url']);
        elseif (is_numeric($hero_image)) { $src = wp_get_attachment_image_src($hero_image, 'full'); $hero_url = $src ? esc_url($src[0]) : ''; }
        elseif (is_string($hero_image)) $hero_url = esc_url($hero_image);
        }
        ?>

        <section class="relative overflow-hidden bg-neutral-100">
            <?php if ($hero_url): ?>
            <img
                src="<?php echo $hero_url; ?>"
                alt="<?php echo esc_attr($hero_heading ?: get_the_title()); ?>"
                class="w-full h-80 sm:h-[60vh] lg:h-[520px] object-cover"
                loading="eager"
            />
            <?php endif; ?>

            <?php if ($hero_heading): ?>
            <div class="absolute inset-0 grid place-items-start">
                <h1
                class="pt-9 text-center w-full
                        text-[2rem] sm:text-[6vw] lg:text-[3.5rem]
                        leading-tight text-orange-500 drop-shadow
                        font-semibold font-[var(--handdrawn,_inherit)]"
                >
                <?php echo wp_kses_post($hero_heading); ?>
                </h1>
            </div>
            <?php endif; ?>
        </section>

        <!-- MISSION (page content) -->
        <section class="bg-neutral-900 text-white">
            <div class="max-w-screen-xl mx-auto px-4 py-12 lg:py-16">
            <h2 class="m-0 mb-5 text-2xl sm:text-3xl font-bold tracking-tight">our mission</h2>

            <div class="max-w-xl text-neutral-200 text-[0.95rem] leading-relaxed space-y-4">
                <?php // while (have_posts()) { the_post(); the_content(); } ?>
            </div>
            </div>
        </section>

        <section>
                <div class="flex flex-col md:items-center text-center justify-center md:px-16 py-8 md:max-w-7xl mx-auto">
                    <?php 
                    $sdg_args = new WP_Query(array(
                        'post_type' => 'sustainable-developm',
                        'posts_per_page' => -1,
                        'orderby' => 'date',
                        'order' => 'asc',
                    ));
                    if ($sdg_args->have_posts()): ?>
                        <?php while ($sdg_args->have_posts()): $sdg_args->the_post(); 
                            $is_even = $sdg_args->current_post % 2 === 0;
                        ?>
                        <div class="flex w-full my-8 <?php echo $is_even ? 'flex-row-reverse' : 'flex-row'; ?>">
                            <div class="md:w-1/2 w-full flex flex-col items-center justify-center md:border border-gray-200 md:rounded-lg md:shadow-sm p-4 <?php echo $is_even ? 'ml-4' : 'mr-4'; ?>">
                                <?php if ($sdg_main_side_heading = get_field("sdg_main_side_heading")): ?>
                                    <h3 class="text-4xl font-bold mb-4 text-black"><?php echo esc_html($sdg_main_side_heading); ?></h3>
                                <?php endif; ?>
                                <?php if ($sdg_second_side_heading = get_field("sdg_second_side_heading")): ?>
                                    <h4 class="text-2xl font-bold mb-4 text-black"><?php echo esc_html($sdg_second_side_heading); ?></h4>
                                <?php endif; ?>
                                <?php if ($sdg_side_content = get_field("sdg_side_content")): ?>
                                    <p class="p-6 text-black leading-relaxed">
                                        <?php echo esc_html($sdg_side_content); ?>
                                    </p>
                                <?php endif; ?>
                                <?php
                                    $sdg_button = get_field("sdg_button");
                                    $sdg_link_button = get_field("sdg_link_button");
                                if ($sdg_button && $sdg_link_button): ?>
                                    <a href="<?php echo esc_url($sdg_link_button['url']); ?>" class="bg-[#DCE896] text-black font-bold px-8 py-2 rounded shadow hover:bg-green-300 transition">
                                        <?php echo esc_html($sdg_button); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="md:w-1/2 w-full flex flex-col items-center">
                                <?php if ($sdg_side_image = get_field("sdg_side_image")): ?>
                                    <img src="<?php echo esc_url($sdg_side_image['url']); ?>" alt="<?php echo esc_attr($sdg_side_image['alt']); ?>" class="w-full md:max-h-120 object-cover md:rounded-lg" />
                                <?php endif; ?>
                            </div>
                        </div>
                            
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer(); ?>