<?php

function get_nav(){
    echo '<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FurSure</a>
            <ul class="navbar-nav nav">
                <li class="navbar-nav"><a href="search">Search</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </nav>';
}
?>
