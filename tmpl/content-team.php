<?php
/**
 * The template for displaying posts in the Gallery post format
 */
if ( function_exists( 'FW' ) ) {
	
	$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
	$social_icons = fw_get_db_post_option(get_The_ID(), 'items');
	$cut = fw_get_db_post_option(get_The_ID(), 'cut');
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
