<p class="text-warning">
    Testcase mit YForm ab 4.0-beta2 (YFORM_DATA_LIST_QUERY statt YFORM_DATA_LIST_SQL)
</p>
<p class="">
    Die Ausgabe führt keine Modifikationen über YFORM_DATA_LIST_QUERY durch. Es werden nur per Dump
    die an die EPs
</p>
    <ul>
        <li>YFORM_DATA_LIST_QUERY,</li>
        <li>YFORM_DATA_LIST und</li>
        <li>YFORM_LIST_GET</li>
    </ul>
<p>
    übergebenen Daten angezeigt.
</p>
<?php
$editor = rex_editor::factory();
if($url = $editor->getUrl(__FILE__,0) ) {
   echo '<p><a href="'. $url .'" class="btn btn-info btn-xs"><i class="rex-icon rex-icon-view"></i> Datei anzeigen ('.$editor->getName().')</a></p>';
}


$tablename = 'rex_yf4b_dokument';

\rex_extension::register('YFORM_DATA_LIST_QUERY', function( \rex_extension_point $ep ) use($tablename) {
    $query = $ep->getSubject();
    if( $tablename !== $query->getTablename() ) return;
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
