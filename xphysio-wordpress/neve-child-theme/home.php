<?php
/**
 * Blog-Archiv Template (Child-Theme Override von Neve index.php)
 * Gibt die Intro-Section full-width VOR dem Neve-Container aus.
 *
 * @package neve-child
 */

$container_class    = apply_filters( 'neve_container_class_filter', 'container', 'blog-archive' );
$wrapper_classes    = apply_filters( 'neve_posts_wrapper_class', [ 'posts-wrapper' ] );
$load_hooks         = get_theme_mod( 'neve_blog_archive_layout', 'grid' ) === 'default';

get_header();

// ── Kategorie-Links aufbauen ──────────────────────────────────────────────────
$cats = [
	[ 'slug' => 'ruecken',       'label' => 'Rücken & Wirbelsäule' ],
	[ 'slug' => 'gelenke',       'label' => 'Gelenke & Schulter'   ],
	[ 'slug' => 'training',      'label' => 'Training & Bewegung'  ],
	[ 'slug' => 'neuroathletik', 'label' => 'Neuroathletik'        ],
	[ 'slug' => 'ernaehrung',    'label' => 'Ernährung'            ],
	[ 'slug' => 'praxis',        'label' => 'Praxis & Wissen'      ],
];
$chips = '';
foreach ( $cats as $c ) {
	$term = get_category_by_slug( $c['slug'] );
	$url  = $term ? esc_url( get_category_link( $term ) ) : '#';
	$chips .= '<a href="' . $url . '" class="xp-topic-chip">' . esc_html( $c['label'] ) . '</a>';
}
?>

<section class="xp-page-hero xp-blog-hero">
  <div class="xp-container">
    <div class="xp-blog-intro-inner">
      <div class="xp-blog-intro-text">
        <span class="subtitle">Wissen &amp; Tipps</span>
        <h1>Blog – Physiotherapie, Bewegung &amp; Gesundheit</h1>
        <p class="lead">Ich teile hier Wissen aus über 20 Jahren Physiotherapie – praxisnah, evidenzbasiert und immer mit dem Ziel, dass du deinen Körper besser verstehst. Von Rückenschmerzen über Neuroathletik bis hin zu Ernährung: Themen, die meine Patientinnen und Patienten wirklich beschäftigen.</p>
        <p class="xp-blog-author-sig">— Michaela Tobler, Physiotherapeutin</p>
      </div>
      <div class="xp-blog-intro-topics">
        <span class="subtitle" style="display:block;margin-bottom:14px;">Alle Themen</span>
        <div class="xp-topic-chips"><?php echo $chips; ?></div>
      </div>
    </div>
  </div>
</section>

<main id="content" class="neve-main">
	<div class="<?php echo esc_attr( $container_class ); ?> archive-container">
		<?php do_action( 'neve_do_featured_post', 'index' ); ?>
		<div class="row">
			<?php do_action( 'neve_do_sidebar', 'blog-archive', 'left' ); ?>
			<div class="nv-index-posts blog col">
				<?php
				do_action( 'neve_before_loop' );
				do_action( 'neve_page_header', 'index' );
				do_action( 'neve_before_posts_loop' );

				if ( have_posts() ) {
					echo '<div class="' . esc_attr( join( ' ', $wrapper_classes ) ) . '">';
					$pagination_type = get_theme_mod( 'neve_pagination_type', 'number' );
					if ( $pagination_type !== 'infinite' ) {
						global $wp_query;
						$posts_on_page = $wp_query->post_count;
						$hook_after    = $posts_on_page >= 2 ? (int) ceil( $posts_on_page / 2 ) : -1;
						$post_index    = 1;
					}
					neve_do_loop_hook( 'before' );
					$excluded = apply_filters( 'nv_exclude_posts', [] );
					while ( have_posts() ) {
						the_post();
						if ( in_array( get_the_ID(), $excluded, true ) ) continue;
						neve_do_loop_hook( 'entry_before' );
						if ( $load_hooks ) do_action( 'neve_loop_entry_before' );
						get_template_part( 'template-parts/content', get_post_type() );
						if ( $load_hooks ) do_action( 'neve_loop_entry_after' );
						if ( $pagination_type !== 'infinite' && $load_hooks ) {
							if ( $post_index === $hook_after && $hook_after !== -1 ) do_action( 'neve_middle_posts_loop' );
							$post_index++;
						}
						neve_do_loop_hook( 'entry_after' );
					}
					echo '</div>';
					if ( ! is_singular() ) do_action( 'neve_do_pagination', 'blog-archive' );
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
				<div class="w-100"></div>
				<?php
				do_action( 'neve_after_posts_loop' );
				neve_do_loop_hook( 'after' );
				?>
			</div>
			<?php do_action( 'neve_do_sidebar', 'blog-archive', 'right' ); ?>
		</div>
	</div>
</main>

<?php get_footer();
