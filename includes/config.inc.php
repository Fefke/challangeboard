<?php
######################################################################
## Database ##########################################################
######################################################################
// Database
  define( 'DB_TYPE', 'mysql' ); //Datenbank Typ
  define( 'DB_HOST', 'pdb28.awardspace.net' ); //Host
  define( 'DB_USERNAME', '2583785_cb' ); //Benutzername
  define( 'DB_PASSWORD', '2@Y^@QZHaS+Z2Nw_' ); //Passwort
  define( 'DB_NAME', '2583785_cb' ); //Datenbankname
  define( 'DB_CONNECTION_CHARSET', 'utf8_bin' ); //Charset
  define( 'DB_PERSISTENT_CONNECTIONS', 'false' ); //Presistente (bestehende) Verbindung

 

######################################################################
## Files #############################################################
###################################################################### 
 
  // File System
  define('FS_DIR_HTTP_ROOT', rtrim(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])), '/'));

  // Web System
  define('WS_DIR_HTTP_HOME', rtrim(str_replace(FS_DIR_HTTP_ROOT, '', str_replace('\\', '/', realpath(__DIR__.'/..'))), '/') . '/');

  
  
/*
  //For swk-azubis.dx.am:
  define( 'DB_TYPE', 'mysql' );
  define( 'DB_HOST', 'fdb18.awardspace.net' );
  define( 'DB_USERNAME', '2583785_challange' );
  define( 'DB_PASSWORD', 'T285jqnyv48xFvQsq3BHfq6gnqP' );
  define( 'DB_NAME', '2583785_challange' );
  define( 'DB_CONNECTION_CHARSET', 'utf8_bin' );
  define( 'DB_PERSISTENT_CONNECTIONS', 'false' );
  */
?>