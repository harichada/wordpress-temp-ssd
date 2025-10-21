<?php
/**
 * Template: Single Deal
 * Display a single deal
 *
 * @package StudySync_Deals
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$deal_id = intval($atts['id']);
$deal = get_post($deal_id);

if (!$deal || $deal->post_type !== 'deal') {
    echo '<p>Deal not found.</p>';
    return;
}

setup_postdata($deal);
?>

<div class="ssd-single-deal <?php echo ssd_is_deal_featured($deal_id) ? 'featured-deal' : ''; ?>">

    <?php echo ssd_get_deal_badge($deal_id); ?>

    <div class="single-deal-header">
        <div class="single-deal-image">
            <?php if (has_post_thumbnail($deal_id)) : ?>
                <?php echo get_the_post_thumbnail($deal_id, 'large'); ?>
            <?php else : ?>
                <div class="no-image-placeholder-large">
                    <span>🏷️</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="single-deal-info">
            <?php
            $store = ssd_get_deal_store_name($deal_id);
            if ($store) :
            ?>
                <span class="deal-store-large"><?php echo esc_html($store); ?></span>
            <?php endif; ?>

            <h2 class="single-deal-title"><?php echo get_the_title($deal_id); ?></h2>

            <?php echo ssd_get_deal_price_html($deal_id); ?>

            <?php
            $savings = ssd_get_deal_savings($deal_id);
            if ($savings) :
            ?>
                <div class="deal-savings-large">
                    💰 You save <?php echo $savings; ?>!
                </div>
            <?php endif; ?>

            <?php echo ssd_format_coupon_code($deal_id); ?>

            <div class="single-deal-actions">
                <?php echo ssd_get_deal_button($deal_id, 'Grab This Deal Now'); ?>
            </div>

            <?php
            $expiration = ssd_get_deal_expiration_date($deal_id);
            if ($expiration && !ssd_is_deal_expired($deal_id)) :
                $days_left = ssd_get_days_until_expiration($deal_id);
            ?>
                <div class="deal-expiration-notice">
                    <span class="icon">⏰</span>
                    <span class="text">
                        Deal expires on <?php echo date('F j, Y', strtotime($expiration)); ?>
                        <?php if ($days_left !== null) : ?>
                            (<?php echo $days_left; ?> day<?php echo $days_left != 1 ? 's' : ''; ?> left)
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>

            <p class="affiliate-disclosure">
                <small>* This is an affiliate link. We may earn a commission at no extra cost to you.</small>
            </p>
        </div>
    </div>

    <div class="single-deal-description">
        <h3>Deal Details</h3>
        <?php echo wpautop($deal->post_content); ?>
    </div>

</div>

<?php
wp_reset_postdata();
