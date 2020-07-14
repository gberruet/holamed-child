<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style', 99 );

function enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	
	wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get('Version')
    );

	if ( function_exists( 'fw' ) ) {
		wp_add_inline_style( 'parent-style', holamed_generate_css() );
	}
}

/**
 * Add your custom functions below
 */

function inu_home_posts_list( $atts ) {

	?><div class="blog blog-sc row centered layout-list size-sm"><?php	
	
	$args = array(
		'post_type' => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page'=> 4,
		'orderby' => 'date',
		'order'   => 'DESC'
		//'offset'  => 4
	);

	$the_query = new WP_Query( $args );
	if($the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$content = get_the_content();
			$trimmed_content = wp_trim_words( $content, 35, NULL );
			$image_url = get_the_post_thumbnail_url();
            $cat = get_the_category();
			$post_url = get_permalink();
			$date = get_the_date();
			$title = get_the_title();?>

			<div class="col-xs-12 post-block">
			   <article id="<?= get_the_ID(); ?>">
			      <a href="<?= $post_url; ?>" class="photo">
                      <div style="background-image: url('<?=$image_url;?>');display: block; min-height: 150px !important; background-size: cover !important; "> <span class="ltx-cats" style="background-color: #ff7243;color: #fff;border-radius: 20px;padding: 4px 15px;"><?= $cat[0]->name; ?></span> </div>
			      </a>
			      <div class="description">
			      	<div class="blog-info">
			            <ul>
			               <li class="ltx-icon-date"> <a href="<?= $post_url; ?>" class="ltx-date"><span class="fa fa-clock-o"></span><span class="dt"><?= $date; ?></span></a></li>
			            </ul>
			         </div>
			         <a href="<?= get_the_permalink(); ?>" class="header">
			            <h3><?= $title; ?></h3>
			         </a>
			         <p><?= $trimmed_content; ?></p>
			      </div>
			   </article>
			</div>

		<?php endwhile;
		wp_reset_query();
	endif;

	?></div><?php

}
add_shortcode( 'inudev_home_posts_list', 'inu_home_posts_list' );



function inu_home_slider( $atts ) {
	$args = array(
        'post_type' => 'post',
        'meta_key' => 'sticky',
        'posts_per_page'=> 4,
        'orderby' => 'date',
        'order'   => 'DESC'

    );

	?>
	<div class="slider-wrapper-home">
    <?php

    $the_query = new WP_Query( $args );
    if($the_query->have_posts() ):
        while ( $the_query->have_posts() ): $the_query->the_post();
            $content = get_the_content();
            $trimmed_content = wp_trim_words( $content, 50, NULL );
            $image_url = get_the_post_thumbnail_url();
            $cat = get_the_category();

            ?>
            <div class="slide-single-container">
				<div class="slide-column left" style="background-image: url('<?=$image_url;?>');">
					<span class="ltx-cats">
						<a href="<?= get_category_link( $cat[0]->term_id ); ?>"><?= $cat[0]->name; ?></a>
					</span>
				</div>
				<div class="slide-column right">
					<div class="blog-info">
						<ul>
							<li class="ltx-icon-date">
								<a href="#" class="ltx-date">
									<span class="fa fa-clock-o" style="color: #8ec752; font-size: 20px;"></span>
									<span class="dt" style="color: white; opacity: 1;"><?= get_the_date( 'j, F' ); ?></span>
								</a>
							</li>
						</ul>
					</div>
					<h4><a href="<?= get_the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p><?= $trimmed_content?></p>
				</div>
			</div>
	
            <?php
        endwhile;
        wp_reset_query();
    endif;
	?>
	</div>
	<?php
}
add_shortcode( 'inudev_home_slider', 'inu_home_slider' );

function inu_team_posts_list( $atts ) {

	if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

    ?><div class="blog blog-sc row centered layout-list size-sm"><?php

    $args = array(
        'post_type'     => 'team',
        'posts_per_page'=> 9,
        'orderby' => 'date',
        'order'   => 'ASC',
        //'offset'  => 9,
        'paged' => (int) $paged,
    );

    $wp_query = new WP_Query( $args );

    if($wp_query->have_posts() ):
        while ( $wp_query->have_posts() ):
        	$wp_query->the_post();
            ?>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-ms-12">
				<div class="item matchHeight team-item item-type-circle">
					<a href="<?php esc_url( the_permalink() ); ?>" class="black">
						<span class="image">
				        <?php
					        echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'holamed-team', false  );
				        ?>  			
				        </span>
						<h4 class="header"><?php the_title(); ?></h4>
					</a>
					<?php

						$item_cats = wp_get_post_terms( get_the_ID(), 'team-category' );
						$item_term = '';
						if ( $item_cats && !is_wp_error ( $item_cats ) ) {
							
							foreach ($item_cats as $cat) {

								$item_term = $cat->name;
							}
						}

						if (!empty($subheader)) {

							echo '<div class="subheader color-black">'. wp_kses_post($subheader) .'</div>';
						}

						if ( !empty($item_term) ) echo '<p class="subheader">'. wp_kses_post($item_term) .'</p>';

						if ( !empty($cut) ) {

							echo '<p class="cut">' . wp_kses_post($cut) .'</p>';
						}

						if ( !empty($social_icons) ) {

							echo '<ul class="social">';
							foreach ($social_icons as $item) {

								echo '<li><a href="'.esc_url( $item['href'] ).'" class="'.esc_attr( $item['icon'] ) .'"></a></li>';
							}
							echo '</ul>';
						}
					?>
				</div>
			</div>

        <?php endwhile;
        //wp_reset_query();
        holamed_paging_nav();
    endif;

    ?></div><?php

}
add_shortcode( 'inudev_team_posts_list', 'inu_team_posts_list' );

/*
function inu_team_posts_list( $atts ) {

    ?><div class="blog blog-sc row centered layout-list size-sm"><?php

    $args = array(
        'post_type'     => 'team',
        'posts_per_page'=> 9,
        'orderby' => 'date',
        'order'   => 'DESC',
        'offset'  => 9,
        'paged' => get_query_var( 'paged' ),
    );

    $the_query = new WP_Query( $args );
    if($the_query->have_posts() ):
        while ( $the_query->have_posts() ): $the_query->the_post();
            $image_url = get_the_post_thumbnail_url();
            $item_term = get_the_category();
            $post_url = get_permalink();
            $title = get_the_title();?>
            <?php
            $item_cats = wp_get_post_terms( get_the_ID(), 'team-category' );
            $item_term = '';
            if ( $item_cats && !is_wp_error ( $item_cats ) ) {

                foreach ($item_cats as $cat) {

                    $item_term = $cat->name;
                }
            }

            ?>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-ms-12">
				<div class="item matchHeight team-item item-type-circle">
					<a href="<?php esc_url( the_permalink() ); ?>" class="black">
						<span class="image">
				        <?php
					        echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'holamed-team', false  );
				        ?>  			
				        </span>
						<h4 class="header"><?php the_title(); ?></h4>
					</a>
					<?php

						$item_cats = wp_get_post_terms( get_the_ID(), 'team-category' );
						$item_term = '';
						if ( $item_cats && !is_wp_error ( $item_cats ) ) {
							
							foreach ($item_cats as $cat) {

								$item_term = $cat->name;
							}
						}

						if (!empty($subheader)) {

							echo '<div class="subheader color-black">'. wp_kses_post($subheader) .'</div>';
						}

						if ( !empty($item_term) ) echo '<p class="subheader">'. wp_kses_post($item_term) .'</p>';

						if ( !empty($cut) ) {

							echo '<p class="cut">' . wp_kses_post($cut) .'</p>';
						}

						if ( !empty($social_icons) ) {

							echo '<ul class="social">';
							foreach ($social_icons as $item) {

								echo '<li><a href="'.esc_url( $item['href'] ).'" class="'.esc_attr( $item['icon'] ) .'"></a></li>';
							}
							echo '</ul>';
						}
					?>
				</div>
			</div>
			<!-- Esto es lo que estaba armado antes
            <div class="col-xs-4 post-block">
                <article id="<?= get_the_ID(); ?>">
                    <a href="<?= $post_url; ?>" class="photo">
                        <div style="background-image: url('<?=$image_url;?>');display: block; min-height: 150px !important; background-size: cover !important; ">  </div>
                    </a>
                    <div class="description">
                        <div class="blog-info">

                        </div>
                        <a href="<?= get_the_permalink(); ?>" class="header">
                            <h3><?= $title; ?></h3>
                        </a>
                        <p class="subheader"><?= $item_term; ?></p>
                    </div>
                </article>
            </div>
			-->
        <?php endwhile;
        wp_reset_query();
    endif;

    ?></div><?php

}
add_shortcode( 'inudev_team_posts_list', 'inu_team_posts_list' );