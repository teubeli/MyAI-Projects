<?php
/**
 * xphysio – BFH-Studie Artikel publizieren
 *
 * Erstellt oder aktualisiert den Blog-Artikel "Physiotherapie & chronische Krankheiten"
 * basierend auf der BFH-Studie 2024 (physioswiss Auftrag).
 *
 * Ausführen:
 *   wp eval-file wp-cli-setup/publish-bfh-studie.php --path=/app/public
 */

$slug    = 'physiotherapie-chronische-krankheiten-bfh-studie';
$cat_obj = get_category_by_slug( 'praxis' );
$cat_id  = $cat_obj ? $cat_obj->term_id : 1;

// Autorin: Michaela Tobler (User ID ermitteln)
$author = get_user_by( 'login', 'mitoloki' );
$author_id = $author ? $author->ID : 1;

$content = <<<'HTML'
<!-- wp:paragraph {"className":"article-intro"} -->
<p class="article-intro">Eine neue Studie der Berner Fachhochschule im Auftrag von physioswiss zeigt: Physiotherapie ist bei den meisten chronischen Krankheiten wissenschaftlich empfohlen – und spart dabei sogar Kosten. Was das für deine Gesundheit bedeutet, erkläre ich dir hier.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>80 % der Schweizer Gesundheitskosten – eine erschreckende Zahl</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Im Jahr 2022 lagen die direkten Gesundheitskosten in der Schweiz bei über 91 Milliarden Franken. Das sind fast 900 Franken pro Kopf – jeden Monat. Und 80 % davon werden durch nicht-übertragbare Krankheiten (NCD) verursacht: Rückenschmerzen, Arthrose, Herzerkrankungen, Diabetes, Demenz und viele mehr.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Gleichzeitig hat die Schweiz weltweit eine der höchsten Raten an Hüft- und Knieoperationen – fast doppelt so hoch wie der OECD-Durchschnitt. Die Frage drängt sich auf: Werden wirklich alle diese Operationen gebraucht?</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Was die Studie untersucht hat</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Forscher der Berner Fachhochschule haben im Auftrag von physioswiss systematisch die 21 einflussreichsten chronischen Krankheiten in der Schweiz analysiert und geprüft, was internationale klinische Leitlinien dazu sagen: Wo ist Physiotherapie empfohlen – und wie stark?</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Das Ergebnis ist eindeutig:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Bei <strong>16 von 21 Krankheiten</strong> sprechen die Leitlinien eine starke oder moderate Empfehlung für physiotherapeutische Massnahmen aus</li>
<li>Bei <strong>11 Krankheiten</strong> gibt es mindestens eine <em>starke</em> Empfehlung</li>
<li>Nur bei 5 Krankheiten wurde keine physiotherapeutische Empfehlung abgegeben</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Kurz gesagt: Physiotherapie ist bei den meisten chronischen Erkrankungen nicht optional – sie ist ein zentraler Baustein der Behandlung.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Bewegung schlägt passive Behandlung – fast immer</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Was mich als Physiotherapeutin besonders freut: Über die Hälfte aller starken und moderaten Empfehlungen beziehen sich auf <strong>medizinische Trainingstherapie und die Förderung körperlicher Aktivität</strong>.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Passive Behandlungen wie manuelle Therapie oder Weichteiltechniken machen dagegen nur 5–7 % der starken Empfehlungen aus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Das bedeutet nicht, dass manuelle Therapie wertlos ist – ich setze sie in meiner Praxis gezielt ein. Aber es bestätigt, was ich täglich erlebe: <strong>Wer aktiv mitarbeitet, wer seinen Körper trainiert und versteht, erholt sich nachhaltiger</strong> als jemand, der passiv behandelt wird und dann nach Hause geht.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Konkrete Beispiele: Wo Physio besonders stark empfohlen wird</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3>Rückenschmerzen</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Die WHO empfiehlt bei chronischen Rückenschmerzen stark: Bewegungstherapie, Beratung und edukative Massnahmen. Ausdrücklich <em>nicht</em> empfohlen: Traktion, therapeutischer Ultraschall und TENS als Routinebehandlung. Aktiv statt passiv – das ist die klare Botschaft der Wissenschaft.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Kniearthrose</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Training – beaufsichtigt, unbeaufsichtigt oder im Wasser – ist bei Kniearthrose besser als keine Behandlung. Selbstmanagementprogramme und Patientenedukation werden stark empfohlen. Und das Beste: Eine Schweizer Studie zeigt, dass leitliniengerechte Physiotherapie nur CHF 2'203 pro gewonnenem qualitätsbereinigtem Lebensjahr (QALY) kostet. Zum Vergleich: Eine Schulterprothese kostet CHF 63'299 pro QALY.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Herzerkrankungen und Schlaganfall</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Kardiale Rehabilitation durch Physiotherapie ist nachweislich kosteneffektiv und senkt die Rehospitalisierungsrate. Bei stabiler Herzkrankheit zeigte trainingsbasierte Rehabilitation sogar bessere Ergebnisse als eine Angioplastie.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Diabetes Typ 2</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Regelmässige Bewegung – mindestens 150 Minuten pro Woche, verteilt auf mindestens drei Tage – wird als eine der wichtigsten Massnahmen im Diabetesmanagement empfohlen. Physiotherapeut:innen spielen hier eine Schlüsselrolle als «Chronic Care Manager».</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Sturzprävention</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Individuell angepasste Gleichgewichts- und Funktionstraining-Programme werden stark empfohlen – mindestens dreimal pro Woche über mindestens 12 Wochen. Das ist genau der Bereich, in dem Physiotherapie Leben verändern kann.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Was das für dich bedeutet</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Diese Studie bestätigt, was meine Arbeit täglich zeigt: <strong>Dein Körper kann mehr, als du denkst</strong> – wenn er die richtigen Impulse bekommt.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Physiotherapie ist keine Luxus-Zusatzbehandlung. Sie ist bei den meisten chronischen Erkrankungen wissenschaftlich empfohlen, kosteneffektiv und oft die bessere Alternative zu teuren Operationen oder einer rein medikamentösen Behandlung.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>In meiner Praxis xphysio verbinde ich genau diese evidenzbasierte Grundlage mit einem ganzheitlichen Blick: Ich schaue nicht nur auf die schmerzende Stelle, sondern auf dich als ganzen Menschen – deine Bewegungsmuster, deinen Schlaf, dein Stressniveau, deinen Alltag. Denn das ist es, was laut Wissenschaft nachhaltig wirkt.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Fazit</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Die BFH-Studie im Auftrag von physioswiss ist ein starkes Statement: <strong>Physiotherapie gehört ins Zentrum der Gesundheitsversorgung</strong> – nicht an den Rand. Wer früh handelt, aktiv bleibt und sich professionell begleiten lässt, investiert in seine Gesundheit auf eine der kosteneffektivsten Arten, die es gibt.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><em>Schurz A., Taeymans J., Baur H. &amp; Lutz N. (September 2024): Stellenwert der Physiotherapie bei nichtübertragbaren Krankheiten in der Schweiz – Leitlinien-basierte Empfehlungen und Kosteneffektivität. Berner Fachhochschule, im Auftrag von physioswiss.</em></p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>Du möchtest wissen, ob Physiotherapie auch bei deinen Beschwerden helfen kann? <a href="/online-buchen/">Buch jetzt einen Termin</a> – ich berate dich gerne.</p>
<!-- /wp:paragraph -->
HTML;

$excerpt = 'Eine Studie der Berner Fachhochschule zeigt: Physiotherapie ist bei 16 von 21 chronischen Krankheiten wissenschaftlich empfohlen – und oft kosteneffektiver als Operationen. Was das für dich bedeutet.';

// Existiert der Post schon?
$existing = get_page_by_path( $slug, OBJECT, 'post' );

if ( $existing ) {
    $post_id = wp_update_post( [
        'ID'           => $existing->ID,
        'post_status'  => 'publish',
        'post_content' => $content,
        'post_excerpt' => $excerpt,
    ] );
    echo "✓ Artikel aktualisiert (ID: {$post_id})\n";
} else {
    $post_id = wp_insert_post( [
        'post_title'    => 'Physiotherapie bei chronischen Krankheiten: Was die Wissenschaft sagt',
        'post_name'     => $slug,
        'post_content'  => $content,
        'post_excerpt'  => $excerpt,
        'post_status'   => 'publish',
        'post_author'   => $author_id,
        'post_category' => [ $cat_id ],
        'post_date'     => '2026-04-01 08:00:00',
    ] );
    echo "✓ Artikel publiziert (ID: {$post_id})\n";
}

if ( is_wp_error( $post_id ) ) {
    echo "✗ Fehler: " . $post_id->get_error_message() . "\n";
    exit( 1 );
}

echo "→ URL: " . get_permalink( $post_id ) . "\n";
echo "\n⚠️  Nächster Schritt: Featured Image in WP-Admin setzen!\n";
echo "   WP-Admin → Beiträge → Artikel öffnen → Beitragsbild (≥1200px breit, 16:9)\n";
