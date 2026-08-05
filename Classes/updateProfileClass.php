<?php
    
class UpdateProfile{
    private $DB; 
    public function __construct($DB) {
        $this->DB = $DB;
    }
    private function checkUniqueness($userPost) {
        $userName = $userPost['userName'];
        if (!empty($userPost['userName'])) {
            $usernameCheck = $this->DB->read("SELECT userName FROM userstats WHERE userName = ?", [$userName]);
            if(!empty($usernameCheck)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function updateInfo($userPost){
        if(isset($_SESSION["myuserId"])){
            $userId = $_SESSION["myuserId"];
            $userName = htmlspecialchars(trim($userPost["userName"]), ENT_QUOTES, 'UTF-8');
            $jobSkill = htmlspecialchars(trim($userPost["jobSkill"]), ENT_QUOTES, 'UTF-8');
            $bioStatement = htmlspecialchars(trim($userPost["bioStatement"]), ENT_QUOTES, 'UTF-8');
            $DateOfBirth = preg_replace('/\D/', '', $userPost["bodYear"]) . "-" .
                            preg_replace('/\D/', '', $userPost["bodMonth"]) . "-" .
                            preg_replace('/\D/', '', $userPost["bodDate"]);
            $DateOfBirth = date($DateOfBirth);
            $gender = htmlspecialchars(trim($userPost["gender"]), ENT_QUOTES, 'UTF-8');
            $townCity = htmlspecialchars(trim($userPost["townCity"]), ENT_QUOTES, 'UTF-8'); 
            $province = htmlspecialchars(trim($userPost["provinces"]), ENT_QUOTES, 'UTF-8');
            $zipCode = htmlspecialchars(trim($userPost["zipCode"]), ENT_QUOTES, 'UTF-8');
    
            if($this->checkUniqueness($userPost)){
                $sqlSaveStats = "UPDATE userstats SET userName = ?, jobSkill = ?,
                                 bioStatement = ?, Gender = ?, DateOfBirth = ?, 
                                    townCity = ?, Province = ?, zipCode = ? WHERE userID = ?";
                $sqlSaveDetails = "UPDATE userdetails SET userName = ? WHERE userID = ?;";
                
                $this->DB->save($sqlSaveDetails, [$userName, $userId]);
                $this->DB->save($sqlSaveStats, [$userName, $jobSkill, $bioStatement, $gender, $DateOfBirth, $townCity, $province, $zipCode, $userId]);
                return true;
            }else{
                return false;
            }

        }
    }
}

?>