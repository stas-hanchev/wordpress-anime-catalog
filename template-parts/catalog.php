<?php
/**
 * Фільтри + сітка тайтлів. Очікує $args['query'] (WP_Query) і необов'язковий $args['genre'].
 */
$query        = $args['query'];
$active_genre = isset( $args['genre'] ) ? $args['genre'] : '';
$all_genres   = get_terms( array( 'taxonomy' => 'genre', 'hide_empty' => true ) );
$years        = array();
foreach ( $query->posts as $p ) {
	$y = (int) get_post_meta( $p->ID, 'ac_year', true );
	if ( $y ) {
		$decade             = (int) floor( $y / 10 ) * 10;
		$years[ $decade ] = $decade;
	}
}
krsort( $years );
?>
<section class="wrap" id="catalog">
	<form class="filters" data-filters onsubmit="return false">
		<input class="f-search" type="search" name="q" placeholder="Пошук: назва українською, англійською або японською…" aria-label="Пошук">
		<select name="genre" aria-label="Жанр">
			<option value="">Усі жанри</option>
			<?php if ( ! is_wp_error( $all_genres ) ) : foreach ( $all_genres as $g ) : ?>
				<option value="<?php echo esc_attr( $g->slug ); ?>" <?php selected( $active_genre, $g->slug ); ?>><?php echo esc_html( $g->name ); ?></option>
			<?php endforeach; endif; ?>
		</select>
		<select name="decade" aria-label="Роки">
			<option value="">Усі роки</option>
			<?php foreach ( $years as $d ) : ?>
				<option value="<?php echo esc_attr( $d ); ?>"><?php echo esc_html( $d ); ?>-ті</option>
			<?php endforeach; ?>
		</select>
		<select name="sort" aria-label="Сортування">
			<option value="rating">За оцінкою</option>
			<option value="new">Спершу нові</option>
			<option value="old">Спершу старі</option>
			<option value="az">За назвою</option>
		</select>
		<button type="button" class="btn" data-random-btn title="Відкрити випадковий тайтл зі знайдених">🎲 Випадкове</button>
	</form>
	<p class="result-count" data-count></p>

	<div class="grid" data-grid>
		<?php
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				ac_card();
			}
			wp_reset_postdata();
		}
		?>
		<p class="empty" data-empty <?php echo $query->have_posts() ? 'hidden' : ''; ?>>Нічого не знайдено. Спробуйте інший запит або жанр.</p>
	</div>
</section>
