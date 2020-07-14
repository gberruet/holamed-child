<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */

$holamed_sidebar_hidden = false;
$holamed_layout = 'classic';
$blog_class = '';

if ( function_exists('FW') ) {

	$blog_class = 'masonry';
	$holamed_layout = fw_get_db_settings_option( 'blog_layout' );
}

get_header('search'); ?>
<div class="inner-page text-page margin-default">
	<div class="row">
        
		<?php
		$url = $_SERVER["REQUEST_URI"];
		$search = $_GET['s'];
		$categoria = esc_url( substr($url, 14));

		if(strpos($categoria , '/page')){
			$categoria = esc_url( substr($categoria, 0, strpos($categoria , '/page')));
			$resultado = str_replace("/", "", $categoria);
		}else{
			$resultado = str_replace("/", "", $categoria);
		}

		if($search == ''){
			if($categoria){
				$wp_query = new WP_Query( array( 
					'team-category' => $resultado,
					'meta_key' => 'apellido',
					'orderby' => 'meta_value',
					'order' => 'ASC',
					'paged' => (int) $paged,
				) );
			}else {
				$wp_query = new WP_Query( array(
					'post_type' => 'team',
			        'posts_per_page'=> 9,
			        'orderby' => 'name',
			        'order'   => 'ASC',
					'paged' => (int) $paged,
				) );
			}
		}


		if ( $wp_query->have_posts() ) :?>

        <div class="row">
        	<div class="col-xl-1 col-lg-2 col-md-10 col-sm-10 col-xs-10 div-sidebar" >
				<div id="content-sidebar" class="content-sidebar widget-area-2" role="complementary">
					<h5>Especialidades</h5>
	    			<?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
	    		</div>
			</div>
			<div class="col-xl-8 col-lg-7 col-md-11 text-page">
	        	<div class="col-sm-11">
	        		<!--
					<div id="especialidad" class="wpb_column vc_column_container vc_col-sm-6">
					<?php //echo do_shortcode( '[searchandfilter order_by="name" search_placeholder="Por especialidad" placeholder="Por especialidad" fields="team-category" submit_label="BUSCAR" headings="ESPECIALIDAD" all_items_labels="TODAS" hide_empty=1]' );?>	
					</div>-->
					<div id="apellido" class="wpb_column vc_column_container vc_col-sm-12">
						<?php echo do_shortcode( '[searchandfilter search_placeholder="Buscar" fields="search" submit_label="BUSCAR" headings="NOMBRE Y/O APELLIDO" post_types="team" required]' );?>
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
			<?php get_sidebar(); ?>  
		</div>
	</div>
</div>
        
<?php
else :
	get_template_part( 'tmpl/content', 'none' );
endif;

get_footer();