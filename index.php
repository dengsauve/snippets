<?php
    
    $contents = file_get_contents('snippets.json');
    $snippets = json_decode($contents)->snippets;
    
    // Get languages and groups
    $languages = [];
    $groups = array();
    foreach($snippets as $snippet) {
        if(!in_array($snippet->language, $languages)) {
            array_push($languages, $snippet->language);
            $groups[$snippet->language] = [];
        }
        
        array_push($groups[$snippet->language], $snippet);
    }
?>

<html>
    <head>
        <title>Dennis's Code Snippets</title>

        <link rel="stylesheet" href="/resources/css/prism.css" />
        <link rel="stylesheet" href="/resources/css/snippets-style.css" />
    </head>
    <body>
        <h1>
            ##########################<br/>
            # Dennis's Code Snippets #<br/>
            ##########################
        </h1>

        Navigation
        
        <ul>
            <?php
                foreach($groups as $name => $snippets) {
                    echo "<li><a href='#$name'>$name</a></li>";
                }
            ?>
        </ul>

        <?php
        foreach($groups as $name => $snippets) {
            $top_bottom = str_repeat("#", strlen($name));
            echo "<h2>$top_bottom<br/><a name='$name'>$name</a><br/>$top_bottom</h2>";
            foreach($snippets as $snippet) {
                echo "<h3>$snippet->name <br/> <small>$snippet->description</small></h3>";
                $body = $snippet->body;
                if($name == "html") {
                    $body = htmlspecialchars($body);
                }
                echo "<pre><code class='language-$name'>$body</code></pre>";
            }
            echo "<br/><br/><br/>";
        }
        ?>


        <script src="/resources/js/prism.js"></script>
    </body>
</html>