<?php get_header(); ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post();?>

        <?php
        $hero_image   = get_field('sdg_hero_image');
        $hero_heading = get_field('sdg_hero_heading');

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
                class="pt-12 text-center w-full
                        text-[2rem] sm:text-[6vw] lg:text-[3.5rem]
                        leading-tight text-[#ED6543] drop-shadow
                        font-semibold font-[var(--handdrawn,_inherit)]"
                >
                <?php echo wp_kses_post($hero_heading); ?>
                </h1>
            </div>
            <?php endif; ?>
        </section>

        <section class="bg-neutral-900">
            <div class="flex items-center justify-center md:px-16 py-8 md:max-w-7xl mx-auto">
                <div class="md:w-1/2 w-full flex flex-col items-center justify-center p-4 mr-4">
                    <?php if ($sdg_first_section_side_heading = get_field("sdg_first_section_side_heading")): ?>
                        <h2 class="text-white m-0 mb-5 text-3xl sm:text-4xl font-bold tracking-tight"><?php echo esc_html($sdg_first_section_side_heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($sdg_first_section_side_text = get_field("sdg_first_section_side_text")): ?>
                        <p class="text-[#ED6543] m-0 mb-5 text-lg sm:text-1xl tracking-widest leading-8"><?php echo esc_html($sdg_first_section_side_text); ?></p>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex flex-col items-center">
                    <?php if ($sdg_first_section_side_image = get_field("sdg_first_section_side_image")): ?>
                        <img src="<?php echo esc_url($sdg_first_section_side_image['url']); ?>" alt="<?php echo esc_attr($sdg_first_section_side_image['alt']); ?>" class="h-full md:w-full md:max-h-120 object-cover md:rounded-lg" />
                    <?php endif; ?>
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
                                    <h3 class="text-5xl font-bold mb-4 text-[#ED6543]"><?php echo esc_html($sdg_main_side_heading); ?></h3>
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
                                    <a href="<?php echo esc_url($sdg_link_button['url']); ?>" class="bg-[#DCE896] text-black font-bold px-8 py-2 rounded shadow hover:bg-[#ED6543] transition">
                                        <?php echo esc_html($sdg_button); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="md:w-1/2 w-full flex flex-col items-center">
                                <?php if ($sdg_side_image = get_field("sdg_side_image")): ?>
                                    <img src="<?php echo esc_url($sdg_side_image['url']); ?>" alt="<?php echo esc_attr($sdg_side_image['alt']); ?>" class="h-full md:w-full md:max-h-120 object-cover md:rounded-lg" />
                                <?php endif; ?>
                            </div>
                        </div>
                            
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="flex flex-col md:flex-row items-center justify-between px-8 py-8 max-w-7xl mx-auto">
                    
                <div class="md:w-1/2 w-full flex flex-col items-center md:items-start p-4 mr-4">
                    <?php if ($sdg_second_section_side_heading = get_field('sdg_second_section_side_heading')): ?>
                        <h2 class="p-6 pb-2 text-5xl font-bold text-black"><?php echo esc_html($sdg_second_section_side_heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($sdg_second_section_side_text = get_field('sdg_second_section_side_text')): ?>
                        <p class="p-6 text-black leading-relaxed">
                            <?php echo esc_html($sdg_second_section_side_text); ?>
                        </p>
                    <?php endif; ?>
                    <?php
                        $sdg_second_section_side_button = get_field('sdg_second_section_side_button');
                        $sdg_second_section_side_button_link = get_field('sdg_second_section_side_button_link');
                    if ($sdg_second_section_side_button && $sdg_second_section_side_button_link): ?>
                        <a href="<?php echo esc_url($sdg_second_section_side_button_link['url']); ?>" class="flex self-center bg-[#FFD54F] text-black font-bold px-8 py-2 rounded shadow hover:bg-[#ED6543] transition">
                            <?php echo esc_html($sdg_second_section_side_button); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex justify-center">
                    <?php if ($sdg_second_section_side_image = get_field('sdg_second_section_side_image')): ?>
                        <img src="<?php echo esc_url($sdg_second_section_side_image['url']); ?>" alt="<?php echo esc_attr($sdg_second_section_side_image['alt']); ?>" class="w-2/3 max-w-xs mb-6 object-contain md:rounded-lg" />
                    <?php endif; ?>
                </div>

            </section>

        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer(); ?>