<?php
/**
 * xphysio – Rückenschmerzen-Artikel publizieren
 *
 * Aktualisiert Post ID 57 (slug: rueckenschmerzen-was-wirklich-hilft):
 * – Du-Ansprache im Content + FAQ
 * – post_status publish, post_date 2026-04-22
 * – Featured Image hochladen (blog-header-rueckenschmerzen.png)
 * – RankMath SEO Meta + Focus-Keyword setzen
 * – FAQ-Items als _xphysio_faq_items Post-Meta (für FAQPage-Schema)
 *
 * Ausführen:
 *   wp eval-file wp-cli-setup/publish-rueckenschmerzen.php --path=/app/public
 */

$slug = 'rueckenschmerzen-was-wirklich-hilft';

$existing = get_page_by_path( $slug, OBJECT, 'post' );
if ( ! $existing ) {
    echo "✗ Artikel nicht gefunden (slug: {$slug})\n";
    exit( 1 );
}
$post_id = $existing->ID;
echo "→ Artikel gefunden: ID {$post_id}\n";

// ── CONTENT (Du-Ansprache, fertig) ─────────────────────────────────────────
$content = <<<'HTML'
<!-- wp:paragraph {"className":"article-intro"} -->
<p class="article-intro">Rückenschmerzen sind in der Schweiz die häufigste Ursache für Arbeitsausfälle. Fast 80 % aller Menschen erleben im Laufe ihres Lebens mindestens eine Episode mit starken Rückenschmerzen. Die gute Nachricht: Mit der richtigen Behandlung lassen sich die meisten Beschwerden deutlich verbessern – oft ohne Operation.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Akute vs. chronische Rückenschmerzen – was ist der Unterschied?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Akute Rückenschmerzen dauern weniger als 6 Wochen und verschwinden meist von selbst. Chronische Rückenschmerzen hingegen persistieren länger als 12 Wochen. Hier ist aktive Physiotherapie entscheidend – passives Warten verschlechtert die Situation oft.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Häufige Ursachen</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Muskelverspannungen</strong> durch Fehlhaltung, einseitige Belastung oder Stress</li>
<li><strong>Bandscheibenvorfall</strong> mit oder ohne Nervenbeteiligung</li>
<li><strong>Facettengelenk-Syndrom</strong> – Verschleiss der kleinen Wirbelgelenke</li>
<li><strong>Ischias-Schmerzen</strong> – Ausstrahlung ins Bein</li>
<li><strong>Stenoseschmerzen</strong> – enger Spinalkanal bei älteren Patienten</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Schonung ist meistens falsch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Der Impuls, sich bei Rückenschmerzen hinzulegen und alles zu vermeiden, ist verständlich – aber wissenschaftlich widerlegt. Studien zeigen klar: <strong>Bewegung ist die beste Medizin.</strong> Wer aktiv bleibt und gezielt trainiert, erholt sich schneller und hat weniger Rückfälle.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Was die Physiotherapie tun kann</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>In der Physiotherapie arbeiten wir mit einem individuellen Behandlungsplan, der auf deine spezifische Situation abgestimmt ist:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Manuelle Therapie nach Maitland</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Gezielte, dosierte Mobilisationen der Wirbelgelenke reduzieren Schmerzen und verbessern die Beweglichkeit. Das Maitland-Konzept analysiert zuerst genau, welche Strukturen betroffen sind – dann wird präzise behandelt.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Medizinische Trainingstherapie (MTT)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Kräftigung der Rumpf- und Rückenmuskulatur ist langfristig der wirksamste Schutz gegen Rückenschmerzen. MTT baut Kraft, Ausdauer und Koordination gezielt auf – mit Geräten und freien Übungen.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Neuroathletik bei chronischen Schmerzen</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Chronische Rückenschmerzen haben oft eine starke neurologische Komponente. Das Gehirn „lernt" den Schmerz. Neuroathletisches Training kann diesen Schmerzkreislauf unterbrechen – durch gezielte Übungen für Augen, Gleichgewichtsorgan und Tiefenwahrnehmung.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Was du zu Hause tun kannst</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol>
<li><strong>Bleib aktiv</strong> – Spazieren gehen, Schwimmen oder Radfahren sind gut verträglich</li>
<li><strong>Wärme</strong> – Bei Muskelverspannungen hilft Wärme besser als Kälte</li>
<li><strong>Ergonomie überprüfen</strong> – Bildschirmhöhe, Stuhlhöhe, Matratze</li>
<li><strong>Dehnübungen</strong> – Sanfte Mobilisationsübungen morgens und abends</li>
<li><strong>Stressmanagement</strong> – Psychischer Stress verstärkt Rückenschmerzen nachweislich</li>
</ol>
<!-- /wp:list -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading {"className":"faq-heading"} -->
<h2 class="faq-heading">Häufig gestellte Fragen zu Rückenschmerzen</h2>
<!-- /wp:heading -->

<!-- wp:html -->
<div class="faq-list" data-schema="faq">

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Brauche ich für Physiotherapie bei Rückenschmerzen eine Krankenkassen-Bewilligung?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>In der Schweiz brauchst du eine ärztliche Verordnung. Mit dieser übernimmt die Grundversicherung (KVG) einen Grossteil der Kosten. Die Franchise und der Selbstbehalt (10 %) gelten wie bei anderen Arztbesuchen. Eine separate Kostengutsprache ist bei Physiotherapie in der Regel nicht nötig.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Wie viele Physiotherapie-Sitzungen brauche ich bei Rückenschmerzen?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Das hängt stark von der Ursache und Dauer der Beschwerden ab. Akute Verspannungen können nach 3–5 Sitzungen deutlich besser sein. Chronische oder komplexe Probleme benötigen oft 10–15 Sitzungen plus ein begleitendes Heimprogramm. In der Erstbeurteilung erstellen wir einen realistischen Behandlungsplan.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Hilft Physiotherapie auch bei einem Bandscheibenvorfall?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Ja – bei den meisten Bandscheibenvorfällen ist Physiotherapie die erste Wahl. Studien zeigen, dass konservative Behandlung (Physiotherapie + Bewegung) in 80–90 % der Fälle genauso effektiv ist wie eine Operation. Manuelle Therapie, Nervenmobilisationen und gezieltes Training sind die Methoden der Wahl.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Wann sollte ich zum Arzt und wann direkt zur Physiotherapie?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Bei normalen Rückenschmerzen kannst du direkt Kontakt mit uns aufnehmen – wir helfen dir auch bei der Frage, ob zuerst ein Arztbesuch sinnvoll ist. Sofort zum Arzt: Bei Taubheitsgefühlen, Schwäche in den Beinen, Blasen- oder Darmproblemen oder nach einem Unfall.</p>
</div>
</div>

</div>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"article-cta"} -->
<p class="article-cta">Hast du Rückenschmerzen? <a href="/online-buchen/">Buch jetzt deinen Termin</a> bei xphysio in Wetzikon ZH – wir analysieren deine Situation und erstellen einen individuellen Behandlungsplan.</p>
<!-- /wp:paragraph -->
HTML;

// ── POST AKTUALISIEREN ─────────────────────────────────────────────────────
$result = wp_update_post( [
    'ID'           => $post_id,
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_date'    => '2026-04-22 08:00:00',
    'post_date_gmt'=> '2026-04-22 06:00:00',
], true );

if ( is_wp_error( $result ) ) {
    echo "✗ Update fehlgeschlagen: " . $result->get_error_message() . "\n";
    exit( 1 );
}
echo "✓ Artikel publiziert (post_status=publish, date=2026-04-22)\n";

// ── SEO META (RankMath) ────────────────────────────────────────────────────
update_post_meta( $post_id, 'rank_math_title',       'Rückenschmerzen: Was wirklich hilft – Physiotherapie Wetzikon' );
update_post_meta( $post_id, 'rank_math_description', 'Rückenschmerzen behandeln statt schonen: Manuelle Therapie, MTT und Neuroathletik bei xphysio Wetzikon ZH. Jetzt Termin buchen.' );
update_post_meta( $post_id, 'rank_math_focus_keyword', 'Rückenschmerzen Physiotherapie Wetzikon' );
echo "✓ RankMath SEO Meta gesetzt\n";

// ── FAQ-ITEMS POST-META (für FAQPage JSON-LD Schema) ──────────────────────
$faq_items = [
    [
        'q' => 'Brauche ich für Physiotherapie bei Rückenschmerzen eine Krankenkassen-Bewilligung?',
        'a' => 'In der Schweiz brauchst du eine ärztliche Verordnung. Mit dieser übernimmt die Grundversicherung (KVG) einen Grossteil der Kosten. Die Franchise und der Selbstbehalt (10 %) gelten wie bei anderen Arztbesuchen. Eine separate Kostengutsprache ist bei Physiotherapie in der Regel nicht nötig.',
    ],
    [
        'q' => 'Wie viele Physiotherapie-Sitzungen brauche ich bei Rückenschmerzen?',
        'a' => 'Das hängt stark von der Ursache und Dauer der Beschwerden ab. Akute Verspannungen können nach 3–5 Sitzungen deutlich besser sein. Chronische oder komplexe Probleme benötigen oft 10–15 Sitzungen plus ein begleitendes Heimprogramm. In der Erstbeurteilung erstellen wir einen realistischen Behandlungsplan.',
    ],
    [
        'q' => 'Hilft Physiotherapie auch bei einem Bandscheibenvorfall?',
        'a' => 'Ja – bei den meisten Bandscheibenvorfällen ist Physiotherapie die erste Wahl. Studien zeigen, dass konservative Behandlung (Physiotherapie + Bewegung) in 80–90 % der Fälle genauso effektiv ist wie eine Operation. Manuelle Therapie, Nervenmobilisationen und gezieltes Training sind die Methoden der Wahl.',
    ],
    [
        'q' => 'Wann sollte ich zum Arzt und wann direkt zur Physiotherapie?',
        'a' => 'Bei normalen Rückenschmerzen kannst du direkt Kontakt mit uns aufnehmen – wir helfen dir auch bei der Frage, ob zuerst ein Arztbesuch sinnvoll ist. Sofort zum Arzt: Bei Taubheitsgefühlen, Schwäche in den Beinen, Blasen- oder Darmproblemen oder nach einem Unfall.',
    ],
];
update_post_meta( $post_id, '_xphysio_faq_items', wp_json_encode( $faq_items, JSON_UNESCAPED_UNICODE ) );
echo "✓ FAQ-Items Post-Meta gesetzt (4 Fragen)\n";

// ── FEATURED IMAGE HOCHLADEN ──────────────────────────────────────────────
$img_path = dirname( __DIR__ ) . '/assets/blog-header-rueckenschmerzen.png';
if ( ! file_exists( $img_path ) ) {
    echo "⚠ Featured Image nicht gefunden: {$img_path}\n";
    echo "  → PNG aus SVG erstellen: rsvg-convert -w 1200 -h 675 assets/blog-header-rueckenschmerzen.svg -o assets/blog-header-rueckenschmerzen.png\n";
} else {
    $upload = wp_upload_bits(
        'blog-header-rueckenschmerzen.png',
        null,
        file_get_contents( $img_path )
    );

    if ( $upload['error'] ) {
        echo "✗ Upload fehlgeschlagen: " . $upload['error'] . "\n";
    } else {
        $attachment = [
            'post_mime_type' => 'image/png',
            'post_title'     => 'Rückenschmerzen Physiotherapie – xphysio Wetzikon',
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];
        $attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );

        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        set_post_thumbnail( $post_id, $attach_id );
        echo "✓ Featured Image hochgeladen + gesetzt (Attachment ID: {$attach_id})\n";

        // Alt-Text setzen
        update_post_meta( $attach_id, '_wp_attachment_image_alt', 'Rückenschmerzen behandeln mit Physiotherapie bei xphysio Wetzikon ZH' );
        echo "✓ Alt-Text gesetzt\n";
    }
}

echo "\n✅ Artikel fertig!\n";
echo "→ URL: " . get_permalink( $post_id ) . "\n";
echo "\nNächster Schritt:\n";
echo "  bash deploy.sh  (deployed Theme + DB-Inhalt auf Prod)\n";
