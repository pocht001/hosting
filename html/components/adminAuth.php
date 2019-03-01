<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 01.02.2019
 * Time: 11:48
 */

if (isset($_SESSION['admin_login'])) {
    $adminLogin='Вы вошли как: '.$_SESSION['admin_login'];
    $adminLogInStyle="display:none;";
    $adminLogOutStyle="display:block;";
}
else {
    $adminLogin = '';
    $adminLogInStyle="display:block;";
    $adminLogOutStyle="display:none;";
}

$adminAuth = $message.'
<div id="adminAuth" style="'.$adminLogInStyle.'">
<h2>Admin area</h2>
<input type="text" name="login" placeholder="login" id="inpLogin" class="authform"><br>
<input type="password" name="password" placeholder="password" id="inpPass" class="authform"><br>
<input type="submit" name="SignIn" value="Авторизироваться" onclick="adminAuth(inpLogin.value,inpPass.value)" class="authform1"><br>
</div>
<div id="adminLogout" style="'.$adminLogOutStyle.'">'.$adminLogin.' 
<input type="submit" name="SignOut" value="Выйти" onclick="admLogOut()" class="authform1"><br>
</div>
';

$adminContent = '
<table id="adminStructure">
<tr>
    <td class="adminMenu1">
        <ul class="adminMenu">
            <li><a href="/admin">Главная</a></li>
            <li><a href="/admin/cathegories">Категории</a></li>
            <li><a href="/admin/news">Новости</a></li>
                <ul><li><a href="/admin/news/add">Добавление новостей</a></li></ul>
                <ul><li><a href="/admin/news/edit">Редактирование новостей</a></li></ul>
            <li><a href="/admin/comments">Комментарии</a>
                <ul><li><a href="/admin/comments/add">Добавление комментариев</a></li></ul>
                <ul><li><a href="/admin/comments/edit">Редактирование комментариев</a></li></ul>
                <ul><li><a href="/admin/comments/moderation">Модерация</a></li></ul>
            </li>
            <li><a href="/admin/rb">Рекламные блоки</a>
                <ul><li><a href="/admin/rb/add">Добавление рекламных блоков</a></li></ul>
            </li>
            <li><a href="/admin/menu">Меню</a></li>
            <li><a href="/admin/background">Фон</a><br/></li>
        </ul>
    </td>
<td>'.$content.'</td><td> </td>
</tr>
</table>
';
if (isset($_SESSION['admin_id'])) {
    $adminAuth .= $adminContent;
}

return $adminAuth;