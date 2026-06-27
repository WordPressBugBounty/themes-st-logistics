<div class="widget widget-categories">
                    <h3 class="widget-title font-weight-bold"><?php esc_html_e( 'Categories', 'st-logistics' ); ?></h3>
                    <ul class="list-group">
                        <?php 
                        $st_logistics_categories = get_categories( array(
                            'orderby' => 'name',
                            'order'   => 'ASC'
                        ) );

                        foreach( $st_logistics_categories as $st_logistics_category ) {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center mb-2">';
                            echo '<a href="' . esc_url( get_category_link( $st_logistics_category->term_id ) ) . '">' . esc_html( $st_logistics_category->name ) . '</a>';
                            echo '<span class="badge badge-primary badge-pill st-logistics-cat-badge">' . esc_html( $st_logistics_category->count ) . '</span>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>