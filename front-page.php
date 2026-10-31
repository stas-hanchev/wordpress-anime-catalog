<?php
get_header();

$query = new WP_Query( array(
	'post_type'      => 'anime',
	'posts_per_page' => -1,
	'meta_key'       => 'ac_rating',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
) );
$genre_count = wp_count_terms( array( 'taxonomy' => 'genre', 'hide_empty' => true ) );
?>
<section class="hero">
	<div class="wrap">
		<h1>Знайди своє наступне <span>аніме</span></h1>
		<p>Добірка тайтлів, які варто подивитися: від класики до новинок. Шукай за назвою, фільтруй за жанром і роками, або довірся випадку.</p>
		<div class="hero-stats">
			<div><b><?php echo (int) $query->found_posts; ?></b><small>тайтлів</small></div>
			<div><b><?php echo is_wp_error( $genre_count ) ? 0 : (int) $genre_count; ?></b><small>жанрів</small></div>
			<div><b>0</b><small>реєстрацій потрібно</small></div>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/catalog', null, array( 'query' => $query ) );
get_footer();
