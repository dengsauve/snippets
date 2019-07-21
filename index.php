<?php
    $contents = file_get_contents('snippets.json');

    $snippets = json_decode($contents)->snippets;

    $languages = [];

    foreach($snippets as $snippet) {
        if(!in_array($snippet->language, $languages)) {
            array_push($languages, $snippet->language);
        }
    }

    var_dump($languages);

?>

<html>
    <head>
        <title>Dennis's Code Snippets</title>

        <link rel="stylesheet" href="snippets-style.css"/>
    </head>
    <body>

    </body>
</html>