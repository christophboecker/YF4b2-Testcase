<p class="text-warning">
    Funktioniert nur YForm bis 4.0-beta1
</p>
<p class="">
    Angezeigt wird die Tabelle "Dokumente" (rex_yf4b_dokument) mit folgenden Änderungen ggü dem Standard:
</p>
<ul>
    <li>Titel nicht verkürzt (xxx...xxx), sondern in voller Länge</li>
    <li>Keine Liste der referenzierten Scans</li>
    <li>Ausgabe "Anzahl referenzierter Scans | Anzahl zugeordneter Boote"</li>
    <li>Highlight der Zeile wenn es keine Referenz aus der Jahrbuch-Tabelle (rex_yf4b_buch) gibt</li>
</ul>
<?php
$editor = rex_editor::factory();
if($url = $editor->getUrl(__FILE__,0) ) {
   echo '<p><a href="'. $url .'" class="btn btn-info btn-xs"><i class="rex-icon rex-icon-view"></i> Datei anzeigen ('.$editor->getName().')</a></p>';
}

$tablename = 'rex_yf4b_dokument';

/*
    Erweitert die SQL-Abfrage.

    Original:
        select `id`,`d_datum`,`d_titel`,`d_id_scan`,NULL AS `d_id_historie` from `rex_yf4b_dokument` t0 ORDER BY `id` ASC

    Änderung:
        Anzahl der im Dokumenten-Datensatz rex_yf4b_dokument via Relatonentabelle rex_yf4b_historie
        referenzierten Boote als Anzahl der gefundenen Datensätze
            COUNT(t1.id) as anzahl_boote
            LEFT JOIN rex_yf4b_historie t1 ON t0.id = t1.h_id_dokument

        Indikator, ob der Dokumenten-Datensatz rex_yf4b_dokument in einem Jahrbuch-Datensatz rex_yf4b_buch
        referenziert wurde
            (0 < COUNT(t2.id) ) as im_jahrbuch
            LEFT JOIN rex_yf4b_buch t2 ON FIND_IN_SET(t0.id, t2.b_id_dokument)

        Beide Join benötigen eine Gruppierung über t0.id

        Das Feld id im SELECT der Originalabfrage muß eindeutig gemacht werden => t0.id

*/

\rex_extension::register('YFORM_DATA_LIST_SQL', function( \rex_extension_point $ep ) use($tablename) {
    $table = $ep->getParam('table');
    if( $tablename !== $table->getTablename() ) return;

    $sql = $ep->getSubject();

    // Feld id eindeutig machen
    $sql = str_replace( 'select `id`', 'select t0.`id`', $sql );

    // zusätzliches Feld "anzahl_boote" ermittelt, wieviele Boote via rex_yf4b_historie zugeordnet sind
    // rex_yf4b_historie: Feld h_id_dokument enthält die ID des zugeordneten Satzes in rex_yf4b_dokument
    $sql = str_replace( ' from ', ', COUNT(t1.id) as anzahl_boote from ', $sql );
    $sql = str_replace( ' ORDER BY ', ' LEFT JOIN rex_yf4b_historie t1 ON t0.id = t1.h_id_dokument ORDER BY ', $sql );

    // zusätzliches Feld "is_referenced" ermittelt, ob der Datensatz einem Jahrbuch-Eintrag zugeordnet ist
    // rex_yf4b_buch: Feld b_id_dokument enthält die IDs auf zugeordnete Sätze in rex_yf4b_dokument
    $sql = str_replace( ' from ', ', (0 < COUNT(t2.id) ) as im_jahrbuch from ', $sql );
    $sql = str_replace( ' ORDER BY ', ' LEFT JOIN rex_yf4b_buch t2 ON FIND_IN_SET(t0.id, t2.b_id_dokument) ORDER BY ', $sql );

    // über ID gruppieren
    $sql = str_replace( ' ORDER BY ', ' GROUP BY t0.id ORDER BY ', $sql );

    return $sql;
});


/*
    Umbau der Listenansicht:

    Die Spalte im_jahrbuch dient nur als indikator, also nicht anzeigen. Sie dient nur als Flag
    um die Darstellung der Zeile zu ändern. Noch nicht in einem Jahrbuch-Eintrag verlinkte Dokumente
    sind rot markiert (setRowAttributes)

    Die Referenz selbst auf die Tabelle rex_yf4b_historie wird gelöscht (soll nur üner inline-Formulare
    laufen).

    Die Scan-Titel werden nicht angezeigt. Statt dessen wird ein Kombifeld daraus, dass Anzahl Scans
    und Anzahl verlinkter Boote anzeigt.

    Für die Optik: Titel nicht verkürzt ausgeben.
*/

\rex_extension::register('YFORM_DATA_LIST', function( \rex_extension_point $ep ) use($tablename) {
    $table = $ep->getParam('table');
    if( $tablename !== $table->getTablename() ) return;

    $rex_list = $ep->getSubject();

    // Zeile in roter Schrift wenn keinem Jahrbucheintrag zugeordnet
    // Spalte selbst nicht ausgeben
    $rex_list->removeColumn('im_jahrbuch');
    $rex_list->setRowAttributes(function($list){
        return $list->getValue('im_jahrbuch') ? '' : 'class="text-danger"';
    });

    // Spalte d_id_historie und anzahl_boote nicht anzeigen
    // d_id_scan umfunktionieren für die Anzahl Scans und Boote kombiniert
    $rex_list->removeColumn('d_id_historie');
    $rex_list->removeColumn('anzahl_boote');
    $rex_list->setColumnLabel('d_id_scan','Scans<br>Boote');
    $rex_list->setColumnFormat('d_id_scan','custom', function ($params) {
        $scans = count(explode(',',$params["value"])) ?: '-';
        $boote = $params['list']->getValue('anzahl_boote') ?: '-';
        return "$scans | $boote";
    } );

    // Titel ausschreiben
    $rex_list->setColumnFormat('d_titel', 'custom', function ($params) { return $params["value"];} );

});


$_REQUEST['table_name'] = $tablename;
include (__DIR__.'/yform.php');
