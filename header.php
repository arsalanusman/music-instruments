<?php
	session_start();
/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) ) {
	echo " | $site_description";
}

	// Add a page number if necessary:
if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
	echo esc_html( ' | ' . sprintf( __( 'Page %s', 'music' ), max( $paged, $page ) ) );
}

?>
	</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php
	/*
	 * We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
if ( is_singular() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

	/*
	 * Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
	
<!-- Google Ana-->
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18975281-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- end gogole -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php 
	$pageID 	= get_the_ID();
	$bg 		= get_the_post_thumbnail_url(get_the_ID(),'full'); 
	$title 		= get_field( "_title_", $pageID );
	$subtitle 	= get_field( "_sub_title_", $pageID );
	
	if(empty($bg)):
		
	else:

	endif;
	

	if(empty($title)):
		$THE_TITLE = get_the_title();
	else:
		$THE_TITLE = $title;
	endif;
?>


<!-- main header bg -->
<div class="header-bg vh-100" style="background:url(<?php echo $bg; ?>)">
	<div class="bg h-100">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-12 align-self-center text-center">
					<h1><?php echo $THE_TITLE; ?></h1>
					<h3><?php echo $subtitle; ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end main header bg -->

<div  class="container p-0">

