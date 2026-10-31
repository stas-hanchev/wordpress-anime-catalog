<?php get_header(); ?>
<div class="wrap page-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry"><?php the_excerpt(); ?></div>
		<?php endwhile; ?>
	<?php else : ?>
		<h1>Сторінку не знайдено</h1>
		<p>Схоже, такої сторінки немає. <a class="back" href="<?php echo esc_url( home_url( '/' ) ); ?>">← Повернутися до каталогу</a></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
