<?php
/**
 * xphysio – Sie → Du Umstellung für alle Blog-Artikel
 * wp eval-file wp-cli-setup/fix-du-ansprache.php --path=... --allow-root
 */

$replacements = [
    // Generische Ersetzungen (Reihenfolge wichtig: längere zuerst)
    'Buchen Sie eine Erstbeurteilung'       => 'Buch eine Erstbeurteilung',
    'Buchen Sie jetzt Ihren Termin'         => 'Buch jetzt deinen Termin',
    'Buchen Sie jetzt einen Termin'         => 'Buch jetzt einen Termin',
    'Buchen Sie'                            => 'Buch',
    'Sprechen Sie uns an'                   => 'Sprich uns an',
    'Erfahren Sie'                          => 'Erfahre',
    'erhalten Sie ein individuelles'        => 'erhältst du ein individuelles',
    'erhalten Sie'                          => 'erhältst du',
    'haben Sie'                             => 'hast du',
    'brauchen Sie'                          => 'brauchst du',
    'können Sie'                            => 'kannst du',
    'müssen Sie'                            => 'musst du',
    'sollten Sie'                           => 'solltest du',
    'wenden Sie sich'                       => 'wende dich',
    'sprechen Sie'                          => 'sprich',
    'gemeinsam mit Ihnen'                   => 'gemeinsam mit dir',
    'mit Ihnen'                             => 'mit dir',
    'für Sie'                               => 'für dich',
    'bei Ihnen'                             => 'bei dir',
    'helfen Ihnen'                          => 'helfe ich dir',
    'Ihnen'                                 => 'dir',
    'auf Ihre Ziele abgestimmt'             => 'auf deine Ziele abgestimmt',
    'auf Ihre spezifische Situation'        => 'auf deine spezifische Situation',
    'Ihre spezifische'                      => 'deine spezifische',
    'Ihren Termin'                          => 'deinen Termin',
    'Ihren Behandlungsplan'                 => 'deinen Behandlungsplan',
    'Ihren Körper'                          => 'deinen Körper',
    'Ihre Situation'                        => 'deine Situation',
    'Ihre Beschwerden'                      => 'deine Beschwerden',
    'Ihre Krankenkasse'                     => 'deine Krankenkasse',
    'Ihre Gesundheit'                       => 'deine Gesundheit',
    'Ihr individuelles'                     => 'dein individuelles',
    'Ihr Körper'                            => 'dein Körper',
    // Link-Korrekturen
    'href="/terminbuchung/"'                => 'href="/online-buchen/"',
    // FAQ-Ansprache
    'Sprechen Sie bitte mit Ihrer Krankenkasse' => 'Sprich bitte mit deiner Krankenkasse',
    'mit Ihrer Krankenkasse'                => 'mit deiner Krankenkasse',
    'Erfahren Sie, welche'                  => 'Erfahre, welche',
];

$post_ids = [57, 59, 70, 158];

foreach ( $post_ids as $id ) {
    $post = get_post( $id );
    if ( ! $post ) { echo "✗ ID $id nicht gefunden\n"; continue; }

    $content = $post->post_content;
    $excerpt = $post->post_excerpt;
    $changed = false;

    foreach ( $replacements as $from => $to ) {
        if ( strpos( $content, $from ) !== false ) {
            $content = str_replace( $from, $to, $content );
            $changed = true;
        }
        if ( strpos( $excerpt, $from ) !== false ) {
            $excerpt = str_replace( $from, $to, $excerpt );
            $changed = true;
        }
    }

    if ( $changed ) {
        wp_update_post( [ 'ID' => $id, 'post_content' => $content, 'post_excerpt' => $excerpt ] );
        echo "✓ ID $id ({$post->post_name}) – aktualisiert\n";
    } else {
        echo "  ID $id ({$post->post_name}) – keine Änderungen nötig\n";
    }
}

wp_cache_flush();
echo "\n✅ Fertig\n";
