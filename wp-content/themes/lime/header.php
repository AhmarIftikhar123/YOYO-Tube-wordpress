<?php
/**
 * 
 * Header Template
 * 
 * @package Lime
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
          <meta charset="<?php bloginfo('charset') ?>">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>
                    <?php wp_title('|', true, 'right') ?>
                    <?php bloginfo('name') ?>
          </title>
          <?php wp_head() ?>
</head>

<body>
          <main class="wrapper container">

                    <header id="header">
                              <?php get_template_part('template-parts/header/nav') ?>
                    </header>
          </main>