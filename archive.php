<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <header class="page-header">
                <?php
                // Lấy cài đặt từ Customizer để ẩn/hiện tiêu đề
                $show_title = get_theme_mod('ht_blog_archive_show_title', true); // true là giá trị mặc định
                if ($show_title) {
                    the_archive_title('<h1 class="page-title">', '</h1>');
                }
                ?>
            </header>

            <?php
            // Lấy cài đặt layout từ Customizer
            // LƯU Ý: ID setting của bạn là 'ht_blog_archive_posts_layout', không phải 'ht_blog_archive_layout'
            $layout = get_theme_mod('ht_blog_archive_posts_layout', 'three-col'); // Mặc định là 3 cột
            $layout_class = 'three-col'; // Lớp CSS mặc định
            $column_class = 'col-md-4'; // Lớp cột bootstrap mặc định

            // Chuyển đổi giá trị setting thành lớp CSS tương ứng
            if ($layout === 'two-col') {
                $column_class = 'col-md-6';
                $layout_class = 'two-col';
            } elseif ($layout === 'three-col' || $layout === 'default') {
                $column_class = 'col-md-4';
                $layout_class = 'three-col';
            } elseif ($layout === 'normal' || $layout === 'list') {
                $column_class = 'col-md-12'; // 1 cột cho layout normal hoặc list
                $layout_class = $layout;
            }
            ?>
            <div class="row blog-archive-wrapper layout-<?php echo esc_attr($layout_class); ?>">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="<?php echo esc_attr($column_class); ?>">
                            <?php get_template_part('template-parts/content', get_post_format()); ?>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p><?php _e('Không có bài viết nào.', 'ht'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>