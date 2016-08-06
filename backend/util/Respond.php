<?php

/*
* Mirko Gueregat - 16/10/2015
*/

namespace StaElisa\Utils;
    
class Respond
{
    private $codes  = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found'
    );
    
    public function send($result, $code, $data = "")
    {
        header('Cache-Control: no cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode(
            array(
                "result" => $result,
                "code" => $code,
                "status" => $this->codes[$code],
                "data" => $data
            ),
            JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT
        );
    }
}
