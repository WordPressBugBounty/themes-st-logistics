<?php get_header(); ?>

<div id="skip-link-target"  class="mt-5">
    <!-- Main Container -->
    <div class="container st-logistics-index-wrap">
        <div class="row">

            <?php
            function st_logistics_excerpt_length($st_logistics_length) {
                return 20;
            }
            add_filter('excerpt_length', 'st_logistics_excerpt_length');
            ?>

            <div class="col-md-8">
                <!-- Dynamic section heading -->
                <?php
                if ( is_search() ) {
                    $st_section_title = sprintf(
                        /* translators: %s: search query string */
                        esc_html__( 'Search Results for: %s', 'st-logistics' ),
                        '<span class="st-search-query">' . esc_html( get_search_query() ) . '</span>'
                    );
                } elseif ( is_archive() ) {
                    $st_section_title = get_the_archive_title();
                } elseif ( is_home() && ! is_front_page() && get_option( 'page_for_posts' ) ) {
                    $st_section_title = esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) );
                } else {
                    $st_section_title = esc_html__( 'Latest Posts', 'st-logistics' );
                }
                ?>
                <div class="st-blog-section-header">
                    <h2><?php echo wp_kses( $st_section_title, array( 'span' => array( 'class' => array() ) ) ); ?></h2>
                    <div class="st-section-divider"></div>
                </div>

                <div class="row">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 st-logistics-post-card">
                              <?php get_template_part( 'template-parts/content/posts-card' ); ?>
                            </div>
                        </div>
                    <?php endwhile; else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <h3><?php esc_html_e( 'Nothing Found!', 'st-logistics' ); ?></h3>
                                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'st-logistics' ); ?></p>
                                <div class="ashe-widget widget_search">
                                    <?php get_search_form(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- Pagination -->
                <?php the_posts_pagination(); ?>
            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4 col-md-5 col-sm-12 sidebar-area">
                
                <!-- Post Categories with Count -->
                <?php get_template_part( 'template-parts/sidebar/categories' ); ?>

                <!-- Recent Posts with Thumbnails -->
                <hr>
                <?php get_template_part( 'template-parts/sidebar/post-list' ); ?>

                <!-- Tags -->
                <hr>
                <?php get_template_part( 'template-parts/sidebar/tags' ); ?>

            </div><!-- .sidebar-area -->
        </div>
    </div>
</div>

<?php get_footer(); ?>
