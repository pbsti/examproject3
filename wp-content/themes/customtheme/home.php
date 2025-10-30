<?php get_header(); ?>
<main>
    <h1 class="flex justify-center text-center text-7xl bold mt-8"><?php pll_e("Yumgo Blogs") ?></h1>

    <?php
        $all_categories = get_categories();
        $current_category = get_queried_object();

        $selected_cat_slug = isset($_GET['cat']) && $_GET['cat'] ? sanitize_text_field($_GET['cat']) : ($current_category && property_exists($current_category, 'slug') ? $current_category->slug : '');

        $args = array(
          'posts_per_page' => -1,
          'orderby' => 'date'
        );

        if ($selected_cat_slug) {
          $args['category_name'] = $selected_cat_slug;
        }

        $query = new WP_Query($args);
    ?>
        <div class="flex flex-col sm:flex-row gap-8 md:gap-12 px-8 lg:px-32 py-8">
          <div class="flex items-center">
            <label class="sr-only" for="cat-select">Categories</label>
            <button class="relative">
              <select id="cat-select"
                class="appearance-none border border-gray-300 px-6 py-3 bg-transparent text-black text-base pr-10 focus:outline-none focus:ring-2 focus:ring-[#DCE896] min-w-76 cursor-pointer"
                onchange="if(this.value) window.location.href=this.value;">
                <option value="<?php echo esc_url(get_permalink(get_page_by_path('yumgo-blogs'))); ?>" <?php if (!$selected_cat_slug) echo 'selected'; ?>>
                  <?php pll_e("All categories")?>
                </option>
                <?php foreach ($all_categories as $cat): ?>
                  <option value="<?php echo esc_url(get_category_link($cat->term_id)); ?>" <?php if ($current_category && $current_category->term_id === $cat->term_id) echo 'selected'; ?>>
                    <?php echo esc_html($cat->name); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 9l-7 7-7-7"/>
                </svg>
              </span>
            </button>
          </div>
        </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 px-8 lg:px-32 py-8">
        <?php if (have_posts()) : while (have_posts()) : the_post();

            $images = [];
            if (has_post_thumbnail()) {
                $images[] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            } else {
                $content = get_the_content();
                $matches = [];
                preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
                if (!empty($matches[1])) {
                    $images[] = $matches[1];
                }
            }
        ?>

        <div class="card-flip w-full border border-gray-200 rounded-lg shadow-sm bg-white relative h-64 cursor-pointer">
          <div class="card-flip-inner w-full h-full relative">

              <a href="<?php the_permalink(); ?>" class="block w-full h-full card-face card-face-front">
              <?php if (!empty($images)) : ?>
                  <img src="<?php echo esc_url($images[0]); ?>"
                      alt="<?php the_title(); ?>"
                      class="w-full h-64 object-cover rounded-lg" />
                  <div class="absolute left-0 top-0 right-0 bottom-[-2px] blackopa flex items-center justify-center rounded-lg">
                      <h4 class="text-white text-2xl font-bold text-center px-4">
                          <?php the_title(); ?>
                      </h4>
                  </div>
              <?php endif; ?>
              </a>

              <a href="<?php the_permalink(); ?>" tabindex="-1" class="block w-full h-full card-face card-face-back">
              <?php if (!empty($images)) : ?>
                  <img src="<?php echo esc_url($images[0]); ?>"
                      alt="<?php the_title(); ?>"
                      class="w-full h-64 object-cover rounded-lg scale-x-[-1]" />
                  <div class="absolute left-0 top-0 right-0 bottom-[-2px] blackopa flex items-center justify-center rounded-lg">
                  <p class="text-white text-base font-normal text-center px-4">
                      <?php echo get_the_excerpt(); ?>
                  </p>
                  </div>
              <?php endif; ?>
              </a>
          </div>
        </div>

        <?php endwhile; else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>