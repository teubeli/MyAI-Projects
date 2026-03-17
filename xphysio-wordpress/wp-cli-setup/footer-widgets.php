<?php
/**
 * xphysio Footer Widgets – WP-CLI Setup
 *
 * Stellt alle 3 Footer-Spalten in der WordPress-Datenbank wieder her.
 * Ausführen mit:
 *   wp eval-file footer-widgets.php --path=/path/to/wordpress
 *
 * Spalten-Zuordnung (Neve HFG columns_layout=true, behält erste 3 Slots):
 *   left    → footer-one-widgets   (Logo + Öffnungszeiten)
 *   c-left  → footer-two-widgets   (Navigation)
 *   center  → footer-three-widgets (Kontakt)
 */

$logo_url = home_url( '/wp-content/uploads/2026/03/Logo-und-Schrift-blau-auf-transparent-1-1024x282-1.png' );
$base_url = home_url();

// ── Spalte 1: Logo + Öffnungszeiten ──────────────────────────────────────────
$col1 = '<div class="footer-logo-col">
<a href="' . $base_url . '/"><img src="' . $logo_url . '" alt="xphysio Physiotherapie Wetzikon" class="footer-logo-img"></a>
<p class="footer-tagline">Physiotherapie in Wetzikon ZH –<br>ganzheitlich, evidenzbasiert, individuell.</p>
<h4 class="footer-widget-title" style="margin-top:20px;">Öffnungszeiten</h4>
<p class="footer-hours">
Di &nbsp;08:30–12:00 / 13:00–16:30<br>
Do &nbsp;14:30–18:30
</p>
</div>';

// ── Spalte 2: Navigation ──────────────────────────────────────────────────────
$col2 = '<div class="footer-nav-col">
<h4 class="footer-widget-title">Seiten</h4>
<ul class="footer-nav-list">
<li><a href="' . $base_url . '/">Startseite</a></li>
<li><a href="' . $base_url . '/angebot/">Leistungen &amp; Preise</a></li>
<li><a href="' . $base_url . '/behandlungsmethoden/">Behandlungsmethoden</a></li>
<li><a href="' . $base_url . '/blog/">Blog</a></li>
<li><a href="' . $base_url . '/ueber-mich/">Über mich</a></li>
<li><a href="' . $base_url . '/kontakt/">Kontakt</a></li>
<li><a href="' . $base_url . '/online-buchen/">Termin buchen</a></li>
</ul>
</div>';

// ── Spalte 3: Kontakt ─────────────────────────────────────────────────────────
$col3 = '<div class="footer-contact-col">
<h4 class="footer-widget-title">Kontakt</h4>
<ul class="footer-contact-list">
<li>
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
<a href="mailto:xphysio@hin.physio">xphysio@hin.physio</a>
</li>
<li>
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
Breitistrasse 25, 8623 Wetzikon ZH
</li>
<li>
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
<a href="' . $base_url . '/online-buchen/">Online Termin buchen</a>
</li>
</ul>
</div>';

// ── Widgets in Sidebars eintragen ─────────────────────────────────────────────
$text_widgets = get_option( 'widget_text', [] );

// Bestehende Footer-Widgets bereinigen
$sidebars = get_option( 'sidebars_widgets', [] );
foreach ( [ 'footer-one-widgets', 'footer-two-widgets', 'footer-three-widgets' ] as $sidebar ) {
    if ( ! empty( $sidebars[ $sidebar ] ) ) {
        foreach ( $sidebars[ $sidebar ] as $wid ) {
            $id_num = (int) substr( $wid, strrpos( $wid, '-' ) + 1 );
            unset( $text_widgets[ $id_num ] );
        }
    }
    $sidebars[ $sidebar ] = [];
}

$existing_keys = array_filter( array_keys( $text_widgets ), 'is_int' );
$next_id = $existing_keys ? ( max( $existing_keys ) + 1 ) : 2;

$widgets_data = [
    'footer-one-widgets'   => $col1,
    'footer-two-widgets'   => $col2,
    'footer-three-widgets' => $col3,
];

foreach ( $widgets_data as $sidebar_id => $html ) {
    $text_widgets[ $next_id ] = [
        'title'  => '',
        'text'   => $html,
        'filter' => false,
        'visual' => false,
    ];
    $sidebars[ $sidebar_id ] = [ "text-{$next_id}" ];
    $next_id++;
}

update_option( 'widget_text', $text_widgets );
update_option( 'sidebars_widgets', $sidebars );
echo "✓ Footer-Widgets (3 Spalten) wiederhergestellt\n";

// ── Footer HFG Layout ─────────────────────────────────────────────────────────
$footer_layout = [
    'desktop' => [
        'top'  => [ 'left' => [], 'c-left' => [], 'center' => [], 'c-right' => [], 'right' => [] ],
        'main' => [
            'left'    => [ [ 'id' => 'footer-one-widgets',   'width' => 4, 'x' => 0 ] ],
            'c-left'  => [ [ 'id' => 'footer-two-widgets',   'width' => 4, 'x' => 4 ] ],
            'center'  => [ [ 'id' => 'footer-three-widgets', 'width' => 4, 'x' => 8 ] ],
            'c-right' => [],
            'right'   => [],
        ],
        'bottom' => [
            'left'    => [ [ 'id' => 'footer_copyright', 'width' => 12, 'x' => 0 ] ],
            'c-left'  => [], 'center' => [], 'c-right' => [], 'right' => [],
        ],
    ],
    'mobile' => [
        'top'  => [ 'left' => [], 'c-left' => [], 'center' => [], 'c-right' => [], 'right' => [] ],
        'main' => [
            'left' => [
                [ 'id' => 'footer-one-widgets' ],
                [ 'id' => 'footer-two-widgets' ],
                [ 'id' => 'footer-three-widgets' ],
            ],
            'c-left' => [], 'center' => [], 'c-right' => [], 'right' => [],
        ],
        'bottom' => [
            'left'    => [ [ 'id' => 'footer_copyright', 'width' => 12, 'x' => 0 ] ],
            'c-left'  => [], 'center' => [], 'c-right' => [], 'right' => [],
        ],
    ],
];
set_theme_mod( 'hfg_footer_layout_v2', wp_json_encode( $footer_layout ) );
echo "✓ Footer HFG Layout gesetzt\n";

// ── Footer Farben ─────────────────────────────────────────────────────────────
set_theme_mod( 'hfg_footer_layout_main_background',   [ 'type' => 'color', 'colorValue' => '#1e2761' ] );
set_theme_mod( 'hfg_footer_layout_top_background',    [ 'type' => 'color', 'colorValue' => '#1e2761' ] );
set_theme_mod( 'hfg_footer_layout_bottom_background', [ 'type' => 'color', 'colorValue' => '#141b4d' ] );
set_theme_mod( 'hfg_footer_layout_bottom_text_color', 'rgba(255,255,255,0.5)' );

$copyright = '&copy; ' . date('Y') . ' xphysio – Physiotherapie Wetzikon &nbsp;&middot;&nbsp; <a href="/datenschutzerklaerung/">Datenschutz</a> &nbsp;&middot;&nbsp; <a href="/agb/">AGB &amp; Impressum</a>';
set_theme_mod( 'footer_copyright_content', $copyright );
echo "✓ Footer-Farben & Copyright gesetzt\n";

echo "\n✅ Footer vollständig wiederhergestellt!\n";
