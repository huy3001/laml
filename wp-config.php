<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Zu diesen Einstellungen gehören:
 *
 * * MySQL-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * Mehr Informationen zur wp-config.php gibt es auf der
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Zugangsdaten für die MySQL-Datenbank
 * bekommst du von deinem Webhoster.
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als wp-config.php mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * @package WordPress
 */

// ** MySQL-Einstellungen ** //
/**   Diese Zugangsdaten bekommst du von deinem Webhoster. **/

/**
 * Ersetze datenbankname_hier_einfuegen
 * mit dem Namen der Datenbank, die du verwenden möchtest.
 */
define('DB_NAME', 'loewenberg_aml_com_lionheartdb');

/**
 * Ersetze benutzername_hier_einfuegen
 * mit deinem MySQL-Datenbank-Benutzernamen.
 */
define('DB_USER', 'loewenberg_aml_com_lionheartdb');

/**
 * Ersetze passwort_hier_einfuegen mit deinem MySQL-Passwort.
 */
define('DB_PASSWORD', 'vD{2mPKed2D293nLMsbWdvZVngPtj/9iAFoPqNp6[vsWRHZAA}LzE{7q6zPU2jtR');

/**
 * Ersetze localhost mit der MySQL-Serveradresse.
 */
define('DB_HOST', 'loewenberg-aml.com.mysql');

/**
 * Der Datenbankzeichensatz, der beim Erstellen der
 * Datenbanktabellen verwendet werden soll
 */
define('DB_CHARSET', 'utf8mb4');

/**
 * Der Collate-Type sollte nicht geändert werden.
 */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '!nM[5Pk9@$;Zhw9SaUEA!APuYKET)8u~!zCarR(W!^R=rvXZ)SB2l#W>-*4CwYM<');
define('SECURE_AUTH_KEY',  'Boef~L?!E~mgzM ub%F#$zgy(WV!i__,s_gB&Io)[Ec}RxLH6%Bu/=8=lB^]XJuV');
define('LOGGED_IN_KEY',    'g&m,>SpVW3PR(,]Sd~y-;=y<>,2F}19?+<tb@m[#]hFGt=w<Z7G(4%._DkmEY7bZ');
define('NONCE_KEY',        'X[jvc|- p7 ODHJf-@{N}I9*Mnu8goY[?? ^@R^_>oC1{2yo {<fgf{:t?i};`Bg');
define('AUTH_SALT',        'oi*7Dz}]AlUmU_H(1oXhU2[3~2J#@ T/9gv[Uvi+G5qlOlhqc|-K)f|<O/g?f`ju');
define('SECURE_AUTH_SALT', ',@}-klEZv0X&!t!vI/r1<LGEQmZ~=vn7F)-7GyOE&L(*xd[%CjNIX.[s|8fu:1z:');
define('LOGGED_IN_SALT',   'hFc_h5n[>|>)q^MZ!NQ~w8.&6O,4}e.ku-&Z7L4?d<<x*~*nJ#m:13Q!:i:kNFQF');
define('NONCE_SALT',       'r%o(hnWo{4l,hjJro$znX;W8SqFhYfI8i+lKa<o$M(k@=GxbY&7qWX-H=yZ#4Vnh');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix  = 'wp_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */
/* That's all, stop editing! Happy blogging. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once(ABSPATH . 'wp-settings.php');
