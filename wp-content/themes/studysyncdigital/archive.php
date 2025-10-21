<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="products-section">
            <header class="archive-header" style="text-align: center; margin-bottom: 3rem;">
                <?php
                the_archive_title('<h1 class="section-title">', '</h1>');
                the_archive_description('<div class="archive-description" style="color: var(--text-light); font-size: 1.125rem; max-width: 800px; margin: 0 auto;">', '</div>');
                ?>
            </header>

            <?php if (have_posts()) : ?>
                <div class="products-grid">
                    <?php while (have_posts()) : the_post(); ?>
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

                                <h2 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="product-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="product-meta">
                                    <?php
                                    $rating = studysyncdigital_get_rating();
                                    echo studysyncdigital_display_rating($rating);
                                    ?>

                                    <?php
                                    $price = studysyncdigital_get_price();
                                    if ($price) {
                                        echo '<span class="product-price">' . esc_html($price) . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination" style="margin-top: 3rem; text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '&laquo; Previous',
                        'next_text' => 'Next &raquo;',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="no-posts" style="text-align: center; padding: 4rem 0;">
                    <h2>No posts found</h2>
                    <p>Sorry, no content is available in this category at this time.</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Back to Home</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
