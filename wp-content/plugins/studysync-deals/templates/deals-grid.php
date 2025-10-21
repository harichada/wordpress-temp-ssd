<?php
/**
 * Template: Deals Grid
 * Displays deals in a grid layout
 *
 * @package StudySync_Deals
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Build query args
$query_args = array(
    'post_type' => 'deal',
    'posts_per_page' => intval($atts['limit']),
    'orderby' => $atts['orderby'],
    'order' => $atts['order'],
    'post_status' => 'publish'
);

// Filter by category
if (!empty($atts['category'])) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'deal_category',
            'field' => 'slug',
            'terms' => $atts['category']
        )
    );
}

// Filter by featured
if ($atts['featured'] === 'true' || $atts['featured'] === '1') {
    $query_args['meta_query'] = array(
        array(
            'key' => '_deal_is_featured',
            'value' => '1'
        )
    );
}

// Exclude expired deals by default
$query_args['meta_query'][] = array(
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
);

$deals_query = new WP_Query($query_args);

if ($deals_query->have_posts()) :
?>
    <div class="ssd-deals-grid">
        <?php while ($deals_query->have_posts()) : $deals_query->the_post(); ?>
            <div class="ssd-deal-card <?php echo ssd_is_deal_featured() ? 'featured-deal' : ''; ?>">

                <?php echo ssd_get_deal_badge(); ?>

                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="deal-card-image">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php else : ?>
                    <a href="<?php the_permalink(); ?>" class="deal-card-image deal-card-no-image">
                        <div class="no-image-placeholder">
                            <span>🏷️</span>
                        </div>
                    </a>
                <?php endif; ?>

                <div class="deal-card-content">
                    <?php
                    $store = ssd_get_deal_store_name();
                    if ($store) :
                    ?>
                        <span class="deal-store"><?php echo esc_html($store); ?></span>
                    <?php endif; ?>

                    <h3 class="deal-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <div class="deal-card-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                    </div>

                    <?php echo ssd_get_deal_price_html(); ?>

                    <?php
                    $savings = ssd_get_deal_savings();
                    if ($savings) :
                    ?>
                        <div class="deal-savings">
                            Save <?php echo $savings; ?>
                        </div>
                    <?php endif; ?>

                    <?php echo ssd_format_coupon_code(); ?>

                    <div class="deal-card-footer">
                        <?php echo ssd_get_deal_button(get_the_ID(), 'Get Deal'); ?>

                        <?php
                        $days_left = ssd_get_days_until_expiration();
                        if ($days_left !== null && $days_left >= 0) :
                        ?>
                            <span class="deal-expires">
                                <?php
                                if ($days_left == 0) {
                                    echo 'Ends today!';
                                } elseif ($days_left == 1) {
                                    echo 'Ends tomorrow';
                                } else {
                                    echo 'Ends in ' . $days_left . ' days';
                                }
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if ($deals_query->max_num_pages > 1) : ?>
        <div class="ssd-deals-pagination">
            <?php
            echo paginate_links(array(
                'total' => $deals_query->max_num_pages,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;'
            ));
            ?>
        </div>
    <?php endif; ?>

<?php
    wp_reset_postdata();
else :
?>
    <div class="ssd-no-deals">
        <p>No deals available at this time. Check back soon for amazing student tech deals!</p>
    </div>
<?php
endif;
