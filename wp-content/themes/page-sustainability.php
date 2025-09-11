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

<main id="primary">

  <!-- HERO -->
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
        <?php while (have_posts()) { the_post(); the_content(); } ?>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
