<!--Раздел Добавления рекламных блоков в админке.-->
<script src="/resources/js/admin/news.js"></script>
<?php
$content = '<h3>Тут можно добавить рекламные блоки.</h3>';
$content.=' <form action="/admin/rb/add" method="POST" enctype="multipart/form-data">
 <div id="rb_added"> </div> <!--Сообщение об ошибке/успехе-->
 <div id="addrb">';// Блок с полями ввода для рекламы

$content .= '
<p>Название товара*:<br/><input type="text" id="productName" name="productName" size="32" autofocus></p>
<p>Цена*:<br/><input type="number" name="price" id="price" value="1000" min="10" max="200000" step="1"></p>
<p>Продавец*:<br/><input type="text" name="seller" id="seller" size="48"></p>
';

$content .= '<p><input type="checkbox" id="active" name="active" checked>
<label for="active">Активировать</label></p>';

/** Радиокнопки на какую сторону добавлять */
$content .= '<p>На какую сторону добавляем:<br/>
<input type="radio" id="sideL"
     name="side" value="L">
    <label for="sideL">Левый сайдбар</label>

    <input type="radio" id="sideR"
     name="side" value="R">
    <label for="sideR">Правый сайдбар</label>
</p>';

$content .= '<div>Добавить картинку: <input type="file" name="file" ></div>';

$content.='<p><input type="submit" class="but" value="Добавить рекламный блок"></p>
</div></form>
';

return $content;