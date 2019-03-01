<?php
include_once ROOT.'/components/Db.php';
/**
 * Выгребаем из базы новости по указанным тегам.
 */

class Tag
{
    public static function getNewsByTag($tag, $limit=0, $offset=0) {
        $newsListByTag = array();
        $tag = filter_var($tag, FILTER_SANITIZE_STRING);
        if ($tag) {
            $db = Db::getConnection();
            $query = 'SELECT id, theme, cathegory , isanalytic, HaveRead, tags
                        FROM news WHERE (tags LIKE "'.$tag.', %" OR tags LIKE "%, '.$tag.', %" 
                        OR tags LIKE "%, '.$tag.'" OR tags LIKE "'.$tag.'")
                        ORDER BY id DESC';

        if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
        elseif ($limit) $query = $query.' LIMIT '.$limit;
        //echo $query.'</br>';
        $result = $db->query($query);
        $i=0;
        while ($row = $result->fetch()) {
            $newsListByTag[$i]['id'] = $row['id'];
            $newsListByTag[$i]['theme'] = $row['theme'];
            $newsListByTag[$i]['cathegory'] = $row['cathegory'];
            $newsListByTag[$i]['isanalytic'] = $row['isanalytic'];
            $newsListByTag[$i]['HaveRead'] = $row['HaveRead'];
            $newsListByTag[$i]['tags'] = $row['tags'];
            $i++;
        }}

        return $newsListByTag;
    }

    public static function getTagsByNewsId($newsId) {
        $tagsList = array();
        if ($newsId) {
            // Получаем список тегов по id новости
            $db = Db::getConnection();
            $query = 'SELECT tags FROM news WHERE id = '.$newsId;

            $result = $db->query($query);
            $row = $result->fetch();
            //$tagsList[0]['tags'] = $row['tags'];
            $tags = $row['tags'];

            // Формируем из строки-списка тегов массив ссылок на каждый тег
            $tagsList = explode(',',$tags);
            for ($i=0;$i<count($tagsList);$i++) {
                $tagsList[$i] = trim($tagsList[$i]);
            }
        }
    return $tagsList;
    }

    //Метод для подсчета сколько у нас новостей всего.
    public static function getCountTag($tag)
    {
        if ($tag) {
            $db = Db::getConnection();
            $tag = filter_var($tag, FILTER_SANITIZE_STRING);

            $query = 'SELECT COUNT(*)
                        FROM news WHERE (tags LIKE "'.$tag.', %" OR tags LIKE "%, '.$tag.', %" 
                        OR tags LIKE "%, '.$tag.'" OR tags LIKE "'.$tag.'")
                        ORDER BY id DESC';

            $result = $db->query($query);
            $count = $result->fetch();
            return $count[0];
        }
        else return null;

    }


    public static function showTags($input=null) {
		//Возвращает список тегов, содержащих ключевое слово.
        $foundTags = array();
		$foundTag = array();
		$foundTagsUnique = array();
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        if ($input) {
            $db = Db::getConnection();
            $query = 'SELECT tags FROM news WHERE tags LIKE "%' . $input . '%"';
            $result = $db->query($query);
            $i=0;
			$k=0; //Это на случай если в одной новости несколько тегов содержат ключевое слово
            while ($row = $result->fetch()) {
                $foundTags[$i] = explode(',',$row['tags']);
				for ($j=0;$j<count($foundTags[$i]);$j++)
				{
					$foundTags[$i][$j] = trim($foundTags[$i][$j]);
					if (mb_stristr($foundTags[$i][$j], $input)) {
					$foundTag[$k] = $foundTags[$i][$j];
					$k++;
					}
				}
				
                $i++;
            }
			$foundTagsUnique = array_unique($foundTag);
			sort($foundTagsUnique);
        }
        return json_encode($foundTagsUnique);
    }

    public static function getAllTags() {
        $db = Db::getConnection();
        $query = 'SELECT tags FROM news';
        $result = $db->query($query);
        $i=0;
        $tags = array();
        while ($row = $result->fetch()) {
            $tagString = null;
            $tagString = explode(',', $row['tags']);
            for ($j=0;$j<count($tagString);$j++) {
                if (strlen(trim($tagString[$j]))) {
                $tags[$i] = (trim($tagString[$j])) ;
                $i++;
            }}
        };
        $tagsUnique = array_unique($tags);
        sort($tagsUnique);
        return $tagsUnique;
    }

    public static function updateTagsForNew($newsId=0,$tagstring='') {
        $newsId=abs((int)$newsId);
        if ($newsId && strlen($tagstring)) {
            $db = Db::getConnection();
            $query = 'UPDATE news SET tags = "'.$tagstring.'" WHERE id = '.$newsId;
            $result = $db->query($query);
            $result = $result->rowCount();
        } else $result=0;
        return $result;
    }
}

