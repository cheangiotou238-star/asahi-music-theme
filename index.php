<?php
/**
 * Main fallback template (also serves the song archive listing).
 *
 * @package Asahi_Music_Theme
 */

get_header();
?>

<main id="main" class="container">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php if ( is_post_type_archive( 'song' ) ) : ?>
				<div class="section-heading">
					<h1 class="section-heading__en">DISCOGRAPHY</h1>
					<div class="section-heading__sub">
						<span class="section-heading__ja">全楽曲一覧</span>
						<span class="section-heading__rule" aria-hidden="true"></span>
					</div>
				</div>
			<?php else : ?>
				<?php the_archive_title( '<h1 class="section-title">', '</h1>' ); ?>
			<?php endif; ?>
		</header>

		<div class="song-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<a class="song-card" href="<?php the_permalink(); ?>">
					<div class="song-card__cover">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<span class="song-card__placeholder">&#9835;</span>
						<?php endif; ?>
					</div>
					<h2 class="song-card__title"><?php echo esc_html( asahi_get_song_title() ); ?></h2>
					<?php if ( 'song' === get_post_type() ) : ?>
						<p class="song-card__creator"><?php echo esc_html( asahi_get_creator() ); ?></p>
					<?php endif; ?>
				</a>
			<?php endwhile; ?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php echo esc_html( asahi_t( 'no_content' ) ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
