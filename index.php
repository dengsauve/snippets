<?php

    if (isset($_POST['submit'])){

        // Get Variable Input
        $name = $_POST['name'];
        $description = $_POST['description'];
        $language = $_POST['language'];
        $body = $_POST['body'];

        $j_str = file_get_contents('resources/data/snippets.json');// Getting JSON file
        $json = json_decode($j_str, true);// Decode

        // Create array from input
        $snippetObj = array(
            'name' => $name,
            'description' => $description,
            'language' => $language,
            'body' => $body
        );

        array_push($json['snippets'], $snippetObj); // push changes into JSON array

        $j_out = json_encode($json); // Encode as JSON

        // Write the changes to file
        $fout = fopen('resources/data/snippets.json', 'w');
        fwrite($fout, $j_out);
        fclose($fout);
    }

    $contents = file_get_contents('resources/data/snippets.json');
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
        
        <div class="nav">
            Navigation
            
            <ul>
                <?php
                    foreach($groups as $name => $snippets) {
                        echo "<li><a href='#$name'>$name</a></li>";
                    }
                    ?>
            </ul>
        </div>
        
        <h1>
            ##########################<br/>
            # Dennis's Code Snippets #<br/>
            ##########################
        </h1>

        <br/>
        
        <p>New Snippet</p>

        <form action="/index.php" method="POST">
            <input class="form-control" type="text" name="name" placeholder="Enter Name">
            <input class="form-control" type="text" name="description" placeholder="Describe the snippet's function, etc.">
            <input class="form-control" type="text" name="language" placeholder="Provide the language">
            <textarea class="form-control" name="body" rows="8" placeholder="Code"></textarea>
            <input type="submit" value="Add Snippet" name="submit" />
        </form>


        <?php
        foreach($groups as $name => $snippets) {
            $top_bottom = str_repeat("#", strlen($name));
            echo "<h2>$top_bottom<br/>$name<br/>$top_bottom</h2><a name='$name' class='target'></a>";
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