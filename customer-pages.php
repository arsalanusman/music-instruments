<?php
/*
Template Name: Customer Templates
*/

get_header();
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		?>
		<div id="header_half" <?php post_class(); ?>>
			<div id="content">
				<?php the_content(); ?>
			</div>
		</div>
<?php endwhile; endif; 

get_footer();
?>