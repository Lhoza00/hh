<?php
    $promoted = $post->isPromoted($row_post['postID'], htmlspecialchars($_SESSION['myuserId']));
    $likes = $post->getLikes($row_post['postID'], "promote");
    $liked = count($likes);
    //$exString = explode("_", $_SESSION['myuserId']);
    //$subType = $exString[0];a
?>
<!--Video and Picture post -->
<?php if(file_exists($row_post['image']) && $row_post['hasImage'] > 0): ?>
    <div class="video-post">
        <div class="caption-wrap">
            <div class="caption-captured">
                <?php if($_SESSION["myuserId"] == $profile_data['userID']):?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?deleteId=' . htmlspecialchars($row_post['postID']);?>">
                        <span name="deletePost" id="trash"><i class="fa-solid fa-trash"></i></span>
                    </a>
                <?php endif;?>
                <div id="userName">
                    <?php if (!empty($user_post)): ?>
                        <a href="profile.php?userName=<?php echo urlencode($row_post['userName']); ?>">
                            <?php echo htmlspecialchars($row_post["userName"]);?>
                        </a>
                    <?php endif; ?>
                    
                </div>
                <div id="hashTags">
                    <?php if (!empty($user_post)) {
                        echo htmlspecialchars($row_post["hashTags"]);
                    } ?>
                </div>
                <div id="userTags">
                    <?php if (!empty($user_post)) {
                        echo htmlspecialchars($row_post["userTags"]);
                    } ?>
                </div>
            </div>
            <div class="date-time-post">
                <?php if (!empty($user_post)) {
                    $date = htmlspecialchars($row_post["dateUpload"]);
                    echo $post->getTime($date);
                } ?>
            </div>
        </div>
        <div class="display-container">
            <div class="userPost">
                
                <?php if (!empty($user_post)) {
                    echo htmlspecialchars($row_post["post"]);
                } ?>
            </div>
            <div class="userImage">
                <div class="displayer">
                    <?php 
                        if(file_exists($row_post["image"])){
                            $postImage = ($row_post["image"]);
                        }
                    ?>
                    <img src="<?php echo $postImage;?>" alt="imageTest">
                </div>
            </div>
        </div>
        <div class="likes-container">
            <div class="likes-wrapper">
                 
                <a onclick="promote(event)" data-link="engagement.php?type=promote&id=<?php echo htmlspecialchars($row_post['postID'])?>"><button name="btnPromote" title="Promote">
                    <?php if($promoted == false): ?>
                        <i class="fa-regular fa-heart"></i>
                    <?php elseif($promoted == true): ?>
                        <i id="Promoted" class="fa-solid fa-heart"></i>
                    <?php endif?>
                    <p id="likeCount"><?php echo htmlspecialchars($liked);?></p></button></a>
                <button name="btnShare" title="Shares"><i class="fa-solid fa-share-from-square"></i><p><?php echo $row_post['shares']; ?></p></button>
                <?php if(substr($row_post['userID'],0,4) == 'busi'):;?>
                    <a href="#"><span title="Affiliate"><i class="fa-regular fa-circle-check"></i></span></a>
                <?php endif;?>
                <span id="comment-video" title="Comments"><i class="fa-regular fa-comment"></i><p><?php echo $row_post['comments']; ?></p></span>
            </div>
            <div class="comment-input">
                <input type="text" placeholder="Enter Comment">
                <button class="comment-post">Comment</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(empty($row_post['image']) && $row_post['hasImage'] == 0): ?>
    <div class="blog-post">
        <div class="caption-wrap">
            <div class="caption-captured">
                <?php if($_SESSION["myuserId"] == $row_post['userID']):?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?deleteId=' . htmlspecialchars($row_post['postID']);?>">
                        <span name="deletePost" id="trash"><i class="fa-solid fa-trash"></i></span>
                    </a>
                <?php endif;?>
                <div id="userName">
                    <?php if (!empty($user_post)) {
                        echo htmlspecialchars($row_post["userName"]);
                    }?>
                </div>
                <div id="hashTags">
                    <?php if(!empty($user_post)) {
                        echo htmlspecialchars($row_post["hashTags"]);
                    } ?>
                </div>
                <div id="userTags">
                    <?php if (!empty($user_post)) {
                        echo htmlspecialchars($row_post["userTags"]);
                    } ?>
                </div>
            </div>
            <div class="date-time-post">
                <?php if (!empty($user_post)) {
                    $date = htmlspecialchars($row_post["dateUpload"]);
                    echo $post->getTime($date);
                } ?></div>
        </div>
        <div class="userPost">
            <?php if (!empty($user_post)) {
                echo htmlspecialchars($row_post["post"]);
                } ?>
        </div>
        <div class="likes-container">
            <div class="likes-wrapper">
                
                <a onclick="promote(event)" data-link="engagement.php?type=promote&id=<?php echo htmlspecialchars($row_post['postID'])?>"><button name="btnPromote" title="Promote">
                    <?php if($promoted == false): ?>
                        <i class="fa-regular fa-heart"></i>
                    <?php elseif($promoted == true): ?>
                        <i id="Promoted" class="fa-solid fa-heart"></i>
                    <?php endif?>
                    <p id="likeCount"><?php echo htmlspecialchars($liked);?></p></button></a>
                <button name="btnShare" title="Shares"><i class="fa-solid fa-share-from-square"></i><p><?php echo $row_post['shares'];?></p></button>
                <?php if(substr($row_post['userID'],0,4) == 'busi'):;?>
                    <a href="#"><span title="Affiliate"><i class="fa-regular fa-circle-check"></i></span></a>
                <?php endif;?>
                <span id="comment-video" title="Comments"><i class="fa-regular fa-comment"></i><p><?php echo $row_post['comments'];?></p></span>
            </div>
            <div class="comment-input">
                <input type="text" placeholder="Enter Comment">
                <button class="comment-post">Comment</button>
            </div>
            
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
(function PromoteModule() {
    function ajax_send(data, element){
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                response(ajax.responseText, element);
            }
        });

        data = JSON.stringify(data);
        ajax.open("post", "ajax.php", true);
        ajax.send(data); 
    }

    function response(result, element){
        if(result != ""){
            var obj = JSON.parse(result);

            if(typeof obj.action !== "undefined" && obj.action == "promote"){
                element.querySelector('p#likeCount').innerHTML = obj.likes;
                const heartIcon = element.querySelector('i.fa-heart');

                if (obj.status == true) {
                    
                    heartIcon.classList.remove("fa-regular");
                    heartIcon.classList.add("fa-solid");
                    heartIcon.style.color = "red";
                   
                } else if (obj.status == false) {
                    
                    heartIcon.classList.remove("fa-solid");
                    heartIcon.classList.add("fa-regular");
                    heartIcon.style.color = "black";
                }
                
            }
        } 
    }

    window.promote = function(e) {
        e.preventDefault();
        const link = e.currentTarget.getAttribute("data-link");
        const data = { 
            action: "promote",
            link: link
        };
        ajax_send(data, e.currentTarget);
    };
})();
</script>


<div class="post-card">
            <div class="post-header">
                <div class="post-user">
                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                    <div class="post-user-info">
                        <a class="post-username" href="Profile.php?username=alex_dev">alex_dev</a>
                        <div class="post-meta">
                            <span>2h ago</span>
                            <span class="post-tag">#webdev</span>
                        </div>
                    </div>
                </div>
                <div class="post-options"><i class="fa fa-ellipsis"></i></div>
            </div>
            <div class="post-body">
                Just shipped a new feature that reduced load time by 60% 🚀 The trick was lazy loading combined with smart caching. <span class="hashtag">#performance</span> <span class="hashtag">#webdev</span> <span class="mention">@linkspam</span>
            </div>
            <div class="post-actions">
                <button class="action-btn" onclick="toggleLike(this)"><i class="fa-regular fa-heart"></i> <span>142</span></button>
                <button class="action-btn" onclick="toggleComment(this)"><i class="fa-regular fa-comment"></i> <span>24</span></button>
                <button class="action-btn"><i class="fa-solid fa-retweet"></i> <span>18</span></button>
                <div class="action-spacer"></div>
                <button class="action-btn" onclick="copyLink()"><i class="fa-regular fa-share-from-square"></i></button>
            </div>
            <div class="comment-section" style="display:none;">
                <input type="text" class="comment-input" placeholder="Write a comment…">
                <button class="comment-submit"><i class="fa fa-arrow-right"></i></button>
            </div>
        </div>