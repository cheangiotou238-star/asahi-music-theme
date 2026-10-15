<?php
/**
 * Theme footer.
 *
 * @package Asahi_Music_Theme
 */
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php echo esc_html( asahi_t( 'footer_rights' ) ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
