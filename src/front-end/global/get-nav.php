<?php

function get_nav(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    echo '<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FurSure</a>
            <ul class="navbar-nav nav">
                <li class="navbar-nav"><a href="search">Search</a></li>
            </ul>
            <ul class="navbar-nav nav">
                <li><a href="messaging"><span class="glyphicon glyphicon-log-out"></span> Messages</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">';
            
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                echo '<li><a href="userprofile"><span class="glyphicon glyphicon-user"></span> ' . htmlspecialchars($_SESSION['username']) . '</a></li>';
                echo '<li><a href="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
            } else {
                echo '<li><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                echo '<li><a href="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            }

        echo '</ul>
        </div>
    </nav>';
}
?>
