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
// 2. GOOGLE FONTS (Lora + Source Sans 3)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', 'xphysio_enqueue_fonts' );
function xphysio_enqueue_fonts() {
    wp_enqueue_style(
        'xphysio-google-fonts',
        'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap',
        [],
        null
    );
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
                'email'        => 'hallo@xphysio.ch',
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
                        'opens'     => '08:30',
                        'closes'    => '16:30',
                    ],
                    [
                        '@type'     => 'OpeningHoursSpecification',
                        'dayOfWeek' => [ 'Thursday' ],
                        'opens'     => '14:30',
                        'closes'    => '18:30',
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
                    'jobTitle' => 'Physiotherapeutin BSc, Neuroathletin, kPNI Therapeutin',
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
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Für kassenpflichtige Physiotherapie benötigen Sie eine ärztliche Verordnung (Arztrezept). Privatleistungen wie Personal Training, Neuroathletik oder Ernährungs-Coaching können ohne Verordnung direkt gebucht werden.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Wie lange dauert eine Physiotherapie-Sitzung bei xphysio?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Eine Standard-Physiotherapie-Sitzung dauert 25 Minuten (CHF 65). Personal Training, Neuroathletik und kPNI sind als 60-Minuten-Termine (CHF 165) geplant.' ],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Welche Krankenkasse übernimmt Physiotherapie-Kosten?',
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Die Grundversicherung (OKP) übernimmt Physiotherapie bei ärztlicher Verordnung. Viele Zusatzversicherungen decken auch Präventionsleistungen. Sprechen Sie bitte mit Ihrer Krankenkasse.' ],
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
                    'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja! Unter xphysio.ch/terminbuchung können Sie direkt über Medidoc einen Termin wählen. Alternativ per Telefon: +41 77 533 08 44 oder E-Mail: hallo@xphysio.ch.' ],
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
            'jobTitle'      => 'Physiotherapeutin BSc',
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
                [ '@type' => 'EducationalOccupationalCredential', 'name' => 'BSc Physiotherapie' ],
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

    // ── TERMINBUCHUNG: MedicalBusiness ───────────────────────────────────────
    if ( is_page( 'terminbuchung' ) ) {
        $booking = [
            '@context'  => 'https://schema.org',
            '@type'     => 'MedicalBusiness',
            'name'      => 'xphysio – Terminbuchung Wetzikon',
            'url'       => 'https://xphysio.ch/terminbuchung/',
            'telephone' => '+41775330844',
            'email'     => 'hallo@xphysio.ch',
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
// 4b. SEO META TAGS (Description, Open Graph, Twitter Card)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_head', 'xphysio_seo_meta', 2 );
function xphysio_seo_meta() {

    // Meta-Descriptions & OG-Daten pro Seite
    $seo = [
        ''                    => [ // Startseite
            'desc'  => 'Physiotherapie, Neuroathletik & Ernährungs-Coaching in Wetzikon ZH. Kassenpflichtig, evidenzbasiert, individuell. Online Termin buchen.',
            'title' => 'Physiotherapie Wetzikon – xphysio | Michaela Tobler',
        ],
        'angebot'             => [
            'desc'  => 'Physiotherapie ab CHF 65 (Kasse), Personal Training & Neuroathletik ab CHF 165. Transparente Preise – Kassenleistungen & Privatleistungen in Wetzikon ZH.',
            'title' => 'Leistungen & Preise | xphysio Physiotherapie Wetzikon',
        ],
        'behandlungsmethoden' => [
            'desc'  => 'Maitland-Konzept, Mulligan MWM, Neuroathletik, kPNI & MTT in Wetzikon ZH. Evidenzbasierte Methoden für nachhaltige Schmerzfreiheit.',
            'title' => 'Behandlungsmethoden | Maitland, Neuroathletik, kPNI – xphysio Wetzikon',
        ],
        'blog'                => [
            'desc'  => 'Fachbeiträge zu Physiotherapie, Neuroathletik, kPNI & Ernährung von Michaela Tobler – Physiotherapeutin BSc in Wetzikon ZH.',
            'title' => 'Blog | Physiotherapie & Gesundheit – xphysio Wetzikon',
        ],
        'ueber-mich'          => [
            'desc'  => 'Michaela Tobler – Physiotherapeutin BSc mit 20+ Jahren Erfahrung in Wetzikon ZH. Spezialisiert auf Maitland, Mulligan, Neuroathletik & kPNI.',
            'title' => 'Über Michaela Tobler | Physiotherapeutin BSc – xphysio Wetzikon',
        ],
        'terminbuchung'           => [
            'desc'  => 'Physiotherapie-Termin online buchen – Di 08:30–16:30, Do 14:30–18:30. Online-Buchung 24/7 über Medidoc. Breitistrasse 25, 8623 Wetzikon ZH.',
            'title' => 'Termin buchen | xphysio Wetzikon – Online 24/7 verfügbar',
        ],
        'datenschutzerklaerung'   => [
            'desc'    => 'Datenschutzerklärung von xphysio – Physiotherapie Wetzikon ZH.',
            'title'   => 'Datenschutzerklärung | xphysio Wetzikon',
            'robots'  => 'noindex,follow',
        ],
        'agb'                     => [
            'desc'    => 'AGB & Impressum von xphysio – Physiotherapie Wetzikon ZH.',
            'title'   => 'AGB & Impressum | xphysio Wetzikon',
            'robots'  => 'noindex,follow',
        ],
    ];

    // Aktuelle Seite ermitteln
    if ( is_front_page() ) {
        $slug = '';
    } elseif ( is_home() ) {
        // Blog-Archiv (Posts-Page) – get_queried_object() gibt die Seite zurück
        $blog_page = get_option( 'page_for_posts' );
        $slug = $blog_page ? get_post( $blog_page )->post_name : 'blog';
    } else {
        $slug = get_post() ? get_post()->post_name : '';
    }
    $data = $seo[ $slug ] ?? null;
    if ( ! $data ) return;

    $desc      = esc_attr( $data['desc'] );
    $og_title  = esc_attr( $data['title'] );
    $robots    = isset( $data['robots'] ) ? esc_attr( $data['robots'] ) : 'index,follow';
    $og_image  = esc_url( home_url( '/wp-content/uploads/2026/03/Logo-und-Schrift-blau-auf-transparent-1-1024x282-1.png' ) );
    $og_url    = esc_url( get_permalink() );
    $site_name = 'xphysio – Physiotherapie Wetzikon';

    echo "\n<!-- xphysio SEO Meta -->\n";
    echo "<meta name=\"robots\" content=\"{$robots}\">\n";
    echo "<meta name=\"description\" content=\"{$desc}\">\n";
    if ( $robots === 'index,follow' ) {
        echo "<meta property=\"og:title\" content=\"{$og_title}\">\n";
        echo "<meta property=\"og:description\" content=\"{$desc}\">\n";
        echo "<meta property=\"og:url\" content=\"{$og_url}\">\n";
        echo "<meta property=\"og:image\" content=\"{$og_image}\">\n";
        echo "<meta property=\"og:type\" content=\"website\">\n";
        echo "<meta property=\"og:site_name\" content=\"{$site_name}\">\n";
        echo "<meta property=\"og:locale\" content=\"de_CH\">\n";
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        echo "<meta name=\"twitter:title\" content=\"{$og_title}\">\n";
        echo "<meta name=\"twitter:description\" content=\"{$desc}\">\n";
        echo "<meta name=\"twitter:image\" content=\"{$og_image}\">\n";
    }
    echo "<!-- /xphysio SEO Meta -->\n\n";
}

// ─────────────────────────────────────────────────────────────────────────────
// 4c. HEADER NAV FARBEN – nach Neve's Inline-CSS ausgeben (Priority 999)
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_head', 'xphysio_nav_colors', 999 );
function xphysio_nav_colors() {
    ?>
<style id="xphysio-nav-colors">
/* Neve Nav: Struktur ist li > div.wrap > a  (nicht li > a!) */

/* Standard: weiss */
.nav-ul li .wrap a,
.nav-ul li .wrap a:visited {
    color: #ffffff !important;
}

/* Hover: Hellblau – li erhält :hover, a bekommt neue Farbe */
.nav-ul li:hover .wrap a,
.nav-ul li .wrap a:hover,
.nav-ul li .wrap a:focus {
    color: #dff2ff !important;
    background: transparent !important;
}

/* Aktive Seite (Neve setzt .nv-active auf das li) */
.nav-ul li.nv-active .wrap a,
.nav-ul li.current-menu-item .wrap a,
.nav-ul li.current_page_item .wrap a,
.nav-ul li.current-menu-ancestor .wrap a {
    color: #dff2ff !important;
    border-bottom: 2px solid #dff2ff !important;
    padding-bottom: 2px !important;
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
    document.querySelectorAll('.faq-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = this.closest('.faq-item');
            var isOpen = item.classList.contains('open');
            // Alle schliessen
            document.querySelectorAll('.faq-item.open').forEach(function (el) {
                el.classList.remove('open');
            });
            // Dieses öffnen (falls vorher geschlossen)
            if (!isOpen) item.classList.add('open');
        });
    });
})();
</script>
    <?php
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. NEVE-FEINSCHLIFF & ALLGEMEIN
// ─────────────────────────────────────────────────────────────────────────────

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

// Sicherheit: XML-RPC deaktivieren
add_filter( 'xmlrpc_enabled', '__return_false' );

// Sicherheit: WordPress-Version ausblenden
remove_action( 'wp_head', 'wp_generator' );

// Kommentare im Feed ausblenden
add_filter( 'feed_links_show_comments_feed', '__return_false' );

// Neve: Sticky Header Navy-Hintergrund beibehalten
add_filter( 'neve_sticky_header_on_scroll', '__return_true' );
