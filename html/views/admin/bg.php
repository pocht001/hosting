<!--Раздел установки фона шапки и страниц сайта.-->
<script src="/resources/js/admin/bg.js"></script>
<?php
/** Фон хедера - цвет и фон страниц - картинка */;
$content = '<h3>Админка. Раздел редактирования фонов.</h3>';

$content.=' <div id="rb_added"> </div> <!--Сообщение об ошибке/успехе-->
 <form action="/admin/background" method="POST" enctype="multipart/form-data"> ';

$content .= '<div>Добавить картинку для фона страниц:<br/> 
 <input type="file" name="file" ></div>';

$content.='<p><input type="submit" class="but" value="Установить выбранную фоновую картинку."></p>
</div></form>';

$content .= '<p><button onclick="defBg()">Сбросить по умолчанию.</button></p>';

$hbg = Config::getHBg();
$content .= '<p>Укажите цвет фона шапки: <input type="color" name="hbg" value="'.$hbg.'" id="hbg">
   <button onclick="hBg(hbg.value)">Задать цвет шапке!</button></p>';

return $content;