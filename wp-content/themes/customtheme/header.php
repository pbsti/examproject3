<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.2.1/iconify.min.js"></script>
  <title><?php bloginfo("name"); ?></title>
  <meta name="description" content="<?php bloginfo("description"); ?>">
  <link rel="icon" href="<?php echo get_template_directory_uri() . '/css/img/.png' ?>" type="image/png">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> class="w-full h-full">

    <header class="w-full h-17 bg-white">
      <nav class="h-full">
        <ul class="text-black flex justify-around items-center h-full">
                <li class="text-base font-bold">
                  <a href="<?php echo esc_url(get_permalink(get_page_by_path(''))); ?>">HOME</a>
                </li>
                <li class="text-base font-bold">
                  <a href="<?php echo esc_url(get_permalink(get_page_by_path('yumgo-blogs'))); ?>">BLOGS</a>
                </li>
                <li class="text-base font-bold">
                  <a href="<?php echo esc_url(get_permalink(get_page_by_path(''))); ?>">LOG IN</a>
                </li>
                <li class="text-base font-bold">
                  <a href="<?php echo esc_url(get_permalink(get_page_by_path(''))); ?>">CART</a>
                </li>
        </ul>
      </nav>
    </header>