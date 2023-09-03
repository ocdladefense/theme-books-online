
    <?php
        $file = "books/{$book}/chapters/chapter-{$chapter}/title.html";
        $path = $contentPath . "/$file";
        @include $path;
    ?>
    

    <?php
        $file = "books/{$book}/chapters/chapter-{$chapter}/authors.html";
        $path = $contentPath . "/$file";
        @include $path;
    ?>

    

    <?php 
        $file = "books/{$book}/chapters/chapter-{$chapter}/content";
        // if(file_exists()).html";
        $path = $contentPath . "/$file";
        if(file_exists($path . ".php")) {
            require "{$path}.php";
        }
        else {
            $success = @include "{$path}.html";
            if(!$success) {
                include $contentPath . "/books/chapter-not-found.html";
            }
        }
    ?>
