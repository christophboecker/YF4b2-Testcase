<?php
/**
 *  Installations-Script
 *
 *  - Demo-Tabellen anlegen und Daten importieren (Datei dataset.sql)
 *  - YForm-Tablesets anlegen zu den Tabellen anlegen (Datei tableset.json)
 *
 *  @var \rex_addon $this
 */

// Meldungen sammeln
$msg = [];

// let´s go
try {

    // Demo-Tabellen anlegen und Daten importieren
    \rex_sql_util::importDump( __DIR__.'/dataset.sql' );
    $msg[] = 'Datenbank-Tabellen rey_yf4b_..... angelegt und befüllt';

    // YForm-Tablesets anlegen basierend auf den Tabellen
    $tableset = \rex_file::get( __DIR__.'/tableset.json' );
    \rex_yform_manager_table_api::importTablesets( $tableset );
    $msg[] = 'YForm-Tablesets für rey_yf4b_..... angelegt';

    // Fertig
    $msg = '<ul><li>'.implode('</li><li>',$msg).'</li></ul>';
    $switch = '<a href="' . rex_url::backendPage($this->getName()) . '">Zum Addon wechseln</a>';
    $this->setProperty( 'successmsg', $msg . $switch );

} catch (\Exception $e) {

    $this->setProperty('installmsg', $e->getMessage().' (file '.$e->getFile().' line '.$e->getLine().')' );

}
