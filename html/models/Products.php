<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 16.02.2019
 * Time: 23:06
 */

class Products
{
    public static function getProducts($side='A', $activeOnly=1, $limit=0, $offset=0) {
        // Запрос к б.д.
        $db = Db::getConnection();
        $products = array();
        if ($side=='A' || $side=='L' || $side=='R') {
            if ($activeOnly) {
                $query = 'SELECT * FROM products WHERE active=1';
                if ($side!=='A') $query.=' AND side = "'.$side.'"';
            } else {
                $query = 'SELECT * FROM products';
                if ($side!=='A') $query.=' WHERE side = "'.$side.'"';
            }

            if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
            elseif ($limit) $query = $query.' LIMIT '.$limit;
            $result = $db->query($query);
            $i=0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = (int)$row['id'];
                $products[$i]['productName'] = $row['productName'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['seller'] = $row['seller'];
                $products[$i]['side'] = $row['side'];
                $products[$i]['photo'] = $row['photo'];
                $products[$i]['active'] = $row['active'];
                $products[$i]['promocode'] = self::generateRandomString();
                $i++;
            }
            return $products;
        }
    }

     public static function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function addProduct($productName, $price, $seller, $side, $photo='', $active=0) {
        //если входные параметры ок - делаем запрос к базе
        $productName = filter_var($productName, FILTER_SANITIZE_STRING);
        $seller = filter_var($seller, FILTER_SANITIZE_STRING);
        $db = Db::getConnection();
        $query = 'INSERT INTO products (productName, price, seller, side, photo, active)
            VALUES ("'.$productName.'", '.$price.', "'.$seller.'", "'.$side.'", "'.$photo.'", '.$active.')';

        $result = $db->query($query);
        if ($result) {
            $res  = $db->query("SELECT LAST_INSERT_ID()");
            $resultId = $res->fetchColumn();
            return $resultId;
        }
        else return 0;
    }

    public static function setStatusProduct($productId, $status) {
        if ((int)$productId) {
            $db=Db::getConnection();
            $s=($status) ? 1 : 0;
            $query = 'UPDATE products SET active='.$s.' WHERE id='.$productId;
            $result = $db->query($query);
            $result = $result->rowCount();
            return $result;
        } else return 0;
    }

    public static function addPhoto($productId, $photoName) {
        if ((int)$productId && strlen($photoName)) {
            $db=Db::getConnection();
            $query = 'UPDATE products SET photo="'.$photoName.'" WHERE id='.$productId;
            $result = $db->query($query);
            $result = $result->rowCount();
            return $result;
        } else return 0;
    }
}