<?php
/**
 * Neve Child Theme – functions.php
 * xphysio.ch – Physiotherapie Wetzikon
 * Michaela Tobler, Breitistrasse 25, 8623 Wetzikon ZH
 *
 * Inhalte:
 *   1. Parent-Theme-Styles einbinden
 *   2. Google Fonts
 *   3. Schema.org JSON-LD (global + seitenspezifisch)
 *   4. Google Tag Manager (GTM-PTL8GNJS)
 *   5. Contact Form 7 – nur auf Kontaktseite
 *   6. Booking-Widget Shortcode [xphysio_booking]
 *   7. FAQ-Akkordeon (Vanilla JS)
 *   8. Neve-Feinschliff
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────────────────────────────────────
// 1. PARENT THEME STYLES + CRITICAL CSS INLINE
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', 'xphysio_enqueue_styles' );
function xphysio_enqueue_styles() {
    // neve-parent-style (style.css) enthält nur den Theme-Header-Kommentar (1555 Bytes, kein CSS).
    // Wird deferred – kein render-blocking, kein visueller Effekt.
    wp_enqueue_style(
        'neve-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( get_template() )->get( 'Version' )
    );
    // Child Theme CSS: via media="print" async laden (nicht render-blocking)
    // Critical CSS (Above-the-fold) wird separat inline gerendert (siehe unten).
    wp_enqueue_style(
        'neve-child-style',
        get_stylesheet_uri(),
        [ 'neve-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
}

// Nicht-kritische CSS via media="print" async laden → kein Render-Blocking
// Betrifft: Child Theme CSS, RankMath CSS, Complianz CSS
add_filter( 'style_loader_tag', 'xphysio_defer_noncritical_css', 10, 2 );
function xphysio_defer_noncritical_css( $tag, $handle ) {
    $defer_handles = [
        // neve-parent-style (style.css) = nur WP Theme-Header-Kommentar, kein CSS → sicher deferren
        'neve-parent-style',     // 1.2 KiB, kein CSS, spart 570ms render-blocking
        // ⚠️ neve-style (39KB) NICHT deferren: verursacht CLS ≥1 (zu viele Above-fold Styles).
        // neve-style bleibt render-blocking, aber preloaded → startet früh. Getestet 2026-03-21.
        'neve-child-style',      // 34KB – critical part ist inline via xphysio_critical_css_inline
        'rank-math',             // RankMath Frontend CSS – nicht above-the-fold
        'cmplz-cookieblocker',   // Complianz cookieblocker.min.css
        'cmplz-general',         // Complianz general CSS
        'cmplz-banner',          // Complianz banner CSS
    ];
    if ( ! in_array( $handle, $defer_handles, true ) ) return $tag;
    $tag = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $tag );
    return $tag;
}

// Neve kritische Struktur-CSS inline (verhindert CLS wenn neve-style async lädt)
// Enthält nur Layout-Regeln (flex, position) für Header/Wrapper – kein Design.
// Design (Farben, Fonts) kommt aus neve-style async + xphysio_nav_colors inline.
// → Nachhaltig: diese Regeln sind Neve-Core und ändern sich selten.
add_action( 'wp_head', 'xphysio_neve_critical_css', 1 );
function xphysio_neve_critical_css() {
    echo '<style id="neve-critical-structure">';
    echo '.wrapper{display:flex;min-height:100vh;flex-direction:column;position:relative;transition:all .3s cubic-bezier(.79,.14,.15,.86)}';
    echo 'body>.wrapper{overflow:hidden}';
    echo '.neve-main{flex:1 auto}';
    echo '.site-header{position:relative}';
    echo '.hfg_header.site-header{box-shadow:0 -1px 3px rgba(0,0,0,.1)}';
    echo '.site-header .header--row-inner{align-items:center;display:flex}';
    echo '.hfg-grid{display:flex}';
    echo '.hfg-slot{display:flex;align-items:center}';
    echo '.hfg-slot.right{justify-content:flex-end}';
    echo '.hfg-slot.center{justify-content:center}';
    echo '.hfg-is-group{display:flex;align-items:center}';
    echo '.builder-item{margin:4px 0;position:relative;min-height:1px;padding-right:15px;padding-left:15px}';
    echo '.builder-item.hfg-end{margin-left:auto}';
    echo '.builder-item.hfg-start{margin-right:auto}';
    echo '.builder-item .item--inner{padding:var(--padding,0);margin:var(--margin,0);position:relative}';
    echo '.nav-ul{display:flex;flex-wrap:wrap}';
    echo '.nav-ul li{display:block;position:relative}';
    echo '.nav-ul li>.wrap{display:flex;align-items:center}';
    echo '.nav-ul li a{position:relative;width:100%;display:flex;align-items:center}';
    echo '.navbar-toggle{display:flex;align-items:center;box-shadow:none;padding:10px 15px}';
    echo '.navbar-toggle-wrapper{align-items:center}';
    echo '#header-grid.global-styled:not(.neve-transparent-header){background:var(--bgcolor);background-image:var(--bgimage,var(--bgcolor,none))}';
    echo '.hfg-ov{top:0;bottom:0;right:0;left:0;position:fixed;z-index:999899;visibility:hidden;opacity:0}';
    echo '.hfg-pe{pointer-events:none}';
    // Logo – Basis-Layout damit das Logo-Bild korrekt im Flex-Container sitzt
    echo '.site-logo{align-items:center;display:flex}';
    echo '.site-logo img{max-width:var(--maxwidth);height:auto;display:block}';
    echo '@media(min-width:960px){.builder-item{margin:8px 0}}';
    echo '</style>' . "\n";
}

// Critical CSS (Above-the-fold) inline in <head>
// Strategie: Alles bis .xp-services{ + alle @media-Blöcke die Hero/Trust betreffen.
// Verhindert CLS auf Mobile (Hero-Grid, Trust-Grid, section-pad wechseln nicht mehr
// nachträglich) und schützt vor LCP-Regression.
// Nachhaltig: Selektoren-Liste pflegen wenn neue Above-fold Elemente dazukommen.
add_action( 'wp_head', 'xphysio_critical_css_inline', 2 );
function xphysio_critical_css_inline() {
    $css_file = get_stylesheet_directory() . '/style.css';
    if ( ! file_exists( $css_file ) ) return;

    $css = file_get_contents( $css_file );
    $css = preg_replace( '/^\/\*.*?\*\//s', '', $css );
    $css = trim( $css );

    // Teil 1: Alles bis .xp-services{ (Hero, Trust-Bar, Buttons, Variablen)
    $cutoff = strpos( $css, '.xp-services{' );
    if ( $cutoff === false ) return;
    $critical = substr( $css, 0, $cutoff );

    // Teil 2: @media-Blöcke aus dem Rest extrahieren, die Above-fold Selektoren enthalten.
    // Diese müssen inline sein, damit Mobile-Layout (Hero-Grid, section-pad) sofort stimmt.
    // → Neue Above-fold Klassen hier ergänzen falls nötig.
    $above_fold = [ 'xp-hero', 'hero-grid', 'hero-badge', 'hero-cta', 'xp-trust', 'trust-item', 'trust-number', 'trust-label', 'section-pad', 'hero-image' ];

    $noncritical = substr( $css, $cutoff );
    preg_match_all( '/@media[^{]+\{(?:[^{}]|\{[^{}]*\})*\}/s', $noncritical, $matches );
    foreach ( $matches[0] as $block ) {
        if ( strpos( $block, 'print' ) !== false ) continue; // @media print überspringen
        foreach ( $above_fold as $selector ) {
            if ( strpos( $block, $selector ) !== false ) {
                $critical .= $block;
                break;
            }
        }
    }

    echo '<style id="xphysio-critical-css">' . $critical . '</style>' . "\n";
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. GOOGLE FONTS – einmalige async-URL (Neve-Fonts deregistriert)
// ─────────────────────────────────────────────────────────────────────────────
// Neve würde Lora + Source Sans 3 mit eingeschränkten Weights laden.
// Wir deregistrieren Neve's Fonts und laden eine konsolidierte async-URL
// mit allen benötigten Weights (inkl. Italic). Kein Render-Blocking.
// Neve enqueued fonts kurz vor der Ausgabe abfangen
add_action( 'wp_print_styles', 'xphysio_dequeue_neve_fonts', 999 );
function xphysio_dequeue_neve_fonts() {
    wp_dequeue_style( 'neve-google-font-lora' );
    wp_deregister_style( 'neve-google-font-lora' );
    wp_dequeue_style( 'neve-google-font-source-sans-3' );
    wp_deregister_style( 'neve-google-font-source-sans-3' );

    // Catch any other Google Fonts handle registered by Neve or plugins
    global $wp_styles;
    foreach ( $wp_styles->registered as $handle => $style ) {
        if ( ! empty( $style->src ) && strpos( $style->src, 'fonts.googleapis.com' ) !== false ) {
            wp_dequeue_style( $handle );
            wp_deregister_style( $handle );
        }
    }
}

// Defer Neve's render-blocking frontend scripts (no defer attribute by default)
add_filter( 'script_loader_tag', 'xphysio_defer_neve_scripts', 10, 3 );
function xphysio_defer_neve_scripts( $tag, $handle, $src ) {
    $defer = [ 'neve-script', 'neve-frontend', 'neve-scroll-to-top' ];
    if ( in_array( $handle, $defer, true ) && strpos( $tag, 'defer' ) === false ) {
        $tag = str_replace( '<script ', '<script defer ', $tag );
    }
    return $tag;
}


add_action( 'wp_head', 'xphysio_fonts_async', 3 );
function xphysio_fonts_async() {
    // display=optional: kein Font-Swap nach erstem Paint → verhindert CLS/FOUT
    // Fonts werden ab 2. Seitenaufruf (gecacht) sofort gezeigt.
    $url = 'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=optional';
    echo '<link rel="preload" href="' . esc_url( $url ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . esc_url( $url ) . '"></noscript>' . "\n";
}

// Preconnect + Preloads (Priority 1 = ganz oben im <head>)
add_action( 'wp_head', 'xphysio_font_preconnect', 1 );
function xphysio_font_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Neve Main CSS preloaden – render-blocking, aber Browser startet Download früh.
    // ⚠️ neve-style NICHT deferren: verursacht CLS ≥1 (Logo, Header, Container). Getestet 2026-03-21.
    $neve_uri = get_template_directory_uri();
    $suffix   = ( defined('NEVE_DEBUG') && NEVE_DEBUG ) ? '' : '.min';
    echo '<link rel="preload" href="' . esc_url( $neve_uri . '/style-main-new' . $suffix . '.css' ) . '" as="style">' . "\n";

    // LCP-Hero-Bild vorladen (Startseite: Michaela-Foto = grösstes Element above the fold)
    if ( is_front_page() ) {
        echo '<link rel="preload" as="image" href="https://xphysio.ch/wp-content/uploads/2026/03/michaela-tobler-physiotherapeutin-bsc-xphysio-wetzikon.webp" type="image/webp" fetchpriority="high">' . "\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. SCHEMA.ORG – GLOBAL (MedicalBusiness + LocalBusiness)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_head', 'xphysio_schema_global', 5 );
function xphysio_schema_global() {
    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            // ── 3a. MedicalBusiness / LocalBusiness ──────────────────────
            [
                '@type'    => [ 'MedicalBusiness', 'LocalBusiness' ],
                '@id'      => 'https://xphysio.ch/#business',
                'name'     => 'xphysio – Physiotherapie Wetzikon',
                'alternateName' => 'x-physio',
                'url'      => 'https://xphysio.ch',
                'logo'     => [
                    '@type' => 'ImageObject',
                    'url'   => 'https://xphysio.ch/wp-content/uploads/logo-xphysio.png',
                ],
                'image'    => 'https://xphysio.ch/wp-content/uploads/praxis-xphysio.jpg',
                'telephone'    => '+41775330844',
                'email'        => 'xphysio@hin.physio',
                'address'      => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => 'Breitistrasse 25',
                    'postalCode'      => '8623',
                    'addressLocality' => 'Wetzikon',
                    'addressRegion'   => 'ZH',
                    'addressCountry'  => 'CH',
                ],
                'geo' => [
                    '@type'     => 'GeoCoordinates',
                    'latitude'  => 47.3209,
                    'longitude' => 8.7992,
                ],
                'hasMap'   => 'https://maps.google.com/?q=Breitistrasse+25,+8623+Wetzikon',
                'openingHoursSpecification' => [
                    [
                        '@type'     => 'OpeningHoursSpecification',
                        'dayOfWeek' => [ 'Tuesday' ],
                        'opens'     => '08:00',
                        'closes'    => '12:00',
                    ],
                    [
                        '@type'     => 'OpeningHoursSpecification',
                        'dayOfWeek' => [ 'Tuesday' ],
                        'opens'     => '13:00',
                        'closes'    => '16:30',
                    ],
                    [
                        '@type'     => 'OpeningHoursSpecification',
                        'dayOfWeek' => [ 'Thursday' ],
                        'opens'     => '14:00',
                        'closes'    => '17:00',
                    ],
                ],
                'priceRange'         => 'CHF 65–580',
                'currenciesAccepted' => 'CHF',
                'paymentAccepted'    => 'Krankenkasse, Bar, Rechnung, Twint',
                'areaServed'         => [
                    [ '@type' => 'City', 'name' => 'Wetzikon' ],
                    [ '@type' => 'City', 'name' => 'Hinwil' ],
                    [ '@type' => 'City', 'name' => 'Rüti' ],
                    [ '@type' => 'City', 'name' => 'Uster' ],
                    [ '@type' => 'AdministrativeArea', 'name' => 'Zürcher Oberland' ],
                ],
                'availableService' => [
                    [
                        '@type'       => 'MedicalTherapy',
                        'name'        => 'Physiotherapie',
                        'description' => 'Krankenkassenpflichtige Physiotherapie nach ärztlicher Verordnung in Wetzikon ZH',
                        'offers'      => [
                            '@type'         => 'Offer',
                            'price'         => '65',
                            'priceCurrency' => 'CHF',
                            'description'   => 'Sitzung à 25 Minuten',
                        ],
                    ],
                    [
                        '@type'       => 'MedicalTherapy',
                        'name'        => 'Medizinische Trainingstherapie (MTT)',
                        'description' => 'Gerätegestütztes Kraft- und Ausdauertraining zur Rehabilitation – kassenpflichtig',
                    ],
                    [
                        '@type'  => 'Service',
                        'name'   => 'Personal Training',
                        'offers' => [
                            '@type'         => 'Offer',
                            'price'         => '165',
                            'priceCurrency' => 'CHF',
                            'description'   => 'Sitzung à 60 Minuten',
                        ],
                    ],
                    [
                        '@type'       => 'MedicalTherapy',
                        'name'        => 'Neuroathletik',
                        'description' => 'Neuroathletisches Training zur Leistungsoptimierung, Schmerzreduktion und Verletzungsprävention',
                        'offers'      => [
                            '@type'         => 'Offer',
                            'price'         => '165',
                            'priceCurrency' => 'CHF',
                        ],
                    ],
                    [
                        '@type'  => 'Service',
                        'name'   => 'Ernährungs-Coaching (RP Nutrition)',
                        'offers' => [
                            '@type'         => 'Offer',
                            'price'         => '580',
                            'priceCurrency' => 'CHF',
                            'description'   => '12-Wochen-Coaching-Programm',
                        ],
                    ],
                    [
                        '@type'       => 'MedicalTherapy',
                        'name'        => 'kPNI – Klinische Psychoneuroimmunologie',
                        'description' => 'Ganzheitliche Therapie, die Psyche, Nervensystem, Immunsystem und Hormonsystem verbindet',
                        'offers'      => [
                            '@type'         => 'Offer',
                            'price'         => '165',
                            'priceCurrency' => 'CHF',
                        ],
                    ],
                ],
                'employee' => [
                    '@type'    => 'Person',
                    '@id'      => 'https://xphysio.ch/ueber-mich/#person',
                    'name'     => 'Michaela Tobler',
                    'jobTitle' => 'Physiotherapeutin, Neuroathletik Coach, kPNI Therapeutin',
                ],
                'sameAs' => [
                    'https://physioswiss.ch/praxen/136014/xphysio-physiotherapie-in-wetzikon/',
                    'https://search.ch/tel/wetzikon/breitistrasse-25/x-physio-m-tobler',
                    'https://www.local.ch/de/d/wetzikon-zh/8623/x-physio-m-tobler-ixMbo_5RDFoklAyqgUanGg',
                ],
            ],
            // ── 3b. Website ───────────────────────────────────────────────
            [
                '@type'          => 'WebSite',
                '@id'            => 'https://xphysio.ch/#website',
                'url'            => 'https://xphysio.ch',
                'name'           => 'xphysio – Physiotherapie Wetzikon',
                'publisher'      => [ '@id' => 'https://xphysio.ch/#business' ],
                'potentialAction' => [
                    '@type'       => 'SearchAction',
                    'target'      => [
                        '@type'       => 'EntryPoint',
                        'urlTemplate' => 'https://xphysio.ch/?s={search_term_string}',
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
                'inLanguage' => 'de-CH',
            ],
        ],
    ];

    echo "\n" . '<script type="application/ld+json">'
        . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
        . '</script>' . "\n";
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. SCHEMA.ORG – SEITENSPEZIFISCH
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_head', 'xphysio_page_schema', 10 );
function xphysio_page_schema() {

    // ── STARTSEITE: FAQPage ──────────────────────────────────────────────────
    if ( is_front_page() ) {
        $faq = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => [
                [
                    '@type'          => 'Question',
                    'name'           => 'Brauche ich eine ärztliche Verordnung für Physiotherapie in Wetzikon?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Für kassenpflichtige Physiotherapie benötigen Sie eine ärztliche Verordnung. Privatleistungen wie Personal Training, Neuroathletik oder Ernährungs-Coaching können ohne Verordnung direkt gebucht werden.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Wie lange dauert eine Physiotherapie-Sitzung bei xphysio?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Eine Standard-Physiotherapie-Sitzung dauert 25 Minuten (CHF 65). Personal Training, Neuroathletik und kPNI sind als 60-Minuten-Termine (CHF 165) geplant.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Welche Krankenkasse übernimmt Physiotherapie-Kosten?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Die Grundversicherung (KVG) und Unfallversicherung (UVG) übernehmen Physiotherapie bei ärztlicher Verordnung. Viele Zusatzversicherungen decken auch Präventionsleistungen. Sprechen Sie bitte mit Ihrer Krankenkasse.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Wo liegt die Physiotherapie-Praxis xphysio?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'xphysio befindet sich an der Breitistrasse 25, 8623 Wetzikon ZH – im Zürcher Oberland. Gut erreichbar mit öffentlichem Verkehr und mit Parkplatz.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Was ist Neuroathletik?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Neuroathletik verbindet neurowissenschaftliche Erkenntnisse mit Bewegungstraining. Da das Gehirn alle Bewegungen steuert, verbessert gezieltes Nervensystem-Training Kraft, Koordination und reduziert Schmerzen nachhaltig.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Was bedeutet kPNI?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'kPNI steht für Klinische Psychoneuroimmunologie – eine ganzheitliche Therapieform, die Zusammenhänge zwischen Psyche, Nervensystem, Immunsystem und Hormonen nutzt. Besonders wirksam bei chronischen Beschwerden und Burnout.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Kann ich online einen Termin buchen?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja! Unter xphysio.ch/online-buchen können Sie direkt über Medidoc einen Termin wählen. Alternativ per E-Mail: xphysio@hin.physio oder Telefon: +41 77 533 08 44.' ],
                ],
            ],
        ];
        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $faq, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }

    // ── ÜBER MICH: Person ────────────────────────────────────────────────────
    if ( is_page( 'ueber-mich' ) ) {
        $person = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Person',
            '@id'           => 'https://xphysio.ch/ueber-mich/#person',
            'name'          => 'Michaela Tobler',
            'givenName'     => 'Michaela',
            'familyName'    => 'Tobler',
            'jobTitle'      => 'Physiotherapeutin',
            'description'   => 'Michaela Tobler ist Physiotherapeutin in Wetzikon ZH mit über 20 Jahren Erfahrung. Spezialisierung in Maitland, Mulligan, Neuroathletik, kPNI und RP-Nutrition.',
            'worksFor'      => [
                '@type' => 'MedicalBusiness',
                '@id'   => 'https://xphysio.ch/#business',
            ],
            'address' => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Wetzikon',
                'addressRegion'   => 'ZH',
                'addressCountry'  => 'CH',
            ],
            'hasCredential' => [
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'Physiotherapeutin' ],
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'Maitland-Konzept (IMTA Level 1+2)' ],
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'Mulligan-Konzept (MWM)' ],
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'Neuroathletik-Trainerin (Z-Health)' ],
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'kPNI Therapeutin' ],
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'RP-Nutrition Coach' ],
            ],
            'knowsAbout' => [
                'Physiotherapie', 'Neuroathletik', 'kPNI', 'Ernährungsberatung',
                'Maitland-Konzept', 'Mulligan MWM', 'MTT', 'Schmerztherapie',
            ],
        ];
        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $person, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }

    // ── BEHANDLUNGSMETHODEN: ItemList ────────────────────────────────────────
    if ( is_page( 'behandlungsmethoden' ) ) {
        $methods = [
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => 'Behandlungsmethoden – xphysio Wetzikon',
            'itemListElement' => [
                [ '@type' => 'ListItem', 'position' => 1, 'item' => [
                    '@type' => 'MedicalTherapy', 'name' => 'Maitland-Konzept',
                    'description' => 'Manuelle Gelenk- und Weichteilmobilisation nach Geoffrey Maitland – passiv, präzise, schonend für Wirbelsäule und Extremitäten.',
                ]],
                [ '@type' => 'ListItem', 'position' => 2, 'item' => [
                    '@type' => 'MedicalTherapy', 'name' => 'Mulligan-Konzept (MWM)',
                    'description' => 'Mobilisation mit Bewegung (Mobilisation With Movement) – gezielte Gelenkkorrektur mit aktiver Bewegung für sofortige Schmerzreduktion.',
                ]],
                [ '@type' => 'ListItem', 'position' => 3, 'item' => [
                    '@type' => 'MedicalTherapy', 'name' => 'Neuroathletik',
                    'description' => 'Neuroathletisches Training – das Nervensystem und Gehirn als Schaltzentrale trainieren für bessere Bewegung, Koordination und Schmerzfreiheit.',
                ]],
                [ '@type' => 'ListItem', 'position' => 4, 'item' => [
                    '@type' => 'MedicalTherapy', 'name' => 'kPNI – Klinische Psychoneuroimmunologie',
                    'description' => 'Ganzheitlicher Therapieansatz: Entzündungen, Stressmuster und Dysbalancen zwischen Psyche, Nerven- und Immunsystem behandeln.',
                ]],
                [ '@type' => 'ListItem', 'position' => 5, 'item' => [
                    '@type' => 'MedicalTherapy', 'name' => 'Medizinische Trainingstherapie (MTT)',
                    'description' => 'Gerätegestütztes Kraft- und Ausdauertraining zur Rehabilitation – krankenkassenpflichtig mit Verordnung.',
                ]],
                [ '@type' => 'ListItem', 'position' => 6, 'item' => [
                    '@type' => 'Service', 'name' => 'RP-Nutrition Coaching',
                    'description' => '12-Wochen Ernährungscoaching nach Renaissance Periodization für nachhaltige Körperkomposition und Leistungssteigerung.',
                ]],
            ],
        ];
        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $methods, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }

    // ── ANGEBOT: ItemList mit Preisen ────────────────────────────────────────
    if ( is_page( 'angebot' ) ) {
        $offers = [
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => 'Leistungen & Preise – xphysio Wetzikon',
            'itemListElement' => [
                [ '@type' => 'ListItem', 'position' => 1, 'item' => [
                    '@type' => 'Offer',
                    'name'  => 'Physiotherapie (Kassenleistung)',
                    'price' => '65', 'priceCurrency' => 'CHF',
                    'description' => 'Sitzung à 25 Minuten, kassenpflichtig mit ärztlicher Verordnung',
                ]],
                [ '@type' => 'ListItem', 'position' => 2, 'item' => [
                    '@type' => 'Offer', 'name' => 'Personal Training',
                    'price' => '165', 'priceCurrency' => 'CHF',
                    'description' => 'Sitzung à 60 Minuten, individuell auf Ihre Ziele abgestimmt',
                ]],
                [ '@type' => 'ListItem', 'position' => 3, 'item' => [
                    '@type' => 'Offer', 'name' => 'Neuroathletik',
                    'price' => '165', 'priceCurrency' => 'CHF',
                    'description' => 'Sitzung à 60 Minuten',
                ]],
                [ '@type' => 'ListItem', 'position' => 4, 'item' => [
                    '@type' => 'Offer', 'name' => 'kPNI',
                    'price' => '165', 'priceCurrency' => 'CHF',
                    'description' => 'Sitzung à 60 Minuten',
                ]],
                [ '@type' => 'ListItem', 'position' => 5, 'item' => [
                    '@type' => 'Offer', 'name' => 'Ernährungs-Coaching RP Nutrition (12 Wochen)',
                    'price' => '580', 'priceCurrency' => 'CHF',
                    'description' => '12-Wochen-Programm inkl. Plan, App-Zugang und wöchentlichem Check-in',
                ]],
            ],
        ];
        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $offers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }

    // ── BLOG-POST: Article ───────────────────────────────────────────────────
    if ( is_single() && get_post_type() === 'post' ) {
        $article = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            '@id'              => get_permalink() . '#article',
            'headline'         => get_the_title(),
            'url'              => get_permalink(),
            'datePublished'    => get_the_date( 'c' ),
            'dateModified'     => get_the_modified_date( 'c' ),
            'author'           => [
                '@type' => 'Person',
                '@id'   => 'https://xphysio.ch/ueber-mich/#person',
                'name'  => 'Michaela Tobler',
            ],
            'publisher'        => [
                '@id' => 'https://xphysio.ch/#business',
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => get_permalink(),
            ],
        ];

        if ( has_post_thumbnail() ) {
            $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            if ( $img ) {
                $article['image'] = [
                    '@type'  => 'ImageObject',
                    'url'    => $img[0],
                    'width'  => $img[1],
                    'height' => $img[2],
                ];
            }
        }

        $excerpt = get_the_excerpt();
        if ( $excerpt ) {
            $article['description'] = wp_strip_all_tags( $excerpt );
        }

        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $article, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }

    // ── KONTAKT: MedicalBusiness ──────────────────────────────────────────────
    if ( is_page( 'kontakt' ) ) {
        $booking = [
            '@context'  => 'https://schema.org',
            '@type'     => 'MedicalBusiness',
            'name'      => 'xphysio – Kontakt & Terminanfrage Wetzikon',
            'url'       => 'https://xphysio.ch/kontakt/',
            'telephone' => '+41775330844',
            'email'     => 'xphysio@hin.physio',
            'address'   => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Breitistrasse 25',
                'postalCode'      => '8623',
                'addressLocality' => 'Wetzikon',
                'addressCountry'  => 'CH',
            ],
        ];
        echo "\n" . '<script type="application/ld+json">'
            . wp_json_encode( $booking, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
            . '</script>' . "\n";
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 4c. HEADER NAV FARBEN – nach Neve's Inline-CSS ausgeben (Priority 999)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_head', 'xphysio_nav_colors', 999 );
function xphysio_nav_colors() {
    ?>
<style id="xphysio-nav-colors">
/* ── Neve CSS-Variable absichern – Customizer-Reset-sicher ── */
.builder-item--primary-menu {
    --activecolor: #dff2ff !important;
    --hovertextcolor: #dff2ff !important;
}

/* ── Desktop-Nav: weisse Links im Navy-Header ── */
/* Nur wenn NICHT in der Mobile-Sidebar */
.hfg-header:not(.mobile-sidebar-open) .nav-ul li .wrap a,
.hfg-header:not(.mobile-sidebar-open) .nav-ul li .wrap a:visited {
    color: #ffffff !important;
}

/* Hover & Fokus (Desktop) – nicht für CTA-Button */
.hfg-header .nav-ul li:not(.menu-cta):hover .wrap a,
.hfg-header .nav-ul li:not(.menu-cta) .wrap a:hover,
.hfg-header .nav-ul li:not(.menu-cta) .wrap a:focus {
    color: #dff2ff !important;
    background: transparent !important;
}

/* Aktive Seite (Desktop) */
.hfg-header .nav-ul li.nv-active .wrap a,
.hfg-header .nav-ul li.current-menu-item .wrap a,
.hfg-header .nav-ul li.current_page_item .wrap a,
.hfg-header .nav-ul li.current-menu-ancestor .wrap a {
    color: #dff2ff !important;
    border-bottom: 2px solid #dff2ff !important;
    padding-bottom: 2px !important;
}

/* ── Mobile Sidebar: dunkle Links auf hellem Hintergrund ── */
.header-menu-sidebar-bg .nav-ul li:not(.menu-cta) .wrap a,
.header-menu-sidebar-bg .nav-ul li:not(.menu-cta) .wrap a:visited {
    color: #1e2761 !important;
}
.header-menu-sidebar-bg .nav-ul li:not(.menu-cta) .wrap a:hover {
    color: #7a2048 !important;
}
/* Aktive Seite in Mobile Sidebar: Bordeaux (nicht Hellblau – weisser Hintergrund!) */
.header-menu-sidebar-bg .nav-ul li.current-menu-item:not(.menu-cta) .wrap a,
.header-menu-sidebar-bg .nav-ul li.current_page_item:not(.menu-cta) .wrap a,
.header-menu-sidebar-bg .nav-ul li.nv-active:not(.menu-cta) .wrap a {
    color: #7a2048 !important;
    font-weight: 600;
    border-bottom: none !important;
}

/* ── CTA-Button «Termin buchen» im Header (Desktop & Mobile) ── */
.nav-ul li.menu-cta,
.nav-ul li.menu-cta .wrap {
    display: flex !important;
    align-items: center !important;
    align-self: center !important;
}
.nav-ul li.menu-cta .wrap a,
.nav-ul li.menu-cta .wrap a:visited {
    background: #7a2048 !important;
    color: #ffffff !important;
    padding: 6px 18px !important;
    border-radius: 6px !important;
    font-weight: 600 !important;
    border-bottom: none !important;
    transition: background 0.2s ease !important;
    display: inline-block !important;
    line-height: 1.4 !important;
}
.nav-ul li.menu-cta .wrap a:hover,
.nav-ul li.menu-cta .wrap a:focus {
    background: #5e1836 !important;
    color: #ffffff !important;
}
</style>
    <?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. CONTACT FORM 7 – nur auf Kontaktseite laden
// ─────────────────────────────────────────────────────────────────────────────
// CF7 lädt sonst auf allen Seiten: wp-hooks + wp-i18n + swv + cf7 = render-blocking Chain
add_action( 'wp_enqueue_scripts', 'xphysio_dequeue_cf7_selectively', 99 );
function xphysio_dequeue_cf7_selectively() {
    if ( is_page( 'kontakt' ) ) return; // CF7-Formular nur hier
    wp_dequeue_script( 'swv' );
    wp_deregister_script( 'swv' );
    wp_dequeue_script( 'contact-form-7' );
    wp_deregister_script( 'contact-form-7' );
    wp_dequeue_style( 'contact-form-7' );
    wp_deregister_style( 'contact-form-7' );
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. GOOGLE TAG MANAGER – GTM-PTL8GNJS
// ─────────────────────────────────────────────────────────────────────────────
// Snippet 1: <head> – lazy load nach erster Interaktion ODER 2 Sekunden
// Grund: GTM lädt 121KB JS, davon 60KB unused bei initialem Seitenaufruf.
// Lazy loading entfernt GTM aus dem kritischen Render-Pfad (FCP/LCP/TBT).
// Pageview-Event wird korrekt erfasst, da gtm.js spätestens nach 2s lädt.
add_action( 'wp_head', 'xphysio_gtm_head', 1 );
function xphysio_gtm_head() {
    ?>
<!-- Google Tag Manager – lazy load -->
<script>
(function(){
  var gtmLoaded=false;
  function loadGTM(){
    if(gtmLoaded)return; gtmLoaded=true;
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PTL8GNJS');
  }
  ['scroll','click','keydown','touchstart','mouseover'].forEach(function(e){
    window.addEventListener(e,loadGTM,{once:true,passive:true});
  });
  setTimeout(loadGTM,2000);
})();
</script>
<!-- End Google Tag Manager -->
    <?php
}

// Snippet 2: direkt nach <body> (noscript-Fallback)
add_action( 'wp_body_open', 'xphysio_gtm_body', 1 );
function xphysio_gtm_body() {
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTL8GNJS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. BOOKING-WIDGET SHORTCODE  →  [xphysio_booking]
// ─────────────────────────────────────────────────────────────────────────────
add_shortcode( 'xphysio_booking', 'xphysio_booking_shortcode' );
function xphysio_booking_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'width'  => '1150',
        'height' => '1000',
    ], $atts, 'xphysio_booking' );

    $width  = absint( $atts['width'] );
    $height = absint( $atts['height'] );

    ob_start();
    ?>
<div class="booking-widget-wrapper">
    <iframe
        src="https://onlinecalendar.medidoc.ch/BookAppointment?cgid=iRbKTRhcMUCaJqT_hUccRg&ssid=mQn5AH47dEij__eiQCnICQ"
        width="<?php echo $width; ?>"
        height="<?php echo $height; ?>"
        allow="fullscreen"
        scrolling="no"
        title="Online-Terminbuchung xphysio Wetzikon – powered by Medidoc"
        loading="lazy"
        style="border:0;display:block;max-width:100%;">
    </iframe>
</div>
    <?php
    return ob_get_clean();
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. FAQ-AKKORDEON (Vanilla JS – kein jQuery-Overhead)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_footer', 'xphysio_faq_script' );
function xphysio_faq_script() {
    ?>
<script>
(function () {
    // ARIA-IDs dynamisch setzen (Barrierefreiheit WCAG 4.1.2)
    document.querySelectorAll('.faq-item').forEach(function (item, i) {
        var btn = item.querySelector('.faq-question');
        var ans = item.querySelector('.faq-answer');
        if (!btn || !ans) return;
        var id = 'faq-answer-' + i;
        ans.id = id;
        ans.setAttribute('role', 'region');
        btn.setAttribute('aria-controls', id);
    });

    document.querySelectorAll('.faq-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = this.closest('.faq-item');
            var isOpen = item.classList.contains('open');
            // Alle schliessen
            document.querySelectorAll('.faq-item.open').forEach(function (el) {
                el.classList.remove('open');
                el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            });
            // Dieses öffnen (falls vorher geschlossen)
            if (!isOpen) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
})();
</script>
    <?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. NEVE-FEINSCHLIFF & ALLGEMEIN
// ─────────────────────────────────────────────────────────────────────────────

// ─────────────────────────────────────────────────────────────────────────────
// 9. DOCUMENT TITLE – Browser-Tab
// ─────────────────────────────────────────────────────────────────────────────
add_filter( 'document_title_parts', 'xphysio_document_title' );
function xphysio_document_title( $parts ) {
    $parts['site'] = 'xphysio Physiotherapie in Wetzikon';
    if ( is_front_page() ) {
        return [ 'title' => 'xphysio Physiotherapie in Wetzikon' ];
    }
    return $parts;
}

add_filter( 'document_title_separator', function() { return '|'; } );

// Excerpt kürzer
add_filter( 'excerpt_length', function () { return 22; }, 999 );
add_filter( 'excerpt_more',   function () { return ' …'; } );

// Neve Breadcrumbs aktivieren
add_theme_support( 'neve-breadcrumbs' );

// RankMath BreadcrumbList-Fix: Startseite entfernen + name-Feld auf ListItem-Ebene sicherstellen
// Fehler: Google meldet "Unbenanntes Element" wenn name nur in item{} steckt, nicht auf ListItem-Ebene
add_filter( 'rank_math/json_ld', 'xphysio_fix_rankmath_breadcrumb', 99 );
function xphysio_fix_rankmath_breadcrumb( $data ) {
    foreach ( $data as $key => $item ) {
        if ( ! isset( $item['@type'] ) || $item['@type'] !== 'BreadcrumbList' ) continue;

        // Startseite: einzelnes "Home"-Item hat keinen SEO-Wert → entfernen
        if ( is_front_page() ) {
            unset( $data[ $key ] );
            continue;
        }

        // Alle anderen Seiten: name auf ListItem-Ebene sicherstellen
        if ( ! empty( $item['itemListElement'] ) ) {
            foreach ( $item['itemListElement'] as $i => $list_item ) {
                if ( empty( $list_item['name'] ) && ! empty( $list_item['item']['name'] ) ) {
                    $data[ $key ]['itemListElement'][ $i ]['name'] = $list_item['item']['name'];
                }
            }
        }
    }
    return $data;
}

// Title-Tag Support
add_theme_support( 'title-tag' );

// Beitragsbilder
add_theme_support( 'post-thumbnails' );
add_image_size( 'xphysio-card', 600, 400, true );
add_image_size( 'xphysio-hero', 1400, 700, true );

// Navigationsmenus registrieren
register_nav_menus( [
    'primary'   => __( 'Hauptnavigation', 'neve-child' ),
    'footer'    => __( 'Footer-Navigation', 'neve-child' ),
] );

// Performance: Header-Logo src + srcset auf WebP umschreiben
add_filter( 'wp_get_attachment_image_attributes', 'xphysio_logo_webp_attrs', 10, 2 );
function xphysio_logo_webp_attrs( $attr, $attachment ) {
    $logo_id = (int) get_theme_mod( 'custom_logo' );
    if ( ! $logo_id || $attachment->ID !== $logo_id ) return $attr;

    // src → .webp (Existenz-Check)
    if ( ! empty( $attr['src'] ) ) {
        $webp = preg_replace( '/\.(png|jpe?g)$/i', '.webp', $attr['src'] );
        $path = str_replace( home_url( '/' ), ABSPATH, $webp );
        if ( file_exists( $path ) ) $attr['src'] = $webp;
    }
    // srcset → alle PNG/JPG-Einträge durch WebP ersetzen
    if ( ! empty( $attr['srcset'] ) ) {
        $attr['srcset'] = preg_replace_callback(
            '/(\S+)\.(png|jpe?g)(\s)/i',
            function ( $m ) {
                $webp = $m[1] . '.webp' . $m[3];
                $path = str_replace( home_url( '/' ), ABSPATH, $m[1] . '.webp' );
                return file_exists( $path ) ? $webp : $m[0];
            },
            $attr['srcset']
        );
    }
    // sizes: Logo wird via CSS auf 120px (--maxwidth) beschränkt.
    // Mit 120px wählt Browser bei 2x DPR → 300w (genug Schärfe), spart Bandbreite.
    $attr['sizes'] = '120px';
    return $attr;
}

/// wp-hooks / wp-i18n / wp-polyfill defer deaktiviert:
// wp-i18n liest wp.hooks synchron → CF7 bricht sonst mit "wp is not defined"

// Accessibility: aria-current="page" auf aktivem Menüpunkt (WCAG 4.1.2)
add_filter( 'nav_menu_link_attributes', 'xphysio_aria_current', 10, 3 );
function xphysio_aria_current( $atts, $item, $args ) {
    if ( in_array( 'current-menu-item', (array) $item->classes ) ) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}

// robots.txt anpassen (AI-Bots + Sitemap)
add_filter( 'robots_txt', 'xphysio_robots_txt', 10, 2 );
function xphysio_robots_txt( $output, $public ) {
    $output .= "\n# AI-Crawler – explizit erlaubt\n";
    $output .= "User-agent: GPTBot\nAllow: /\n\n";
    $output .= "User-agent: ClaudeBot\nAllow: /\n\n";
    $output .= "User-agent: PerplexityBot\nAllow: /\n\n";
    $output .= "User-agent: Google-Extended\nAllow: /\n\n";
    $output .= "User-agent: Applebot-Extended\nAllow: /\n\n";
    $output .= "User-agent: cohere-ai\nAllow: /\n";
    return $output;
}

// Sicherheit: XML-RPC deaktivieren
add_filter( 'xmlrpc_enabled', '__return_false' );

// Sicherheit: WordPress-Version ausblenden
remove_action( 'wp_head', 'wp_generator' );

// Performance: Emoji-Support deaktivieren (spart ~50-100ms / unnötiger Script-Load)
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );
remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );
add_filter( 'emoji_svg_url', '__return_false' );

// Kommentare im Feed ausblenden
add_filter( 'feed_links_show_comments_feed', '__return_false' );

// Neve: Sticky Header Navy-Hintergrund beibehalten
add_filter( 'neve_sticky_header_on_scroll', '__return_true' );

// ─────────────────────────────────────────────────────────────────────────────
// 8. BLOG – ZURÜCK-LINK & META-INFO (oberhalb + unterhalb des Artikels)
// ─────────────────────────────────────────────────────────────────────────────
add_filter( 'the_content', 'xphysio_blog_post_wrap' );
function xphysio_blog_post_wrap( $content ) {
    if ( ! is_single() || get_post_type() !== 'post' ) {
        return $content;
    }

    $blog_url    = esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' ) );
    $category    = get_the_category();
    $cat_label   = $category ? esc_html( $category[0]->name ) : '';
    $cat_url     = $category ? esc_url( get_category_link( $category[0]->term_id ) ) : '';
    $read_time   = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( $content ) ) / 200 ) );
    $date        = get_the_date( 'd. F Y' );

    $before = '<div class="xp-blog-back">
  <a href="' . $blog_url . '" class="xp-back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Zurück zur Blog-Übersicht
  </a>
  <div class="xp-post-meta">
    ' . ( $cat_label ? '<a href="' . $cat_url . '" class="xp-cat-badge">' . $cat_label . '</a>' : '' ) . '
    <span>' . $date . '</span>
    <span>' . $read_time . ' Min. Lesezeit</span>
  </div>
</div>';

    $after = '<div class="xp-blog-back xp-blog-back--bottom">
  <a href="' . $blog_url . '" class="xp-back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Zurück zur Blog-Übersicht
  </a>
</div>';

    return $before . $content . $after;
}

// ============================================================
// 11. SMTP – Ausgehende Mails via hallo@xphysio.ch (Infomaniak)
//     Passwort als Konstante in wp-config.php: SMTP_PASSWORD
// ============================================================
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'mail.infomaniak.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Username   = 'hallo@xphysio.ch';
    $phpmailer->Password   = defined( 'SMTP_PASSWORD' ) ? SMTP_PASSWORD : '';
    $phpmailer->From       = 'hallo@xphysio.ch';
    $phpmailer->FromName   = 'xphysio Wetzikon';
    $phpmailer->addReplyTo( 'xphysio@hin.physio', 'xphysio Wetzikon' );
} );
