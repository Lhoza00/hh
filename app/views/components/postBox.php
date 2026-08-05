<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <section class="SectionPost">
        <div class="container">
            <textarea rows="4" maxlength="255" name="post"></textarea>
            <div class="inner-post">
                <button type="button" id="tagHashBtn"name="hashTag" class="postTags"><i class="fa-solid fa-hashtag"></i></button>
                <button type="button" id="tagUserBtn" name="tagUser" class="postTags"><i class="fa-solid fa-user-tag"></i></button>
                <label>
                    <input type="file" title=" " name="file">
                    <i class="fa-solid fa-image"></i>
                </label>
                <button class="btnSavePost" name="btnSavePost">Post</button>
            </div>
        </div>
    </section>
</form>
<script>
    
</script>
<?php include('userDialog.php') ?>
<?php include('hashDialog.php') ?>
<?php 
    if($_SERVER['PHP_SELF'] === '/Components/postBox.php'){
        session_start();
        if(empty($_SESSION['myuserId'])){
            session_destroy();
            header('Location: /Index.php');
            exit;
        }else{
            header('Location: /Home.php');
            exit;
        }
    }
?>