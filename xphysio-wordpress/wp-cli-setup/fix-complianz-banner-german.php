<?php
/**
 * Fix Complianz cookie banner language to German
 * Bannertext ist in wp_cmplz_cookiebanners gespeichert – nicht via gettext übersetzt.
 */

global $wpdb;
$table = $wpdb->prefix . 'cmplz_cookiebanners';

$de_message = 'Um Ihnen ein optimales Erlebnis zu bieten, verwenden wir Technologien wie Cookies, um Geräteinformationen zu speichern bzw. darauf zuzugreifen. Wenn Sie diesen Technologien zustimmen, können wir Daten wie das Surfverhalten oder eindeutige IDs auf dieser Website verarbeiten. Wenn Sie Ihre Zustimmung nicht erteilen oder zurückziehen, können bestimmte Merkmale und Funktionen beeinträchtigt werden.';

$de_functional_text   = 'Der Zugriff oder die technische Speicherung ist unbedingt für den rechtmäßigen Zweck erforderlich, um die Nutzung eines bestimmten Dienstes zu ermöglichen, der vom Abonnenten oder Nutzer ausdrücklich angefordert wurde, oder für den alleinigen Zweck der Übertragung einer Nachricht über ein elektronisches Kommunikationsnetz.';
$de_statistics_text   = 'Die technische Speicherung oder der Zugriff, der ausschließlich zu statistischen Zwecken erfolgt.';
$de_stats_anon_text   = 'Die technische Speicherung oder der Zugriff, der ausschließlich zu anonymen statistischen Zwecken verwendet wird. Ohne eine Aufforderung, die freiwillige Zustimmung Ihres Internetdienstanbieters oder zusätzliche Aufzeichnungen von Dritten können die zu diesem Zweck gespeicherten oder abgerufenen Informationen allein in der Regel nicht zu Ihrer Identifizierung verwendet werden.';
$de_preferences_text  = 'Die technische Speicherung oder der Zugriff ist für den rechtmäßigen Zweck der Speicherung von Voreinstellungen erforderlich, die nicht vom Abonnenten oder Nutzer beantragt wurden.';
$de_marketing_text    = 'Die technische Speicherung oder der Zugriff ist erforderlich, um Nutzerprofile zu erstellen, um Werbung zu versenden oder um den Nutzer auf einer Website oder über mehrere Websites hinweg zu ähnlichen Marketingzwecken zu verfolgen.';

$result = $wpdb->update(
	$table,
	[
		// Plain strings
		'revoke'            => 'Zustimmung verwalten',
		'save_preferences'  => 'Einstellungen speichern',
		'view_preferences'  => 'Einstellungen ansehen',
		'category_functional' => 'Funktional',
		'accept'            => 'Akzeptieren',
		'message_optin'     => $de_message,
		'message_optout'    => $de_message,

		// Serialized arrays – keep structure, replace text value
		'header'            => serialize( [ 'text' => 'Zustimmung verwalten', 'show' => 1 ] ),
		'dismiss'           => serialize( [ 'text' => 'Ablehnen', 'show' => 1 ] ),
		'accept_informational' => serialize( [ 'text' => 'Akzeptieren', 'show' => 1 ] ),
		'category_all'      => serialize( [ 'text' => 'Marketing', 'show' => 1 ] ),
		'category_stats'    => serialize( [ 'text' => 'Statistik', 'show' => 1 ] ),
		'category_prefs'    => serialize( [ 'text' => 'Präferenzen', 'show' => 1 ] ),
		'functional_text'   => serialize( [ 'text' => $de_functional_text, 'show' => 1 ] ),
		'statistics_text'   => serialize( [ 'text' => $de_statistics_text, 'show' => 1 ] ),
		'statistics_text_anonymous' => serialize( [ 'text' => $de_stats_anon_text, 'show' => 1 ] ),
		'preferences_text'  => serialize( [ 'text' => $de_preferences_text, 'show' => 1 ] ),
		'marketing_text'    => serialize( [ 'text' => $de_marketing_text, 'show' => 1 ] ),
	],
	[ 'ID' => 1 ]
);

if ( $result !== false ) {
	echo "✓ Complianz Banner auf Deutsch aktualisiert (ID=1, {$result} Felder geändert)\n";

	// Flush relevant transients
	delete_transient( 'cmplz_default_banner_id' );
	delete_transient( 'cmplz_min_banner_id' );
	wp_cache_flush();
	echo "✓ Transients und Cache geleert\n";
} else {
	echo "✗ Fehler beim Update: " . $wpdb->last_error . "\n";
}
