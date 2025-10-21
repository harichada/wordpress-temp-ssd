<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div style="padding: 4rem 0;">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header" style="text-align: center; margin-bottom: 3rem;">
                        <h1 class="section-title"><?php the_title(); ?></h1>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image" style="margin-bottom: 3rem;">
                            <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 1rem;')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="article-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
