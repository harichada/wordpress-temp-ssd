<?php
/**
 * Plugin Name: StudySync Deals Manager
 * Plugin URI: https://studysyncdigital.com
 * Description: Manage and display tech deals with discounts, expiration dates, and affiliate links for StudySync Digital
 * Version: 1.0.0
 * Author: StudySync Digital Team
 * Author URI: https://studysyncdigital.com
 * License: GPL v2 or later
 * Text Domain: studysync-deals
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SSD_VERSION', '1.0.0');
define('SSD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SSD_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class StudySync_Deals {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'register_deal_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('add_meta_boxes', array($this, 'add_deal_meta_boxes'));
        add_action('save_post_deal', array($this, 'save_deal_meta'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_menu', array($this, 'add_settings_page'));

        // Shortcodes
        add_shortcode('studysync_deals', array($this, 'deals_shortcode'));
        add_shortcode('studysync_deal', array($this, 'single_deal_shortcode'));

        // Include additional files
        $this->includes();
    }

    /**
     * Include required files
     */
    private function includes() {
        require_once SSD_PLUGIN_DIR . 'includes/deal-functions.php';
        require_once SSD_PLUGIN_DIR . 'includes/deal-widgets.php';
    }

    /**
     * Register Deal Post Type
     */
    public function register_deal_post_type() {
        $labels = array(
            'name' => 'Tech Deals',
            'singular_name' => 'Deal',
            'menu_name' => 'Deals',
            'add_new' => 'Add New Deal',
            'add_new_item' => 'Add New Deal',
            'edit_item' => 'Edit Deal',
            'new_item' => 'New Deal',
            'view_item' => 'View Deal',
            'search_items' => 'Search Deals',
            'not_found' => 'No deals found',
            'not_found_in_trash' => 'No deals found in trash',
            'all_items' => 'All Deals'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-tag',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'deals'),
            'show_in_rest' => true,
            'menu_position' => 5,
        );

        register_post_type('deal', $args);
    }

    /**
     * Register Taxonomies
     */
    public function register_taxonomies() {
        // Deal Categories
        register_taxonomy('deal_category', 'deal', array(
            'label' => 'Deal Categories',
            'rewrite' => array('slug' => 'deal-category'),
            'hierarchical' => true,
            'show_in_rest' => true,
        ));

        // Deal Tags
        register_taxonomy('deal_tag', 'deal', array(
            'label' => 'Deal Tags',
            'rewrite' => array('slug' => 'deal-tag'),
            'hierarchical' => false,
            'show_in_rest' => true,
        ));
    }

    /**
     * Add Meta Boxes
     */
    public function add_deal_meta_boxes() {
        add_meta_box(
            'deal_details',
            'Deal Details',
            array($this, 'deal_details_callback'),
            'deal',
            'normal',
            'high'
        );
    }

    /**
     * Deal Details Meta Box Callback
     */
    public function deal_details_callback($post) {
        wp_nonce_field('save_deal_details', 'deal_details_nonce');

        $original_price = get_post_meta($post->ID, '_deal_original_price', true);
        $sale_price = get_post_meta($post->ID, '_deal_sale_price', true);
        $discount_percent = get_post_meta($post->ID, '_deal_discount_percent', true);
        $affiliate_link = get_post_meta($post->ID, '_deal_affiliate_link', true);
        $expiration_date = get_post_meta($post->ID, '_deal_expiration_date', true);
        $coupon_code = get_post_meta($post->ID, '_deal_coupon_code', true);
        $store_name = get_post_meta($post->ID, '_deal_store_name', true);
        $is_featured = get_post_meta($post->ID, '_deal_is_featured', true);
        $deal_type = get_post_meta($post->ID, '_deal_deal_type', true);

        ?>
        <style>
            .deal-meta-row { margin-bottom: 20px; }
            .deal-meta-row label { display: inline-block; width: 150px; font-weight: 600; }
            .deal-meta-row input[type="text"],
            .deal-meta-row input[type="number"],
            .deal-meta-row input[type="url"],
            .deal-meta-row input[type="date"],
            .deal-meta-row select { width: 60%; }
            .deal-meta-row input[type="checkbox"] { width: auto; }
            .deal-price-preview {
                margin-top: 10px;
                padding: 15px;
                background: #f0f0f1;
                border-radius: 5px;
                display: inline-block;
            }
            .deal-price-preview .original {
                text-decoration: line-through;
                color: #999;
                font-size: 18px;
                margin-right: 10px;
            }
            .deal-price-preview .sale {
                color: #e74c3c;
                font-size: 24px;
                font-weight: bold;
            }
            .deal-price-preview .discount {
                background: #2ecc71;
                color: white;
                padding: 5px 10px;
                border-radius: 3px;
                margin-left: 10px;
                font-weight: bold;
            }
        </style>

        <div class="deal-meta-row">
            <label for="deal_original_price">Original Price ($):</label>
            <input type="number" id="deal_original_price" name="deal_original_price"
                   value="<?php echo esc_attr($original_price); ?>" step="0.01" min="0">
            <p class="description">The regular price before discount</p>
        </div>

        <div class="deal-meta-row">
            <label for="deal_sale_price">Sale Price ($):</label>
            <input type="number" id="deal_sale_price" name="deal_sale_price"
                   value="<?php echo esc_attr($sale_price); ?>" step="0.01" min="0">
            <p class="description">The discounted price</p>
        </div>

        <div class="deal-meta-row">
            <label for="deal_discount_percent">Discount (%):</label>
            <input type="number" id="deal_discount_percent" name="deal_discount_percent"
                   value="<?php echo esc_attr($discount_percent); ?>" min="0" max="100" readonly>
            <p class="description">Auto-calculated from prices above</p>
        </div>

        <div class="deal-price-preview">
            <span class="original">$<span id="preview_original"><?php echo $original_price ? number_format($original_price, 2) : '0.00'; ?></span></span>
            <span class="sale">$<span id="preview_sale"><?php echo $sale_price ? number_format($sale_price, 2) : '0.00'; ?></span></span>
            <span class="discount"><span id="preview_discount"><?php echo $discount_percent ? $discount_percent : '0'; ?></span>% OFF</span>
        </div>

        <div class="deal-meta-row">
            <label for="deal_affiliate_link">Affiliate Link:</label>
            <input type="url" id="deal_affiliate_link" name="deal_affiliate_link"
                   value="<?php echo esc_url($affiliate_link); ?>" placeholder="https://amazon.com/...">
            <p class="description">Your affiliate URL for this deal</p>
        </div>

        <div class="deal-meta-row">
            <label for="deal_store_name">Store Name:</label>
            <input type="text" id="deal_store_name" name="deal_store_name"
                   value="<?php echo esc_attr($store_name); ?>" placeholder="Amazon, Best Buy, etc.">
        </div>

        <div class="deal-meta-row">
            <label for="deal_coupon_code">Coupon Code:</label>
            <input type="text" id="deal_coupon_code" name="deal_coupon_code"
                   value="<?php echo esc_attr($coupon_code); ?>" placeholder="SAVE20">
            <p class="description">Optional promo code (leave blank if not needed)</p>
        </div>

        <div class="deal-meta-row">
            <label for="deal_expiration_date">Expiration Date:</label>
            <input type="date" id="deal_expiration_date" name="deal_expiration_date"
                   value="<?php echo esc_attr($expiration_date); ?>">
            <p class="description">When does this deal expire?</p>
        </div>

        <div class="deal-meta-row">
            <label for="deal_deal_type">Deal Type:</label>
            <select id="deal_deal_type" name="deal_deal_type">
                <option value="discount" <?php selected($deal_type, 'discount'); ?>>Price Discount</option>
                <option value="coupon" <?php selected($deal_type, 'coupon'); ?>>Coupon Code</option>
                <option value="freebie" <?php selected($deal_type, 'freebie'); ?>>Free Item</option>
                <option value="bundle" <?php selected($deal_type, 'bundle'); ?>>Bundle Deal</option>
                <option value="student" <?php selected($deal_type, 'student'); ?>>Student Discount</option>
            </select>
        </div>

        <div class="deal-meta-row">
            <label for="deal_is_featured">
                <input type="checkbox" id="deal_is_featured" name="deal_is_featured"
                       value="1" <?php checked($is_featured, '1'); ?>>
                Featured / Hot Deal
            </label>
            <p class="description">Mark this as a hot deal to highlight it</p>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Auto-calculate discount percentage
            function calculateDiscount() {
                var original = parseFloat($('#deal_original_price').val()) || 0;
                var sale = parseFloat($('#deal_sale_price').val()) || 0;

                if (original > 0 && sale > 0 && sale < original) {
                    var discount = Math.round(((original - sale) / original) * 100);
                    $('#deal_discount_percent').val(discount);
                    $('#preview_discount').text(discount);
                } else {
                    $('#deal_discount_percent').val(0);
                    $('#preview_discount').text(0);
                }

                $('#preview_original').text(original.toFixed(2));
                $('#preview_sale').text(sale.toFixed(2));
            }

            $('#deal_original_price, #deal_sale_price').on('input', calculateDiscount);
        });
        </script>
        <?php
    }

    /**
     * Save Deal Meta
     */
    public function save_deal_meta($post_id) {
        // Check nonce
        if (!isset($_POST['deal_details_nonce']) ||
            !wp_verify_nonce($_POST['deal_details_nonce'], 'save_deal_details')) {
            return;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save fields
        $fields = array(
            'deal_original_price' => '_deal_original_price',
            'deal_sale_price' => '_deal_sale_price',
            'deal_discount_percent' => '_deal_discount_percent',
            'deal_affiliate_link' => '_deal_affiliate_link',
            'deal_expiration_date' => '_deal_expiration_date',
            'deal_coupon_code' => '_deal_coupon_code',
            'deal_store_name' => '_deal_store_name',
            'deal_deal_type' => '_deal_deal_type',
        );

        foreach ($fields as $field => $meta_key) {
            if (isset($_POST[$field])) {
                if ($field === 'deal_affiliate_link') {
                    update_post_meta($post_id, $meta_key, esc_url_raw($_POST[$field]));
                } else {
                    update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
                }
            }
        }

        // Save checkbox
        $is_featured = isset($_POST['deal_is_featured']) ? '1' : '0';
        update_post_meta($post_id, '_deal_is_featured', $is_featured);
    }

    /**
     * Enqueue Frontend Assets
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style('studysync-deals', SSD_PLUGIN_URL . 'assets/css/deals.css', array(), SSD_VERSION);
        wp_enqueue_script('studysync-deals', SSD_PLUGIN_URL . 'assets/js/deals.js', array('jquery'), SSD_VERSION, true);

        wp_localize_script('studysync-deals', 'ssdDeals', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ssd_deals_nonce')
        ));
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueue_admin_assets($hook) {
        if ('post.php' === $hook || 'post-new.php' === $hook) {
            wp_enqueue_style('studysync-deals-admin', SSD_PLUGIN_URL . 'assets/css/admin.css', array(), SSD_VERSION);
        }
    }

    /**
     * Add Settings Page
     */
    public function add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=deal',
            'Deals Settings',
            'Settings',
            'manage_options',
            'studysync-deals-settings',
            array($this, 'settings_page_callback')
        );
    }

    /**
     * Settings Page Callback
     */
    public function settings_page_callback() {
        ?>
        <div class="wrap">
            <h1>StudySync Deals Settings</h1>
            <p>Configure your deals management system.</p>

            <h2>Quick Stats</h2>
            <?php
            $total_deals = wp_count_posts('deal')->publish;
            $active_deals = $this->count_active_deals();
            $expired_deals = $this->count_expired_deals();
            $featured_deals = $this->count_featured_deals();
            ?>
            <table class="widefat" style="max-width: 600px;">
                <tr>
                    <th>Total Deals</th>
                    <td><?php echo $total_deals; ?></td>
                </tr>
                <tr>
                    <th>Active Deals</th>
                    <td><?php echo $active_deals; ?></td>
                </tr>
                <tr>
                    <th>Expired Deals</th>
                    <td><?php echo $expired_deals; ?></td>
                </tr>
                <tr>
                    <th>Featured Deals</th>
                    <td><?php echo $featured_deals; ?></td>
                </tr>
            </table>

            <h2>Shortcodes</h2>
            <p>Use these shortcodes to display deals on your pages:</p>
            <table class="widefat" style="max-width: 800px;">
                <thead>
                    <tr>
                        <th>Shortcode</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>[studysync_deals]</code></td>
                        <td>Display all active deals in a grid</td>
                    </tr>
                    <tr>
                        <td><code>[studysync_deals limit="6"]</code></td>
                        <td>Show only 6 deals</td>
                    </tr>
                    <tr>
                        <td><code>[studysync_deals category="laptops"]</code></td>
                        <td>Show deals from specific category</td>
                    </tr>
                    <tr>
                        <td><code>[studysync_deals featured="true"]</code></td>
                        <td>Show only featured/hot deals</td>
                    </tr>
                    <tr>
                        <td><code>[studysync_deal id="123"]</code></td>
                        <td>Display a single deal by ID</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Count Active Deals
     */
    private function count_active_deals() {
        $args = array(
            'post_type' => 'deal',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_deal_expiration_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
                array(
                    'key' => '_deal_expiration_date',
                    'compare' => 'NOT EXISTS'
                )
            )
        );
        $query = new WP_Query($args);
        return $query->found_posts;
    }

    /**
     * Count Expired Deals
     */
    private function count_expired_deals() {
        $args = array(
            'post_type' => 'deal',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_deal_expiration_date',
                    'value' => date('Y-m-d'),
                    'compare' => '<',
                    'type' => 'DATE'
                )
            )
        );
        $query = new WP_Query($args);
        return $query->found_posts;
    }

    /**
     * Count Featured Deals
     */
    private function count_featured_deals() {
        $args = array(
            'post_type' => 'deal',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_deal_is_featured',
                    'value' => '1'
                )
            )
        );
        $query = new WP_Query($args);
        return $query->found_posts;
    }

    /**
     * Deals Shortcode
     */
    public function deals_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 12,
            'category' => '',
            'featured' => '',
            'orderby' => 'date',
            'order' => 'DESC'
        ), $atts);

        ob_start();
        include SSD_PLUGIN_DIR . 'templates/deals-grid.php';
        return ob_get_clean();
    }

    /**
     * Single Deal Shortcode
     */
    public function single_deal_shortcode($atts) {
        $atts = shortcode_atts(array(
            'id' => 0
        ), $atts);

        if (!$atts['id']) {
            return '<p>Please provide a deal ID.</p>';
        }

        ob_start();
        include SSD_PLUGIN_DIR . 'templates/single-deal.php';
        return ob_get_clean();
    }
}

// Initialize the plugin
function studysync_deals_init() {
    return StudySync_Deals::get_instance();
}
add_action('plugins_loaded', 'studysync_deals_init');

// Activation Hook
register_activation_hook(__FILE__, 'studysync_deals_activate');
function studysync_deals_activate() {
    studysync_deals_init();
    flush_rewrite_rules();
}

// Deactivation Hook
register_deactivation_hook(__FILE__, 'studysync_deals_deactivate');
function studysync_deals_deactivate() {
    flush_rewrite_rules();
}
