<?php
/**
 * xphysio Blog-Setup – WP-CLI
 *
 * Erstellt Kategorien + erste 3 Blog-Artikel.
 * Ausführen mit:
 *   wp eval-file blog-setup.php --path=/path/to/wordpress
 */

// ── 1. KATEGORIEN ─────────────────────────────────────────────────────────────
$categories = [
    ['name' => 'Rücken & Wirbelsäule', 'slug' => 'ruecken',       'desc' => 'Rückenschmerzen, Wirbelsäulenprobleme und Behandlungsmethoden'],
    ['name' => 'Gelenke & Schulter',    'slug' => 'gelenke',       'desc' => 'Knie, Schulter, Hüfte – Diagnose und Behandlung'],
    ['name' => 'Training & Bewegung',   'slug' => 'training',      'desc' => 'Medizinische Trainingstherapie, Personal Training, Bewegungsübungen'],
    ['name' => 'Ernährung & Gesundheit','slug' => 'ernaehrung',    'desc' => 'Ernährungs-Coaching, kPNI, ganzheitliche Gesundheit'],
    ['name' => 'Neuroathletik',         'slug' => 'neuroathletik', 'desc' => 'Neuroathletisches Training, Gleichgewicht, Hirnleistung'],
    ['name' => 'Praxis & Wissen',       'slug' => 'praxis',        'desc' => 'Praxis-News, Kassenfragen, Tipps rund um die Physiotherapie'],
];

$cat_ids = [];
// Uncategorized umbenennen (ID 1)
wp_update_term( 1, 'category', ['name' => 'Praxis & Wissen', 'slug' => 'praxis', 'description' => 'Praxis-News, Kassenfragen, Tipps rund um die Physiotherapie'] );
$cat_ids['praxis'] = 1;

foreach ( $categories as $cat ) {
    if ( $cat['slug'] === 'praxis' ) continue;
    $existing = get_term_by( 'slug', $cat['slug'], 'category' );
    if ( $existing ) {
        $cat_ids[ $cat['slug'] ] = $existing->term_id;
    } else {
        $result = wp_insert_term( $cat['name'], 'category', ['slug' => $cat['slug'], 'description' => $cat['desc']] );
        $cat_ids[ $cat['slug'] ] = is_wp_error( $result ) ? 0 : $result['term_id'];
    }
    echo "✓ Kategorie: {$cat['name']}\n";
}

// ── 2. ARTIKEL ────────────────────────────────────────────────────────────────

$posts = [];

// ── ARTIKEL 1: Rückenschmerzen ─────────────────────────────────────────────
$posts[] = [
    'post_title'   => 'Rückenschmerzen: Was wirklich hilft – und was nicht',
    'post_name'    => 'rueckenschmerzen-was-wirklich-hilft',
    'post_category'=> [ $cat_ids['ruecken'] ],
    'post_excerpt' => 'Rückenschmerzen betreffen fast jeden. Doch Schonung ist oft kontraproduktiv. Erfahren Sie, welche Behandlungen wirklich wirken – aus physiotherapeutischer Sicht.',
    'post_content' => <<<'HTML'
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
<p>In der Physiotherapie arbeiten wir mit einem individuellen Behandlungsplan, der auf Ihre spezifische Situation abgestimmt ist:</p>
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
<h2>Was Sie zu Hause tun können</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol>
<li><strong>Bleiben Sie aktiv</strong> – Spazieren gehen, Schwimmen oder Radfahren sind gut verträglich</li>
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
<p>In der Schweiz benötigen Sie eine ärztliche Verordnung. Mit dieser übernimmt die Grundversicherung (KVG) einen Grossteil der Kosten. Die Franchise und der Selbstbehalt (10 %) gelten wie bei anderen Arztbesuchen. Eine separate Kostengutsprache ist bei Physiotherapie in der Regel nicht nötig.</p>
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
<p>Bei normalen Rückenschmerzen können Sie direkt Kontakt mit uns aufnehmen – wir helfen Ihnen auch bei der Frage, ob zuerst ein Arztbesuch sinnvoll ist. Sofort zum Arzt: Bei Taubheitsgefühlen, Schwäche in den Beinen, Blasen- oder Darmproblemen oder nach einem Unfall.</p>
</div>
</div>

</div>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"article-cta"} -->
<p class="article-cta">Haben Sie Rückenschmerzen? <a href="/online-buchen/">Buchen Sie jetzt Ihren Termin</a> bei xphysio in Wetzikon ZH – wir analysieren Ihre Situation und erstellen einen individuellen Behandlungsplan.</p>
<!-- /wp:paragraph -->
HTML
    ,
    'seo_title' => 'Rückenschmerzen: Was wirklich hilft – Physiotherapie Wetzikon',
    'seo_desc'  => 'Rückenschmerzen behandeln statt schonen: Manuelle Therapie, MTT und Neuroathletik bei xphysio Wetzikon ZH. Jetzt Termin buchen.',
];

// ── ARTIKEL 2: Was ist Neuroathletik? ─────────────────────────────────────
$posts[] = [
    'post_title'   => 'Was ist Neuroathletik? Wie das Gehirn Schmerz und Bewegung steuert',
    'post_name'    => 'was-ist-neuroathletik',
    'post_category'=> [ $cat_ids['neuroathletik'] ],
    'post_excerpt' => 'Neuroathletik ist mehr als Sport – es ist ein Trainingsansatz, der das Nervensystem direkt anspricht. Erfahren Sie, wie Augen, Gleichgewicht und Bewegung zusammenhängen.',
    'post_content' => <<<'HTML'
<!-- wp:paragraph {"className":"article-intro"} -->
<p class="article-intro">Warum stolpern manche Menschen öfter? Warum werden Verletzungen immer wieder am gleichen Ort? Warum helfen klassische Übungen manchmal nicht? Die Antwort liegt oft im Nervensystem – und genau hier setzt Neuroathletik an.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Was ist Neuroathletik?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Neuroathletik (auch: neuroathletisches Training oder Z-Health) ist ein Trainingsansatz, der das Nervensystem als <strong>Schaltzentrale von Bewegung und Schmerz</strong> behandelt. Die Grundidee: Das Gehirn steuert alles. Wenn Sensoren schlechte Informationen liefern, reagiert das Gehirn mit Schutzmechanismen – Schmerz, Verspannung, eingeschränkte Beweglichkeit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Neuroathletisches Training verbessert die Qualität der Informationen, die das Gehirn empfängt – und verändert dadurch direkt, wie sich der Körper bewegt und anfühlt.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Die drei Eingangssysteme des Gehirns</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Das Gehirn bekommt seine Informationen über Bewegung und Position aus drei Hauptquellen:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>1. Visuelles System (Augen)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Das Gehirn verarbeitet über 70 % seiner Umgebungsinformationen visuell. Wenn die Augen nicht optimal arbeiten – Fokussieren, Verfolgen, Tiefenwahrnehmung – entstehen im Körper Schutzreaktionen. Mit gezielten Augenübungen kann man Schmerzen, Gleichgewichtsprobleme und Bewegungseinschränkungen direkt beeinflussen.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>2. Vestibuläres System (Gleichgewichtsorgan)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Das Innenohr registriert Beschleunigungen und die Ausrichtung im Raum. Ein schlecht kalibriertes Gleichgewichtsorgan – z. B. nach Kopfverletzungen, Schwindel oder langen Ruhephasen – führt zu Unsicherheit, Kompensationsbewegungen und Schmerz.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>3. Propriozeptives System (Tiefenwahrnehmung)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Muskeln, Sehnen und Gelenke senden ständig Lagemeldungen ans Gehirn. Nach Verletzungen oder bei chronischen Schmerzen sind diese Rezeptoren oft weniger aktiv. Propriozeptives Training reaktiviert diese Signalwege.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Für wen ist Neuroathletik geeignet?</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Chronische Schmerzen</strong> – wenn klassische Physiotherapie nur begrenzt hilft</li>
<li><strong>Sportler</strong> – zur Leistungssteigerung und Verletzungsprävention</li>
<li><strong>Nach Verletzungen</strong> – Knöchelverstauchung, Schleudertrauma, Knie-OP</li>
<li><strong>Gleichgewichtsprobleme</strong> – Schwindel, Sturzangst, Unsicherheit</li>
<li><strong>Kopfschmerzen</strong> – besonders spannungskopfbedingte und Migräne</li>
<li><strong>Burnout & Stress</strong> – Neuroathletik reguliert auch das autonome Nervensystem</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Wie läuft eine Neuroathletik-Sitzung bei xphysio ab?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Jede Sitzung beginnt mit einem <strong>Neuromapping</strong>: Wir testen, welche Eingangssysteme gut funktionieren und wo Defizite liegen. Dann folgen spezifische Übungen – oft sind diese überraschend einfach, aber ihre Wirkung ist unmittelbar messbar.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Ein typisches Beispiel: Ein Patient mit chronischen Schulterschmerzen hat eingeschränkte Augenbeweglichkeit auf der betroffenen Seite. Nach 5 Minuten Augentraining verbessert sich die Schulterbeweglichkeit spürbar – ohne eine einzige Schultermobilisation.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Neuroathletik und klassische Physiotherapie – kein Widerspruch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Bei xphysio kombinieren wir Neuroathletik mit dem Maitland-Konzept, Mulligan MWM und MTT. Das Nervensystem und das Bewegungssystem arbeiten zusammen – eine Behandlung, die beide Ebenen einbezieht, ist nachhaltiger als eine rein mechanische Therapie.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Neuroathletik bei xphysio in Wetzikon ZH</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Als eine der wenigen Physiotherapeutinnen in der Region Zürcher Oberland, die Neuroathletik gezielt in die Behandlung integriert, bietet Michaela Tobler einen modernen, evidenzbasierten Ansatz. Ob bei chronischen Rückenschmerzen, Schwindel, nach Sportverletzungen oder zur Leistungssteigerung – neuroathletisches Training ergänzt die klassische Physiotherapie auf eine Art, die Ergebnisse sichtbar und messbar macht. Neuroathletik in Wetzikon ist kein Trend, sondern gezielte Wissenschaft.</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading {"className":"faq-heading"} -->
<h2 class="faq-heading">Häufig gestellte Fragen zu Neuroathletik</h2>
<!-- /wp:heading -->

<!-- wp:html -->
<div class="faq-list" data-schema="faq">

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Übernimmt die Krankenkasse Neuroathletik?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Neuroathletisches Training wird als Privatleistung abgerechnet (CHF 165 / 50 Min). Wenn es im Rahmen einer verordneten Physiotherapie eingesetzt wird, kann ein Teil der Kosten über die KVG-Verordnung abgedeckt sein. Sprechen Sie uns an – wir klären das gemeinsam mit Ihnen.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Wie unterscheidet sich Neuroathletik von klassischem Gleichgewichtstraining?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Klassisches Gleichgewichtstraining trainiert vorwiegend das propriozeptive System (Wackelbrett, einbeiniger Stand). Neuroathletik geht einen Schritt weiter: Es analysiert alle drei Eingangssysteme (Augen, Vestibulum, Propriozeption) und trainiert gezielt die schwächsten Verbindungen. Das macht es präziser und oft schneller wirksam.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Kann ich Neuroathletik-Übungen auch zu Hause machen?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Ja – ein grosser Vorteil ist, dass viele Übungen überall und ohne Geräte durchgeführt werden können. Nach einer Einschätzung durch Michaela Tobler erhalten Sie ein individuelles Heimprogramm mit Videoanleitungen.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Wie schnell sieht man Ergebnisse bei Neuroathletik?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Oft sofort – das ist das Erstaunliche an neuroathletischem Training. Verbesserungen in Beweglichkeit, Balance oder Schmerzfreiheit lassen sich häufig direkt in der ersten Sitzung testen und messen. Langfristige Veränderungen brauchen regelmässiges Training über mehrere Wochen.</p>
</div>
</div>

</div>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"article-cta"} -->
<p class="article-cta">Neugierig auf Neuroathletik? <a href="/online-buchen/">Buchen Sie eine Erstbeurteilung</a> bei xphysio in Wetzikon – Michaela Tobler ist zertifizierte Neuroathletik-Trainerin mit über 20 Jahren Erfahrung.</p>
<!-- /wp:paragraph -->
HTML
    ,
    'seo_title' => 'Was ist Neuroathletik? Gehirn, Schmerz & Bewegung – xphysio Wetzikon',
    'seo_desc'  => 'Neuroathletik trainiert Augen, Gleichgewicht und Nervensystem direkt. Wie das wirkt und für wen – erklärt von Michaela Tobler, xphysio Wetzikon ZH.',
];

// ── ARTIKEL 3: Physiotherapie auf Krankenkasse ────────────────────────────
$posts[] = [
    'post_title'   => 'Physiotherapie auf Krankenkasse in der Schweiz: Alles zur Kostenübernahme',
    'post_name'    => 'physiotherapie-krankenkasse-kostenuebernahme-schweiz',
    'post_category'=> [ $cat_ids['praxis'] ],
    'post_excerpt' => 'Wer übernimmt die Kosten? Wie viele Sitzungen bezahlt die Krankenkasse? Alles Wichtige zur KVG-Verordnung und Kostenübernahme für Physiotherapie in der Schweiz.',
    'post_content' => <<<'HTML'
<!-- wp:paragraph {"className":"article-intro"} -->
<p class="article-intro">Physiotherapie ist kassenpflichtig – das wissen die meisten. Aber wann, wie viel und unter welchen Bedingungen? Diese Fragen stellen uns unsere Patient:innen regelmässig. Hier finden Sie alle Antworten, klar und ohne Fachchinesisch.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Grundvoraussetzung: Ärztliche Verordnung</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Damit die Grundversicherung (KVG) Physiotherapie bezahlt, benötigen Sie eine <strong>ärztliche Verordnung</strong>. Diese stellt Ihr Hausarzt, Orthopäde, Neurologe oder ein anderer Facharzt aus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Wichtig: Die Verordnung muss <strong>vor der ersten Behandlung</strong> ausgestellt sein. Im Nachhinein lässt sich eine Kostenübernahme in der Regel nicht mehr erwirken.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Wie viele Sitzungen übernimmt die Krankenkasse?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Eine ärztliche Verordnung gilt für <strong>9 Sitzungen</strong>. Sind weitere Behandlungen nötig, stellt der Arzt eine neue Verordnung aus. In der Praxis ist es oft so, dass bei chronischen Erkrankungen mehrere Verordnungsblöcke über das Jahr verteilt werden.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Wer trägt welche Kosten?</h3>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table>
<thead><tr><th>Kosten-Anteil</th><th>Wer zahlt?</th></tr></thead>
<tbody>
<tr><td>Physiotherapie-Tarif (TARMED / Pauschale)</td><td>Krankenkasse (nach Franchise + Selbstbehalt)</td></tr>
<tr><td>Franchise (je nach Modell CHF 300–2'500)</td><td>Patient</td></tr>
<tr><td>Selbstbehalt (10 % der restlichen Kosten)</td><td>Patient</td></tr>
<tr><td>Max. Selbstbehalt pro Jahr</td><td>CHF 700 (Erwachsene), CHF 350 (Kinder)</td></tr>
</tbody>
</table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2>Was kostet Physiotherapie bei xphysio?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Bei xphysio in Wetzikon gelten folgende Tarife:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Physiotherapie (kassenpflichtig):</strong> CHF 65 / 25 Min. | CHF 115 / 50 Min.</li>
<li><strong>Medizinische Trainingstherapie (MTT):</strong> ab CHF 65 (mit Verordnung kassenpflichtig)</li>
<li><strong>Personal Training (Privatleistung):</strong> CHF 165 / 50 Min.</li>
<li><strong>Neuroathletik (Privatleistung):</strong> CHF 165 / 50 Min.</li>
<li><strong>kPNI-Beratung (Privatleistung):</strong> CHF 165 / 50 Min.</li>
<li><strong>RP-Nutrition (12 Wochen Programm):</strong> CHF 580</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Zusatzversicherung: Noch mehr Leistungen möglich</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Wer eine <strong>Zusatzversicherung</strong> (ambulante Zusatzversicherung, Komplementärmedizin-Zusatz oder ähnliches) hat, kann oft auch Privatleistungen wie Neuroathletik, Personal Training oder Ernährungs-Coaching teilweise erstattet bekommen. Fragen Sie direkt bei Ihrer Krankenkasse nach – die Leistungskataloge unterscheiden sich stark.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Schritt für Schritt zur Physiotherapie mit Kassenleistung</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol>
<li>Arztbesuch → Verordnung für Physiotherapie holen</li>
<li>Termin bei xphysio online buchen (Medidoc, 24/7)</li>
<li>Verordnung zur ersten Sitzung mitbringen (Original)</li>
<li>xphysio rechnet direkt mit Ihrer Krankenkasse ab (Tiers payant möglich)</li>
<li>Sie erhalten nur noch die verbleibende Rechnung für Franchise / Selbstbehalt</li>
</ol>
<!-- /wp:list -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:heading {"className":"faq-heading"} -->
<h2 class="faq-heading">Häufig gestellte Fragen zur Kostenübernahme</h2>
<!-- /wp:heading -->

<!-- wp:html -->
<div class="faq-list" data-schema="faq">

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Brauche ich eine Kostengutsprache der Krankenkasse vor der Physiotherapie?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>In der Regel nein. Eine ärztliche Verordnung reicht als Basis für die Kostenübernahme durch die Grundversicherung. Eine separate Voranfrage oder Kostengutsprache ist bei ambulanter Physiotherapie normalerweise nicht notwendig.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Was passiert, wenn die 9 Sitzungen aufgebraucht sind, ich aber noch Behandlung benötige?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Sie lassen sich vom Arzt eine neue Verordnung ausstellen. Es gibt keine jährliche Obergrenze für die Anzahl der Verordnungen – bei chronischen oder komplexen Erkrankungen können mehrere Blöcke pro Jahr verordnet werden.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Kann ich auch ohne Verordnung zur Physiotherapie gehen?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Ja, aber dann als Selbstzahler (Privatleistung). Das kann sinnvoll sein, wenn Sie keine Franchise ausgeschöpft haben und nur wenige Sitzungen benötigen, oder wenn Sie spezifische Privatleistungen wie Personal Training oder Neuroathletik nutzen möchten.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Rechnet xphysio direkt mit der Krankenkasse ab (Tiers payant)?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Ja, auf Wunsch rechnen wir direkt ab (Tiers payant). Sie erhalten dann nur eine Rechnung für den nicht gedeckten Anteil (Franchise/Selbstbehalt). Sprechen Sie uns beim ersten Termin darauf an.</p>
</div>
</div>

<div class="faq-item">
<button class="faq-question" aria-expanded="false">
<span class="faq-question-text">Welche Krankenkasse ist für Physiotherapie in Wetzikon zuständig?</span>
<span class="faq-icon" aria-hidden="true">+</span>
</button>
<div class="faq-answer">
<p>Alle Schweizer Grundversicherungen (KVG) sind bei anerkannten Physiotherapeut:innen gleichwertig. Michaela Tobler ist als Physiotherapeutin BSc beim Kanton Zürich anerkannt und bei allen Grundversicherungen zugelassen.</p>
</div>
</div>

</div>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"article-cta"} -->
<p class="article-cta">Haben Sie eine ärztliche Verordnung? <a href="/online-buchen/">Buchen Sie jetzt Ihren Termin online</a> bei xphysio in Wetzikon – Di 08:00–12:00 / 13:00–16:30 Uhr, Do 14:00–17:00 Uhr.</p>
<!-- /wp:paragraph -->
HTML
    ,
    'seo_title' => 'Physiotherapie Krankenkasse Schweiz: Kosten & Verordnung erklärt',
    'seo_desc'  => 'Was übernimmt die Krankenkasse bei Physiotherapie? Verordnung, Sitzungen, Selbstbehalt – alles erklärt von xphysio Wetzikon ZH.',
];

// ── 3. ARTIKEL EINSPIELEN ─────────────────────────────────────────────────────
$author_id = 1; // Admin-User

foreach ( $posts as $p ) {
    // Prüfe ob Artikel schon existiert
    $existing = get_page_by_path( $p['post_name'], OBJECT, 'post' );
    if ( $existing ) {
        echo "⚠ Übersprungen (existiert): {$p['post_title']}\n";
        continue;
    }

    $post_id = wp_insert_post( [
        'post_title'    => $p['post_title'],
        'post_name'     => $p['post_name'],
        'post_content'  => $p['post_content'],
        'post_excerpt'  => $p['post_excerpt'],
        'post_status'   => 'publish',
        'post_author'   => $author_id,
        'post_category' => $p['post_category'],
        'post_date'     => date( 'Y-m-d H:i:s', strtotime( '-' . (count($posts) - array_search($p, $posts)) . ' days' ) ),
    ], true );

    if ( is_wp_error( $post_id ) ) {
        echo "✗ Fehler bei: {$p['post_title']} – " . $post_id->get_error_message() . "\n";
        continue;
    }

    // SEO Meta (RankMath + custom)
    update_post_meta( $post_id, 'rank_math_title',       $p['seo_title'] );
    update_post_meta( $post_id, 'rank_math_description', $p['seo_desc'] );
    update_post_meta( $post_id, '_xphysio_seo_title',    $p['seo_title'] );
    update_post_meta( $post_id, '_xphysio_seo_desc',     $p['seo_desc'] );

    echo "✓ Artikel erstellt (ID {$post_id}): {$p['post_title']}\n";
    echo "  URL: " . get_permalink( $post_id ) . "\n";
}

echo "\n✅ Blog-Setup abgeschlossen!\n";
echo "Blog: " . home_url('/blog/') . "\n";
