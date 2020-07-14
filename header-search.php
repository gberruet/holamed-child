<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head>
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({
            scrollTop: $('#apellido').offset().top
        }, 'slow');
    });
    </script>
    <script type="text/javascript" src="/wp-content/themes/holamed-child/main.js"></script>
	<link rel="stylesheet" type="text/css" href="/wp-content/themes/holamed-child/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body <?php body_class(); ?>>
<?php

	holamed_the_pageloader_overlay();
	get_template_part( 'navbar' ); 

	$pageheader_layout = holamed_get_pageheader_layout();
	$holamed_header_class = holamed_get_pageheader_class();

	if ( $pageheader_layout != 'disabled' ) : ?>
	<header class="page-header  <?php echo esc_attr($holamed_header_class); ?>">
	    <div class="container">   
	    	<?php
	    		holamed_the_h1();			
				holamed_the_breadcrumbs();
			?>	    
	    </div>	    
	</header>
	<?php endif; ?>
	<div class="container main-wrapper">