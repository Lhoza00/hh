<?php
// $DB, $post supplied by PagesController::postView()
$profile_data['userID'] = $_SESSION['myuserId']; // or wherever you get this
$user_post = $post->getPost($profile_data['userID']);

ob_start(); // Start output buffering to capture HTML

if(!empty($user_post)){
    foreach($user_post as $row_post){
        if(htmlspecialchars($profile_data['userID']) == htmlspecialchars($row_post['userID'])){
            require __DIR__ . '/post.php';  // This will output the HTML of a single post
        }
    }
}

$html = ob_get_clean(); // Get all HTML from the buffer
echo $html; // Send HTML back to JS
?>
