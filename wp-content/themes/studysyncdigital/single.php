<?php get_header(); ?>

<main class="site-main single-product">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="product-header">
                    <div class="product-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('product-large'); ?>
                        <?php else : ?>
                            <div style="width: 100%; height: 500px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                                💻
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-info">
                        <?php
                        if (get_post_type() == 'product') {
                            $categories = get_the_terms(get_the_ID(), 'product_category');
                        } else {
                            $categories = get_the_category();
                        }

                        if ($categories && !is_wp_error($categories)) {
                            $category = is_array($categories) ? $categories[0] : $categories;
                            echo '<span class="product-category">' . esc_html($category->name) . '</span>';
                        }
                        ?>

                        <h1><?php the_title(); ?></h1>

                        <?php
                        $rating = studysyncdigital_get_rating();
                        echo studysyncdigital_display_rating($rating);
                        echo '<span style="margin-left: 0.5rem; color: var(--text-light);">' . number_format($rating, 1) . ' out of 5</span>';
                        ?>

                        <div class="product-description">
                            <?php the_excerpt(); ?>
                        </div>

                        <?php
                        $features = get_post_meta(get_the_ID(), 'product_features', true);
                        if ($features) :
                            $features_array = explode("\n", $features);
                        ?>
                            <div class="product-features">
                                <h3>Key Features</h3>
                                <ul>
                                    <?php foreach ($features_array as $feature) :
                                        if (trim($feature)) :
                                    ?>
                                            <li><?php echo esc_html(trim($feature)); ?></li>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php
                        $price = studysyncdigital_get_price();
                        if ($price) :
                        ?>
                            <div class="product-price" style="font-size: 2rem; margin-bottom: 1.5rem;">
                                <?php echo esc_html($price); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $affiliate_link = studysyncdigital_get_affiliate_link();
                        ?>
                        <a href="<?php echo esc_url($affiliate_link); ?>" class="buy-button" target="_blank" rel="nofollow noopener">
                            Check Current Price
                        </a>

                        <p class="affiliate-notice">
                            * We may earn a commission when you purchase through this link at no extra cost to you.
                        </p>
                    </div>
                </div>

                <div class="article-content">
                    <h2>Detailed Review</h2>
                    <?php the_content(); ?>

                    <?php if (!$features) : ?>
                        <!-- Default features if none are set -->
                        <h2>What We Like</h2>
                        <div class="product-features">
                            <ul>
                                <li>High-quality build and materials</li>
                                <li>Excellent performance for the price</li>
                                <li>Great for students and professionals</li>
                                <li>Reliable and durable</li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <h2>Final Verdict</h2>
                    <p>After thorough testing and evaluation, we believe this is an excellent choice for students and digital learners. Whether you're taking notes, attending online classes, or working on projects, this product delivers the performance and reliability you need.</p>

                    <div style="background: var(--background-light); padding: 2rem; border-radius: 1rem; margin: 2rem 0; text-align: center;">
                        <h3 style="margin-bottom: 1rem;">Ready to upgrade your study setup?</h3>
                        <a href="<?php echo esc_url($affiliate_link); ?>" class="btn btn-secondary" target="_blank" rel="nofollow noopener">
                            Get it Now
                        </a>
                    </div>
                </div>

            </article>

            <div class="related-products" style="margin-top: 4rem;">
                <h2 class="section-title">You Might Also Like</h2>
                <div class="products-grid">
                    <?php
                    if (get_post_type() == 'product') {
                        $terms = get_the_terms(get_the_ID(), 'product_category');
                        $term_ids = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'term_id') : array();

                        $related_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_category',
                                    'field' => 'term_id',
                                    'terms' => $term_ids,
                                ),
                            ),
                        );
                    } else {
                        $categories = get_the_category();
                        $category_ids = $categories ? wp_list_pluck($categories, 'term_id') : array();

                        $related_args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'category__in' => $category_ids,
                        );
                    }

                    $related_query = new WP_Query($related_args);

                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                    ?>
                            <article class="product-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumbnail', array('class' => 'product-image')); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                        💻
                                    </div>
                                <?php endif; ?>

                                <div class="product-content">
                                    <h2 class="product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="product-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                                </div>
                            </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
