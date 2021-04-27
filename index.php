<!DOCTYPE html>
<html>
<head>
    <title>Template and styling</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono&subset=greek">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
    $url_authors = 'http://maqe.github.io/json/authors.json';
    $data_authors = file_get_contents($url_authors);
    $authors = json_decode($data_authors);

    $url_posts = 'http://maqe.github.io/json/posts.json';
    $data_posts = file_get_contents($url_posts);
    $posts = json_decode($data_posts);
    $posts_this_page = array_slice($posts, 0, 5);

    function time_elapsed($secs){
        $bit = array(
            ' year'      => $secs / 31556926 % 12,
            ' week'      => $secs / 604800 % 52,
            ' day'       => $secs / 86400 % 7,
            ' hour'      => $secs / 3600 % 24,
            ' minute'    => $secs / 60 % 60,
            ' second'    => $secs % 60
            );
           
        foreach($bit as $k => $v){
            if($v > 1)$ret[] = $v . $k . 's';
            if($v == 1)$ret[] = $v . $k;
        }
        array_splice($ret, count($ret)-1, 0, 'and');
        $ret[] = 'ago';
       
        return $ret[0] . ' ' .$ret[count($ret)-1];
    }

    $now_time = time();

    $offset = 0;
    $limit = 5;
    $total_pages = count($posts) / $limit;

    if(isset($_GET["page"])) {
        $page = $_GET["page"];
        $offset = ($page - 1) * $limit;
        $posts_this_page = array_slice($posts, $offset, $limit); 
        $previous = ($page == 1 ? $page : $page - 1);
        $next = ($page == $total_pages ? $page : $page + 1);
    } else {
        $page = 1;
        $offset = ($page - 1) * $limit;
        $posts_this_page = array_slice($posts, $offset, $limit); 
        $previous = ($page == 1 ? $page : $page - 1);
        $next = ($page == $total_pages ? $page : $page + 1);
    }
?>

<h2>MAQE Forums</h2>
<h3>Subtitle</h3>
<h4>Posts</h4>
<?php foreach ($posts_this_page as $post) : ?>
    <div class="card">
        <div class="card-post">
            <div class="card-detail">
                <?php 
                    echo "<img src=\"$post->image_url.\".png\"\" alt=\"Image Not Found\" style=\"width:160px;height:120px;\">"; 
                ?>
            </div>
            <div class="card-detail">
                <h4><?php echo $post->title; ?></h4>
                <p><?php echo $post->body; ?></p>
                <p class="time"><i class="far fa-clock"></i>&nbsp;<?php echo time_elapsed($now_time-strtotime($post->created_at)); ?></p>
            </div>
        </div>
        <?php foreach ($authors as $author) : if ($post->author_id == $author->id) {
                echo "<div class=\"card-author\">";
                echo "    <div class=\"card-detail\">";
                echo "        <img src=\"$author->avatar_url\" alt=\"Image Not Found\" class=\"avatar\">";
                echo "    </div>";
                echo "    <div class=\"card-detail\">";
                echo "        <p class=\"author-name\">$author->name</p>";
                echo "        <p>$author->role</p>";
                echo "        <p><i class=\"fas fa-map-marker-alt\"></i>&nbsp;$author->place</p>";
                echo "    </div>";
                echo "</div>";
            }
        ?>           
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php
    $page_link = "<div class=\"pagination\">";   
    for ($i=1; $i<=$total_pages; $i++) {
        if ($i == 1) {
            $page_link .= "<a href=\"index.php?page=$previous\">Previous</a>"; 
            $page_link .= "<a href='index.php?page=$i'";
            if ($page == $i) {
                $page_link .= ' class="active"';
            }
            $page_link .= ">$i</a>";
        } else if ($i == $total_pages) {
            $page_link .= "<a href='index.php?page=$i'";
            if ($page == $i) {
                $page_link .= ' class="active"';
            }
            $page_link .= ">$i</a>";
            $page_link .= "<a href=\"index.php?page=$next\">Next</a>";
        } else {
            $page_link .= "<a href='index.php?page=$i'";
            if ($page == $i) {
                $page_link .= ' class="active"';
            }
            $page_link .= ">$i</a>";
        }
    }
    echo $page_link . "</div>";  
?>
</body>
</html>