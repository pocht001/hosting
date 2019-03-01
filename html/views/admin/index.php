<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Админка!</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости.</title>
    <link rel="stylesheet" href="/resources/css/paginator.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/admin.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/comments.css" type="text/css" >
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="/resources/js/admin/adminAuth.js"></script>
    <script src="/resources/js/paginator.js"></script>
</head>
<body>
<?php
if (!isset($message)) $message='';
$adminAuth = include(ROOT . '/components/adminAuth.php');

echo $adminAuth;

?>
</body>
</html>
