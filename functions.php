<?php
/**
 * Asahi Music Theme functions and definitions.
 *
 * @package Asahi_Music_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ASAHI_THEME_VERSION', '1.0.0' );

/* -------------------------------------------------------------------------
 * Multilingual support (JA / ZH / EN / PT)
 * ---------------------------------------------------------------------- */
function asahi_get_supported_langs() {
	return array( 'ja', 'zh', 'en', 'pt' );
}

function asahi_get_lang() {
	$lang    = isset( $_GET['lang'] ) ? sanitize_key( wp_unslash( $_GET['lang'] ) ) : 'ja';
	$allowed = asahi_get_supported_langs();
	return in_array( $lang, $allowed, true ) ? $lang : 'ja';
}

function asahi_lang_labels() {
	return array(
		'ja' => '日本語',
		'zh' => '繁體中文',
		'en' => 'English',
		'pt' => 'Português',
	);
}

function asahi_get_dictionary() {
	return array(
		'ja' => array(
			'lang_support_label' => '4言語対応：',
			'news'               => 'ニュース',
			'discography'        => 'ディスコグラフィー',
			'home'               => 'ホーム',
			'all_songs'          => '全楽曲',
			'latest_release'     => '最新リリース',
			'view_song'          => '楽曲を見る',
			'no_songs'           => '楽曲はまだ公開されていません。',
			'no_content'         => 'コンテンツはまだありません。',
			'role_creator'       => '歌唱・クリエイター',
			'role_lyrics'        => '作詞',
			'role_compose'       => '作曲',
			'role_arrange'       => '編曲',
			'role_illustrator'   => 'イラスト',
			'section_story'      => '楽曲背景ストーリー',
			'section_notes'      => '制作後記・インスピレーション',
			'section_lyrics'     => '歌詞',
			'footer_rights'      => '全著作権所有。',
			'audio_unsupported'  => 'お使いのブラウザは音声再生に対応していません。',
			'skip_to_content'    => '本文へスキップ',
		),
		'zh' => array(
			'lang_support_label' => '支援四種語言：',
			'news'               => '最新消息',
			'discography'        => '作品列表',
			'home'               => '首頁',
			'all_songs'          => '全部單曲',
			'latest_release'     => '最新主打',
			'view_song'          => '查看單曲',
			'no_songs'           => '尚未發佈任何單曲。',
			'no_content'         => '暫無內容。',
			'role_creator'       => '創作者 / 歌唱',
			'role_lyrics'        => '作詞',
			'role_compose'       => '作曲',
			'role_arrange'       => '編曲',
			'role_illustrator'   => '插畫設計',
			'section_story'      => '歌曲背景故事',
			'section_notes'      => '創作後記與靈感',
			'section_lyrics'     => '完整歌詞',
			'footer_rights'      => '保留所有權利。',
			'audio_unsupported'  => '您的瀏覽器不支援音訊播放。',
			'skip_to_content'    => '跳至主要內容',
		),
		'en' => array(
			'lang_support_label' => '4 languages:',
			'news'               => 'NEWS',
			'discography'        => 'DISCOGRAPHY',
			'home'               => 'HOME',
			'all_songs'          => 'ALL SONGS',
			'latest_release'     => 'LATEST RELEASE',
			'view_song'          => 'VIEW SONG',
			'no_songs'           => 'No songs have been released yet.',
			'no_content'         => 'No content yet.',
			'role_creator'       => 'Creator / Vocal',
			'role_lyrics'        => 'Lyrics',
			'role_compose'       => 'Composition',
			'role_arrange'       => 'Arrangement',
			'role_illustrator'   => 'Illustration',
			'section_story'      => 'Background Story',
			'section_notes'      => 'Liner Notes & Inspiration',
			'section_lyrics'     => 'Lyrics',
			'footer_rights'      => 'All rights reserved.',
			'audio_unsupported'  => 'Your browser does not support audio playback.',
			'skip_to_content'    => 'Skip to content',
		),
		'pt' => array(
			'lang_support_label' => '4 idiomas:',
			'news'               => 'NOTÍCIAS',
			'discography'        => 'DISCOGRAFIA',
			'home'               => 'INÍCIO',
			'all_songs'          => 'TODAS AS MÚSICAS',
			'latest_release'     => 'LANÇAMENTO MAIS RECENTE',
			'view_song'          => 'VER MÚSICA',
			'no_songs'           => 'Nenhuma música foi lançada ainda.',
			'no_content'         => 'Nenhum conteúdo ainda.',
			'role_creator'       => 'Criador / Vocal',
			'role_lyrics'        => 'Letra',
			'role_compose'       => 'Composição',
			'role_arrange'       => 'Arranjo',
			'role_illustrator'   => 'Ilustração',
			'section_story'      => 'História de Fundo',
			'section_notes'      => 'Notas do Autor & Inspiração',
			'section_lyrics'     => 'Letra',
			'footer_rights'      => 'Todos os direitos reservados.',
			'audio_unsupported'  => 'Seu navegador não suporta reprodução de áudio.',
			'skip_to_content'    => 'Pular para o conteúdo',
		),
	);
}

function asahi_t( $key ) {
	$dict = asahi_get_dictionary();
	$lang = asahi_get_lang();
	if ( isset( $dict[ $lang ][ $key ] ) ) {
		return $dict[ $lang ][ $key ];
	}
	if ( isset( $dict['ja'][ $key ] ) ) {
		return $dict['ja'][ $key ];
	}
	return $key;
}

function asahi_get_song_title( $post_id = 0, $lang = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$lang    = $lang ? $lang : asahi_get_lang();
	$title   = get_the_title( $post_id );
	if ( 'ja' === $lang ) {
		return $title;
	}
	$translated = get_post_meta( $post_id, '_asahi_' . $lang . '_title', true );
	return ( '' !== $translated ) ? $translated : $title;
}

function asahi_audio_mime_type( $url ) {
	$path = wp_parse_url( $url, PHP_URL_PATH );
	$ext  = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
	if ( in_array( $ext, array( 'mp4', 'm4a', 'aac' ), true ) ) {
		return 'audio/mp4';
	}
	return 'audio/mpeg';
}

function asahi_filter_html_lang( $output ) {
	$map  = array( 'ja' => 'ja', 'zh' => 'zh-Hant', 'en' => 'en', 'pt' => 'pt' );
	$lang = asahi_get_lang();
	$code = isset( $map[ $lang ] ) ? $map[ $lang ] : 'ja';
	return 'lang="' . esc_attr( $code ) . '"';
}
add_filter( 'language_attributes', 'asahi_filter_html_lang' );

function asahi_output_hreflang() {
	$hreflang_map = array(
		'ja' => 'ja',
		'zh' => 'zh-Hant',
		'en' => 'en',
		'pt' => 'pt',
	);

	$scheme = is_ssl() ? 'https' : 'http';
	$host   = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	$uri    = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$base   = remove_query_arg( 'lang', $scheme . '://' . $host . $uri );

	foreach ( $hreflang_map as $code => $hreflang ) {
		$url = add_query_arg( 'lang', $code, $base );
		echo '<link rel="alternate" hreflang="' . esc_attr( $hreflang ) . '" href="' . esc_url( $url ) . '">' . "\n";
	}

	$default_url = add_query_arg( 'lang', 'ja', $base );
	echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $default_url ) . '">' . "\n";
}
add_action( 'wp_head', 'asahi_output_hreflang' );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function asahi_theme_setup() {
	load_theme_textdomain( 'asahi-music-theme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 240, 'flex-width' => true, 'flex-height' => true ) );
}
add_action( 'after_setup_theme', 'asahi_theme_setup' );

/* -------------------------------------------------------------------------
 * Enqueue front-end assets (Plyr + Color Thief via CDN)
 * ---------------------------------------------------------------------- */
function asahi_enqueue_assets() {
	wp_enqueue_style( 'asahi-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;600;700&display=swap', array(), null );
	wp_enqueue_style( 'asahi-style', get_stylesheet_uri(), array(), ASAHI_THEME_VERSION );
	wp_enqueue_style( 'plyr', 'https://cdn.jsdelivr.net/npm/plyr@3.7.8/dist/plyr.css', array(), '3.7.8' );
	wp_enqueue_script( 'color-thief', 'https://cdn.jsdelivr.net/npm/colorthief@2.4.0/dist/color-thief.umd.js', array(), '2.4.0', true );
	wp_enqueue_script( 'plyr', 'https://cdn.jsdelivr.net/npm/plyr@3.7.8/dist/plyr.min.js', array(), '3.7.8', true );
	wp_enqueue_script( 'asahi-frontend', get_template_directory_uri() . '/assets/js/frontend.js', array( 'color-thief', 'plyr' ), ASAHI_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'asahi_enqueue_assets' );

/* -------------------------------------------------------------------------
 * Enqueue admin assets (WP media picker)
 * ---------------------------------------------------------------------- */
function asahi_admin_assets( $hook ) {
	global $post_type;
	if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && 'song' === $post_type ) {
		wp_enqueue_media();
		wp_enqueue_script( 'asahi-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), ASAHI_THEME_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'asahi_admin_assets' );

/* -------------------------------------------------------------------------
 * Register Custom Post Type: song
 * ---------------------------------------------------------------------- */
function asahi_register_song_cpt() {
	$labels = array(
		'name'                  => __( '單曲作品', 'asahi-music-theme' ),
		'singular_name'         => __( '單曲', 'asahi-music-theme' ),
		'menu_name'             => __( '單曲作品', 'asahi-music-theme' ),
		'add_new'               => __( '新增單曲', 'asahi-music-theme' ),
		'add_new_item'          => __( '新增單曲作品', 'asahi-music-theme' ),
		'edit_item'             => __( '編輯單曲', 'asahi-music-theme' ),
		'new_item'              => __( '新單曲', 'asahi-music-theme' ),
		'view_item'             => __( '查看單曲', 'asahi-music-theme' ),
		'search_items'          => __( '搜尋單曲', 'asahi-music-theme' ),
		'not_found'             => __( '找不到單曲', 'asahi-music-theme' ),
		'not_found_in_trash'    => __( '垃圾桶中找不到單曲', 'asahi-music-theme' ),
		'all_items'             => __( '所有單曲', 'asahi-music-theme' ),
		'archives'              => __( '單曲作品彙整', 'asahi-music-theme' ),
		'featured_image'        => __( '單曲封面', 'asahi-music-theme' ),
		'set_featured_image'    => __( '設定單曲封面', 'asahi-music-theme' ),
		'remove_featured_image' => __( '移除單曲封面', 'asahi-music-theme' ),
		'use_featured_image'    => __( '使用為單曲封面', 'asahi-music-theme' ),
	);

	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'songs', 'with_front' => false ),
		'menu_icon'     => 'dashicons-format-audio',
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest'  => true,
	);

	register_post_type( 'song', $args );
}
add_action( 'init', 'asahi_register_song_cpt' );

/* -------------------------------------------------------------------------
 * Helper: creator name with default fallback
 * ---------------------------------------------------------------------- */
function asahi_get_creator( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$creator = get_post_meta( $post_id, '_asahi_creator', true );
	return ( '' === $creator ) ? '白鳥朝陽 / Shiratori Asahi' : $creator;
}

/* -------------------------------------------------------------------------
 * Meta boxes
 * ---------------------------------------------------------------------- */
function asahi_add_meta_boxes() {
	add_meta_box( 'asahi_song_info', __( '單曲資訊', 'asahi-music-theme' ), 'asahi_song_info_meta_box_cb', 'song', 'normal', 'high' );
	add_meta_box( 'asahi_song_content', __( '創作內容', 'asahi-music-theme' ), 'asahi_song_content_meta_box_cb', 'song', 'normal', 'high' );
	add_meta_box( 'asahi_song_multilang', __( '多語系內容（中文 / English / Português）', 'asahi-music-theme' ), 'asahi_song_multilang_meta_box_cb', 'song', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'asahi_add_meta_boxes' );

function asahi_song_info_meta_box_cb( $post ) {
	wp_nonce_field( 'asahi_song_meta_save', 'asahi_song_meta_nonce' );

	$fields = array(
		'asahi_creator'           => array( 'label' => __( '創作者名稱', 'asahi-music-theme' ), 'default' => '白鳥朝陽 / Shiratori Asahi', 'type' => 'text' ),
		'asahi_staff_lyrics'      => array( 'label' => __( '作詞', 'asahi-music-theme' ), 'default' => '', 'type' => 'text' ),
		'asahi_staff_compose'     => array( 'label' => __( '作曲', 'asahi-music-theme' ), 'default' => '', 'type' => 'text' ),
		'asahi_staff_arrange'     => array( 'label' => __( '編曲', 'asahi-music-theme' ), 'default' => '', 'type' => 'text' ),
		'asahi_illustrator'       => array( 'label' => __( '插畫工作者名稱', 'asahi-music-theme' ), 'default' => '', 'type' => 'text' ),
		'asahi_mp3_url'           => array( 'label' => __( 'MP3 音檔網址', 'asahi-music-theme' ), 'default' => '', 'type' => 'media' ),
		'asahi_spotify_url'       => array( 'label' => __( 'Spotify 連結', 'asahi-music-theme' ), 'default' => '', 'type' => 'url' ),
		'asahi_apple_music_url'   => array( 'label' => __( 'Apple Music 連結', 'asahi-music-theme' ), 'default' => '', 'type' => 'url' ),
		'asahi_youtube_music_url' => array( 'label' => __( 'YouTube Music 連結', 'asahi-music-theme' ), 'default' => '', 'type' => 'url' ),
	);
	?>
	<div class="asahi-meta-fields">
		<?php foreach ( $fields as $key => $field ) : ?>
			<?php
			$value = get_post_meta( $post->ID, '_' . $key, true );
			if ( '' === $value && '' !== $field['default'] ) {
				$value = $field['default'];
			}
			?>
			<p class="asahi-meta-row">
				<label for="<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
				<?php if ( 'media' === $field['type'] ) : ?>
					<span class="asahi-media-field">
						<input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat asahi-media-url" placeholder="https://example.com/audio.mp3">
						<button type="button" class="button asahi-media-upload"><?php esc_html_e( '從媒體庫選擇/上傳音檔', 'asahi-music-theme' ); ?></button>
					</span>
				<?php else : ?>
					<input type="<?php echo ( 'url' === $field['type'] ) ? 'url' : 'text'; ?>" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<style>
		.asahi-media-field { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
		.asahi-media-field input { flex: 1; min-width: 240px; }
		.asahi-meta-row { margin: 0 0 14px; }
		.asahi-meta-row label { display: block; margin-bottom: 4px; }
	</style>
	<?php
}

function asahi_song_content_meta_box_cb( $post ) {
	$notes  = get_post_meta( $post->ID, '_asahi_notes', true );
	$lyrics = get_post_meta( $post->ID, '_asahi_lyrics', true );
	?>
	<p>
		<label for="asahi_notes"><strong><?php esc_html_e( '創作後記與靈感', 'asahi-music-theme' ); ?></strong></label>
		<textarea id="asahi_notes" name="asahi_notes" rows="6" class="widefat" placeholder="<?php esc_attr_e( '記錄這首歌的創作背景、靈感來源…', 'asahi-music-theme' ); ?>"><?php echo esc_textarea( $notes ); ?></textarea>
	</p>
	<p>
		<label for="asahi_lyrics"><strong><?php esc_html_e( '完整歌詞', 'asahi-music-theme' ); ?></strong></label>
		<textarea id="asahi_lyrics" name="asahi_lyrics" rows="14" class="widefat" placeholder="<?php esc_attr_e( '每一行一段歌詞，輸出時會保留換行格式。', 'asahi-music-theme' ); ?>"><?php echo esc_textarea( $lyrics ); ?></textarea>
	</p>
	<?php
}

function asahi_render_lang_panel( $post, $code, $label ) {
	$title = get_post_meta( $post->ID, '_asahi_' . $code . '_title', true );
	$story = get_post_meta( $post->ID, '_asahi_' . $code . '_story', true );
	$notes = get_post_meta( $post->ID, '_asahi_' . $code . '_notes', true );
	?>
	<p>
		<label for="asahi_<?php echo esc_attr( $code ); ?>_title"><strong><?php esc_html_e( '歌名標題', 'asahi-music-theme' ); ?>（<?php echo esc_html( $label ); ?>）</strong></label>
		<input type="text" id="asahi_<?php echo esc_attr( $code ); ?>_title" name="asahi_<?php echo esc_attr( $code ); ?>_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" placeholder="<?php esc_attr_e( '留空則自動使用日文主標題', 'asahi-music-theme' ); ?>">
	</p>
	<p>
		<label for="asahi_<?php echo esc_attr( $code ); ?>_story"><strong><?php esc_html_e( '背景故事', 'asahi-music-theme' ); ?></strong></label>
		<textarea id="asahi_<?php echo esc_attr( $code ); ?>_story" name="asahi_<?php echo esc_attr( $code ); ?>_story" rows="6" class="widefat" placeholder="<?php esc_attr_e( '留空則自動回退顯示日文主編輯器內容', 'asahi-music-theme' ); ?>"><?php echo esc_textarea( $story ); ?></textarea>
	</p>
	<p>
		<label for="asahi_<?php echo esc_attr( $code ); ?>_notes"><strong><?php esc_html_e( '創作後記', 'asahi-music-theme' ); ?></strong></label>
		<textarea id="asahi_<?php echo esc_attr( $code ); ?>_notes" name="asahi_<?php echo esc_attr( $code ); ?>_notes" rows="5" class="widefat" placeholder="<?php esc_attr_e( '留空則自動回退顯示日文後記', 'asahi-music-theme' ); ?>"><?php echo esc_textarea( $notes ); ?></textarea>
	</p>
	<?php
}

function asahi_song_multilang_meta_box_cb( $post ) {
	?>
	<div class="asahi-lang-tabs">
		<ul class="asahi-lang-tabs__nav">
			<li><a href="#" class="is-active" data-tab="zh">繁體中文</a></li>
			<li><a href="#" data-tab="en">English</a></li>
			<li><a href="#" data-tab="pt">Português</a></li>
		</ul>
		<div class="asahi-lang-tabs__panel" data-panel="zh">
			<?php asahi_render_lang_panel( $post, 'zh', '繁體中文' ); ?>
		</div>
		<div class="asahi-lang-tabs__panel" data-panel="en" hidden>
			<?php asahi_render_lang_panel( $post, 'en', 'English' ); ?>
		</div>
		<div class="asahi-lang-tabs__panel" data-panel="pt" hidden>
			<?php asahi_render_lang_panel( $post, 'pt', 'Português' ); ?>
		</div>
	</div>
	<p class="description" style="margin-top:8px;"><?php esc_html_e( '日本語為預設主語言；以下語言未填寫時，前台會自動回退顯示日文內容。', 'asahi-music-theme' ); ?></p>
	<style>
		.asahi-lang-tabs__nav { display: flex; gap: 6px; margin: 0 0 12px; padding: 0; list-style: none; border-bottom: 1px solid #dcdcde; }
		.asahi-lang-tabs__nav a { display: inline-block; padding: 8px 14px; text-decoration: none; color: #2271b1; border-bottom: 2px solid transparent; margin-bottom: -1px; }
		.asahi-lang-tabs__nav a.is-active { border-bottom-color: #2271b1; font-weight: 600; color: #1d2327; }
	</style>
	<?php
}

/* -------------------------------------------------------------------------
 * Save meta boxes (nonce + capability checks)
 * ---------------------------------------------------------------------- */
function asahi_save_song_meta( $post_id ) {
	if ( ! isset( $_POST['asahi_song_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['asahi_song_meta_nonce'] ) ), 'asahi_song_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array( 'asahi_creator', 'asahi_staff_lyrics', 'asahi_staff_compose', 'asahi_staff_arrange', 'asahi_illustrator' );
	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	$url_fields = array( 'asahi_mp3_url', 'asahi_spotify_url', 'asahi_apple_music_url', 'asahi_youtube_music_url' );
	foreach ( $url_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	$textarea_fields = array( 'asahi_notes', 'asahi_lyrics' );
	foreach ( $textarea_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	// Multilingual fields (zh / en / pt): per-language title, story and notes.
	foreach ( array( 'zh', 'en', 'pt' ) as $code ) {
		foreach ( array( 'title', 'story', 'notes' ) as $field ) {
			$meta_key = 'asahi_' . $code . '_' . $field;
			if ( isset( $_POST[ $meta_key ] ) ) {
				$value = ( 'title' === $field )
					? sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) )
					: sanitize_textarea_field( wp_unslash( $_POST[ $meta_key ] ) );
				update_post_meta( $post_id, '_' . $meta_key, $value );
			}
		}
	}
}
add_action( 'save_post', 'asahi_save_song_meta' );

/* -------------------------------------------------------------------------
 * SEO: MusicRecording JSON-LD (Schema.org) on single song pages
 * ---------------------------------------------------------------------- */
function asahi_output_music_recording_json_ld() {
	if ( ! is_singular( 'song' ) ) {
		return;
	}

	global $post;

	$summary = get_the_excerpt( $post );
	if ( '' === $summary ) {
		$summary = wp_trim_words( wp_strip_all_tags( get_the_content( null, false, $post ) ), 40, '…' );
	}

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'MusicRecording',
		'name'          => get_the_title( $post ),
		'byArtist'      => array(
			'@type' => 'MusicGroup',
			'name'  => asahi_get_creator( $post->ID ),
		),
		'datePublished' => get_the_date( 'Y-m-d', $post ),
		'image'         => get_the_post_thumbnail_url( $post->ID, 'full' ) ?: null,
		'description'   => $summary,
	);

	$schema = array_filter( $schema, function ( $value ) {
		return null !== $value && '' !== $value;
	} );

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'asahi_output_music_recording_json_ld' );


