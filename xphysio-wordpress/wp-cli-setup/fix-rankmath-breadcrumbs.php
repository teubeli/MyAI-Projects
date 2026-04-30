<?php
/**
 * xphysio – RankMath Breadcrumbs aktivieren
 *
 * Schaltet BreadcrumbList JSON-LD Schema in RankMath ein.
 * Idempotent: prüft Zustand bevor es ändert.
 *
 * Ausführen: wp eval-file wp-cli-setup/fix-rankmath-breadcrumbs.php --path=/app/public
 */

$option_key = 'rank-math-options-general';
$settings   = get_option( $option_key, [] );

if ( ! is_array( $settings ) ) {
    $settings = [];
}

if ( isset( $settings['breadcrumbs'] ) && $settings['breadcrumbs'] === 'on' ) {
    echo "✓ RankMath Breadcrumbs bereits aktiv – keine Änderung nötig\n";
} else {
    $settings['breadcrumbs'] = 'on';
    update_option( $option_key, $settings );
    echo "✓ RankMath Breadcrumbs aktiviert (war: off)\n";
}
