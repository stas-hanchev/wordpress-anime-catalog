<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="wrap">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="logo-mark" aria-hidden="true">桜</span>
			<?php bloginfo( 'name' ); ?>
		</a>
		<nav class="site-nav" aria-label="Головне меню">
			<?php
			if ( has_nav_menu( 'main' ) ) {
				wp_nav_menu( array( 'theme_location' => 'main', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1 ) );
			} else {
				$about = get_page_by_path( 'about' );
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo is_front_page() ? 'is-active' : ''; ?>">Каталог</a>
				<a href="<?php echo esc_url( home_url( '/#random' ) ); ?>" data-random>Випадкове</a>
				<?php if ( $about ) : ?>
					<a href="<?php echo esc_url( get_permalink( $about ) ); ?>" class="<?php echo is_page( 'about' ) ? 'is-active' : ''; ?>">Про сайт</a>
				<?php endif; ?>
			<?php } ?>
		</nav>
	</div>
</header>
<main id="main">
