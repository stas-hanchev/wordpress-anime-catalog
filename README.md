# Anime Catalog

A WordPress theme for a small anime catalog: search by title, filters by genre and decade, sorting, a "Random" button and a page for every title. No registration, comments or user accounts.

The site interface is in Ukrainian.

## Features

- **Anime** custom post type with fields: Japanese and original title, year, episodes, studio, rating, format, status and cover colors.
- **Genres** taxonomy with archive pages at `/genre/<genre>/`.
- Front page with the catalog and instant client-side filters (no page reloads).
- Title page with key facts and a "Similar by genre" block.
- Gradient cover with the Japanese title, or your own featured image.
- On first run, the catalog is populated with 16 demo titles and an "About" page.

## Installation

1. Install WordPress (for example, locally with MAMP).
2. Copy this folder to `wp-content/themes/anime-catalog`.
3. In the admin panel go to **Appearance → Themes** and activate "Аніме-каталог" (Anime Catalog).
   Alternatively, before installing WordPress, add this line to `wp-config.php`:
   ```php
   define( 'WP_DEFAULT_THEME', 'anime-catalog' );
   ```
4. Open the front page: demo content and pretty permalinks are set up automatically.

## Editing content

Admin menu labels are in Ukrainian; the English meaning is given here.

- Titles: **Аніме → Усі тайтли / Додати тайтл** (Anime → All titles / Add title)
- Genres: **Аніме → Жанри** (Anime → Genres)
- Header menu: **Appearance → Menus**, assigned to the "Головне меню" (Main menu) location

## Structure

```
anime-catalog/
├── style.css                   # theme header and all styles
├── functions.php               # post type, genres, fields, helpers
├── inc/demo-content.php        # demo titles and permalink setup
├── front-page.php              # front page with the catalog
├── archive-anime.php           # /catalog/
├── taxonomy-genre.php          # genre pages
├── single-anime.php            # title page
├── template-parts/catalog.php  # filters + card grid
├── assets/catalog.js           # search, filters, sorting, "Random"
└── header.php, footer.php, page.php, index.php, 404.php
```

## Notes

- Content (titles, genres) is stored in the WordPress database, not in this repository.
- Ratings are approximate; official posters are not included to avoid using third-party images.
