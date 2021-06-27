<p class="text-warning">
    Testcase mit YForm ab 4.0-beta2 (YFORM_DATA_LIST_QUERY statt YFORM_DATA_LIST_SQL)
</p>
<p class="">
    Die Ausgabe führt eine erste Modifikationen über YFORM_DATA_LIST_QUERY durch. Hinzugefügt wird ein
    leftRelationJoin über das Feld "d_id_historie", der zu einer SQL-Exception führt, da das einzige
    feld in der Abfrage ("id") nicht mehr eindeutig zuordnenbar ist.
</p>
<?php
$editor = rex_editor::factory();
if($url = $editor->getUrl(__FILE__,0) ) {
   echo '<p><a href="'. $url .'" class="btn btn-info btn-xs"><i class="rex-icon rex-icon-view"></i> Datei anzeigen ('.$editor->getName().')</a></p>';
}

$tablename = 'rex_yf4b_dokument';

/*
    Die einzige Änderung (join hinzugefügt) führt dazu, dass zwischen den EP YFORM_DATA_LIST_QUERY
    und YFORM_DATA_LIST ein SQL-Fehler auftritt. ID nicht meh eindeutig
*/

\rex_extension::register('YFORM_DATA_LIST_QUERY', function( \rex_extension_point $ep ) use($tablename) {
    $query = $ep->getSubject();
    if( $tablename !== $query->getTablename() ) return;

    $query->leftJoinRelation('d_id_historie');

    dump(get_defined_vars());
});


\rex_extension::register('YFORM_DATA_LIST', function( \rex_extension_point $ep ) use($tablename) {
    $table = $ep->getParam('table');
    if( $tablename !== $table->getTablename() ) return;
    dump(get_defined_vars());
});

\rex_extension::register('YFORM_LIST_GET', function( \rex_extension_point $ep ) use($tablename) {
    $list = $ep->getSubject();
    dump(get_defined_vars());
});


$_REQUEST['table_name'] = $tablename;
include (__DIR__.'/yform.php');
