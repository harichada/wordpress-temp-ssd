<?php get_header(); ?>

<main class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Discover the Best Tech for Your Study Success</h1>
                <p>Expert reviews and recommendations for laptops, tablets, headphones, and more to enhance your digital learning experience</p>
                <a href="<?php echo home_url('/products'); ?>" class="btn btn-secondary">Explore Products</a>
            </div>
        </div>
    </section>

    <!-- Product Categories -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Browse by Category</h2>
            <div class="categories-grid">
                <a href="<?php echo home_url('/product-category/laptops'); ?>" class="category-card">
                    <div class="category-icon">💻</div>
                    <h3>Laptops</h3>
                    <p>Best laptops for students and professionals</p>
                </a>

                <a href="<?php echo home_url('/product-category/tablets'); ?>" class="category-card">
                    <div class="category-icon">📱</div>
                    <h3>Tablets</h3>
                    <p>Portable devices for note-taking and reading</p>
                </a>

                <a href="<?php echo home_url('/product-category/headphones'); ?>" class="category-card">
                    <div class="category-icon">🎧</div>
                    <h3>Headphones</h3>
                    <p>Focus better with quality audio equipment</p>
                </a>

                <a href="<?php echo home_url('/product-category/smart-devices'); ?>" class="category-card">
                    <div class="category-icon">⌚</div>
                    <h3>Smart Devices</h3>
                    <p>Smartwatches and productivity gadgets</p>
                </a>

                <a href="<?php echo home_url('/product-category/software'); ?>" class="category-card">
                    <div class="category-icon">⚙️</div>
                    <h3>Software</h3>
                    <p>Essential apps and tools for learning</p>
                </a>

                <a href="<?php echo home_url('/product-category/accessories'); ?>" class="category-card">
                    <div class="category-icon">🖱️</div>
                    <h3>Accessories</h3>
                    <p>Keyboards, mice, and desk essentials</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="products-grid">
                <?php
                $args = array(
                    'post_type' => array('product', 'post'),
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $featured_query = new WP_Query($args);

                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
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
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
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
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <!-- Placeholder products when no posts exist -->
                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            💻
                        </div>
                        <div class="product-content">
                            <span class="product-category">Laptops</span>
                            <h2 class="product-title">
                                <a href="#">MacBook Pro 16" M3 Pro</a>
                            </h2>
                            <div class="product-excerpt">
                                The ultimate laptop for students and professionals. Powerful performance, stunning display, and all-day battery life.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star half">★</span>
                                </div>
                                <span class="product-price">$2,499</span>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            📱
                        </div>
                        <div class="product-content">
                            <span class="product-category">Tablets</span>
                            <h2 class="product-title">
                                <a href="#">iPad Air 2024</a>
                            </h2>
                            <div class="product-excerpt">
                                Perfect for note-taking and reading. Lightweight, powerful, and compatible with Apple Pencil for seamless studying.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                </div>
                                <span class="product-price">$599</span>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            🎧
                        </div>
                        <div class="product-content">
                            <span class="product-category">Headphones</span>
                            <h2 class="product-title">
                                <a href="#">Sony WH-1000XM5</a>
                            </h2>
                            <div class="product-excerpt">
                                Industry-leading noise cancellation. Perfect for focusing in busy environments with exceptional sound quality.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star half">★</span>
                                </div>
                                <span class="product-price">$399</span>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            ⌚
                        </div>
                        <div class="product-content">
                            <span class="product-category">Smart Devices</span>
                            <h2 class="product-title">
                                <a href="#">Apple Watch Series 9</a>
                            </h2>
                            <div class="product-excerpt">
                                Stay connected and track your health. Perfect companion for managing your study schedule and fitness goals.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star empty">☆</span>
                                </div>
                                <span class="product-price">$429</span>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            ⚙️
                        </div>
                        <div class="product-content">
                            <span class="product-category">Software</span>
                            <h2 class="product-title">
                                <a href="#">Notion Pro Subscription</a>
                            </h2>
                            <div class="product-excerpt">
                                All-in-one workspace for notes, tasks, and collaboration. Essential tool for organizing your study life.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                </div>
                                <span class="product-price">$10/mo</span>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            🖱️
                        </div>
                        <div class="product-content">
                            <span class="product-category">Accessories</span>
                            <h2 class="product-title">
                                <a href="#">Logitech MX Master 3S</a>
                            </h2>
                            <div class="product-excerpt">
                                Premium wireless mouse with ergonomic design. Perfect for long study sessions and precise work.
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star full">★</span>
                                    <span class="star half">★</span>
                                </div>
                                <span class="product-price">$99</span>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo home_url('/products'); ?>" class="btn btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Latest Articles -->
    <section class="products-section" style="background: var(--background-light);">
        <div class="container">
            <h2 class="section-title">Latest Articles & Reviews</h2>
            <div class="products-grid">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $blog_query = new WP_Query($args);

                if ($blog_query->have_posts()) :
                    while ($blog_query->have_posts()) : $blog_query->the_post();
                ?>
                        <article class="product-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('product-thumbnail', array('class' => 'product-image')); ?>
                                </a>
                            <?php else : ?>
                                <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    📝
                                </div>
                            <?php endif; ?>

                            <div class="product-content">
                                <span class="product-category">Article</span>
                                <h2 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="product-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
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
    </section>
</main>

<?php get_footer(); ?>
