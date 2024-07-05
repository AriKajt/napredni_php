<?php

$connection = mysqli_connect('localhost', 'algebra', 'algebra', 'videoteka');

if($connection === false){
    die("Connection failed: ". mysqli_connect_error());
}

$sql = "SELECT * from zanrovi;";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die("There are no genres in our database!");
}

$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = "Zanrovi - Admin";

require 'genres.view.php';