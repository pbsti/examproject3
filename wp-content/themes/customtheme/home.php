<?php get_header(); ?>
<main class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 px-8 md:px-16 py-8">
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

    <div class="card-flip w-full border border-gray-200 rounded-lg shadow-sm bg-white relative h-64">
      <div class="card-flip-inner w-full h-full relative">

        <a href="<?php the_permalink(); ?>" class="block w-full h-full card-face card-face-front">
          <?php if (!empty($images)) : ?>
            <img src="<?php echo esc_url($images[0]); ?>"
                alt="Post Image"
                class="w-full h-64 object-cover rounded-lg" />
            <div class="absolute inset-0 blackopa flex items-center justify-center rounded-lg">
              <h4 class="text-white text-2xl font-bold text-center px-4">
                <?php the_title(); ?>
              </h4>
            </div>
          <?php endif; ?>
        </a>

        <a href="<?php the_permalink(); ?>" class="block w-full h-full card-face card-face-back">
          <?php if (!empty($images)) : ?>
            <img src="<?php echo esc_url($images[0]); ?>"
                alt="Post Image"
                class="w-full h-64 object-cover rounded-lg scale-x-[-1]" />
            <div class="absolute inset-0 blackopa flex items-center justify-center rounded-lg">
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
</main>
<?php get_footer(); ?>