<?php
/**
 * Тема «Аніме-каталог».
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AC_VERSION', '1.1' );

/* ---------- Базові налаштування ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'main' => 'Головне меню' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'ac-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Unbounded:wght@500;700&display=swap', array(), null );
	wp_enqueue_style( 'ac-style', get_stylesheet_uri(), array( 'ac-fonts' ), AC_VERSION );
	wp_enqueue_script( 'ac-catalog', get_template_directory_uri() . '/assets/catalog.js', array(), AC_VERSION, true );
} );

/* ---------- Тип запису «Аніме» і жанри ---------- */
add_action( 'init', function () {
	register_post_type( 'anime', array(
		'labels'        => array(
			'name'          => 'Аніме',
			'singular_name' => 'Аніме',
			'add_new'       => 'Додати тайтл',
			'add_new_item'  => 'Новий тайтл',
			'edit_item'     => 'Редагувати тайтл',
			'all_items'     => 'Усі тайтли',
			'search_items'  => 'Шукати тайтли',
			'menu_name'     => 'Аніме',
		),
		'public'        => true,
		'has_archive'   => 'catalog',
		'rewrite'       => array( 'slug' => 'anime' ),
		'menu_icon'     => 'dashicons-format-video',
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'genre', 'anime', array(
		'labels'            => array(
			'name'          => 'Жанри',
			'singular_name' => 'Жанр',
			'add_new_item'  => 'Додати жанр',
			'all_items'     => 'Усі жанри',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	) );
} );

/* ---------- Поля тайтлу ---------- */
function ac_fields() {
	return array(
		'ac_jp'       => array( 'label' => 'Назва японською', 'type' => 'text' ),
		'ac_original' => array( 'label' => 'Оригінальна назва (латиницею)', 'type' => 'text' ),
		'ac_year'     => array( 'label' => 'Рік', 'type' => 'number' ),
		'ac_episodes' => array( 'label' => 'Епізоди', 'type' => 'text' ),
		'ac_studio'   => array( 'label' => 'Студія', 'type' => 'text' ),
		'ac_rating'   => array( 'label' => 'Оцінка (0–10)', 'type' => 'number' ),
		'ac_format'   => array( 'label' => 'Формат', 'type' => 'select', 'options' => array( 'Серіал', 'Фільм' ) ),
		'ac_status'   => array( 'label' => 'Статус', 'type' => 'select', 'options' => array( 'Завершено', 'Виходить' ) ),
		'ac_color1'   => array( 'label' => 'Колір обкладинки 1', 'type' => 'color' ),
		'ac_color2'   => array( 'label' => 'Колір обкладинки 2', 'type' => 'color' ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'ac_details', 'Деталі тайтлу', 'ac_render_meta_box', 'anime', 'normal', 'high' );
} );

function ac_render_meta_box( $post ) {
	wp_nonce_field( 'ac_save', 'ac_nonce' );
	echo '<table class="form-table">';
	foreach ( ac_fields() as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th><label for="' . esc_attr( $key ) . '">' . esc_html( $f['label'] ) . '</label></th><td>';
		if ( 'select' === $f['type'] ) {
			echo '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '">';
			foreach ( $f['options'] as $opt ) {
				echo '<option ' . selected( $val, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
			}
			echo '</select>';
		} else {
			$step = ( 'ac_rating' === $key ) ? ' step="0.1" min="0" max="10"' : '';
			echo '<input class="regular-text" type="' . esc_attr( $f['type'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '"' . $step . '>';
		}
		echo '</td></tr>';
	}
	echo '</table><p class="description">Обкладинка: додайте «Зображення запису» праворуч, або залиште кольоровий градієнт із японською назвою.</p>';
}

add_action( 'save_post_anime', function ( $post_id ) {
	if ( ! isset( $_POST['ac_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ac_nonce'] ) ), 'ac_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ac_fields() as $key => $f ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
} );

/* ---------- Хелпери для шаблонів ---------- */
function ac_meta( $key, $post_id = null ) {
	return get_post_meta( $post_id ? $post_id : get_the_ID(), $key, true );
}

function ac_genres( $post_id = null ) {
	$terms = get_the_terms( $post_id ? $post_id : get_the_ID(), 'genre' );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms : array();
}

function ac_cover( $post_id = null, $size = 'large' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$c1      = ac_meta( 'ac_color1', $post_id ) ? ac_meta( 'ac_color1', $post_id ) : '#ff6fae';
	$c2      = ac_meta( 'ac_color2', $post_id ) ? ac_meta( 'ac_color2', $post_id ) : '#8f7dff';
	$jp      = ac_meta( 'ac_jp', $post_id ) ? ac_meta( 'ac_jp', $post_id ) : get_the_title( $post_id );
	$rating  = ac_meta( 'ac_rating', $post_id );
	$status  = ac_meta( 'ac_status', $post_id );

	echo '<div class="cover" style="--c1:' . esc_attr( $c1 ) . ';--c2:' . esc_attr( $c2 ) . '">';
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size );
	} else {
		echo '<span class="cover-jp" lang="ja">' . esc_html( $jp ) . '</span>';
	}
	if ( $status ) {
		echo '<span class="badge' . ( 'Виходить' === $status ? ' is-ongoing' : '' ) . '">' . esc_html( $status ) . '</span>';
	}
	if ( $rating ) {
		echo '<span class="badge badge-rating">★ ' . esc_html( number_format( (float) $rating, 1 ) ) . '</span>';
	}
	echo '</div>';
}

/** Картка тайтлу для сітки. */
function ac_card() {
	$genres = ac_genres();
	$slugs  = implode( ' ', wp_list_pluck( $genres, 'slug' ) );
	?>
	<a class="card" href="<?php the_permalink(); ?>"
		data-title="<?php echo esc_attr( mb_strtolower( get_the_title() . ' ' . ac_meta( 'ac_original' ) . ' ' . ac_meta( 'ac_jp' ) ) ); ?>"
		data-genres="<?php echo esc_attr( $slugs ); ?>"
		data-year="<?php echo esc_attr( ac_meta( 'ac_year' ) ); ?>"
		data-rating="<?php echo esc_attr( ac_meta( 'ac_rating' ) ); ?>"
		data-status="<?php echo esc_attr( ac_meta( 'ac_status' ) ); ?>"
		data-format="<?php echo esc_attr( ac_meta( 'ac_format' ) ); ?>">
		<?php ac_cover(); ?>
		<div class="card-body">
			<h3 class="card-title"><?php the_title(); ?></h3>
			<div class="card-meta">
				<span><?php echo esc_html( ac_meta( 'ac_year' ) ); ?></span>
				<span><?php echo esc_html( ac_meta( 'ac_format' ) ); ?></span>
				<?php if ( ac_meta( 'ac_episodes' ) ) : ?><span><?php echo esc_html( ac_meta( 'ac_episodes' ) ); ?> еп.</span><?php endif; ?>
			</div>
			<div class="tags">
				<?php foreach ( array_slice( $genres, 0, 3 ) as $g ) : ?>
					<span class="tag"><?php echo esc_html( $g->name ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</a>
	<?php
}

/* Показувати всі тайтли на сторінках каталогу та жанрів. */
add_action( 'pre_get_posts', function ( $q ) {
	if ( ! is_admin() && $q->is_main_query() && ( $q->is_post_type_archive( 'anime' ) || $q->is_tax( 'genre' ) ) ) {
		$q->set( 'posts_per_page', -1 );
		$q->set( 'meta_key', 'ac_rating' );
		$q->set( 'orderby', 'meta_value_num' );
		$q->set( 'order', 'DESC' );
	}
} );

require get_template_directory() . '/inc/demo-content.php';
