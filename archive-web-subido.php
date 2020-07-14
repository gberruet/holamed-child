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
<div class="inner-page margin-default">
	<div class="row with-sidebar">
        <div class="col-xl-9 col-lg-8 col-md-12 ltx-blog-wrap">
            <div class="blog blog-block layout-<?php echo esc_attr($holamed_layout); ?>">
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
							'orderby' => 'post_title',
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


				if ( $wp_query->have_posts() ) :

	            	echo '<div class="row">'; ?>

	            	<div class="col-sm-12">
						<div id="especialidad" class="wpb_column vc_column_container vc_col-sm-6">
						<?php echo do_shortcode( '[searchandfilter order_by="name" search_placeholder="Por especialidad" placeholder="Por especialidad" fields="team-category" submit_label="BUSCAR" headings="ESPECIALIDAD" all_items_labels="TODAS" hide_empty=1]' );?>	
						</div>
						<div id="apellido" class="wpb_column vc_column_container vc_col-sm-6">
							<?php echo do_shortcode( '[searchandfilter search_placeholder="Buscar" fields="search" submit_label="BUSCAR" headings="NOMBRE Y/O APELLIDO" post_types="team" required]' );?>
						</div>
					</div>
				<?php
					while ( $wp_query->have_posts() ) : the_post();

						// Showing classic blog without framework
						if ( !function_exists( 'FW' ) ) {

							get_template_part( 'tmpl/content-post-one-col' );
						}
							else {

							set_query_var( 'holamed_layout', $holamed_layout );

							if ($holamed_layout == 'three-cols') {

								get_template_part( 'tmpl/content-team' );
							}
								else
							if ($holamed_layout == 'two-cols') {

								get_template_part( 'tmpl/content-post-two-cols' );
							}
								else {

								get_template_part( 'tmpl/content-post-one-col' );
							}
						}

					endwhile;
					echo '</div>';
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'tmpl/content', 'none' );

				endif;

				?>
				<?php
				if ( have_posts() ) {

					holamed_paging_nav();
				}
	            ?>
	        </div>
	    </div>
	    <?php
	    if ( !$holamed_sidebar_hidden ) {

            	get_sidebar();
	    }
	    ?>
	</div>
</div>
<?php

get_footer();

