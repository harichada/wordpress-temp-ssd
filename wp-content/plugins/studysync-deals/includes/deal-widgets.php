<?php
/**
 * Deal Widgets
 *
 * @package StudySync_Deals
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Featured Deals Widget
 */
class SSD_Featured_Deals_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'ssd_featured_deals',
            'Featured Deals',
            array('description' => 'Display featured hot deals')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 3;

        $query_args = array(
            'post_type' => 'deal',
            'posts_per_page' => $limit,
            'meta_query' => array(
                array(
                    'key' => '_deal_is_featured',
                    'value' => '1'
                )
            )
        );

        $deals = new WP_Query($query_args);

        if ($deals->have_posts()) {
            echo '<div class="widget-deals">';
            while ($deals->have_posts()) {
                $deals->the_post();
                ?>
                <div class="widget-deal-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="widget-deal-image">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="widget-deal-content">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php echo ssd_get_deal_price_html(); ?>
                        <?php echo ssd_get_deal_badge(); ?>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No featured deals available.</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Hot Deals';
        $limit = !empty($instance['limit']) ? $instance['limit'] : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>">Number of deals:</label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('limit')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number"
                   value="<?php echo esc_attr($limit); ?>" min="1" max="10">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 3;
        return $instance;
    }
}

// Register widget
function ssd_register_widgets() {
    register_widget('SSD_Featured_Deals_Widget');
}
add_action('widgets_init', 'ssd_register_widgets');
