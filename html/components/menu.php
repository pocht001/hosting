<?php
/* В этом файле хранится верстка меню сайта.
 *
 */
if (isset($_SESSION['login'])) {
    $userLogin='Вы вошли как: '.$_SESSION['login'];
    $logInStyle="display:none;";
    $logOutStyle="display:block;";
}
else {
    $userLogin = '';
    $logInStyle="display:block;";
    $logOutStyle="display:none;";
}
return $menu = '
<div id="authform" style="'.$logInStyle.'">
<input type="text" name="login" placeholder="login" id="inpLogin" class="authform"><br>
<input type="password" name="password" placeholder="password" id="inpPass" class="authform"><br>
<input type="submit" name="SignIn" value="Авторизироваться" onclick="signIn(inpLogin.value,inpPass.value)" class="authform1"><br>
<!--<span id="authresult"></span>-->
</div>
<div id="outform" style="'.$logOutStyle.'">'.$userLogin.' 
<input type="submit" name="SignOut" value="Выйти" onclick="signOut()" class="authform1"><br>
</div>


<table id="headtable1">
  <tr>
  <td colspan="2">
		
<ul id="menu">
        <li><a href="#">О нас</a></li>
        <li>
                <a href="#">Статьи</a>
                <ul>
                        <li><a href="#">HTML</a></li>
                        <li><a href="#">CSS</a></li>
                        <li>
                            <a href="#">jQuery</a>
                            <ul>
                                <li><a href="#">Вступление</a></li>
                                <li><a href="#">Начальный</a></li>
                                <li><a href="#">Продвинутый</a></li>
                            </ul>
                        </li>
                </ul>
        </li>
        <li>
                <a href="#">Видео курс</a>
        </li>
        <li>
                <a href="#">Материалы</a>
        </li>
        <li>
                <a href="#">Форум</a>
        </li>
		</ul>  
  
</td>
  </tr>
  <tr>
    <td><ul id="searchTag"> <li>
    <form action="/search/searchonsite" method="POST">
    <input type=submit value="Расширенный поиск с фильтром"  class="searchButton">
    </form>
				</li><li>
				<input class="searchData" type="text" name="searchData" placeholder="Поиск по тегу" onkeyup="searchTag(this)">
				<ul id="si1"></ul>
				</form>
				</li>
    </td>
  </tr>
</table> 

  <div class="overlay"></div>
<div class="popup" id="popup1">
	<span class="close">X</span>
	<form action="#" method="POST">
  <p><b>Подпишитесь на новостную рассылку</b></p>
  <p>Ваш email: <input type="email" name="email" placeholder="test1@test.com"><Br>
  Имя, фамилия: <input type="text" name="name" placeholder="Джон Смитт"></p>
  <p><span class="subscribe">Подписаться</span></p>
 </form>
</div>
	<script src="/resources/js/popup.js"></script>
	
';
