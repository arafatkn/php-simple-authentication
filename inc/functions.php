<?php

    session_start();

    function is_logged()
    {
        if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]>0)
            return true;
        else
            return false;
    }
    
    function redir( $url )
    {
        header("Location:".$url);
    }

    function get($var, $def='')
    {
        return isset($_GET[$var])?$_GET[$var]:$def;
    }

    function post($var, $def='')
    {
        return isset($_POST[$var])?$_POST[$var]:$def;
    }

    function request($var, $def='')
    {
        return isset($_REQUEST[$var])?$_REQUEST[$var]:$def;
    }

    function showError($errors)
    {
        $html = '<div class="alert alert-danger" role="alert">';
        foreach($errors as $error)
        {
            $html .= $error.'<br/>';
        }
        return $html.'</div>';
    }

    function showMessage($var = "message", $type = "success")
    {
        if(!isset($_SESSION[$var])) return;
        $html = '<div class="alert alert-'.$type.'" role="alert">'.$_SESSION[$var].'</div>';
        unset($_SESSION[$var]);
        return $html;
    }

    function getCurrentUser()
    {
        global $mysqli;
        $uid = isset($_SESSION["user_id"])?$_SESSION["user_id"]:0;
        $result = $mysqli->query("SELECT * FROM users WHERE id='$uid' LIMIT 1");
        if($result->num_rows==0)    return false;
        return $result->fetch_assoc();
    }

?>