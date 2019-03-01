<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 21.10.2018
 * Time: 19:33
 */

class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host=".$params['host'].";dbname=".$params['dbname'].";charset=utf8";
        $db = new PDO($dsn, $params['user'], $params['password'],  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//"mysql:host=$host;dbname=$db;charset=utf8"

        return $db;
    }
}