<?php
/**
 * Theme footer.
 *
 * @package Asahi_Music_Theme
 */
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( '保留所有權利。', 'asahi-music-theme' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
