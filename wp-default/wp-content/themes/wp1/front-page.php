<?php get_header(); ?>
    <div class="container">
        <h1><?php echo get_the_title(); ?></h1>
        <?php if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <h2><?php the_content(); ?></h2>
                <p><?php echo do_shortcode('[current_day]'); ?></p>
            <?php endwhile;
        else : ?>
            <p>No content found</p>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>