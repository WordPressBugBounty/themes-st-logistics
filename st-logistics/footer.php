<footer class="footer-side">
  <?php if ( get_theme_mod( 'st_logistics_show_footer_widget', true ) ) : ?>
    <div class="footer-widget">
      <div class="container st-footer-container">
        <?php
          // Check if any footer sidebar is active
          $st_logistics_any_sidebar_active = false;
          for ( $st_logistics_i = 1; $st_logistics_i <= 4; $st_logistics_i++ ) {
            if ( is_active_sidebar( "footer{$st_logistics_i}-sidebar" ) ) {
              $st_logistics_any_sidebar_active = true;
              break;
            }
          }
          // Count active for responsive column classes
          $st_logistics_active_sidebars = 0;
          if ( $st_logistics_any_sidebar_active ) {
            for ( $st_logistics_i = 1; $st_logistics_i <= 4; $st_logistics_i++ ) {
              if ( is_active_sidebar( "footer{$st_logistics_i}-sidebar" ) ) {
                $st_logistics_active_sidebars++;
              }
            }
          }
          $st_logistics_col_class = $st_logistics_active_sidebars > 0 ? 'col-lg-' . (12 / $st_logistics_active_sidebars) . ' col-md-6 col-sm-12' : 'col-lg-3 col-md-6 col-sm-12';
        ?>
        <div class="row pt-2 <?php echo esc_attr( get_theme_mod( 'st_logistics_enable_footer_animation', true ) ? 'zoomInUp wow' : '' ); ?>">
          <?php for ( $st_logistics_i = 1; $st_logistics_i <= 4; $st_logistics_i++ ) : ?>
            <div class="footer-area <?php echo esc_attr( $st_logistics_col_class ); ?>">
              <?php if ( $st_logistics_any_sidebar_active && is_active_sidebar( "footer{$st_logistics_i}-sidebar" ) ) : ?>
                <?php dynamic_sidebar( "footer{$st_logistics_i}-sidebar" ); ?>
              <?php elseif ( ! $st_logistics_any_sidebar_active ) : ?>
                  <?php if ( $st_logistics_i === 1 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer1', 'st-logistics' ); ?>" id="Search" class="sidebar-widget">
                      <h4 class="title"><?php esc_html_e( 'Search', 'st-logistics' ); ?></h4>
                      <?php get_search_form(); ?>
                    </aside>

                  <?php elseif ( $st_logistics_i === 2 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer2', 'st-logistics' ); ?>" id="archives" class="sidebar-widget">
                      <h4 class="title"><?php esc_html_e( 'Archives', 'st-logistics' ); ?></h4>
                      <ul>
                          <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                      </ul>
                    </aside>

                  <?php elseif ( $st_logistics_i === 3 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer3', 'st-logistics' ); ?>" id="meta" class="sidebar-widget">
                      <h4 class="title"><?php esc_html_e( 'Meta', 'st-logistics' ); ?></h4>
                      <ul>
                        <?php wp_register(); ?>
                        <li><?php wp_loginout(); ?></li>
                        <?php wp_meta(); ?>
                      </ul>
                    </aside>

                  <?php elseif ( $st_logistics_i === 4 ) : ?>
                    <aside role="complementary" aria-label="<?php echo esc_attr__( 'footer4', 'st-logistics' ); ?>" id="categories" class="sidebar-widget">
                      <h4 class="title"><?php esc_html_e( 'Categories', 'st-logistics' ); ?></h4>
                      <ul>
                          <?php wp_list_categories( 'title_li=' ); ?>
                      </ul>
                    </aside>
                  <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if ( get_theme_mod( 'st_logistics_show_footer_copyright', true ) ) : ?>
    <div class="footer-copyright <?php if ( get_theme_mod( 'st_logistics_sticky_copyright_enable', 'off' ) === 'on' ) { ?>sticky-copyright<?php } else { ?>close-sticky<?php } ?>">
      <div class="container st-footer-container">
        <div class="row pt-2">
          <div class="col-lg-6 col-md-6 align-self-center">
            <p class="mb-0 py-3 text-start text-md-end">
              <?php
                if ( ! get_theme_mod( 'st_logistics_footer_text' ) ) { ?>
                <a href="<?php echo esc_url( __( 'https://striviothemes.com/product/logistics-wordpress-theme/?utm_source=wordpress&utm_medium=theme&utm_campaign=footer_link', 'st-logistics' ) ); ?>" target="_blank">
                  <?php esc_html_e( 'ST Logistics WordPress Theme', 'st-logistics' ); ?>
                </a>
                <?php } else {
                  echo esc_html( get_theme_mod( 'st_logistics_footer_text' ) );
                }
              ?>
              <?php if ( get_theme_mod( 'st_logistics_copyright_enable', true ) === true ) : ?>
              <?php
                /* translators: %s: StrivioThemes */
                printf( wp_kses( __( ' By <a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>', 'st-logistics' ), array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) ) ), esc_url( 'https://striviothemes.com/?utm_source=wordpress&utm_medium=theme&utm_campaign=footer_link' ), 'StrivioThemes' ); ?>
              <?php endif; ?>
            </p>
          </div>
          <div class="col-lg-6 col-md-6 align-self-center text-right text-md-end">
            <?php if ( get_theme_mod( 'st_logistics_copyright_enable', true ) === true ) : ?>
              <a href="<?php echo esc_url( __( 'https://wordpress.org', 'st-logistics' ) ); ?>" rel="generator"><?php /* translators: %s: WordPress */ printf( esc_html__( 'Proudly powered by %s', 'st-logistics' ), 'WordPress' ); ?></a>
            <?php endif; ?>
          </div>
          <?php if ( get_theme_mod( 'st_logistics_footer_social_icon_hide', false ) === true ) { ?>
            <div class="row">
              <div class="col-12 align-self-center py-1">
                <div class="footer-links">
                  <?php $st_logistics_settings_footer = get_theme_mod( 'st_logistics_social_links_settings_footer' ); ?>
                  <?php if ( is_array( $st_logistics_settings_footer ) || is_object( $st_logistics_settings_footer ) ) { ?>
                    <?php foreach ( $st_logistics_settings_footer as $st_logistics_setting_footer ) { ?>
                      <a href="<?php echo esc_url( $st_logistics_setting_footer['link_url'] ); ?>" target="_blank">
                        <i class="<?php echo esc_attr( $st_logistics_setting_footer['link_text'] ); ?> me-2"></i>
                      </a>
                    <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  
</footer>

<?php wp_footer(); ?>

</body>
</html>
