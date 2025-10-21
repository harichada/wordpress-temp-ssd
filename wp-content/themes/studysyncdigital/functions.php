<?php
/**
 * StudySync Digital Theme Functions
 *
 * @package StudySyncDigital
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function studysyncdigital_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Set thumbnail sizes
    set_post_thumbnail_size(1200, 800, true);
    add_image_size('product-thumbnail', 400, 300, true);
    add_image_size('product-large', 800, 600, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'studysyncdigital'),
        'footer' => __('Footer Menu', 'studysyncdigital'),
    ));

    // Add custom post type for products
    studysyncdigital_register_product_post_type();
}
add_action('after_setup_theme', 'studysyncdigital_setup');

/**
 * Register Custom Post Type for Products
 */
function studysyncdigital_register_product_post_type() {
    $labels = array(
        'name' => 'Tech Products',
        'singular_name' => 'Product',
        'menu_name' => 'Products',
        'add_new' => 'Add New Product',
        'add_new_item' => 'Add New Product',
        'edit_item' => 'Edit Product',
        'new_item' => 'New Product',
        'view_item' => 'View Product',
        'search_items' => 'Search Products',
        'not_found' => 'No products found',
        'not_found_in_trash' => 'No products found in trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-laptop',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'products'),
        'show_in_rest' => true,
    );

    register_post_type('product', $args);

    // Register product categories
    register_taxonomy('product_category', 'product', array(
        'label' => 'Product Categories',
        'rewrite' => array('slug' => 'product-category'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'studysyncdigital_register_product_post_type');

/**
 * Enqueue Scripts and Styles
 */
function studysyncdigital_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('studysyncdigital-style', get_stylesheet_uri(), array(), '1.0');

    // Enqueue custom scripts
    wp_enqueue_script('studysyncdigital-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'studysyncdigital_scripts');

/**
 * Register Widget Areas
 */
function studysyncdigital_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'studysyncdigital'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'studysyncdigital'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    // Footer widgets
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name' => sprintf(__('Footer Widget %d', 'studysyncdigital'), $i),
            'id' => 'footer-' . $i,
            'description' => sprintf(__('Footer widget area %d', 'studysyncdigital'), $i),
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        ));
    }
}
add_action('widgets_init', 'studysyncdigital_widgets_init');

/**
 * Custom Excerpt Length
 */
function studysyncdigital_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'studysyncdigital_excerpt_length');

/**
 * Custom Excerpt More
 */
function studysyncdigital_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'studysyncdigital_excerpt_more');

/**
 * Get Product Rating
 */
function studysyncdigital_get_rating($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $rating = get_post_meta($post_id, 'product_rating', true);

    if (!$rating) {
        $rating = 4.5; // Default rating
    }

    return $rating;
}

/**
 * Display Star Rating
 */
function studysyncdigital_display_rating($rating) {
    $output = '<div class="product-rating">';

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= floor($rating)) {
            $output .= '<span class="star full">★</span>';
        } elseif ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {
            $output .= '<span class="star half">★</span>';
        } else {
            $output .= '<span class="star empty">☆</span>';
        }
    }

    $output .= '</div>';

    return $output;
}

/**
 * Get Product Price
 */
function studysyncdigital_get_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $price = get_post_meta($post_id, 'product_price', true);

    return $price ? '$' . number_format($price, 2) : '';
}

/**
 * Get Affiliate Link
 */
function studysyncdigital_get_affiliate_link($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $link = get_post_meta($post_id, 'affiliate_link', true);

    return $link ? $link : '#';
}

/**
 * Add Custom Meta Boxes for Products
 */
function studysyncdigital_add_meta_boxes() {
    add_meta_box(
        'product_details',
        'Product Details',
        'studysyncdigital_product_details_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'studysyncdigital_add_meta_boxes');

/**
 * Meta Box Callback
 */
function studysyncdigital_product_details_callback($post) {
    wp_nonce_field('studysyncdigital_save_product_details', 'studysyncdigital_product_details_nonce');

    $price = get_post_meta($post->ID, 'product_price', true);
    $rating = get_post_meta($post->ID, 'product_rating', true);
    $affiliate_link = get_post_meta($post->ID, 'affiliate_link', true);
    $features = get_post_meta($post->ID, 'product_features', true);

    ?>
    <p>
        <label for="product_price">Price ($):</label><br>
        <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="product_rating">Rating (1-5):</label><br>
        <input type="number" id="product_rating" name="product_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="affiliate_link">Affiliate Link:</label><br>
        <input type="url" id="affiliate_link" name="affiliate_link" value="<?php echo esc_attr($affiliate_link); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="product_features">Key Features (one per line):</label><br>
        <textarea id="product_features" name="product_features" rows="5" style="width: 100%;"><?php echo esc_textarea($features); ?></textarea>
    </p>
    <?php
}

/**
 * Save Product Details
 */
function studysyncdigital_save_product_details($post_id) {
    if (!isset($_POST['studysyncdigital_product_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['studysyncdigital_product_details_nonce'], 'studysyncdigital_save_product_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, 'product_price', sanitize_text_field($_POST['product_price']));
    }

    if (isset($_POST['product_rating'])) {
        update_post_meta($post_id, 'product_rating', sanitize_text_field($_POST['product_rating']));
    }

    if (isset($_POST['affiliate_link'])) {
        update_post_meta($post_id, 'affiliate_link', esc_url_raw($_POST['affiliate_link']));
    }

    if (isset($_POST['product_features'])) {
        update_post_meta($post_id, 'product_features', sanitize_textarea_field($_POST['product_features']));
    }
}
add_action('save_post', 'studysyncdigital_save_product_details');
