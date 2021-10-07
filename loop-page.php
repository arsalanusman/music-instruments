<?php
/**
 * The loop that displays a page
 *
 * The loop displays the posts and the post content. See
 * https://codex.wordpress.org/The_Loop to understand it and
 * https://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$vc_enabled = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
		
		?>
		<div id="header_half" <?php post_class(); ?>>
			<div id="content">
				<?php the_content(); ?>
			</div>
		</div>
<?php endwhile; endif; ?>
