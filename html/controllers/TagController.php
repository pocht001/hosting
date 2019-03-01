<?php

session_start();
include_once ROOT . '/models/Tag.php';
include_once ROOT . '/models/News.php';

class TagController
{
    public  function actionNewsbytag($params=null) {
        if ($_GET) {
            if (array_key_exists('tag',$_GET)) $tag=trim($_GET['tag']);
            $page = 0;
            $offset=0;
            if (array_key_exists('page',$_GET)) {
				$page = abs((int)$_GET['page']);
                if ($page)
                    $offset = ($page-1)*5;
                else $offset = 0;
            }
            $cant = Tag::getCountTag($tag);//cant - count all news this tag

            $newsThisTag = Tag::getNewsByTag($tag,5,$offset);
        }
        else $newsThisTag=null;

        $sliderList = News::sliderList();
        require_once (ROOT.'/views/tag/newsByTag.php');
}

    public function actionShowTags($inputData = null) {
        $inputData = $_POST['inputData'];
        $foundTagsUnique = Tag::showTags($inputData);
        echo $foundTagsUnique;
    }

    public function actionEditNewsTag($params=null) {
        $newTags = '';
        $newsId=$params[1];
        if (isset($_POST['tags'])) {
            for ($i=0;$i<count($_POST['tags']);$i++) {
                if (strlen($_POST['tags'][$i])) {
                    if (strlen($newTags)) $newTags.=', ';
                    $newTags.=$_POST['tags'][$i];
                }
            }
        }
        $cleanTags = filter_var($newTags, FILTER_SANITIZE_STRING);
        $editResult = Tag::updateTagsForNew($newsId,$cleanTags);
        echo $editResult;
    }

}
