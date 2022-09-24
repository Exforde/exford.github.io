<?php

    // Redirect to Error 401 Page
    function redirectError401() {
        redirectToPage('Error401.php');
    }

    function redirectToPage($page) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$page");
    }
?>