<?php
$menuArray=Config::getMenu();
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
$menu1 = '
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
		
<ul id="menu">';
$subItem=array();
for ($i=0;$i<count($menuArray);$i++) {
    $menu1.='
       <li><a href="'.$menuArray[$i]['link'].'">'.$menuArray[$i]['menu_item'].'</a>';
    if (isset($menuArray[$i]['si'])) {
        $subItem=$menuArray[$i]['si'];
          $menu1 .= '<ul>';
            for ($j=0;$j<count($subItem);$j++) {

            $menu1 .= '<li><a href="'.$subItem[$j]['link'].'">'.$subItem[$j]['menu_item'].'</a>';
            if (isset($subItem[$j]['ssi'])) {
                $subSubItem=$subItem[$j]['ssi'];
                $menu1 .= '<ul>';
                for ($k=0;$k<count($subSubItem);$k++) {
                    $menu1 .= '<li><a href="'.$subSubItem[$k]['link'].'">'.$subSubItem[$k]['menu_item'].'</a></li>';
                }
                $menu1 .= '</ul>';
            }
            $menu1 .= '</li>';

        }
        $menu1 .= '</ul>';

    }
    $menu1.='</li>';
}


$menu1 .= '</ul>  
  
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
return $menu1;