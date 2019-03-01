<?php
/** Вытягиваем из БД стили сайта,
 * запоминаем в БД некоторые стили сайта (фоновые картинки например)
 * для управления из админки
 */

class Config
{
    public static function getCfgStyle() {
        $db = Db::getConnection();
        $cfgStyle=array();
        $query = 'SELECT id, element, property, val
                        FROM cfgstyles';

        $result = $db->query($query);
        $i=0;
        while ($row = $result->fetch()) {
            $cfgStyle[$i]['id'] = $row['id'];
            $cfgStyle[$i]['element'] = $row['element'];
            $cfgStyle[$i]['property'] = $row['property'];
            $cfgStyle[$i]['val'] = $row['val'];
            $i++;
        }
        return $cfgStyle;
    }

    public static function getBgImg() {
        $db = Db::getConnection();
        $bgImg='';
        $query = 'SELECT val FROM cfgstyles
        WHERE element="body" AND property="background-image"';

        $result = $db->query($query);
        $i=0;
        $bgImg = $result->fetch();
        return $bgImg[0];
    }

    public static function setBgImg($p) {
        $db = Db::getConnection();
        $bgImg='';
        $query = 'UPDATE cfgstyles SET val="'.$p.'" WHERE element="body" AND property="background-image"';

        $result = $db->query($query);
        $bgImg = $result->rowCount();
        return $bgImg;
    }

    public static function getHBg() {
        $db = Db::getConnection();
        $bgImg = '';
        $query = 'SELECT val FROM cfgstyles WHERE `cfgstyles`.`id` = 2';

        $result = $db->query($query);
        $i = 0;
        $bgImg = $result->fetch();
        return $bgImg[0];
    }

    public static function setHBg($color) {
        $db = Db::getConnection();
        $bgImg='';
        $query = 'UPDATE cfgstyles SET val="'.$color.'" WHERE `cfgstyles`.`id` = 2';

        $result = $db->query($query);
        $bgImg = $result->rowCount();
        return $bgImg;
    }

    public static function getMenu() {
        $db = Db::getConnection();
        $item=array();
        $subItem=array();
        $menu=array();
        $subIndexes=array();
        $i=0;
        $j=0;

        $result = $db->query('SELECT sub_item FROM menu WHERE sub_item>0');
        while ($row=$result->fetch()) {
            $subIndexes[$i]=$row['sub_item'];
            $i++;
        }
        $subIndexes=array_unique($subIndexes);

        $i=0;
        $result=$db->query('SELECT * FROM menu WHERE sub_item=0');
        while ($row=$result->fetch()) {
            $item[$i]['id']=(int)$row['id'];
            $item[$i]['menu_item']=$row['menu_item'];
            $item[$i]['link']=$row['link'];
            $item[$i]['sub_item']=(int)$row['sub_item'];
            $item[$i]['all_sub_items'] = $row['id'].',';
            if (in_array($item[$i]['id'],$subIndexes)) {
                $j=0;
                $result2=$db->query('SELECT * FROM menu WHERE sub_item='.$item[$i]['id']);
                while ($row2=$result2->fetch()) {
                    $item[$i]['si'][$j]['id']=(int)$row2['id'];
                    $item[$i]['si'][$j]['menu_item']=$row2['menu_item'];
                    $item[$i]['si'][$j]['link']=$row2['link'];
                    $item[$i]['si'][$j]['sub_item']=(int)$row2['sub_item'];
                    $item[$i]['si'][$j]['all_sub_items']=$row2['id'].',';
                    $item[$i]['all_sub_items'] .= $row2['id'].',';
                    if (in_array($item[$i]['si'][$j]['id'],$subIndexes)) {
                        $k=0;
                        $result3=$db->query('SELECT * FROM menu WHERE sub_item='.$item[$i]['si'][$j]['id']);
                        while ($row3=$result3->fetch()){
                            $item[$i]['si'][$j]['ssi'][$k]['id']=(int)$row3['id'];
                            $item[$i]['si'][$j]['ssi'][$k]['menu_item']=$row3['menu_item'];
                            $item[$i]['si'][$j]['ssi'][$k]['link']=$row3['link'];
                            $item[$i]['si'][$j]['ssi'][$k]['sub_item']=(int)$row3['sub_item'];
                            $item[$i]['si'][$j]['ssi'][$k]['all_sub_items']=$row3['id'];
                            $item[$i]['si'][$j]['all_sub_items'].=$row3['id'].',';
                            $item[$i]['all_sub_items'] .=$row3['id'].',';
                            $k++;
                        }
                    }
                    $item[$i]['si'][$j]['all_sub_items'] = rtrim($item[$i]['si'][$j]['all_sub_items'], ',');
                    $j++;
                }

            }
            $item[$i]['all_sub_items'] = rtrim($item[$i]['all_sub_items'], ',');
            $i++;
        }

        /*  $query='SELECT * FROM menu';
            $result = $db->query($query);
            while ($row = $result->fetch()) {
            if ($row['sub_item']) {
                $subItem[$row['sub_item']][$j]['id'] = $row['id'];
                $subItem[$row['sub_item']][$j]['menu_item'] = $row['menu_item'];
                $subItem[$row['sub_item']][$j]['link'] = $row['link'];
                $subItem[$row['sub_item']][$j]['sub_item'] = $row['sub_item'];
                $j++;
            } else {
                $item['s'.$i]['id'] = $row['id'];
                $item['s'.$i]['menu_item'] = $row['menu_item'];
                $item['s'.$i]['link'] = $row['link'];
                $item['s'.$i]['sub_item'] = $row['sub_item'];
                $i++;
            }
        }*/
        $menu['item']=$item;
        $menu['subIndexes']=$subIndexes;
        return $item;
    }

    public static function deleteMenuItems($iid=0) {
        if ($iid) {
        $db = Db::getConnection();
        $query='DELETE FROM `menu` WHERE id IN ('.$iid.')';
        $result = $db->query($query);
            $count = $result->rowCount();
        }
        else $count = 0;
        return $count;
    }

    public static function addMenuItem($subItem, $menuItem, $link) {

        $menuItem = filter_var($menuItem, FILTER_SANITIZE_STRING);
        $link = filter_var($link, FILTER_SANITIZE_STRING);

        $db = Db::getConnection();
        $query = 'INSERT INTO menu (sub_item, menu_item, link)
            VALUES ('.$subItem.', "'.$menuItem.'", "'.$link.'")';

        $result = $db->query($query);
        if ($result) {
            $res  = $db->query("SELECT LAST_INSERT_ID()");
            $resultId = $res->fetchColumn();
            return $resultId;
        }
        else return 0;
    }

    public static function updateMenuItem($mId, $menuItem, $link) {
        $menuItem = filter_var($menuItem, FILTER_SANITIZE_STRING);
        $link = filter_var($link, FILTER_SANITIZE_STRING);

        $db = Db::getConnection();
        //$query = 'UPDATE cfgstyles SET val="'.$color.'" WHERE `cfgstyles`.`id` = 2';
        $query = 'UPDATE menu SET menu_item="'.$menuItem.'", link="'.$link.'" WHERE id='.$mId;

        $result = $db->query($query);
        return $updated = $result->rowCount();
    }

}