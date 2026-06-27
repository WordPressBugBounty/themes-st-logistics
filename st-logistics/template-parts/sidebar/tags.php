<div class="widget widget-tags">
                    <h3 class="widget-title font-weight-bold"><?php esc_html_e( 'Tags', 'st-logistics' ); ?></h3>
                    <div class="tagcloud">
                        <ul class="list-inline">
                            <?php
                            $st_logistics_tags = get_tags();
                            foreach ( $st_logistics_tags as $st_logistics_tag ) {
                                echo '<li class="list-inline-item mt-2"><a href="' . esc_url( get_tag_link($st_logistics_tag->term_id) ) . '" class="btn btn-outline-primary st-read-more-btn btn-sm st-tags-btn">' . esc_html( $st_logistics_tag->name ) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>