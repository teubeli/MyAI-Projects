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
 *   4. Matomo Tracking (cookieless, DSGVO/DSG CH-konform)
 *   5. Booking-Widget Shortcode [xphysio_booking]
 *   6. FAQ-Akkordeon (Vanilla JS)
 *   7. Neve-Feinschliff
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─────────────────────────────────────────────────────────────────────────────
// 1. PARENT THEME STYLES
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', 'xphysio_enqueue_styles' );
function xphysio_enqueue_styles() {
    // Neve Parent CSS
    wp_enqueue_style(
        'neve-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( get_template() )->get( 'Version' )
    );
    // Child Theme CSS (überschreibt Neve)
    wp_enqueue_style(
        'neve-child-style',
        get_stylesheet_uri(),
        [ 'neve-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
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
}

add_action( 'wp_head', 'xphysio_fonts_async', 3 );
function xphysio_fonts_async() {
    $url = 'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap';
    echo '<link rel="preload" href="' . esc_url( $url ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . esc_url( $url ) . '"></noscript>' . "\n";
}

// Preconnect + LCP-Preload (Priority 1 = ganz oben im <head>)
add_action( 'wp_head', 'xphysio_font_preconnect', 1 );
function xphysio_font_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
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
                    'https://www.instagram.com/xphysio.ch',
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
// 5. MATOMO – DSGVO/DSG-KONFORM (cookieless, self-hosted)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_footer', 'xphysio_matomo_tracking' );
function xphysio_matomo_tracking() {
    // TODO nach Matomo-Installation: URL und Site-ID anpassen
    // Matomo URL Beispiel: https://matomo.xphysio.ch/
    // Keine Cookies → kein Cookie-Banner nötig (CH DSG)
    ?>
<!-- Matomo (cookieless – DSG CH-konform) -->
<script>
var _paq = window._paq = window._paq || [];
_paq.push(['disableCookies']);       // kein Cookie = kein Banner nötig
_paq.push(['setDoNotTrack', true]);  // DNT respektieren
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function () {
    var u = "https://matomo.xphysio.ch/"; /* TODO: Matomo-URL anpassen */
    _paq.push(['setTrackerUrl', u + 'matomo.php']);
    _paq.push(['setSiteId', '1']); /* TODO: Site-ID anpassen */
    var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.async = true;
    g.src = u + 'matomo.js';
    s.parentNode.insertBefore(g, s);
})();
</script>
<!-- End Matomo -->
    <?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. BOOKING-WIDGET SHORTCODE  →  [xphysio_booking]
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
