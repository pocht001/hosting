<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 17.10.2018
 * Time: 2:17
 */

class p404
{
    public function a404($params = null)
    {   echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404</title>
    <link rel="stylesheet" href="/resources/css/news.css" type="text/css" >
</head>
<body style="background-image: url('.BGBODY.');">
<h1>404. PAGE NOT FOUND.<br>
Бедося драмушка.</h1><br>
</body>
    ';

        return true;
    }
}
?>
