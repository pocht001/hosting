<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости.</title>
    <link rel="stylesheet" href="/resources/css/news.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/menu.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/slider.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/paginator.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/comments.css" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/resources/js/slider.js"></script>
    <script src="/resources/js/searchTag.js"></script>
    <script src="/resources/js/paginator.js"></script>
    <script src="/resources/js/signIn.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="/resources/js/recl.js"></script>

</head>
<body style="background-image: url(<?php echo BGBODY; ?>);">

<header id = "menucontainer" style="background-color: <?php echo BGHEAD; ?>;">
    <?php
    //Меню сделано в отдельном файле menu.php
    //Его и подключаем и содержимое выводим
    $menu = include(ROOT . '/components/menu1.php');
    echo $menu1;
    //if (isset($_SESSION)) var_dump($_SESSION); echo "<br>";
    ?>
</header>
<table cellspacing="0" cellpadding="4" class="main">
    <tr>
        <td width="208">
            <?php
            //Рекламы левого и правого сайдбара хранятся в массиве, в файле sidebar.php
            $reclama = include(ROOT . '/components/reclama.php');
            echo $reclama['left'];
            ?>
        </td>

        <td>
            <div>
                <?php

                $slider = include(ROOT.'/components/slider.php');
                echo $slider;
                ?>
            </div>
            <div class="newsCath">
                <?php

                //Выводим список новостей с таким тегом
                if ($userComment) {
                    $cntp = count($userComment); //cntp - count this comments on page
                }
                else $cntp=0;

                if ($cntp) { //проверяем есть ли вообще новости с таким тегом на этой странице
                    echo "<h3>Все комментарии комментатора <b>".$commentator['login']."</b>:</h3>";
                    for ($i=0;$i<$cntp;$i++) {
                        echo "<p><span class='commentatribute'>".$userComment[$i]['date']."</span> ";
                        echo "<span class='commenttext'>".nl2br($userComment[$i]['text'])."</span></br>";
                        echo " <span class='commentatribute'>Коммент понравился: ".$userComment[$i]['likes'].", 
                         не понравился: ".$userComment[$i]['dislikes'].". </span></p>";
                    }

                    //По количеству новостей определяем количество страниц и нужен ли пагинатор
                    if ($cun>5) {
                        $countPages = ceil($cun/5);
                        $paginator1 = new Paginator();
                        echo $paginator1->pag('/usercomments/'.$commentatorId.'/',$countPages, $page);
                    }

                } else echo "Неизвестный комментатор.";

                ?>
            </div>
        </td>

        <td width="208">
            <?php
            //Рекламы правого сайдбара (как и левого) берем из массива $sidebar в файле sidebar.php
            //Этот файл подключен в колонке левого сайдбара.
            echo $reclama['right'];
            ?>
        </td>
    </tr>
</table>
</body>
</html>

