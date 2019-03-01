<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 01.02.2019
 * Time: 14:14
 */

class Admins
{
    public static function auth($adminLogin,$adminPassword) {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM admins WHERE login="' . $adminLogin.'"');

        $admin = $result->fetch();

        return $admin;
    }
}