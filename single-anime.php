<?php
get_header();
while ( have_posts() ) :
	the_post();
	$genres = ac_genres();
	$facts  = array(
		'Рік'     => ac_meta( 'ac_year' ),
		'Формат'  => ac_meta( 'ac_format' ),
		'Епізоди' => ac_meta( 'ac_episodes' ),
		'Студія'  => ac_meta( 'ac_studio' ),
		'Статус'  => ac_meta( 'ac_status' ),
		'Оцінка'  => ac_meta( 'ac_rating' ) ? '★ ' . number_format( (float) ac_meta( 'ac_rating' ), 1 ) : '',
	);
	?>
	<article class="wrap anime-single">
		<?php ac_cover( get_the_ID(), 'large' ); ?>
		<div>
			<a class="back" href="<?php echo esc_url( home_url( '/#catalog' ) ); ?>">← До каталогу</a>
			<h1><?php the_title(); ?></h1>
			<p class="orig"><?php echo esc_html( trim( ac_meta( 'ac_original' ) . ' · ' . ac_meta( 'ac_jp' ), ' ·' ) ); ?></p>

			<div class="facts">
				<?php foreach ( $facts as $label => $val ) : if ( '' === (string) $val ) { continue; } ?>
					<div class="fact"><small><?php echo esc_html( $label ); ?></small><b><?php echo esc_html( $val ); ?></b></div>
				<?php endforeach; ?>
			</div>

			<?php if ( $genres ) : ?>
				<div class="tags" style="margin-bottom:24px">
					<?php foreach ( $genres as $g ) : ?>
						<a class="tag" href="<?php echo esc_url( get_term_link( $g ) ); ?>"><?php echo esc_html( $g->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="entry"><?php the_content(); ?></div>
		</div>
	</article>

	<?php
	$related = new WP_Query( array(
		'post_type'      => 'anime',
		'posts_per_page' => 4,
		'post__not_in'   => array( get_the_ID() ),
		'orderby'        => 'rand',
		'tax_query'      => $genres ? array( array( 'taxonomy' => 'genre', 'field' => 'term_id', 'terms' => wp_list_pluck( $genres, 'term_id' ) ) ) : array(),
	) );
	if ( $related->have_posts() ) :
		?>
		<section class="wrap related">
			<h2>Схоже за жанром</h2>
			<div class="grid">
				<?php
				while ( $related->have_posts() ) {
					$related->the_post();
					ac_card();
				}
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile;
get_footer();
