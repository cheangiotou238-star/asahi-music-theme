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
<script>
(function () {
	var L = ['ja', 'zh', 'en', 'pt'];
	var K = 'asahi-lang';
	var p = new URLSearchParams(location.search).get('lang');
	if (p && L.indexOf(p) !== -1) {
		localStorage.setItem(K, p);
		return;
	}
	var s = localStorage.getItem(K);
	if (s && L.indexOf(s) !== -1 && s !== 'ja') {
		var u = new URL(location.href);
		u.searchParams.set('lang', s);
		location.replace(u.toString());
	}
})();
</script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$asahi_lang      = asahi_get_lang();
$asahi_lang_lbl  = asahi_lang_labels();
$asahi_songs_url = get_post_type_archive_link( 'song' );
?>
<a class="screen-reader-text skip-link" href="#main"><?php echo esc_html( asahi_t( 'skip_to_content' ) ); ?></a>

<header class="site-header">
	<div class="site-header__inner">
		<div class="site-header__top">
			<div class="lang-switcher">
				<div class="lang-select">
					<button type="button" class="lang-select__trigger" id="lang-select-trigger" aria-haspopup="true" aria-expanded="false">
						<span class="lang-select__globe" aria-hidden="true">🌐</span>
						<span class="lang-select__current"><?php echo esc_html( $asahi_lang_lbl[ $asahi_lang ] ); ?></span>
						<span class="lang-select__caret" aria-hidden="true">▼</span>
					</button>
					<ul class="lang-select__menu" id="lang-select-menu" hidden>
						<?php foreach ( $asahi_lang_lbl as $code => $name ) : ?>
							<li><a href="?lang=<?php echo esc_attr( $code ); ?>" data-lang="<?php echo esc_attr( $code ); ?>" <?php echo ( $code === $asahi_lang ) ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="lang-quick">
					<span class="lang-quick__label"><?php echo esc_html( asahi_t( 'lang_support_label' ) ); ?></span>
					<span class="lang-quick__links">
						<?php foreach ( $asahi_lang_lbl as $code => $name ) : ?>
							<a href="?lang=<?php echo esc_attr( $code ); ?>" data-lang="<?php echo esc_attr( $code ); ?>" class="<?php echo ( $code === $asahi_lang ) ? 'is-active' : ''; ?>"><?php echo esc_html( $name ); ?></a>
						<?php endforeach; ?>
					</span>
				</div>
			</div>
		</div>

		<div class="site-header__brand-row">
			<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="site-brand__name"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</a>

			<nav class="site-nav" aria-label="<?php esc_attr_e( '主要選單', 'asahi-music-theme' ); ?>">
				<a class="nav-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="nav-link__main"><?php echo esc_html( asahi_t( 'news' ) ); ?></span>
					<span class="nav-link__sub">NEWS</span>
				</a>
				<?php if ( $asahi_songs_url ) : ?>
					<a class="nav-link" href="<?php echo esc_url( $asahi_songs_url ); ?>">
						<span class="nav-link__main"><?php echo esc_html( asahi_t( 'discography' ) ); ?></span>
						<span class="nav-link__sub">DISCOGRAPHY</span>
					</a>
				<?php endif; ?>
			</nav>
		</div>
	</div>
</header>
