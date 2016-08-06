<?php

/*
* Mirko Gueregat - 16/10/2015
*/

namespace StaElisa\Models;

//include_once(dirname(__FILE__)."/../config/config.php");

use StaElisa\Config;

class Model
{

    private static $conn;
    private static $stmt;

    public function connect()
    {
        self::$conn = mysqli_connect(
            DB_HOSTNAME,
            DB_USERNAME,
            DB_PASSWORD,
            DB_DATABASE
        ) or die("Some error occurred during connection " . mysqli_error(self::$conn));
        mysqli_set_charset(self::$conn, "utf8");
    }

    public function disconnect()
    {
        mysqli_close(self::$conn);
        if (isset(self::$stmt)) {
            self::$stmt->close();
        }
    }

    public function query($sql)
    {
        self::connect();
        $query = mysqli_query(self::$conn, $sql);
        self::disconnect();
        return $query;
    }

    public function fetchArray($result)
    {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    public function fetchRow($result)
    {
        return mysqli_fetch_assoc($result);
    }

    public function numRows($result)
    {
        return mysqli_num_rows($result);
    }

    public function affectedRows()
    {
        if (isset(self::$stmt)) {
            return self::$stmt->affected_rows;
        }
        return mysqli_affected_rows(self::$conn);
    }
    
    public function prepare($sql, $a_bind_params, $a_param_type)
    {
        $a_params = array();
        $param_type = '';
        $lenght = count($a_param_type);
        for ($i = 0; $i < $lenght; $i++) {
            $param_type .= $a_param_type[$i];
        }
        $a_params[] = & $param_type;
        for ($i = 0; $i < $lenght; $i++) {
            $a_params[] = & $a_bind_params[$i];
        }
        self::$stmt = self::$conn->prepare($sql);
        if (self::$stmt === false) {
            trigger_error('Wrong SQL: '
                          . $sql . ' Error: '
                          . self::$conn->errno . ' '
                          . self::$conn->error, E_USER_ERROR);
        }
        call_user_func_array(array(self::$stmt, 'bind_param'), $a_params);
        self::$stmt->execute();
        return self::$stmt->get_result();
    }
}
