<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 03.02.2019
 * Time: 20:39
 */

class Cathegories
{
public static function getCathegories() {
    $cathegories = array();
    $db = Db::getConnection();
        $result = $db->query('SELECT * FROM cathegories');
        $i=0;
        while ($row = $result->fetch()) {
            $cathegories[$i]['id'] = (int)$row['id'];
            $cathegories[$i]['cath_eng'] = $row['cath_eng'];
            $cathegories[$i]['cath_ru'] = $row['cath_ru'];
            $i++;
        }
        /*for ($j=0;$j<$i;$j++) {
            $cathegories[$j]['count_news'] = News::getCountNews($cathegories[$j]['cath_eng'])[0];
        }*/
    return $cathegories;
}

public static function cathegoryName($cathegory) {
    $cath=null;
    //Определяем категорию новостей, есть ли у нас такая.
    $cathegories=self::getCathegories();
    for ($i=0;$i<count($cathegories);$i++) {
        if ($cathegories[$i]['cath_eng']==$cathegory) {
            $cath=$cathegories[$i]['cath_ru'];
            break;
        }
    }
return $cath;
}

public static function addCathegory($cath_ru, $cath_eng) {
    $cathegories=self::getCathegories();

    if (in_array($cath_ru, $cathegories) || in_array($cath_eng, $cathegories)) {
        return "Not unique"; }
        elseif(!strlen($cath_ru) || !strlen($cath_ru)) {
        return "Empty or incorrect data.";
        }
        else {
            $resultId=0;
            $db = Db::getConnection();
            $query='INSERT INTO cathegories (cath_ru, cath_eng)
            VALUES ("'.$cath_ru.'", "'.$cath_eng.'")';
            $result = $db->query($query);
            if ($result) {
                $res  = $db->query("SELECT LAST_INSERT_ID()");
                $resultId = $res->fetchColumn();
                return $resultId;
            }
        }
    }

}