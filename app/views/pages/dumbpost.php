<?php $userPosts = $postObj->getPost($_SESSION["userID"]);

foreach ($userPosts as $row_post):?>

    $postId       = $row_post["postId"];
    $name         = $row_post["userName"];
    $hashTags     = $row_post["hashTags"];
    $userTags     = $row_post["userTags"];
    $content         = $row_post["content"];
    $image        = $row_post["image"];
    $comments     = $row_post["comments"];
    $promotes     = $row_post["promotes"];
    $shares       = $row_post["shares"];
    $created_at = $row_post["created_at"];
    
    $hashTags = !empty($hashTags) ? explode(",", $hashTags) : [];
    $userTags = !empty($userTags) ? explode(",", $userTags) : [];

<?php endforeach;?>