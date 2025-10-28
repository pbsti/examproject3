<?php get_header(); ?>

<?php
if ( function_exists( 'is_singular' ) && is_singular( 'product' ) ) {

    if ( function_exists( 'wc_get_template' ) ) {
        wc_get_template( 'single-product.php' );
    } else {
        $fallback = WP_PLUGIN_DIR . '/woocommerce/templates/single-product.php';
        if ( file_exists( $fallback ) ) {
            include $fallback;
        } elseif ( function_exists( 'wc_get_template_part' ) ) {
            wc_get_template_part( 'content', 'single-product' );
        }
    }

    get_footer();
    return;
}

if ( function_exists( 'is_tax' ) && is_tax( 'product_cat' ) ) {

    if ( function_exists( 'wc_get_template' ) ) {
        wc_get_template( 'archive-product.php' );
    } else {
        $fallback = WP_PLUGIN_DIR . '/woocommerce/templates/archive-product.php';
        if ( file_exists( $fallback ) ) {
            include $fallback;
        } elseif ( function_exists( 'wc_get_template_part' ) ) {
            wc_get_template_part( 'archive', 'product' );
        }
    }

    get_footer();
    return;
}
?>

<div class="container mx-auto px-4 py-8 max-w-5xl">
<?php
$sellers = array();
if ( function_exists( 'dokan_get_sellers' ) ) {
    $dokan_sellers = dokan_get_sellers( array( 'number' => 8 ) );
    if ( is_array( $dokan_sellers ) && ! empty( $dokan_sellers['users'] ) ) {
        $sellers = $dokan_sellers['users'];
    } elseif ( is_array( $dokan_sellers ) && ! empty( $dokan_sellers ) ) {
        $sellers = $dokan_sellers;
    }
}
if ( empty( $sellers ) ) {
    $roles = array( 'seller', 'vendor', 'shop_manager', 'administrator', 'author' );
    $sellers = get_users( array(
        'role__in' => $roles,
        'number'    =>  12,
        'orderby'   => 'user_registered',
        'order'     => 'DESC',
    ) );
}
$norm_sellers = array();
foreach ( (array) $sellers as $s ) {
    if ( is_object( $s ) && isset( $s->ID ) ) {
        $norm_sellers[] = $s;
    } elseif ( is_array( $s ) && isset( $s['ID'] ) ) {
        $norm_sellers[] = get_user_by( 'id', $s['ID'] );
    } elseif ( is_numeric( $s ) ) {
        $user = get_user_by( 'id', intval( $s ) );
        if ( $user ) { $norm_sellers[] = $user; }
    }
}
$norm_sellers = array_slice( $norm_sellers, 0, 8 );
if ( empty( $norm_sellers ) ) {
    echo '<p>No restaurants found.</p>';
} else {
    foreach ( $norm_sellers as $seller ) {
        if ( ! $seller ) { continue; }
        $seller_id = $seller->ID;
        $store_name = ( function_exists( 'dokan_get_store_info' ) ) ? dokan_get_store_info( $seller_id ) : array();
        if ( is_array( $store_name ) && ! empty( $store_name['store_name'] ) ) {
            $title = esc_html( $store_name['store_name'] );
        } else {
            $title = esc_html( $seller->display_name );
        }
        $store_url = function_exists( 'dokan_get_store_url' ) ? dokan_get_store_url( $seller_id ) : get_author_posts_url( $seller_id );

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'author'         => $seller_id,
            'post_status'    => 'publish',
            'orderby'        => 'meta_value_num date',
            'order'          => 'DESC',
            'meta_key'       => 'total_sales',
        );
        $products_q = new WP_Query( $args );
        if ( ! $products_q->have_posts() ) {
            continue;
        }
        echo '<section class="vendor-row">';
        echo '<div class="vendor-header">';
        echo '<div class="vendor-title">' . $title . '</div>';
        echo '<a class="vendor-link" href="' . esc_url( $store_url ) . '">View menu →</a>';
        echo '</div>';
        echo '<ul class="vendor-products">';
        $count = 0;
        while ( $products_q->have_posts() ) : $products_q->the_post();
            $pid = get_the_ID();
            $product = wc_get_product( $pid );
            if ( ! $product ) { continue; }
            $price_html = $product->get_price_html();
            $permalink = get_permalink( $pid );
            if ( $count >= 12 ) { break; }
            echo '<li class="product">';
            echo '<div class="card-inner">';
            echo '<a class="woocommerce-LoopProduct-link" href="' . esc_url( $permalink ) . '">';
            echo get_the_post_thumbnail( $pid, 'medium' );
            echo '<div class="card-content">';
            echo '<h3 class="woocommerce-loop-product__title">' . esc_html( get_the_title( $pid ) ) . '</h3>';
            echo '</div>';
            echo '</a>';
            echo '<div class="card-footer">';
            echo '<span class="price">' . $price_html . '</span>';
            if ( $product->is_purchasable() && $product->is_in_stock() ) {
                $add_url = esc_url( add_query_arg( 'add-to-cart', $pid, wc_get_cart_url() ) );
                echo '<a href="' . $add_url . '" data-quantity="1" data-product_id="' . esc_attr( $pid ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" class="button add_to_cart_button ajax_add_to_cart" aria-label="Add &quot;' . esc_attr( get_the_title( $pid ) ) . '&quot; to cart">Add to cart</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</li>';
            $count++;
        endwhile;
        wp_reset_postdata();
        echo '</ul>';
        echo '</section>';
    }
}
?>
</div>

<script>
(function(){
  var sliders = document.querySelectorAll('.vendor-products');
  sliders.forEach(function(slider){
    var isDown = false;
    var startX;
    var scrollLeft;
    slider.addEventListener('pointerdown', function(e){
      var interactive = e.target.closest('a, button, .add_to_cart_button, .woocommerce-LoopProduct-link');
      if (interactive) return;
      isDown = true;
      if (slider.setPointerCapture) slider.setPointerCapture(e.pointerId);
      startX = e.clientX || (e.touches && e.touches[0] && e.touches[0].clientX) || 0;
      scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('pointermove', function(e){
      if(!isDown) return;
      var x = e.clientX || (e.touches && e.touches[0] && e.touches[0].clientX) || 0;
      var walk = (startX - x);
      slider.scrollLeft = scrollLeft + walk;
    });
    slider.addEventListener('pointerup', function(e){
      isDown = false;
      try { if (slider.releasePointerCapture) slider.releasePointerCapture(e.pointerId); } catch(err){}
    });
    slider.addEventListener('pointercancel', function(){ isDown = false; });
    slider.addEventListener('pointerleave', function(){ isDown = false; });
  });

  function showCartToast(productTitle){
    var existing = document.querySelector('.cart-toast');
    if (existing) existing.remove();
    var toast = document.createElement('div');
    toast.className = 'cart-toast';
    var txt = document.createElement('span');
    txt.textContent = productTitle ? (productTitle + ' added') : 'Added to cart';
    var link = document.createElement('a');
    link.href = '<?php echo esc_js( wc_get_cart_url() ); ?>';
    link.textContent = 'View cart';
    toast.appendChild(txt);
    toast.appendChild(link);
    document.body.appendChild(toast);
    setTimeout(function(){ toast.classList.add('visible'); }, 20);
    setTimeout(function(){ if (toast) toast.remove(); }, 4200);
  }

  document.addEventListener('click', function(e){
    var btn = e.target.closest('.add_to_cart_button');
    if (!btn) return;
    var li = btn.closest('.product');
    var title = li ? (li.querySelector('.woocommerce-loop-product__title') && li.querySelector('.woocommerce-loop-product__title').textContent) : '';
    setTimeout(function(){ showCartToast(title); }, 300);
  });

})();
</script>

<?php get_footer(); ?>