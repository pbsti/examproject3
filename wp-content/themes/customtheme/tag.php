<?php get_header(); ?>
<main>
    <h1 class="flex justify-center text-7xl bold mt-8"><?php pll_e("Yumgo Blogs"); ?></h1>

    <?php
        $all_tags = get_tags();
        $current_tag = get_queried_object();

        $selected_tag_slug = isset($_GET['tag']) && $_GET['tag']
            ? sanitize_text_field($_GET['tag'])
            : ( $current_tag && property_exists($current_tag, 'slug') ? $current_tag->slug : '' );

        $args = array(
          'posts_per_page' => -1,
          'orderby' => 'date',
          'post_type' => 'post',
        );

        if ( $selected_tag_slug ) {
          $args['tag'] = $selected_tag_slug;
        }

        $query = new WP_Query( $args );
    ?>
    <div class="flex flex-col sm:flex-row gap-8 md:gap-12 px-8 lg:px-32 py-8">
      <div class="flex items-center">
        <label class="sr-only" for="tag-select">Tags</label>
        <div class="relative">
          <select id="tag-select"
            class="appearance-none border border-gray-300 px-6 py-3 bg-transparent text-black text-base pr-10 focus:outline-none focus:ring-2 focus:ring-[#DCE896] min-w-76 cursor-pointer"
            onchange="if(this.value) window.location.href=this.value;">
            <option value="<?php echo esc_url( get_permalink( get_page_by_path( 'yumgo-blogs' ) ) ); ?>" <?php if ( ! $selected_tag_slug ) echo 'selected'; ?>>
              <?php esc_html_e( 'All', '' ); ?>
            </option>
            <?php foreach ( $all_tags as $tag ):
                $tag_link = get_tag_link( $tag->term_id );
                $is_selected = ( $selected_tag_slug && $selected_tag_slug === $tag->slug ) || ( $current_tag && isset( $current_tag->term_id ) && $current_tag->term_id === $tag->term_id );
            ?>
              <option value="<?php echo esc_url( $tag_link ); ?>" <?php if ( $is_selected ) echo 'selected'; ?>>
                <?php echo esc_html( $tag->name ); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M19 9l-7 7-7-7"/>
            </svg>
          </span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 md:gap-12 px-8 lg:px-32 py-8">
        <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

            $images = [];
            if ( has_post_thumbnail() ) {
                $thumb_id = get_post_thumbnail_id( get_the_ID() );
                $thumb_src = $thumb_id ? wp_get_attachment_image_src( $thumb_id, 'medium' ) : false;
                if ( $thumb_src ) {
                    $images[] = $thumb_src[0];
                }
            }

            if ( empty( $images ) ) {
                $content = get_the_content();
                $matches = [];
                // match first <img src="..."> in post content
                if ( preg_match( '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches ) ) {
                    $images[] = $matches[1];
                }
            }
        ?>

        <div class="card-flip w-full border border-gray-200 rounded-lg shadow-sm bg-white relative h-64 cursor-pointer">
          <div class="card-flip-inner w-full h-full relative">

              <a href="<?php the_permalink(); ?>" class="block w-full h-full card-face card-face-front">
              <?php if ( ! empty( $images ) ) : ?>
                  <img src="<?php echo esc_url( $images[0] ); ?>"
                      alt="<?php echo esc_attr( get_the_title() ); ?>"
                      class="w-full h-64 object-cover rounded-lg" />
                  <div class="absolute left-0 top-0 right-0 bottom-[-2px] blackopa flex items-center justify-center rounded-lg">
                      <h4 class="text-white text-2xl font-bold text-center px-4">
                          <?php the_title(); ?>
                      </h4>
                  </div>
              <?php else: ?>
                  <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg">
                      <h4 class="text-black text-xl font-bold px-4"><?php the_title(); ?></h4>
                  </div>
              <?php endif; ?>
              </a>

              <a href="<?php the_permalink(); ?>" tabindex="-1" class="block w-full h-full card-face card-face-back">
              <?php if ( ! empty( $images ) ) : ?>
                  <img src="<?php echo esc_url( $images[0] ); ?>"
                      alt="<?php echo esc_attr( get_the_title() ); ?>"
                      class="w-full h-64 object-cover rounded-lg scale-x-[-1]" />
              <?php else: ?>
                  <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg"></div>
              <?php endif; ?>
                  <div class="absolute left-0 top-0 right-0 bottom-[-2px] blackopa flex items-center justify-center rounded-lg">
                      <p class="text-white text-base font-normal text-center px-4">
                          <?php echo get_the_excerpt(); ?>
                      </p>
                  </div>
              </a>
          </div>
        </div>

        <?php endwhile; wp_reset_postdata(); else : ?>
            <p><?php esc_html_e( 'No posts found.', '' ); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>