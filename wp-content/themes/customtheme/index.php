<?php get_header(); ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post();?>

        <main class="min-h-screen w-full">
            <section class="w-full flex justify-center z-0 overflow-hidden relative">
                    <?php if ($img = get_field('main_hero_image')): ?>
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full object-cover" />
                    <?php endif; ?>
                    <div class="hidden md:flex items-center justify-center absolute top-2/3 left-1/2 md:left-6/11 text-center gap-10 px-4 lg:ml-22">
                        <a href="#vendors" class="bg-yellow-300 text-lg text-black font-bold px-6 py-2 rounded shadow hover:bg-yellow-400 transition">Meet our vendors</a>
                        <a href="#about" class="bg-yellow-200 text-lg text-black font-bold px-6 py-2 rounded shadow hover:bg-yellow-300 transition">About us</a>
                    </div>
            </section>

            <section class="flex flex-col md:flex-row items-center justify-between px-8 py-8 max-w-7xl mx-auto">
                    
                <div class="md:w-1/2 w-full flex flex-col items-center md:items-start md:border border-gray-200 md:rounded-lg md:shadow-sm p-4 mr-4">
                    <?php if ($img = get_field('main_headline_image')): ?>
                        <h1><img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full max-w-md object-contain md:rounded-lg" /></h1>
                    <?php endif; ?>
                    <?php if ($text = get_field('first_text_on_fp')): ?>
                        <p class="p-6 text-black leading-relaxed">
                            <?php echo esc_html($text); ?>
                        </p>
                    <?php endif; ?>
                    <?php
                        $first_button_text = get_field('first_button_text');
                        $first_button_link = get_field('first_button_link');
                    if ($first_button_text && $first_button_link): ?>
                        <a href="<?php echo esc_url($first_button_link['url']); ?>" class="flex self-center bg-[#DCE896] text-black font-bold px-8 py-2 rounded shadow hover:bg-green-300 transition"
                            aria-label="<?php echo esc_attr($first_button_text); ?>">
                            <?php echo esc_html($first_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex justify-center">
                    <?php if ($img = get_field('first_side_image')): ?>
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-2/3 max-w-xs mb-6 object-contain md:rounded-lg" />
                    <?php endif; ?>
                </div>

            </section>
            
            <section class="flex flex-row-reverse items-center justify-between md:px-8 py-8 max-w-7xl mx-auto">
                <div class="md:w-1/2 w-full flex flex-col items-center md:border border-gray-200 md:rounded-lg md:shadow-sm p-4 ml-4">
                    <?php if ($section_one_headline = get_field('section_one_headline')): ?>
                        <h2 id="vendors" class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($section_one_headline); ?></h2>
                    <?php endif; ?>

                    <?php if ($section_one_text = get_field('section_one_text')): ?>
                        <p class="p-6 text-black leading-relaxed">
                            <?php echo esc_html($section_one_text); ?>
                        </p>
                    <?php endif; ?>
                    <?php
                        $section_one_button_text = get_field('section_one_button_text');
                        $section_one_button_link = get_field('section_one_button_link');
                    if ($section_one_button_text && $section_one_button_link): ?>
                        <a href="<?php echo esc_url($section_one_button_link['url']); ?>" class="bg-[#DCE896] text-black font-bold px-8 py-2 rounded shadow hover:bg-green-300 transition"
                            aria-label="<?php echo esc_attr($section_one_button_text); ?>">
                            <?php echo esc_html($section_one_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex flex-col items-center">
                    <?php if ($section_one_image = get_field('section_one_image')): ?>
                        <img src="<?php echo esc_url($section_one_image['url']); ?>" alt="<?php echo esc_attr($section_one_image['alt']); ?>" class="h-full w-auto md:w-full md:max-h-120 lg:h-82 object-cover md:rounded-lg" />
                    <?php endif; ?>
                </div>
            </section>

            <section class="flex items-center justify-center text-center px-16 py-8 max-w-7xl mx-auto">
                    <?php if($section_splitter_text_one = get_field('section_splitter_text_one')): ?>
                        <p class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($section_splitter_text_one); ?></p>
                    <?php endif; ?>
            </section>

            <section class="flex flex-row items-center justify-between md:px-8 py-8 max-w-7xl mx-auto">
                <div class="md:w-1/2 w-full flex flex-col items-center md:border border-gray-200 md:rounded-lg md:shadow-sm p-4 mr-4">
                    <?php if ($section_two_headline = get_field('section_two_headline')): ?>
                        <h2 id="about" class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($section_two_headline); ?></h2>
                    <?php endif; ?>

                    <?php if ($section_two_text = get_field('section_two_text')): ?>
                        <p class="p-6 text-black leading-relaxed">
                            <?php echo esc_html($section_two_text); ?>
                        </p>
                    <?php endif; ?>
                    <?php
                        $section_two_button_text = get_field('section_two_button_text');
                        $section_two_button_link = get_field('section_two_button_link');
                    if ($section_two_button_text && $section_two_button_link): ?>
                        <a href="<?php echo esc_url($section_two_button_link['url']); ?>" class="bg-[#FFD54F] text-black font-bold px-8 py-2 rounded shadow hover:bg-yellow-400 transition"
                            aria-label="<?php echo esc_attr($section_two_button_text); ?>">
                            <?php echo esc_html($section_two_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:w-1/2 w-full flex flex-col items-center">
                    <?php if ($section_two_image = get_field('section_two_image')): ?>
                        <img src="<?php echo esc_url($section_two_image['url']); ?>" alt="<?php echo esc_attr($section_two_image['alt']); ?>" class="h-full w-auto md:w-full md:max-h-120 lg:h-76 object-cover md:rounded-lg" />
                    <?php endif; ?>
                </div>
            </section>

            <section class="flex flex-col items-center text-center justify-center px-16 py-8 max-w-7xl mx-auto">
                    <?php if($testimonials_title = get_field('testimonials_title')): ?>
                        <h2 class="text-5xl font-bold mb-4 text-black"><?php echo esc_html($testimonials_title); ?></h2>
                    <?php endif; ?>
                    <?php if($testimonials_text_line = get_field('testimonials_text_line')): ?>
                        <h3 class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($testimonials_text_line); ?></h3>
                    <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
                    <?php
                    $args = [
                        'post_type' => 'testimonial',
                        'posts_per_page' => 4,
                        'orderby' => 'rand'
                    ];
                    $testimonials = new WP_Query($args);
                    if ($testimonials->have_posts()):
                        while ($testimonials->have_posts()): $testimonials->the_post();
                            $name = get_field('testimonial_name') ?: get_the_title();
                            $rating = get_field('testimonial_rating') ?: 5;
                            $photo = get_field('testimonial_photo');
                    ?>
                    <div class="border-2 border-orange-400 rounded-xl p-8 flex flex-col items-center bg-white">
                        <?php if ($photo): ?>
                            <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($name); ?>" class="w-24 h-24 rounded-full mb-4 object-cover" />
                        <?php endif; ?>
                        <h4 class="font-bold text-xl mb-2 text-black"><?php echo esc_html($name); ?></h4>
                        <div class="flex mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="iconify text-2xl <?php echo $i <= $rating ? 'text-red-500' : 'text-gray-300'; ?>" data-icon="mdi:star"></span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-black text-center"><?php the_content(); ?></p>
                    </div>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </section>

            <section class="max-w-2xl px-16 py-8 max-w-7xl mx-auto">
                <h3 class="text-2xl font-bold mb-4 text-black">Submit your testimonial</h3>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow space-y-4 max-w-lg mx-auto">
                    <input type="hidden" name="action" value="submit_testimonial">
                    <?php wp_nonce_field('submit_testimonial_action', 'testimonial_nonce'); ?>
                    <label for="testimonial_name" class="block font-bold mb-1">Name</label>
                    <input type="text" name="testimonial_name" id="testimonial_name" required class="w-full border p-2 rounded mb-4" />

                    <label for="testimonial_rating" class="block font-bold mb-1">Rating (1-5)</label>
                    <input type="number" name="testimonial_rating" id="testimonial_rating" min="1" max="5" required class="w-full border p-2 rounded mb-4" />

                    <label for="testimonial_photo" class="block font-bold mb-1">Profile picture</label>
                    <input type="file" name="testimonial_photo" id="testimonial_photo" accept="image/*" class="w-full border p-2 rounded mb-4" />

                    <label for="testimonial_content" class="block font-bold mb-1">Testimonial</label>
                    <textarea name="testimonial_content" id="testimonial_content" required class="w-full border p-2 rounded mb-4"></textarea>

                    <input type="submit" value="Send" class="bg-orange-400 text-white font-bold px-6 py-2 rounded hover:bg-orange-500 transition" />
                </form>
                <?php
                if (isset($_GET['testimonial']) && $_GET['testimonial'] === 'success') {
                    echo '<p class="mt-4 text-green-600 font-bold">Thank you for your testimonial! It will appear after review.</p>';
                }
                ?>
            </section>

        </main>

        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer(); ?>