<?php
/**
 * Theme header.
 *
 * @package Asahi_Music_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( '跳至主要內容', 'asahi-music-theme' ); ?></a>

<header class="site-header">
	<div class="site-header__inner">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="site-brand__name"><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>

		<nav class="site-nav" aria-label="<?php esc_attr_e( '主要選單', 'asahi-music-theme' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '首頁', 'asahi-music-theme' ); ?></a>
			<?php $songs_url = get_post_type_archive_link( 'song' ); ?>
			<?php if ( $songs_url ) : ?>
				<a href="<?php echo esc_url( $songs_url ); ?>"><?php esc_html_e( '全部單曲', 'asahi-music-theme' ); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</header>
