<?php
/**
 * Авторизация пользователя
 */
include_once ROOT.'/components/Db.php';

class Users
{
    public static function auth($userLogin,$userPassword) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM users WHERE login="' . $userLogin.'"');

            $user = $result->fetch();

            return $user;
    }

    /** Инфа о юзере по его id
    */
    public static function userInfById($userId) {
        $user = null;
        $userId = intval($userId);
        if ($userId) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM users WHERE id="' . $userId.'"');

            $user = $result->fetch();
        }
        return $user;
    }

    /** Список id пользователей
     */
public static function getUserIdList() {
    $db = Db::getConnection();
    $result = $db->query('SELECT id FROM `users`');
    $userIdList = array();
    $i=0;
    while($row = $result->fetch()) {
        $userIdList[$i] = $row['id'];
        $i++;
    };
    return $userIdList;
}

}