<?php
/**
 * Deal Helper Functions
 *
 * @package StudySync_Deals
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get deal original price
 */
function ssd_get_deal_original_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $price = get_post_meta($post_id, '_deal_original_price', true);
    return $price ? '$' . number_format($price, 2) : '';
}

/**
 * Get deal sale price
 */
function ssd_get_deal_sale_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $price = get_post_meta($post_id, '_deal_sale_price', true);
    return $price ? '$' . number_format($price, 2) : '';
}

/**
 * Get deal discount percentage
 */
function ssd_get_deal_discount_percent($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_discount_percent', true);
}

/**
 * Get deal affiliate link
 */
function ssd_get_deal_affiliate_link($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $link = get_post_meta($post_id, '_deal_affiliate_link', true);
    return $link ? $link : '#';
}

/**
 * Get deal expiration date
 */
function ssd_get_deal_expiration_date($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_expiration_date', true);
}

/**
 * Get deal coupon code
 */
function ssd_get_deal_coupon_code($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_coupon_code', true);
}

/**
 * Get deal store name
 */
function ssd_get_deal_store_name($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_store_name', true);
}

/**
 * Check if deal is featured
 */
function ssd_is_deal_featured($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_is_featured', true) === '1';
}

/**
 * Get deal type
 */
function ssd_get_deal_type($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_deal_deal_type', true);
}

/**
 * Check if deal is expired
 */
function ssd_is_deal_expired($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $expiration = ssd_get_deal_expiration_date($post_id);
    if (!$expiration) {
        return false; // No expiration date means never expires
    }

    $exp_timestamp = strtotime($expiration);
    $now_timestamp = strtotime(date('Y-m-d'));

    return $exp_timestamp < $now_timestamp;
}

/**
 * Check if deal is expiring soon (within 3 days)
 */
function ssd_is_deal_expiring_soon($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $expiration = ssd_get_deal_expiration_date($post_id);
    if (!$expiration) {
        return false;
    }

    $exp_timestamp = strtotime($expiration);
    $now_timestamp = strtotime(date('Y-m-d'));
    $three_days = 3 * 24 * 60 * 60; // 3 days in seconds

    return ($exp_timestamp - $now_timestamp) <= $three_days && ($exp_timestamp >= $now_timestamp);
}

/**
 * Get days until expiration
 */
function ssd_get_days_until_expiration($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $expiration = ssd_get_deal_expiration_date($post_id);
    if (!$expiration) {
        return null;
    }

    $exp_timestamp = strtotime($expiration);
    $now_timestamp = strtotime(date('Y-m-d'));

    $diff = $exp_timestamp - $now_timestamp;
    $days = floor($diff / (24 * 60 * 60));

    return $days;
}

/**
 * Get deal savings amount
 */
function ssd_get_deal_savings($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $original = get_post_meta($post_id, '_deal_original_price', true);
    $sale = get_post_meta($post_id, '_deal_sale_price', true);

    if (!$original || !$sale) {
        return '';
    }

    $savings = $original - $sale;
    return '$' . number_format($savings, 2);
}

/**
 * Display deal badge based on status
 */
function ssd_get_deal_badge($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $badges = array();

    // Featured/Hot badge
    if (ssd_is_deal_featured($post_id)) {
        $badges[] = '<span class="deal-badge deal-badge-hot">🔥 HOT</span>';
    }

    // Expiring soon badge
    if (ssd_is_deal_expiring_soon($post_id)) {
        $days = ssd_get_days_until_expiration($post_id);
        if ($days === 0) {
            $badges[] = '<span class="deal-badge deal-badge-expiring">⏰ ENDS TODAY</span>';
        } else {
            $badges[] = '<span class="deal-badge deal-badge-expiring">⏰ ENDS IN ' . $days . ' DAY' . ($days > 1 ? 'S' : '') . '</span>';
        }
    }

    // Expired badge
    if (ssd_is_deal_expired($post_id)) {
        $badges[] = '<span class="deal-badge deal-badge-expired">EXPIRED</span>';
    }

    // Deal type badge
    $deal_type = ssd_get_deal_type($post_id);
    if ($deal_type === 'student') {
        $badges[] = '<span class="deal-badge deal-badge-student">🎓 STUDENT</span>';
    } elseif ($deal_type === 'freebie') {
        $badges[] = '<span class="deal-badge deal-badge-free">🎁 FREE</span>';
    }

    return implode(' ', $badges);
}

/**
 * Format coupon code for display
 */
function ssd_format_coupon_code($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $code = ssd_get_deal_coupon_code($post_id);
    if (!$code) {
        return '';
    }

    return '<div class="deal-coupon-code">
        <span class="coupon-label">Use Code:</span>
        <span class="coupon-code" onclick="ssdCopyCode(this)" data-code="' . esc_attr($code) . '">' . esc_html($code) . '</span>
        <span class="coupon-copy-hint">Click to copy</span>
    </div>';
}

/**
 * Get formatted deal price display
 */
function ssd_get_deal_price_html($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $original = get_post_meta($post_id, '_deal_original_price', true);
    $sale = get_post_meta($post_id, '_deal_sale_price', true);
    $discount = ssd_get_deal_discount_percent($post_id);

    if (!$sale) {
        return '';
    }

    $html = '<div class="deal-price-display">';

    if ($original && $original > $sale) {
        $html .= '<span class="price-original">$' . number_format($original, 2) . '</span>';
    }

    $html .= '<span class="price-sale">$' . number_format($sale, 2) . '</span>';

    if ($discount && $discount > 0) {
        $html .= '<span class="price-discount">' . $discount . '% OFF</span>';
    }

    $html .= '</div>';

    return $html;
}

/**
 * Get deal button HTML
 */
function ssd_get_deal_button($post_id = null, $text = 'Get This Deal') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $link = ssd_get_deal_affiliate_link($post_id);
    $expired = ssd_is_deal_expired($post_id);

    if ($expired) {
        return '<a href="#" class="deal-button deal-button-expired" onclick="return false;">Deal Expired</a>';
    }

    return '<a href="' . esc_url($link) . '" class="deal-button deal-button-active" target="_blank" rel="nofollow noopener">' . esc_html($text) . '</a>';
}
