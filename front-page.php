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
					<span class="featured-song__badge"><?php esc_html_e( '最新主打', 'asahi-music-theme' ); ?></span>
					<h1 class="featured-song__title"><?php the_title(); ?></h1>
					<p class="featured-song__creator"><?php echo esc_html( $f_creator ); ?></p>

					<?php if ( $f_mp3 ) : ?>
						<div class="song-player">
							<audio class="plyr-audio" controls preload="metadata">
								<source src="<?php echo esc_url( $f_mp3 ); ?>">
							</audio>
						</div>
					<?php endif; ?>

					<a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e( '查看單曲內頁', 'asahi-music-theme' ); ?></a>
				</div>
			</section>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<section class="all-songs">
		<h2 class="section-title"><?php esc_html_e( '全部單曲', 'asahi-music-theme' ); ?></h2>

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
						<h3 class="song-card__title"><?php the_title(); ?></h3>
						<p class="song-card__creator"><?php echo esc_html( asahi_get_creator() ); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<?php
			wp_reset_postdata();
		else :
			?>
			<p><?php esc_html_e( '尚未發佈任何單曲。', 'asahi-music-theme' ); ?></p>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
