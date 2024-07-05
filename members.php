<?php

// MVC pattern -> Model - View - Controller

$connection = mysqli_connect('localhost', 'algebra', 'algebra', 'videoteka');

if($connection === false){
    die("Connection failed: ". mysqli_connect_error());
}

$sql = "SELECT * from clanovi;";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die("There are no memebers in our database!");
}

$members = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = "Clanovi - Admin";

require 'members.view.php';


//<!-- partials-header-included-in-members-view -->

//<!-- partials-sidebar-included-in-header -->
//<!-- line between sidebar and nav added in header.php -->
//<!-- partials-nav-included-in-header -->

//<!-- main-members-view -->
//<!-- partials-footer-included-in-members-view -->