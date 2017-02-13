<?php

$doc = new DomDocument;

// We need to validate our document before refering to the id
$doc->validateOnParse = true;
$doc->loadHtml(file_get_contents('create_post.php'));
echo "<pre>";
var_dump($doc->getElementById('selecteditems'));
echo "</pre>";

/*
$url = 'create_post.php';
$content = file_get_contents($url);
$first_step = explode( '<div id="selecteditems">' , $content );
$second_step = explode("</div>" , $first_step[1] );

echo $second_step[0];*/
?>