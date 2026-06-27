<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ST_Logistics_Rating_Notice {
    private $past_date;

    public function __construct() {
        $this->past_date = false == get_option('st_logistics_maybe_later_time') ? strtotime( '-5 days' ) : strtotime('-15 days');

        if ( current_user_can( 'manage_options' ) ) {
            if ( empty(get_option('st_logistics_rating_dismiss_notice')) && empty(get_option('st_logistics_rating_already_rated')) ) {
                add_action( 'admin_init', [$this, 'st_logistics_check_theme_install_time'] );
            }
        }

        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'admin_head', [$this, 'st_logistics_enqueue_scripts' ] );
        }

        add_action( 'wp_ajax_st_logistics_rating_dismiss_notice', [$this, 'st_logistics_rating_dismiss_notice'] );
        add_action( 'wp_ajax_st_logistics_rating_already_rated', [$this, 'st_logistics_rating_already_rated'] );
        add_action( 'wp_ajax_st_logistics_rating_maybe_later', [$this, 'st_logistics_rating_maybe_later'] );
    }

    public function st_logistics_check_theme_install_time() {   
        $st_logistics_install_date = get_option('st_logistics_activation_time');

        if ( false !== $st_logistics_install_date && $this->past_date >= $st_logistics_install_date ) {
            add_action( 'admin_notices', [$this, 'st_logistics_render_rating_notice' ]);
        }
    }

    public function st_logistics_rating_maybe_later() {
        check_ajax_referer( 'st_logistics_rating_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }
        update_option('st_logistics_maybe_later_time', true);
        update_option('st_logistics_activation_time', strtotime('now'));
        wp_die();
    }

    public function st_logistics_rating_dismiss_notice() {
        check_ajax_referer( 'st_logistics_rating_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }
        update_option( 'st_logistics_rating_dismiss_notice', true );
        wp_die();
    }

    public function st_logistics_rating_already_rated() {
        check_ajax_referer( 'st_logistics_rating_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }
        update_option( 'st_logistics_rating_already_rated' , true );
        wp_die();
    }

    public function st_logistics_render_rating_notice() {
        if ( current_user_can( 'manage_options' ) ) {
            echo '<div class="notice st-rating-notice is-dismissible" style="border-left-color: #0073aa!important; display: flex; align-items: center;">
                    <div class="st-rating-notice-logo">
                        <img class="st-logo" src="'.esc_url(get_theme_file_uri('/inc/activation/img/logo-128x128.png')).'">
                    </div>
                    <div>
                        <h3>' . esc_html__('Thank you for using ST Logistics Theme to build this website!', 'st-logistics') . '</h3>
                        <p>' . esc_html__('Could you please do us a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', 'st-logistics') . '</p>
                        <p>
                            <a href="https://wordpress.org/support/theme/st-logistics/reviews/?filter=5" target="_blank" class="st-you-deserve-it button button-primary">' . esc_html__('OK, you deserve it!', 'st-logistics') . '</a>
                            <a class="st-maybe-later"><span class="dashicons dashicons-clock"></span> ' . esc_html__('Maybe Later', 'st-logistics') . '</a>
                            <a class="st-already-rated"><span class="dashicons dashicons-yes"></span> ' . esc_html__('I Already did', 'st-logistics') . '</a>
                        </p>
                    </div>
                </div>';
        }
    }
    

    public function st_logistics_enqueue_scripts() {
        $nonce = wp_create_nonce( 'st_logistics_rating_nonce' );
        echo "
        <script>
        jQuery( document ).ready( function() {
            var stRatingNonce = '" . esc_js( $nonce ) . "';

            jQuery(document).on( 'click', '.st-rating-notice .notice-dismiss', function(e) {
                e.preventDefault();
                jQuery(document).find('.st-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'st_logistics_rating_dismiss_notice',
                        nonce: stRatingNonce,
                    }
                })
            });

            jQuery(document).on( 'click', '.st-maybe-later', function() {
                jQuery(document).find('.st-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'st_logistics_rating_maybe_later',
                        nonce: stRatingNonce,
                    }
                })
            });

            jQuery(document).on( 'click', '.st-already-rated', function() {
                jQuery(document).find('.st-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'st_logistics_rating_already_rated',
                        nonce: stRatingNonce,
                    }
                })
            });
        });
        </script>

        <style>
            .st-rating-notice {
              padding: 0 15px;
            }

            .st-rating-notice-logo {
                margin-right: 20px;
                width: 100px;
                height: 100px;
            }

            .st-rating-notice-logo img {
                max-width: 100%;
            }

            .st-rating-notice h3 {
              margin-bottom: 0;
            }

            .st-rating-notice p {
              margin-top: 3px;
              margin-bottom: 15px;
            }

            .st-already-rated,
            .st-maybe-later {
              text-decoration: none;
              margin-left: 12px;
              font-size: 14px;
              cursor: pointer;
            }

            .st-already-rated .dashicons,
            .st-maybe-later .dashicons {
              vertical-align: sub;
            }

            .st-logo {
                height: 100%;
                width: auto;
            }

        </style>
        ";
    }
}

new ST_Logistics_Rating_Notice();