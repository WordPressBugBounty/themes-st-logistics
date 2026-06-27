<?php
// Category label (first category only)
$st_categories = get_the_category();
$st_cat_label  = ! empty( $st_categories ) ? $st_categories[0]->name : '';
$st_cat_link   = ! empty( $st_categories ) ? get_category_link( $st_categories[0]->term_id ) : '';
?>

<?php if ( has_post_thumbnail() ) : ?>
    <a href="<?php echo esc_url( get_permalink() ); ?>">
        <?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top img-fluid' ) ); ?>
    </a>
<?php else : ?>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="st-post-img-placeholder" aria-hidden="true">
        &#9997;
    </a>
<?php endif; ?>

<div class="card-body">
    <?php if ( $st_cat_label ) : ?>
        <a href="<?php echo esc_url( $st_cat_link ); ?>" class="st-card-category-label"><?php echo esc_html( $st_cat_label ); ?></a>
    <?php endif; ?>
    <h5 class="card-title">
        <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
    </h5>
    <p class="card-text"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
</div>

<div class="card-footer">
    <small class="text-muted">
        <?php the_time( get_option( 'date_format' ) ); ?> /
        <?php
        comments_popup_link(
            esc_html__( '0 Comments', 'st-logistics' ),
            esc_html__( '1 Comment', 'st-logistics' ),
            esc_html__( '% Comments', 'st-logistics' ),
            'post-comments'
        );
        ?>
    </small>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary float-right st-read-more-btn">
        <?php esc_html_e( 'Read more', 'st-logistics' ); ?>
    </a>
</div>
