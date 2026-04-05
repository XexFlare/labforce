<?php

/**
 * replacement for all mysql functions
 *
 * @version 3
 * @git https://github.com/rubo77/php-mysql-fix
 *
 * Be aware, that this is just a workaround to fix-up some old code and the resulting project
 * will be more vulnerable than if you use the recommended newer mysqli-functions instead.
 * So only If you are sure that this is not setting your server at risk, you can fix your old
 * code by adding this line at the beginning of your old code:
 *
 * see: https://stackoverflow.com/a/37877644/1069083
 */

if (!function_exists("mysql_connect")) {
  /* warning: fatal error "cannot redeclare" if a function was disabled in php.ini with disable_functions:
  disable_functions =mysql_connect,mysql_pconnect,mysql_select_db,mysql_ping,mysql_query,mysql_fetch_assoc,mysql_num_rows,mysql_fetch_array,mysql_error,mysql_insert_id,mysql_close,mysql_real_escape_string,mysql_data_seek,mysql_result
  */

  define("MYSQL_ASSOC", MYSQLI_ASSOC);
  define("MYSQL_NUM", MYSQLI_NUM);
  define("MYSQL_BOTH", MYSQLI_BOTH);

  global $insert_id;
  $insert_id = null;
  function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
  {
    $row = mysqli_fetch_array($result, $result_type);
    return is_null($row) ? false : $row;
  }

  function mysql_fetch_assoc($result)
  {
    $row = mysqli_fetch_assoc($result);
    return is_null($row) ? false : $row;
  }

  function mysql_fetch_row($result)
  {
    $row = mysqli_fetch_row($result);
    return is_null($row) ? false : $row;
  }

  function mysql_fetch_object($result)
  {
    $row = mysqli_fetch_object($result);
    return is_null($row) ? false : $row;
  }

  function mysql_connect($host, $username, $password, $new_link = FALSE, $client_flags = 0)
  {
    global $global_link_identifier;
    $global_link_identifier = mysqli_connect($host, $username, $password);
    return $global_link_identifier;
  }

  function mysql_pconnect($host, $username, $password, $client_flags = 0)
  {
    global $global_link_identifier;
    $global_link_identifier = mysqli_connect("p:" . $host, $username, $password);
    return $global_link_identifier;
  }

  function mysql_select_db($dbname, $link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_select_db($link_identifier, $dbname);
  }

  function mysql_ping($link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_ping($link_identifier);
  }

  function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
  }

  function mysql_query($stmt, $link_identifier = null, $log = true)
  {
    if($log && (startsWith(strtoupper($stmt),'DELETE') || startsWith(strtoupper($stmt),'UPDATE'))){
      log_query($stmt);
    }
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    $res = mysqli_query($link_identifier, $stmt);
    if($log && startsWith(strtoupper($stmt),'INSERT')){
      log_query($stmt);
    }
    return $res;
  }
  
  function log_query($stmt)
  {
    $uppr = strtoupper($stmt);
    $fields = [];
    $values = [];
    $table = null;
    $user = null;
    $id = 0;
    $data = null;
    $operation = null;
    if(startsWith($uppr,'INSERT')){
      preg_match_all('/insert into ([^)]*) \(([^)]*)\) values \(([^)]*)\)/isu', $stmt, $matches, PREG_SET_ORDER);
      if(count($matches) >0) {
        $table = $matches[0][1];
        $operation = "INSERT";
        $fields = explode(',', $matches[0][2]);
        $values = explode(',', $matches[0][3]);
        $id =  mysql_insert_id();
        global $insert_id;
        $insert_id = $id;
      }
    }
    if(startsWith($uppr,'DELETE')){
      preg_match_all('/delete from ([^)]*) where ([^)]*)/isu', $stmt, $matches, PREG_SET_ORDER);
      if(count($matches) > 0) {
        $table = $matches[0][1];
        $operation = "DELETE";
        $condition = $matches[0][2];
        $res = mysql_query("SELECT * FROM $table WHERE $condition");
        $data = mysql_fetch_assoc($res);
        $id = $data[array_keys($data)[0]];
      }
    }
    if(startsWith($uppr,'UPDATE')){
      preg_match_all('/update ([^)]*) set ([^)]*) where ([^)]*)/isu', $stmt, $matches, PREG_SET_ORDER);
      if(count($matches) > 0) {
        $table = $matches[0][1];
        $operation = "UPDATE";
        $condition = $matches[0][3];
        $res = mysql_query("SELECT * FROM $table WHERE $condition");
        $prev_data = mysql_fetch_assoc($res);
        if($prev_data != null){
          foreach (explode(',', $matches[0][2]) as $value) {
            $split = explode('=',$value);
            $key = trim($split[0]);
            if(remove_quotes($prev_data[$key]) != remove_quotes($split[1])){
              $fields[] = $key;
              $values[] = $prev_data[$key]  .' -> '. $split[1];
            }
          }
          $id = $prev_data[array_keys($prev_data)[0]];
        }
      }
    }

    if($table == null) return;

    if($data == null && $fields ==[]) return;
    if($data == null)
      foreach ($fields as $key => $field) {
        $data[remove_quotes($field)] = remove_quotes($values[$key]);
      }
    
    $user = $_SESSION['user'];
    $dats = mysql_escape_string(json_encode($data));
    $query = mysql_escape_string($stmt);
    $logQuery = "INSERT into trail values (DEFAULT, '$table', '$operation', $id, '$dats', $user, '$query', DEFAULT)";
    mysql_query($logQuery, null, false);
  }

  function remove_quotes($string)
  {
    return trim(str_replace(['"', "'", "`"], "", $string));
  }

  function mysql_db_query($database, $query, $link_identifier = NULL)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    mysqli_select_db($link_identifier, $database);
    return mysqli_query($link_identifier, $query);
  }

  function mysql_num_rows($result)
  {
    return mysqli_num_rows($result);
  }

  function mysql_affected_rows($link_identifier = NULL)
  {
    // TODO: check, if working when called without argument: mysql_affected_rows()
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_affected_rows($link_identifier);
  }

  function mysql_list_tables($dbname, $link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    $sql = "SHOW TABLES FROM $dbname";
    $result = mysql_query($sql, $link_identifier);
    return $result;
  }

  function mysql_error($link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_error($link_identifier);
  }

  function mysql_errno($link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_errno($link_identifier);
  }

  function real_mysql_insert_id($link_identifier = NULL)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_insert_id($link_identifier);
  }
  function mysql_insert_id()
  {
    global $insert_id;
    if($insert_id != null) return $insert_id;
    return real_mysql_insert_id();
  }

  function mysql_close($link_identifier = NULL)
  {
    return true;
  }

  function mysql_real_escape_string($unescaped_string, $link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_real_escape_string($link_identifier, $unescaped_string);
  }

  function mysql_data_seek($result, $row_number)
  {
    return mysqli_data_seek($result, $row_number);
  }

  function mysql_result($result, $row = 0, $col = 0)
  {
    $numrows = mysqli_num_rows($result);
    if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
      mysqli_data_seek($result, $row);
      $resultrow = (is_numeric($col)) ? mysqli_fetch_row($result) : mysqli_fetch_assoc($result);
      if (isset($resultrow[$col])) {
        return $resultrow[$col];
      }
    }
    return false;
  }

  function mysql_escape_string($s, $link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_real_escape_string($link_identifier, $s);
  }

  function mysql_field_name($result, $i)
  {
    return mysqli_fetch_field_direct($result, $i);
  }

  function mysql_free_result($result)
  {
    return mysqli_free_result($result);
  }

  function mysql_get_server_info($link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_get_server_info($link_identifier);
  }

  function mysql_set_charset($csname, $link_identifier = null)
  {
    global $global_link_identifier;
    if ($link_identifier == null) {
      $link_identifier = $global_link_identifier;
    }
    return mysqli_set_charset($link_identifier, $csname);
  }

  // aliases 
  function mysql(...$args)
  {
    return mysql_db_query(...$args);
  }
  function mysql_createdb(...$args)
  {
    return mysql_create_db(...$args);
  }
  function mysql_db_name(...$args)
  {
    return mysql_result(...$args);
  }
  function mysql_dbname(...$args)
  {
    return mysql_result(...$args);
  }
  function mysql_dropdb(...$args)
  {
    return mysql_drop_db(...$args);
  }
  function mysql_fieldflags(...$args)
  {
    return mysql_field_flags(...$args);
  }
  function mysql_fieldlen(...$args)
  {
    return mysql_field_len(...$args);
  }
  function mysql_fieldname(...$args)
  {
    return mysql_field_name(...$args);
  }
  function mysql_fieldtable(...$args)
  {
    return mysql_field_table(...$args);
  }
  function mysql_fieldtype(...$args)
  {
    return mysql_field_type(...$args);
  }
  function mysql_freeresult(...$args)
  {
    return mysql_free_result(...$args);
  }
  function mysql_listdbs(...$args)
  {
    return mysql_list_dbs(...$args);
  }
  function mysql_listfields(...$args)
  {
    return mysql_list_fields(...$args);
  }
  function mysql_listtables(...$args)
  {
    return mysql_list_tables(...$args);
  }
  function mysql_numfields(...$args)
  {
    return mysql_num_fields(...$args);
  }
  function mysql_numrows(...$args)
  {
    return mysql_num_rows(...$args);
  }
  function mysql_selectdb(...$args)
  {
    return mysql_select_db(...$args);
  }

  // TODO: those functions are not defined yet:
  function mysql_client_encoding()
  {
    trigger_error("mysql_client_encoding is not defined yet", E_USER_ERROR);
  }
  function mysql_create_db()
  {
    trigger_error("mysql_create_db is not defined yet", E_USER_ERROR);
  }
  function mysql_drop_db()
  {
    trigger_error("mysql_drop_db is not defined yet", E_USER_ERROR);
  }
  function mysql_fetch_field()
  {
    trigger_error("mysql_fetch_field is not defined yet", E_USER_ERROR);
  }
  function mysql_fetch_lengths()
  {
    trigger_error("mysql_fetch_lengths is not defined yet", E_USER_ERROR);
  }
  function mysql_field_flags()
  {
    trigger_error("mysql_field_flags is not defined yet", E_USER_ERROR);
  }
  function mysql_field_len()
  {
    trigger_error("mysql_field_len is not defined yet", E_USER_ERROR);
  }
  function mysql_field_seek()
  {
    trigger_error("mysql_field_seek is not defined yet", E_USER_ERROR);
  }
  function mysql_field_table()
  {
    trigger_error("mysql_field_table is not defined yet", E_USER_ERROR);
  }
  function mysql_field_type()
  {
    trigger_error("mysql_field_type is not defined yet", E_USER_ERROR);
  }
  function mysql_get_client_info()
  {
    trigger_error("mysql_get_client_info is not defined yet", E_USER_ERROR);
  }
  function mysql_get_host_info()
  {
    trigger_error("mysql_get_host_info is not defined yet", E_USER_ERROR);
  }
  function mysql_get_proto_info()
  {
    trigger_error("mysql_get_proto_info is not defined yet", E_USER_ERROR);
  }
  function mysql_info()
  {
    trigger_error("mysql_info is not defined yet", E_USER_ERROR);
  }
  function mysql_list_dbs()
  {
    trigger_error("mysql_list_dbs is not defined yet", E_USER_ERROR);
  }
  function mysql_list_fields()
  {
    trigger_error("mysql_list_fields is not defined yet", E_USER_ERROR);
  }
  function mysql_list_processes()
  {
    trigger_error("mysql_list_processes is not defined yet", E_USER_ERROR);
  }
  function mysql_num_fields()
  {
    trigger_error("mysql_num_fields is not defined yet", E_USER_ERROR);
  }
  function mysql_tablename()
  {
    trigger_error("mysql_tablename is not defined yet", E_USER_ERROR);
  }
  function mysql_stat()
  {
    trigger_error("mysql_stat is not defined yet", E_USER_ERROR);
  }
  function mysql_thread_id()
  {
    trigger_error("mysql_thread_id is not defined yet", E_USER_ERROR);
  }
  function mysql_unbuffered_query()
  {
    trigger_error("mysql_unbuffered_query is not defined yet", E_USER_ERROR);
  }
}
