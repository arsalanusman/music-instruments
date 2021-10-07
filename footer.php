

<div id="footer">
	<div class="row">
		<div class="col-12">
			<!-- footer nav-->
			<div class="footer-nav">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'items_wrap'     => '<ul>%3$s</ul>'
				) );
				?>
			</div>
			<!-- -->
			<!-- copy -->
			<div class="copyright">
				<?php dynamic_sidebar('footercopy'); ?>
			</div>
		</div>
	</div>
</div>

</div><!-- container -->
<script>
	
</script>
<?php
	/*
	 * Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
