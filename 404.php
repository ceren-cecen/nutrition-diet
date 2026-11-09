<?php
/**
 * The template for displaying 404 pages (not found)
 * @subpackage Nutrition Diet
 * @since 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="content" class="site-main" role="main">
		<?php $nutrition_diet_header_option = get_theme_mod( 'nutrition_diet_show_header_image','on');
		if($nutrition_diet_header_option == 'on'){ ?>
			<header class="page-header">
				<div class="header-image"></div>
				<div class="internal-div">
					<?php //breadcrumb
					if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
						<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
							<?php nutrition_diet_breadcrumb();  ?>
						</div>
					<?php } ?>
					<h1 class="page-title text-center my-5"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'nutrition-diet' ); ?></h1>
					<div class="home-btn text-center">
					<a href="<?php echo esc_url( home_url() ); ?>" class="py-3 px-4"><?php esc_html_e( 'GO BACK', 'nutrition-diet' ); ?></a>
				</div>
				</div>
			</header>
			<section class="error-404 not-found my-5">
				<div class="container">
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'nutrition-diet' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</div>
			</section>
		<?php }
		else if($nutrition_diet_header_option == 'off'){ ?>	
			<section class="error-404 without-img-head not-found py-5">
				<div class="container">
					<div class="page-content">
						<?php //breadcrumb
						if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
							<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
								<div class="without-img">
									<?php nutrition_diet_breadcrumb();  ?>
								</div>
							</div>
						<?php } ?>
						<h2 class=" text-center my-5"><?php esc_html_e( '404', 'nutrition-diet' ); ?></h2>
						<h1 class=" text-center my-5"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'nutrition-diet' ); ?></h1>
						<p class="text-center"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'nutrition-diet' ); ?></p>
						<?php get_search_form(); ?>
						<div class="home-btn text-center mt-5">
							<a href="<?php echo esc_url( home_url() ); ?>" class="py-3 px-4"><?php esc_html_e( 'GO BACK', 'nutrition-diet' ); ?></a>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
	</main>
</div>

<?php get_footer();