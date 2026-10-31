<?php
/**
 * Одноразове заповнення каталогу демо-тайтлами.
 * Запускається один раз після встановлення; потім усе редагується в адмінці → «Аніме».
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ac_seed_demo_content', 50 );

function ac_seed_demo_content() {
	if ( get_option( 'ac_demo_seeded' ) || ! get_option( 'siteurl' ) || wp_installing() ) {
		return;
	}
	update_option( 'ac_demo_seeded', 1 );

	$genres = array(
		'action'    => 'Екшн',
		'adventure' => 'Пригоди',
		'fantasy'   => 'Фентезі',
		'drama'     => 'Драма',
		'comedy'    => 'Комедія',
		'sci-fi'    => 'Наукова фантастика',
		'thriller'  => 'Трилер',
		'sports'    => 'Спорт',
		'romance'   => 'Романтика',
		'family'    => 'Сімейне',
		'slice'     => 'Повсякдення',
		'mystery'   => 'Містика',
	);
	foreach ( $genres as $slug => $name ) {
		if ( ! term_exists( $slug, 'genre' ) ) {
			wp_insert_term( $name, 'genre', array( 'slug' => $slug ) );
		}
	}

	$titles = array(
		array( 'Сталевий алхімік: Братство', '鋼の錬金術師', 'Fullmetal Alchemist: Brotherhood', 2009, '64', 'Bones', 9.1, 'Серіал', 'Завершено', array( 'action', 'adventure', 'fantasy', 'drama' ), '#c0392b', '#f39c12',
			'Брати Едвард і Альфонс Елріки намагаються повернути втрачене після невдалого алхімічного ритуалу. Пошуки філософського каменю виводять їх на змову, що сягає самої верхівки держави. Історія про ціну помилок, братерство і відповідальність.' ),
		array( 'Атака титанів', '進撃の巨人', 'Shingeki no Kyojin', 2013, '89', 'Wit Studio / MAPPA', 8.6, 'Серіал', 'Завершено', array( 'action', 'drama', 'mystery' ), '#5d4037', '#b71c1c',
			'Людство живе за величезними стінами, ховаючись від велетнів, що пожирають людей. Коли стіну проломлено, юний Ерен присягається знищити титанів, але правда про світ виявляється значно складнішою.' ),
		array( 'Стейнс;Гейт', 'シュタインズ・ゲート', 'Steins;Gate', 2011, '24', 'White Fox', 9.1, 'Серіал', 'Завершено', array( 'sci-fi', 'thriller', 'drama' ), '#1b5e20', '#263238',
			'Ексцентричний винахідник випадково створює пристрій, що надсилає повідомлення в минуле. Невинні експерименти перетворюються на небезпечну гру з часом, де кожна зміна має наслідки.' ),
		array( 'Ковбой Бібоп', 'カウボーイビバップ', 'Cowboy Bebop', 1998, '26', 'Sunrise', 8.8, 'Серіал', 'Завершено', array( 'action', 'sci-fi', 'drama' ), '#0d47a1', '#ffb300',
			'Мисливці за головами на старенькому кораблі мандрують Сонячною системою у пошуках нагород. Джаз, нуар і меланхолійні історії героїв, яких наздоганяє минуле.' ),
		array( 'Ван-Піс', 'ワンピース', 'One Piece', 1999, '1100+', 'Toei Animation', 8.7, 'Серіал', 'Виходить', array( 'action', 'adventure', 'comedy' ), '#e53935', '#fbc02d',
			'Хлопець із тілом, що розтягується, як гума, збирає команду піратів, щоб знайти легендарний скарб і стати королем піратів. Одна з найдовших і найулюбленіших пригодницьких саг.' ),
		array( 'Фрірен: Та, що проводжає в останню путь', '葬送のフリーレン', 'Sousou no Frieren', 2023, '28+', 'Madhouse', 9.3, 'Серіал', 'Виходить', array( 'adventure', 'fantasy', 'drama' ), '#4db6ac', '#5c6bc0',
			'Після перемоги над Королем демонів ельфійка-чарівниця бачить, як її смертні друзі старіють і йдуть із життя. Вона вирушає в нову подорож, щоб зрозуміти людей, яких колись ледь помічала.' ),
		array( 'Віолетта Евергарден', 'ヴァイオレット・エヴァーガーデン', 'Violet Evergarden', 2018, '13', 'Kyoto Animation', 8.7, 'Серіал', 'Завершено', array( 'drama', 'fantasy', 'slice' ), '#3949ab', '#ffcc80',
			'Колишня юна солдатка стає авторкою листів на замовлення. Пишучи чужі листи, вона вчиться розуміти почуття і намагається збагнути останні слова свого командира.' ),
		array( 'Зошит смерті', 'デスノート', 'Death Note', 2006, '37', 'Madhouse', 8.6, 'Серіал', 'Завершено', array( 'thriller', 'mystery' ), '#212121', '#b71c1c',
			'Старшокласник знаходить зошит, що вбиває будь-кого, чиє ім\'я в ньому записати. Він вирішує очистити світ від злочинців, і за ним починає полювати геніальний детектив.' ),
		array( 'Мобі Псих 100', 'モブサイコ100', 'Mob Psycho 100', 2016, '37', 'Bones', 8.5, 'Серіал', 'Завершено', array( 'action', 'comedy' ), '#7e57c2', '#26c6da',
			'Сором\'язливий школяр із неймовірною екстрасенсорною силою понад усе хоче жити звичайним життям. Смішна, добра і несподівано глибока історія про дорослішання.' ),
		array( 'Шпигунська сім\'я', 'SPY×FAMILY', 'Spy x Family', 2022, '37+', 'Wit Studio / CloverWorks', 8.4, 'Серіал', 'Виходить', array( 'action', 'comedy', 'family' ), '#ec407a', '#43a047',
			'Шпигун для місії створює фіктивну сім\'ю: удочеряє дівчинку і бере шлюб із незнайомкою. Він не знає, що донька читає думки, а дружина — найманка.' ),
		array( 'Ванпанчмен', 'ワンパンマン', 'One Punch Man', 2015, '24+', 'Madhouse / J.C.Staff', 8.5, 'Серіал', 'Виходить', array( 'action', 'comedy' ), '#fdd835', '#e53935',
			'Сайтама настільки сильний, що перемагає будь-кого одним ударом, і через це йому страшенно нудно. Пародія на супергеройський жанр із вражаючим екшном.' ),
		array( 'Волейбол!!', 'ハイキュー!!', 'Haikyuu!!', 2014, '85', 'Production I.G', 8.5, 'Серіал', 'Завершено', array( 'sports', 'comedy', 'drama' ), '#ff7043', '#212121',
			'Невисокий, але стрибучий Хіната приходить у шкільну волейбольну команду, щоб довести, що зріст не головне. Енергійна історія про командну гру та суперництво.' ),
		array( 'Клинок, що знищує демонів', '鬼滅の刃', 'Kimetsu no Yaiba', 2019, '63', 'ufotable', 8.4, 'Серіал', 'Виходить', array( 'action', 'fantasy', 'drama' ), '#00897b', '#212121',
			'Після нападу демонів на родину Танджіро стає мисливцем на демонів, щоб повернути людську подобу сестрі. Відома неймовірною анімацією битв.' ),
		array( 'Твоє ім\'я', '君の名は。', 'Kimi no Na wa.', 2016, '', 'CoMix Wave Films', 8.8, 'Фільм', 'Завершено', array( 'romance', 'drama', 'fantasy' ), '#1e88e5', '#ff8a65',
			'Хлопець із Токіо і дівчина з провінційного містечка починають уві сні мінятися тілами. Зворушлива історія зв\'язку двох людей, розділених простором і часом.' ),
		array( 'Мій сусід Тоторо', 'となりのトトロ', 'Tonari no Totoro', 1988, '', 'Studio Ghibli', 8.2, 'Фільм', 'Завершено', array( 'family', 'fantasy', 'slice' ), '#558b2f', '#81d4fa',
			'Дві сестри переїжджають у сільський будинок і знайомляться з добрими лісовими духами. Тепла, спокійна казка про дитинство і природу.' ),
		array( 'Віднесені привидами', '千と千尋の神隠し', 'Sen to Chihiro no Kamikakushi', 2001, '', 'Studio Ghibli', 8.8, 'Фільм', 'Завершено', array( 'adventure', 'fantasy', 'family' ), '#c62828', '#00838f',
			'Дівчинка Тіхіро потрапляє у світ духів і мусить працювати в купальні для богів, щоб урятувати батьків. Оскароносна казка про сміливість і дорослішання.' ),
	);

	foreach ( $titles as $t ) {
		list( $title, $jp, $orig, $year, $eps, $studio, $rating, $format, $status, $g, $c1, $c2, $text ) = $t;
		$id = wp_insert_post( array(
			'post_type'    => 'anime',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => sanitize_title( $orig ),
			'post_content' => $text,
			'post_excerpt' => wp_trim_words( $text, 20 ),
		) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		$meta = array(
			'ac_jp'       => $jp,
			'ac_original' => $orig,
			'ac_year'     => $year,
			'ac_episodes' => $eps,
			'ac_studio'   => $studio,
			'ac_rating'   => $rating,
			'ac_format'   => $format,
			'ac_status'   => $status,
			'ac_color1'   => $c1,
			'ac_color2'   => $c2,
		);
		foreach ( $meta as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		wp_set_object_terms( $id, $g, 'genre' );
	}

	// Сторінка «Про сайт».
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => 'Про сайт',
		'post_name'    => 'about',
		'post_content' => 'Аніме-каталог — невеликий фан-проєкт із добіркою тайтлів, які варто подивитися. Тут немає реєстрації: просто шукайте, фільтруйте за жанром і відкривайте опис. Нові тайтли додаються в адмінці через розділ «Аніме».',
	) );

	// Прибрати стандартні демо-записи WordPress.
	foreach ( array( 'hello-world', 'sample-page' ) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, array( 'post', 'page' ) );
		if ( $p ) {
			wp_delete_post( $p->ID, true );
		}
	}

	update_option( 'default_comment_status', 'closed' );
	update_option( 'users_can_register', 0 );
}

/**
 * Гарні посилання + латинські адреси тайтлів. Виконується один раз (і повторно, якщо змінити версію).
 */
add_action( 'init', 'ac_fix_permalinks', 60 );

function ac_fix_permalinks() {
	if ( wp_installing() || '2' === get_option( 'ac_rewrite_v' ) ) {
		return;
	}
	global $wp_rewrite;

	$items = get_posts( array( 'post_type' => 'anime', 'posts_per_page' => -1, 'post_status' => 'any' ) );
	foreach ( $items as $p ) {
		$orig = get_post_meta( $p->ID, 'ac_original', true );
		if ( $orig && rawurldecode( $p->post_name ) !== sanitize_title( $orig ) && preg_match( '/%[0-9a-f]{2}/i', $p->post_name ) ) {
			wp_update_post( array( 'ID' => $p->ID, 'post_name' => sanitize_title( $orig ) ) );
		}
	}

	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	flush_rewrite_rules( false );
	update_option( 'ac_rewrite_v', '2' );
}
