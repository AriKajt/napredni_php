<?php

$connection = mysqli_connect('localhost', 'algebra', 'algebra', 'videoteka');

if ($connection === false) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
    f.id, 
    f.naslov, 
    f.godina, 
    z.ime as zanr, 
    GROUP_CONCAT(DISTINCT m.tip) AS medij, 
    c.tip_filma
FROM
    kopija k
    JOIN filmovi f ON f.id = k.film_id
    JOIN zanrovi z ON z.id = f.zanr_id
    JOIN mediji m ON m.id = k.medij_id
    JOIN cjenik c ON c.id = f.cjenik_id
GROUP BY f.id
ORDER BY 
    f.godina DESC, 
    f.naslov;
";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die("There are no movies in our database!");
}

$movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($movies as $key => $movie)
{
    $mediji[$key] = explode(',', $movie['medij']);
    $movies[$key]['medij'] = $mediji[$key];
}


$sql = "SELECT 
    f.id, 
    f.naslov, 
    f.godina, 
    z.ime as zanr, 
    c.tip_filma
FROM
    kopija k
    JOIN mediji m ON m.id = k.medij_id
    RIGHT JOIN filmovi f ON f.id = k.film_id
    JOIN zanrovi z ON z.id = f.zanr_id
    JOIN cjenik c ON c.id = f.cjenik_id
WHERE m.tip IS NULL
GROUP BY f.id
ORDER BY 
    f.godina DESC, 
    f.naslov;
";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) === 0) {
    die("There are no movies to be discarded in our database!");
}

$moviesDiscard = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

$title = "Filmovi - Admin";

require 'movies.view.php';