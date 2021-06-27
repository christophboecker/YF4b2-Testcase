<?php
/**
 *  De-Installations-Script
 *
 *  - Demo-Tabellen entfernen (rex_yf4b_...)
 *  - YForm-Tablesets entfernen (rex_yf4b_...)
 *
 *  @var \rex_addon $this
 */

$sql = rex_sql::factory();

$qry = 'SELECT DISTINCT table_name FROM information_schema.tables WHERE table_name LIKE "rex_yf4b_%"';

foreach( array_column($sql->getArray($qry),'TABLE_NAME') as $tablename ){
    rex_yform_manager_table_api::removeTable( $tablename );
    if( $table = rex_sql_table::get($tablename) ) $table->drop();
}
