<?php

/*
* Mirko Gueregat - 16/10/2015
*/

namespace StaElisa\Users;

use StaElisa\Models\Model;

include_once("Model.php");

class UsersModel extends Model
{
    
    public function login($rut, $year)
    {
        $sql = "SELECT * FROM sueldo WHERE rut = '$rut' AND agno_ingreso = $year";
        $query = self::query($sql);
        if ($query != null and self::numRows($query) > 0) {
            return $query;
        }
        return false;
    }
}
