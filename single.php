<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2"> <?php // Layout 1 cột đơn giản ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content-single', get_post_format()); ?>
                        <?php
                        // Hiển thị phần bình luận
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>