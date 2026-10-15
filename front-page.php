<?php
/**
 * Front page: latest featured single + responsive grid of all songs.
 *
 * @package Asahi_Music_Theme
 */

get_header();
?>

<main id="main" class="container">
	<?php
	$featured = new WP_Query(
		array(
			'post_type'      => 'song',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( $featured->have_posts() ) :
		while ( $featured->have_posts() ) :
			$featured->the_post();
			$f_creator = asahi_get_creator();
			$f_mp3     = get_post_meta( get_the_ID(), '_asahi_mp3_url', true );
			$f_mp3     = $f_mp3 ? set_url_scheme( $f_mp3, 'https' ) : '';
			$f_cover   = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			?>
			<section class="featured-song">
				<div class="featured-song__media">
					<?php if ( $f_cover ) : ?>
						<img src="<?php echo esc_url( $f_cover ); ?>" alt="<?php the_title_attribute(); ?>" loading="eager">
					<?php else : ?>
						<span class="song-card__placeholder">&#9835;</span>
					<?php endif; ?>
				</div>

				<div class="featured-song__info">
					<span class="featured-song__badge"><?php echo esc_html( asahi_t( 'latest_release' ) ); ?></span>
					<h1 class="featured-song__title"><?php echo esc_html( asahi_get_song_title() ); ?></h1>
					<p class="featured-song__creator"><?php echo esc_html( $f_creator ); ?></p>

					<?php if ( $f_mp3 ) : ?>
						<div class="song-player">
							<audio class="plyr-audio" controls preload="metadata">
								<source src="<?php echo esc_url( $f_mp3 ); ?>" type="<?php echo esc_attr( asahi_audio_mime_type( $f_mp3 ) ); ?>">
								<?php echo esc_html( asahi_t( 'audio_unsupported' ) ); ?>
							</audio>
						</div>
					<?php endif; ?>

					<a class="btn" href="<?php the_permalink(); ?>"><?php echo esc_html( asahi_t( 'view_song' ) ); ?></a>
				</div>
			</section>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<section class="all-songs">
		<h2 class="section-title"><?php echo esc_html( asahi_t( 'all_songs' ) ); ?></h2>

		<?php
		$all_songs = new WP_Query(
			array(
				'post_type'      => 'song',
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		if ( $all_songs->have_posts() ) :
			?>
			<div class="song-grid">
				<?php
				while ( $all_songs->have_posts() ) :
					$all_songs->the_post();
					$card_cover = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
					?>
					<a class="song-card" href="<?php the_permalink(); ?>">
						<div class="song-card__cover">
							<?php if ( $card_cover ) : ?>
								<img src="<?php echo esc_url( $card_cover ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
							<?php else : ?>
								<span class="song-card__placeholder">&#9835;</span>
							<?php endif; ?>
						</div>
						<h3 class="song-card__title"><?php echo esc_html( asahi_get_song_title() ); ?></h3>
						<p class="song-card__creator"><?php echo esc_html( asahi_get_creator() ); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<?php
			wp_reset_postdata();
		else :
			?>
			<p><?php echo esc_html( asahi_t( 'no_songs' ) ); ?></p>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
