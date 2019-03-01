<?php

include_once ROOT.'/components/Db.php';
class News
{

/**
 * Returns single news item with specified id
 * @param integer $id
 */
    public static function getNewsItemById($id)
    {
       $id = intval($id);
        //Запрос к б.д.
       if ($id) {
           $db = Db::getConnection();
           $result = $db->query('SELECT * FROM news WHERE id=' . $id);

           $row = $result->fetch();
           $newsItem['id'] = $row['id'];
           $newsItem['theme'] = $row['theme'];
           $newsItem['cathegory'] = $row['cathegory'];
           $newsItem['text'] = $row['text'];
           $newsItem['isanalytic'] = $row['isanalytic'];
           $newsItem['pictures'] = self::newsItemPicturesList($id);
           $newsItem['tags'] = $row['tags'];
           return $newsItem;
       }
    }

    /**
     * Returns an array of news items
     */
    public static function getNewsList($limit=0, $offset=0)
    {
        // Запрос к б.д.
        $db = Db::getConnection();
        $newsList = array();

        $query = 'SELECT id, theme, cathegory, publicDate FROM news ORDER BY id DESC';
        if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
        elseif ($limit) $query = $query.' LIMIT '.$limit;
        $result = $db->query($query);
        $i=0;
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = (int)$row['id'];
            $newsList[$i]['theme'] = $row['theme'];
            $newsList[$i]['cathegory'] = $row['cathegory'];
            $newsList[$i]['publicDate'] = $row['publicDate'];
            $i++;
        }
        return $newsList;
    }

    /**
     * Returns an array of news items by cathegory
     */
     public static function getNewsListByCathegory($cathegory, $limit=0, $offset=0)
     {
         $newsListCathegory = array();

         $cath = Cathegories::cathegoryName($cathegory);
         if ($cath) {
         $db = Db::getConnection();

         if ($cathegory == 'analytics') {
             $query = 'SELECT id, theme, cathegory, isanalytic 
                        FROM news WHERE isanalytic = 1
                        ORDER BY id DESC';
         }
         //Если категория - не аналитика - выборку делаем из базы по категории
         else $query = 'SELECT id, theme, cathegory , isanalytic
                        FROM news WHERE cathegory = "'.$cath.'"
                        ORDER BY id DESC';
         if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
         elseif ($limit) $query = $query.' LIMIT '.$limit;
         //echo $query.'</br>';
         $result = $db->query($query);
         $i=0;
         while ($row = $result->fetch()) {
             $newsListCathegory[$i]['id'] = $row['id'];
             $newsListCathegory[$i]['theme'] = $row['theme'];
             $newsListCathegory[$i]['cathegory'] = $row['cathegory'];
             $newsListCathegory[$i]['isanalytic'] = $row['isanalytic'];
             $i++;
         }}
        return $newsListCathegory;
     }

     //Метод для подсчета сколько у нас новостей всего.
     public static function getCountNews($cathegory='all')
     {
         $cath = Cathegories::cathegoryName($cathegory);
         if ($cath || $cathegory=='all') {
         $db = Db::getConnection();
         if ($cathegory=='all') { //если all - значит выгрести из базы все подряд новости
             $query = 'SELECT COUNT(*) FROM news';
         }
         elseif ($cathegory == 'analytics') {
             //echo 'аналитика это!!!</br>';
             //Если категория - аналитика выборку делаем по флагу isanalytic = 1
             $query = 'SELECT COUNT(*) 
                        FROM news WHERE isanalytic = 1';
         } //Если категория - не аналитика - выборку делаем из базы по категории
         elseif(strlen($cathegory)) $query = 'SELECT COUNT(*)
                        FROM news WHERE cathegory = "' . $cath . '"';
     }

         $result = $db->query($query);
         $count = $result->fetch();
         return $count;
     }

    //Ищем картинки данной новости.
     public static function newsItemPicturesList($id) {
         //Картинки должны быть с расширением в нижнем регистре
         $picturesList = glob(ROOT.'/resources/images/news/{'
             .$id.'-*.jpg,'.$id.'-*.png,'.$id.'-*.JPG,'.$id.'-*.PNG,'.$id.'-*.gif,
                '.$id.'-*.GIF,'.$id.'-*.jpeg,'.$id.'-*.JPEG,'.$id.'-*.bmp,'.$id.'-*.BMP}',
             GLOB_BRACE);

         //Вытягиваем с полного локального пути само название файла
         $countPictures = count($picturesList);
         for ($i=0;$i<$countPictures;$i++) {
             $pictures = explode('/',$picturesList[$i]);
             $picturesList[$i] = end($pictures);
             }
             //var_dump($picturesList);
         return $picturesList;
}

/** Получить последние 4 новости, с картинками для слайдера.
 */
     public static function sliderList() {
        $lastNews = self::getNewsList(4);

        $sliderNewsImage = array();

         for ($i = 0; $i<4; $i++) {
            $sliderNewsImage[$i] = self::newsItemPicturesList($lastNews[$i]['id']);
            if ($sliderNewsImage[$i]) {
                $lastNews[$i]['image'] = $sliderNewsImage[$i][0];
            } else {
                $lastNews[$i]['image'] = 'default.jpg';
            }
        }
        //var_dump($lastNews);
        return $lastNews;
     }


    /** Получить список id новостей для быстрого определения есть ли новость с таким id
     */
    public static function getNewsId() {
        $commentsId = array();
        $db = Db::getConnection();
        $query = 'SELECT id FROM news';

        $result = $db->query($query);
        $i=0;
        while ($row = $result->fetch()) {
            $newsIds[$i] = (int)$row['id'];

            $i++;
        }
        return $newsIds;
    }

    /** Получение количества прочитавших за все время новость.
     */
    public static function haveReadNew($newsId)
    {
        $newsId = intval($newsId);
        //Запрос к б.д.
        if ($newsId) {
            $db = Db::getConnection();
            $result = $db->query('SELECT `HaveRead` FROM news WHERE id=' . $newsId);

            $row = $result->fetch();
            $haveReadNew = $row['HaveRead'];

            return $haveReadNew;
        }
    }

    /** Увеличить чило прочитавших за все время новость.
     */
    public static function AddnewReaders($newsId,$readersAdd)
    {
        $newsId = intval($newsId);
        $readersAdd = intval($readersAdd);
        //Запрос к б.д.
        if ($newsId) {
            $db = Db::getConnection();
            $query = 'UPDATE news SET HaveRead=HaveRead+'.$readersAdd.' WHERE id='.$newsId;
            $result = $db->query($query);

        }
    }

    /** Получить категорию новости по её id
     */
    public static function getNewsCathegoryById($newsId) {
        $newsId = intval($newsId);
        $newsCath='uknown';
        if ($newsId) {
            $db = Db::getConnection();
            $query = 'SELECT cathegory FROM news WHERE id='.$newsId;
            $result = $db->query($query);
            $newsCath = $result->fetch();
        }
        return $newsCath;
    }

    /** Получить новости по параметрам фильтра
     */
    public static function getNewsByFilterSearch($filter=null) {
        //Проверяем выбраны ли параметры фильтра
        if (!$filter['date_begin'] && !$filter['date_end'] && !$filter['tags'] && !$filter['cathegories'])
            $res['message']='Параметры фильтра не заданы';
        //Проверяем чтобы дата начала<дата конца
        elseif ($filter['date_begin'] > $filter['date_end'] && $filter['date_end'])
            $res['message'] = "Дата начала публикации не может быть больше даты конца";
        else {
            $query = 'SELECT id, theme, cathegory, isanalytic, publicDate FROM news';
            if ($filter['date_begin']) $query .= ' WHERE publicDate > "'.$filter['date_begin'].'"';
            if ($filter['date_end']) {
                if ($filter['date_begin']) $query .= ' AND publicDate < "'.$filter['date_end'].'"';
                else $query .= ' WHERE publicDate < "'.$filter['date_end'].'"';
            }
            if ($filter['tags']) {
                if ($filter['date_begin'] || $filter['date_end']) $query .=' AND (';
                else $query .= ' WHERE (';
                for ($i=0;$i<count($filter['tags']);$i++) {
                    $filter['tags'][$i] = filter_var($filter['tags'][$i], FILTER_SANITIZE_STRING);
                    $query .= '(tags LIKE "'.$filter['tags'][$i].', %" OR tags LIKE "%, '.$filter['tags'][$i].', %"
                OR tags LIKE "%, '.$filter['tags'][$i].'" OR tags LIKE "'.$filter['tags'][$i].'") ';
                    if ($i!=(count($filter['tags'])-1)) $query .= 'OR ';
                    else $query .= ') ';
                }
            }
            if ($filter['cathegories']) {
                if ($filter['date_begin'] || $filter['date_end'] || $filter['tags']) $query .=' AND (';
                else $query .= ' WHERE (';
                for ($i=0;$i<count($filter['cathegories']);$i++) {
                    if ($filter['cathegories'][$i]=='аналитика') { $query .= '(isanalytic=1) '; }
                    else {
                        $query .= '(cathegory LIKE "'.$filter['cathegories'][$i].', %" OR cathegory LIKE "%, '.$filter['cathegories'][$i].', %"
                OR cathegory LIKE "%, '.$filter['cathegories'][$i].'" OR cathegory LIKE "'.$filter['cathegories'][$i].'") ';
                    }

                    if ($i!=(count($filter['cathegories'])-1)) $query .= 'OR ';
                    else $query .= ') ';
                }
            }
            $db=Db::getConnection();
            $result = $db->query($query);
            $news = array();
            $i=0;
            while ($row = $result->fetch()) {
                //id, theme, cathegory, isanalytic, publicDate
                $news[$i]['id'] = $row['id'];
                $news[$i]['theme'] = $row['theme'];
                $news[$i]['cathegory'] = $row['cathegory'];
                $news[$i]['isanalytic'] = $row['isanalytic'];
                $news[$i]['publicDate'] = $row['publicDate'];

                $i++;
            }
            if (count($news)) $res=$news;
            else $res['message'] = "По Вашему запросу ничего не найдено";
        }
        return $res;
    }


    /** Для внутренних целей.
     * */
public static function dateInserta() {
        $db=Db::getConnection();
        for ($i=1;$i<=31;$i++) {
            $sm=100+$i;
            if ($i<10)
                $query = 'UPDATE news SET publicDate="2019-01-0'.$i.' 15:43:16" WHERE id='.$sm;
            else $query = 'UPDATE news SET publicDate="2019-01-'.$i.' 16:43:16" WHERE id='.$sm;
            $result = $db->query($query);
        }
return true;
}

public static function addNewsItem($newTheme, $newText, $cathegory, $isanalytic=0, $tagstring='') {
    //Проверяем адекватность входных значений
    if (strlen($newTheme) && strlen($newText) && strlen($cathegory)) {
        //если входные параметры ок - делаем запрос к базе
        $newTheme = filter_var($newTheme, FILTER_SANITIZE_STRING);
        $newText = filter_var($newText, FILTER_SANITIZE_STRING);
        $tagstring = filter_var($tagstring, FILTER_SANITIZE_STRING);
        $db = Db::getConnection();
        $query = 'INSERT INTO news (theme, text, cathegory, isanalytic, tags)
            VALUES ("'.$newTheme.'", "'.$newText.'", "'.$cathegory.'", '.$isanalytic.', "'.$tagstring.'")';

        $result = $db->query($query);
        if ($result) {
            $res  = $db->query("SELECT LAST_INSERT_ID()");
            $resultId = $res->fetchColumn();
            return $resultId;
        }
    }
    return false;
}

public static function updateNewsItem($newsItem=null) {
    if (is_array($newsItem)) {

        $query='UPDATE news SET ';
        foreach ($newsItem as $key=>$value) {
            if ($key == 'file') {
                if (strlen($newsItem['file'])) {
                    //echo $newsItem['file'];
                }
            }
            elseif ($key == 'isanalytic') $query.='isanalytic=1, ';
            elseif($key=='id') {}
            else {
                if (($key=='text'||$key=='theme')&&!strlen($value)) return 0;
                $value = filter_var($value, FILTER_SANITIZE_STRING);
                $query .= $key.'="'.$value.'", ';
            }
        }
        if (!array_key_exists('isanalytic', $newsItem)) $query.='isanalytic=0, ';
        $query=trim($query,', ');
        $query.=' WHERE id='.$newsItem['id'];

    }
    $db = Db::getConnection();
    $result = $db->query($query);
    $result = $result->rowCount();
    return $result;
    //var_dump($query);
}

public static function dellFile($fileName) {
    if (!file_exists(ROOT.$fileName)) {$result="Файл не найден";}
    elseif (unlink(ROOT.$fileName)) { $result = "Файл удален"; }
    else { $result = "Ошибка при удалении файла"; }
    return $result;
}


    public static function can_upload($file){
        // если имя пустое, значит файл не выбран
        if($file['name'] == '')
            return '';//'Вы не выбрали файл.';

        /* если размер файла 0, значит его не пропустили настройки
        сервера из-за того, что он слишком большой */
        if($file['size'] == 0)
            return 'Файл слишком большой.';

        // разбиваем имя файла по точке и получаем массив
        $getMime = explode('.', $file['name']);
        // нас интересует последний элемент массива - расширение
        $mime = strtolower(end($getMime));
        // объявим массив допустимых расширений
        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

        // если расширение не входит в список допустимых - return
        if(!in_array($mime, $types))
            return 'Недопустимый тип файла.';

        return $mime;
    }

    public static function make_upload($file,$name){
        copy($file['tmp_name'], $name);
    }

}
