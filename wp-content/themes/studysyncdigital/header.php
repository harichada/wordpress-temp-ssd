<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <span class="logo-icon">📚</span>
                <span><?php bloginfo('name'); ?></span>
            </a>

            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => function() {
                        echo '<ul>';
                        echo '<li><a href="' . home_url('/') . '">Home</a></li>';
                        echo '<li><a href="' . home_url('/products') . '">Products</a></li>';
                        echo '<li><a href="' . home_url('/blog') . '">Blog</a></li>';
                        echo '<li><a href="' . home_url('/about') . '">About</a></li>';
                        echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
                        echo '</ul>';
                    }
                ));
                ?>
            </nav>
        </div>
    </div>
</header>
