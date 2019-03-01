<?php
session_start();
/**
 * Тут обрабатываем http запросы
 */
include_once ROOT.'/models/Tag.php';
include_once ROOT.'/models/Users.php';
include_once ROOT.'/models/News.php';
include_once ROOT.'/models/Cathegories.php';

class SearchController
{
    public static function actionSearchOnSite() {

        $allTags=Tag::getAllTags();
        $cathegories = Cathegories::getCathegories();
        $searchResult = array();
        if ($_POST) {
        $filter = $_POST;
        if ($filter) {
        if (!strlen($filter['date_begin'])) $filter['date_begin']=null;
        if (!strlen($filter['date_end'])) $filter['date_end']=null;
        if (!isset($filter['tags'])) $filter['tags']=null;
        if (!isset($filter['cathegories'])) $filter['cathegories']=null;
            $searchResult = News::getNewsByFilterSearch($filter);
        }}

        require_once (ROOT.'/views/search/search.php');

        return true;
    }

}
