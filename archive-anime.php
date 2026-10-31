<?php
get_header();
global $wp_query;
$genre = is_tax( 'genre' ) ? get_queried_object() : null;
?>
<section class="hero">
	<div class="wrap">
		<h1><?php echo $genre ? 'Жанр: <span>' . esc_html( $genre->name ) . '</span>' : 'Весь <span>каталог</span>'; ?></h1>
		<p><?php echo $genre ? 'Тайтли в жанрі «' . esc_html( $genre->name ) . '». Можна звузити пошук фільтрами нижче.' : 'Усі тайтли каталогу в одному місці.'; ?></p>
	</div>
</section>
<?php
get_template_part( 'template-parts/catalog', null, array(
	'query' => $wp_query,
	'genre' => $genre ? $genre->slug : '',
) );
get_footer();
