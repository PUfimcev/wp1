<?php get_header(); ?>
    <div class="container">
        <h1><?php the_archive_title(); ?>:</h1>
        <?php if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">read more</a></p>
            <?php endwhile; else : ?>
            <p>No content found</p
        <?php endif; ?>
    </div>
<?php get_footer() ?>