<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="products-section">
            <?php if (have_posts()) : ?>
                <h1 class="section-title">Latest Tech Reviews</h1>
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
                                $categories = get_the_category();
                                if ($categories) {
                                    echo '<span class="product-category">' . esc_html($categories[0]->name) . '</span>';
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
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read Review</a>
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
                <div class="no-posts">
                    <h2>No posts found</h2>
                    <p>Sorry, no content is available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
