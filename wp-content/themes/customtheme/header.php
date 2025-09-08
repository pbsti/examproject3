<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.2.1/iconify.min.js"></script>
  <title><?php bloginfo("name"); ?></title>
  <meta name="description" content="<?php bloginfo("description"); ?>">
  <link rel="icon" href="<?php echo get_template_directory_uri() . '/css/img/YumGo.png' ?>" type="image/png">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> class="w-full h-full">

    <header class="w-full h-17 bg-white">
      <nav class="h-full">
        <ul class="text-black flex justify-around items-center h-full">
                <li class="w-25">
                  <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri() . '/css/img/YumGoWide.png' ?>" alt="Logo">
                  </a>
                </li>
                <li class="text-base font-bold">
                  <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
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
                <li class="relative" id="lang-dropdown">
                  <?php
                    $languages = pll_the_languages(array('raw' => 1));
                    $current_flag = '';
                    foreach ($languages as $lang) {
                      if ($lang['current_lang']) {
                        $flag = $lang['flag'];
                        if (filter_var($flag, FILTER_VALIDATE_URL)) {
                          $current_flag = '<img src="' . esc_url($flag) . '" alt="' . esc_attr($lang['name']) . '" class="inline w-8 h-6 mr-1" />';
                        }
                        break;
                      }
                    }
                  ?>
                  <button id="lang-toggle" class="flex items-center px-2 py-1 bg-white hover:bg-gray-100">
                    <?php echo $current_flag; ?>
                    <span class="iconify" data-icon="mdi:chevron-down"></span>
                  </button>
                  <ul id="lang-menu" class="absolute left-0 mt-2 w-12 bg-white shadow-lg z-10 hidden">
                    <?php
                    foreach ($languages as $lang) {
                      if ($lang['current_lang']) continue;
                      $flag = $lang['flag'];
                      if (filter_var($flag, FILTER_VALIDATE_URL)) {
                        $flag = '<img src="' . esc_url($flag) . '" alt="' . esc_attr($lang['name']) . '" class="inline w-8 h-6" />';
                      }
                      echo '<li>
                        <a href="' . esc_url($lang['url']) . '" class="block px-2 py-1 hover:bg-gray-100">'
                          . $flag .
                        '</a>
                      </li>';
                    }
                    ?>
                  </ul>
                </li>
        </ul>
      </nav>
    </header>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      var toggle = document.getElementById('lang-toggle');
      var menu = document.getElementById('lang-menu');
      toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
      });
      document.addEventListener('click', function(e) {
        if (!document.getElementById('lang-dropdown').contains(e.target)) {
          menu.classList.add('hidden');
        }
      });
    });
    </script>