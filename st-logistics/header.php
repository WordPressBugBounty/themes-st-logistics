<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
    ?>
    <!-- Page Wrapper -->
    <div id="page-wrap">

        <a class="skip-link screen-reader-text" href="#skip-link-target"><?php esc_html_e( 'Skip to content', 'st-logistics' ); ?></a>

        <header id="masthead" class="site-header header sticky-header" role="banner">
            <div class="container st-header-container">

                <!-- Display Custom Header Image -->
                <?php if ( get_header_image() ) : ?>
                    <div id="custom-header" class="mb-4">
                        <img src="<?php echo esc_url( get_header_image() ); ?>"
                             width="<?php echo esc_attr( get_custom_header()->width ); ?>"
                             height="<?php echo esc_attr( get_custom_header()->height ); ?>"
                             alt="<?php esc_attr_e( 'Header Image', 'st-logistics' ); ?>" />
                    </div>
                <?php endif; ?>

                <div class="row align-items-center">

                    <!-- Logo / Site Title -->
                    <div class="col-lg-4 col-md-5 col-8 site-logo align-self-center">
                        <div class="logo">
                            <?php if ( has_custom_logo() ) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <h1 class="site-title mb-0">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                       title="<?php esc_attr_e( 'Home', 'st-logistics' ); ?>"
                                       rel="home">
                                        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                                    </a>
                                </h1>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Navigation + Search -->
                    <div class="col-lg-8 col-md-7 col-4 d-flex align-items-center justify-content-end st-nav-col">

                        <nav id="site-navigation" class="main-navigation">
                            <button type="button" class="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'st-logistics' ); ?>">
                                <i class="fa fa-bars fa-lg"></i>
                            </button>
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'primary-menu',
                                )
                            );
                            ?>
                        </nav><!-- #site-navigation -->

                        <!-- Search Toggle -->
                        <div class="st-header-search-wrap">
                            <button class="st-header-search-toggle"
                                    aria-label="<?php esc_attr_e( 'Open search', 'st-logistics' ); ?>"
                                    aria-expanded="false"
                                    aria-controls="st-header-search-box"
                                    aria-haspopup="true">
                                <i class="fas fa-search" aria-hidden="true"></i>
                                <span class="st-search-label"><?php esc_html_e( 'Search', 'st-logistics' ); ?></span>
                            </button>
                            <div class="st-header-search-box"
                                 id="st-header-search-box"
                                 aria-label="<?php esc_attr_e( 'Site search', 'st-logistics' ); ?>"
                                 hidden>
                                <?php get_search_form(); ?>
                            </div>
                        </div><!-- .st-header-search-wrap -->

                    </div><!-- .st-nav-col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </header><!-- #masthead -->

    </div><!-- #page-wrap -->

