<?php
/**
 * Single song template: sticky left column + scrollable right column.
 *
 * @package Asahi_Music_Theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$song_id       = get_the_ID();
	$creator       = asahi_get_creator( $song_id );
	$staff_lyrics  = get_post_meta( $song_id, '_asahi_staff_lyrics', true );
	$staff_compose = get_post_meta( $song_id, '_asahi_staff_compose', true );
	$staff_arrange = get_post_meta( $song_id, '_asahi_staff_arrange', true );
	$illustrator   = get_post_meta( $song_id, '_asahi_illustrator', true );
	$mp3_url       = get_post_meta( $song_id, '_asahi_mp3_url', true );
	$spotify_url   = get_post_meta( $song_id, '_asahi_spotify_url', true );
	$apple_url     = get_post_meta( $song_id, '_asahi_apple_music_url', true );
	$youtube_url   = get_post_meta( $song_id, '_asahi_youtube_music_url', true );
	$notes         = get_post_meta( $song_id, '_asahi_notes', true );
	$lyrics        = get_post_meta( $song_id, '_asahi_lyrics', true );
	$cover_url     = get_the_post_thumbnail_url( $song_id, 'large' );

	// Current language + per-language translated content with Japanese fallback.
	$lang          = asahi_get_lang();
	$title_ja      = get_the_title( $song_id );
	$trans_title   = ( 'ja' === $lang ) ? '' : get_post_meta( $song_id, '_asahi_' . $lang . '_title', true );
	$display_title = ( '' !== $trans_title ) ? $trans_title : $title_ja;
	$trans_story   = ( 'ja' === $lang ) ? '' : get_post_meta( $song_id, '_asahi_' . $lang . '_story', true );
	$trans_notes   = ( 'ja' === $lang ) ? '' : get_post_meta( $song_id, '_asahi_' . $lang . '_notes', true );
	$display_notes = ( '' !== $trans_notes ) ? $trans_notes : $notes;
	$mp3_url       = $mp3_url ? set_url_scheme( $mp3_url, 'https' ) : '';
	?>

<main id="main" class="song-layout">
	<aside class="song-sidebar">
		<div class="song-sidebar__inner">
			<figure class="song-cover">
				<?php if ( $cover_url ) : ?>
					<img id="song-cover-img" src="<?php echo esc_url( $cover_url ); ?>" alt="<?php the_title_attribute(); ?>" crossorigin="anonymous" loading="eager">
				<?php else : ?>
					<span class="song-cover__placeholder">&#9835;</span>
				<?php endif; ?>
			</figure>

			<h1 class="song-title"><?php echo esc_html( $display_title ); ?></h1>

			<dl class="song-credits">
				<div class="song-credits__item"><dt><?php echo esc_html( asahi_t( 'role_creator' ) ); ?></dt><dd><?php echo esc_html( $creator ); ?></dd></div>
				<?php if ( $staff_lyrics ) : ?>
					<div class="song-credits__item"><dt><?php echo esc_html( asahi_t( 'role_lyrics' ) ); ?></dt><dd><?php echo esc_html( $staff_lyrics ); ?></dd></div>
				<?php endif; ?>
				<?php if ( $staff_compose ) : ?>
					<div class="song-credits__item"><dt><?php echo esc_html( asahi_t( 'role_compose' ) ); ?></dt><dd><?php echo esc_html( $staff_compose ); ?></dd></div>
				<?php endif; ?>
				<?php if ( $staff_arrange ) : ?>
					<div class="song-credits__item"><dt><?php echo esc_html( asahi_t( 'role_arrange' ) ); ?></dt><dd><?php echo esc_html( $staff_arrange ); ?></dd></div>
				<?php endif; ?>
				<?php if ( $illustrator ) : ?>
					<div class="song-credits__item"><dt><?php echo esc_html( asahi_t( 'role_illustrator' ) ); ?></dt><dd><?php echo esc_html( $illustrator ); ?></dd></div>
				<?php endif; ?>
			</dl>

			<?php if ( $mp3_url ) : ?>
				<div class="song-player">
					<audio class="plyr-audio" controls preload="metadata">
						<source src="<?php echo esc_url( $mp3_url ); ?>" type="<?php echo esc_attr( asahi_audio_mime_type( $mp3_url ) ); ?>">
						<?php echo esc_html( asahi_t( 'audio_unsupported' ) ); ?>
					</audio>
				</div>
			<?php endif; ?>

			<?php if ( $spotify_url || $apple_url || $youtube_url ) : ?>
				<div class="song-streaming">
					<?php if ( $spotify_url ) : ?>
						<a class="stream-btn stream-btn--spotify" href="<?php echo esc_url( $spotify_url ); ?>" target="_blank" rel="noopener noreferrer">Spotify</a>
					<?php endif; ?>
					<?php if ( $apple_url ) : ?>
						<a class="stream-btn stream-btn--apple" href="<?php echo esc_url( $apple_url ); ?>" target="_blank" rel="noopener noreferrer">Apple Music</a>
					<?php endif; ?>
					<?php if ( $youtube_url ) : ?>
						<a class="stream-btn stream-btn--youtube" href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener noreferrer">YouTube Music</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</aside>

	<section class="song-content">
		<article class="song-section song-story">
			<h2 class="song-section__title"><?php echo esc_html( asahi_t( 'section_story' ) ); ?></h2>
			<div class="song-section__body entry-content">
				<?php if ( '' === $trans_story ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<?php echo nl2br( esc_html( $trans_story ) ); ?>
				<?php endif; ?>
			</div>
		</article>

		<?php if ( $display_notes ) : ?>
			<section class="song-section song-notes">
				<h2 class="song-section__title"><?php echo esc_html( asahi_t( 'section_notes' ) ); ?></h2>
				<div class="song-section__body"><?php echo nl2br( esc_html( $display_notes ) ); ?></div>
			</section>
		<?php endif; ?>

		<?php if ( $lyrics ) : ?>
			<section class="song-section song-lyrics">
				<h2 class="song-section__title"><?php echo esc_html( asahi_t( 'section_lyrics' ) ); ?></h2>
				<div class="song-section__body song-lyrics__body"><?php echo nl2br( esc_html( $lyrics ) ); ?></div>
			</section>
		<?php endif; ?>
	</section>
</main>

<?php endwhile; ?>

<?php
get_footer();
