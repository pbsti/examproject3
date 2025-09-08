<?php get_header(); ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post();?>

        <main class="min-h-screen w-full">
            <section class="w-full flex justify-center z-0 overflow-hidden relative">
                    <?php if ($img = get_field('main_hero_image')): ?>
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full object-cover" />
                    <?php endif; ?>
                    <!-- FIX :D -->
                    <div class="flex items-center justify-center absolute top-2/3 left-1/2 md:left-6/11 text-center gap-10 px-4">
                        <a href="#vendors" class="bg-yellow-300 text-black font-bold px-6 py-2 rounded shadow hover:bg-yellow-400 transition">Meet our vendors</a>
                        <a href="#about" class="bg-yellow-200 text-black font-bold px-6 py-2 rounded shadow hover:bg-yellow-300 transition">About us</a>
                    </div>
                </div>
            </section>

            <section class="flex flex-col md:flex-row items-center justify-between px-8 py-16 max-w-7xl mx-auto">
                    
                <div class="md:w-1/2 w-full flex flex-col items-center md:items-start">
                    <?php if ($img = get_field('main_headline_image')): ?>
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full max-w-md object-contain" />
                    <?php endif; ?>
                    <?php if ($text = get_field('first_text_on_fp')): ?>
                        <p class="p-6 text-black leading-relaxed">
                            <?php echo esc_html($text); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex justify-center mb-8 md:mb-0">
                    <?php if ($img = get_field('first_side_image')): ?>
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-2/3 max-w-xs mb-6 object-contain" />
                    <?php endif; ?>
                </div>

            </section>

        </main>

        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer(); ?>