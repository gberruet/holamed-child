<?php
/**
 * Team Archive
 */
$sidebar_layout = 'right';
$margin_layout = 'margin-default';
if ( function_exists( 'fw_get_db_settings_option' ) ) {

	$sidebar_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'sidebar-layout' );
	$margin_layout = 'margin-'.fw_get_db_post_option( $wp_query->get_queried_object_id(), 'margin-layout' );

	$holamed_current_scheme_db = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'color-scheme' );
	
	add_filter ('holamed_current_scheme', function() {
		global $holamed_current_scheme_db;
		if ($holamed_current_scheme_db == 'default') $holamed_current_scheme_db = 1; 
		return $holamed_current_scheme_db; 
	} );

}

if ( holamed_is_wc('cart') OR holamed_is_wc('checkout') ) {

	$sidebar_layout = 'hidden';	
}

if ( empty($margin_layout) OR $margin_layout == 'margin-' ) $margin_layout = 'margin-default';

get_header('search');

if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }


$titulo = get_the_title();
$apellido = explode(". ", $titulo);	       

$wp_query = new WP_Query( array(
	'post_type' => 'team',
    'posts_per_page'=> 9,
    'meta_key'	=> 'apellido',
	'orderby' => 'meta_value',
	'order'	=> 'ASC',
	'paged' => (int) $paged,
) );

$wp_query->the_title();

if ( $wp_query->have_posts() ) :
?>
<div class="inner-page text-page <?php echo esc_attr( $margin_layout ); ?>">
    <div class="row">
    	<?php //if ( $sidebar_layout == 'left' ): ?>
    	<div class="col-md-12 col-lg-2 col-xl-2" >
			<div id="content-sidebar" class="content-sidebar widget-area-2" role="complementary">
				<h5>Especialidades</h5>
    			<?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
    		</div>
		</div>
		<?php //endif; ?>

        <div class="col-xl-7 col-lg-7">
	    	<div class="col-sm-12">
	    		<!--
				<div id="especialidad" class="wpb_column vc_column_container vc_col-sm-6">
				<?php //echo do_shortcode( '[searchandfilter order_by="name" search_placeholder="Por especialidad" placeholder="Por especialidad" fields="team-category" submit_label="BUSCAR" headings="ESPECIALIDAD" all_items_labels="TODAS" hide_empty=1]' );?>	
				</div>-->
				<div id="apellido" class="wpb_column vc_column_container vc_col-sm-12">
					<?php echo do_shortcode( '[searchandfilter search_placeholder="Buscar" fields="search" submit_label="BUSCAR" headings="NOMBRE Y/O APELLIDO" post_types="team"]' );?>
				</div>
			</div>

		<?php
		
			while ( $wp_query->have_posts() ) : 

				$wp_query->the_post();

				get_template_part( 'tmpl/content', 'team' );

			endwhile;
			holamed_paging_nav();
		?>  
		</div>
		<?php if ( $sidebar_layout == 'right' ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>      
	</div>    
</div>        
<?php
else :
	get_template_part( 'tmpl/content', 'none' );
endif;

get_footer();

