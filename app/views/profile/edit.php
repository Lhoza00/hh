<?php
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | Edit Profile</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <section class="SectionEditProfile">
            <div class="container">
                <form class="EditContainer" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div id="changeImage">
                        <!--<a href="changeImage.php?change=cover">Change Cover Picture</a>
                        ||-->
                        <a href="changeImage.php?change=profile">Change Profile Picture</a>
                    </div>
                    <hr class="hredit" color="black"/>
                    <div class="BioCard">
                        <div>
                            <div>
                                <h4>Username</h4>
                                <input name="userName" class="editInput editUsername" value="<?php echo $profile_data['userName'];?>">
                            </div>
                            <hr class="hredit" color="black"/>
                            <div>
                                <h4>Skill</h4>
                                <input name="jobSkill" class="editInput editInfo" value="<?php echo $profile_data['jobSkill']?>">        
                            </div>
                        </div>
                        <hr class="hredit" color="black"/>
                        <div class="ClashedDIV">
                            <div class="AboutUserContainer">
                                <div class="BioStatement">
                                    <h4>Bio</h4>
                                    <textarea type="text" class="editInput editBio" maxlength="254" name="bioStatement"><?php echo $user_data['bioStatement'];?></textarea>
                                </div>
                                <hr class="hredit" color="black"/>
                                <div class="zin">
                                    <h4>Gender</h4>
                                    <select class="opt" name="gender">
                                        <option hidden><?php echo $profile_data['Gender'];?></option>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                        <option value=" ">Prefer not to say</option>
                                    </select>
                                </div>
                                <hr class="hredit" color="black"/>
                                <div class="zin Birth Of Date">
                                    <h4>Birth of Date</h4>
                                    <div>
                                       <input type="number" class="optInput" placeholder="Date" name="bodDate" value="<?php echo "" ?>">
                                       <select class="opt" name="bodMonth">
                                            <option hidden>Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                        <input type="tel" class="optInput" min="1970" max="2026" placeholder="Year" name="bodYear">
                                    </div>
                                </div>
                                <hr class="hredit" color="black"/>
                                <div class="zin location">
                                    <h4>Location</h4>
                                    <div>
                                        <input placeholder="Town/City" class="optInput" name="townCity" value="<?php echo $profile_data['townCity'];?>">
                                        <select class="opt" name="provinces" >
                                            <option hidden><?php if(!empty($profile_data['Province'])){
                                                echo $profile_data['Province'];}else{echo "Province";};?></option>
                                            <option value="Eastern Cape">Eastern Cape</option>
                                            <option value="Free State">Free State</option>
                                            <option value="Gauteng">Gauteng</option>
                                            <option value="KwaZulu-Natal">KwaZulu Natal</option>
                                            <option value="Limpopo">Limpopo</option>
                                            <option value="Mpumalanga">Mpumalanga</option>
                                            <option value="Nothern Cape">Nothern Cape</option>
                                            <option value="North West">North West</option>
                                            <option value="Western Cape">Western Cape</option>
                                        </select>
                                        <input type="number" placeholder="Zip-Code" class="optInput" name="zipCode" value="<?php echo $profile_data['ZipCode'];?>" >
                                    </div>
                                    
                                </div>
                                <hr class="hredit" color="black"/>
                            </div>   
                        </div>
                            <div class="btnTrack">
                                <button type="submit" name="EditProfile">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../layout/footer.php';?>
</body>
</html>