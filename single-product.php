<?php
/**
 * Created by PhpStorm.
 * User: Romi
 * Date: 29-Feb-16
 * Time: 9:39 PM
 */
?>

<?php while ( have_posts() ) : the_post(); ?>
                <div class="main-post-div">
                <div class="single-page-post-heading">
                <h1><?php the_title(); ?></h1>
                </div>


         <?php the_post_thumbnail('thumbnail');




                    $price = get_post_meta( get_the_ID(), 'product_price', true ); ?>

            <h4> $<?php echo $price; ?></h4>


        <p><?php $quantity = get_post_meta( get_the_ID(), 'product_qty', true );

    echo $quantity; ?></p>


                <div class="content-here">
                <?php  the_content();  ?>
                </div>
                <div class="comment-section-here"
                <?php //comments_template(); ?>
                </div>
                </div>

            <?php endwhile; ?>

