<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 16.12.2018
 * Time: 0:38
 */
include_once ROOT.'/models/Admins.php';
include_once ROOT.'/models/Users.php';

class UserController
{
    public function actionSignIn() {
        $userLogin = (isset($_POST['userlogin'])) ? $_POST['userlogin'] : '';
        $userPassword = (isset($_POST['userpass'])) ? $_POST['userpass'] : '';
        $authResult='';

        if ($userLogin && $userPassword) {
            $authResult=Users::auth($userLogin,$userPassword);
        }
        $authRes = "[]";
        if ($authResult) {

            if ($userPassword == $authResult['password']) {

                session_start();
                $_SESSION['login']=$userLogin;
                $_SESSION['id']=$authResult['id'];

                $authRes = json_encode($_SESSION);//($authResult);
            }
        }
        echo $authRes;

        return true;
    }

    public function actionSignOut() {

        session_start();
        $_SESSION['login']=null;//'';
        $_SESSION['id']=null;//'';
        //session_destroy();
        echo '{"result":"true"}';

        return true;
    }

    public function actionTopCommentators() {
        $userIdList = Users::getUserIdList();
        $max=array();
        $max[1]['count']=$max[2]['count']=$max[3]['count']=$max[4]['count']=$max[5]['count']=0;
        for ($i=0;$i<count($userIdList);$i++) {
            $userCommentCount[$i] = Comments::getCountCommentsByUser($userIdList[$i]);
            if ($userCommentCount[$i]>$max[1]['count']) {
                $max[2] = $max[1];
                $max[1]['count'] = $userCommentCount[$i];
                $max[1]['userId'] = $userIdList[$i];
                $max[1]['commentator'] = Users::userInfById($userIdList[$i])['login'];
            } else if ($userCommentCount[$i]>$max[2]['count']) {
                $max[3] = $max[2];
                $max[2]['count'] = $userCommentCount[$i];
                $max[2]['userId'] = $userIdList[$i];
                $max[2]['commentator'] = Users::userInfById($userIdList[$i])['login'];
            } else if ($userCommentCount[$i]>$max[3]['count']) {
                $max[4] = $max[3];
                $max[3]['count'] = $userCommentCount[$i];
                $max[3]['userId'] = $userIdList[$i];
                $max[3]['commentator'] = Users::userInfById($userIdList[$i])['login'];
            } else if ($userCommentCount[$i]>$max[4]['count']) {
                $max[5] = $max[4];
                $max[4]['count'] = $userCommentCount[$i];
                $max[4]['userId'] = $userIdList[$i];
                $max[4]['commentator'] = Users::userInfById($userIdList[$i])['login'];
            } else if ($userCommentCount[$i]>$max[5]['count']) {
                $max[5]['count'] = $userCommentCount[$i];
                $max[5]['userId'] = $userIdList[$i];
                $max[5]['commentator'] = Users::userInfById($userIdList[$i])['login'];
            }
        }
        return $max;
    }

    public function actionAdminAuth() {
        $adminLogin = (isset($_POST['admin_login'])) ? $_POST['admin_login'] : '';
        $adminPassword = (isset($_POST['admin_pass'])) ? $_POST['admin_pass'] : '';
        $authResult='';

        if ($adminLogin && $adminPassword) {
            $authResult=Admins::auth($adminLogin,$adminPassword);
        }
        $authRes = "[]";
        //echo $authRes;
        if ($authResult) {

            if ($adminPassword == $authResult['password']) {

                session_start();
                $_SESSION['admin_login']=$adminLogin;
                $_SESSION['admin_id']=$authResult['id'];

                $authRes = json_encode($_SESSION);//($authResult);
            }
        }
        echo $authRes;

        return true;
    }

    public function actionAdminLogOut() {

        session_start();
        $_SESSION['admin_login']=null;//'';
        $_SESSION['admin_id']=null;//'';
        //session_destroy();
        echo '{"result":"true"}';

        return true;
    }
}