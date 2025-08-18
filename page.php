<!-- <head>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <link
    rel="stylesheet"
    data-purpose="Layout StyleSheet"
    title="Web Awesome"
    href="/css/app-wa-86cd56275caec687041f80b17dc62e32.css?vsn=d">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-thin.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-regular.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-light.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-thin.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-regular.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-light.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-thin.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-regular.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-light.css">
</head> -->
<?php get_header(); ?>
<main class="">
  <?php
  if (have_posts()):
    while (have_posts()):
      the_post();

      // Hiển thị nội dung từ WordPress/Elementor
      the_content();

    endwhile;
  endif;
  ?>
  <!-- abc -->
</main>
<?php get_footer(); ?>