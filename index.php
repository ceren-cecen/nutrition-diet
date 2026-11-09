<?php
/**
 * The main template file
 *
 * @subpackage Nutrition Diet
 * @since 1.0
 */

get_header(); ?>

<main id="content">
	<?php $nutrition_diet_header_option = get_theme_mod( 'nutrition_diet_show_header_image','on');
	if($nutrition_diet_header_option == 'on'){ ?>
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<div class="header-image"></div>
				<div class="internal-div">
				<?php //breadcrumb
				if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
					<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
						<?php nutrition_diet_breadcrumb();  ?>
					</div>
				<?php } ?>
				<h1 class="page-title mt-4 text-center"><span><?php single_post_title(); ?></span></h1>
				</div>
			</header>
		<?php else : ?>
			<header class="page-header">
				<div class="header-image"></div>
				<div class="internal-div">
				<?php //breadcrumb
				if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
					<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
						<?php nutrition_diet_breadcrumb();  ?>
					</div>
				<?php } ?>
				<h2 class="page-title mt-4 text-center"><span><?php esc_html_e( 'Posts', 'nutrition-diet' ); ?></span></h2>
				</div>
			</header>
		<?php endif; ?>
	<?php }
	else if($nutrition_diet_header_option == 'off'){ ?>
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="mt-4">
				<?php //breadcrumb
				if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
					<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
						<div class="without-img">
							<?php nutrition_diet_breadcrumb();  ?>
						</div>
					</div>
				<?php } ?>
				<h1 class="page-title mt-4 withoutimg text-center"><span><?php single_post_title(); ?></span></h1>
			</header>
		<?php else : ?>
			<header class="mt-4">
				<?php //breadcrumb
				if ( !is_page_template( 'page-template/custom-home-page.php' ) ) { ?>
					<div class="bread_crumb archieve_breadcrumb align-self-center text-center">
						<div class="without-img">
							<?php nutrition_diet_breadcrumb();  ?>
						</div>
					</div>
				<?php } ?>
				<h2 class="page-title mt-4 withoutimg text-center"><span><?php esc_html_e( 'Posts', 'nutrition-diet' ); ?></span></h2>
			</header>
		<?php endif; ?>
	<?php } ?>	
	<div class="container">
		<div class="content-area my-5">
			<div id="main" class="site-main" role="main">
		    	<div class="row m-0">
					<?php
					get_template_part( 'template-parts/post/post-layout' );
					?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer();