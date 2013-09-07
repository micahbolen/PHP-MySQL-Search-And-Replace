<?php

    // edit this line to add old and new terms which you want to be replaced
    $search_replace = array( 'old_term' => 'new_term', 'old_term2' => 'new_term2' );

    //change the localhost,username,password and database-name according to your db
    mysql_connect("localhost", "username", "password") or die(mysql_error());
    mysql_select_db("database-name") or die(mysql_error());

    $show_tables = mysql_query( 'SHOW TABLES' );
    while( $st_rows = mysql_fetch_row( $show_tables ) ) {
        foreach( $st_rows as $cur_table ) {
            $show_columns = mysql_query( 'SHOW COLUMNS FROM ' . $cur_table );
            while( $cc_row = mysql_fetch_assoc( $show_columns ) ) {
                $column = $cc_row['Field'];
                $type = $cc_row['Type'];
                if( strpos( $type, 'char' ) !== false || strpos( $type, 'text' ) !== false ) {
                    foreach( $search_replace as $old_string => $new_string ) {
                        $replace_query = 'UPDATE ' . $cur_table .
                            ' SET ' .  $column . ' = REPLACE(' . $column .
                            ', \'' . $old_string . '\', \'' . $new_string . '\')';
                        mysql_query( $replace_query );
                    }
                }
            }
        }
    }
    echo 'replaced';
    mysql_free_result( $show_columns );
    mysql_free_result( $show_tables );
    mysql_close( $mysql_link );

?>
