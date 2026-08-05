<?php
class Profile{
    public $profileData = "";
    public function get_data($userId){
        $userId = addslashes($userId);
        $DB = new Database();
        $query = "SELECT * FROM userstats WHERE userID = '$userId'";
        $result= $DB->read($query);
        if($result){
            $row = $result[0];
            return $row;
        }else{
            return false;
        }
    }
    public function getProfile($userName){
        $DB = new Database();
        $query = "SELECT * FROM userstats WHERE userName LIKE '%$userName%' ORDER BY userName";
        $result = $DB->read($query);
        //$row = $this->get_data($result[0]);
        return $result ? $result : false;
    }
    public function getUserTag($userName){
        $DB = new Database();
        $userName = addslashes($userName);
        $query = "SELECT * FROM userstats WHERE userName LIKE '%$userName%' ORDER BY userName LIMIT 5";
        $result = $DB->read($query);
        //$row = $this->get_data($result[0]);
        return $result ? $result : false;
    }
    public function getleaderBoard(){
        $DB = new Database();
        $query = "SELECT userID, userName, userLevel, xpLevel, totalXP, userPfp, bioStatement FROM userstats ORDER BY userLevel DESC LIMIT 5";
        $result = $DB->read($query);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    public function xpLevel($userId){
        $userId = addslashes($userId);
        $userData = $this->get_data($userId);
        $quota = ((($userData['userLevel'] + 1) * 8) * 4) + 2;
        $LevelUp = ceil(($userData['xpLevel'] * 100) / $quota);
        if($LevelUp == 100){
            $userData['userLevel'] += 1;
            $userData['totalXP'] += $userData['xpLevel'];
            $userData['xpLevel'] = 0;
        }
        $DB = new Database();
        $updateQuery = "UPDATE userstats SET userLevel = '{$userData['userLevel']}', totalXP = '{$userData['totalXP']}', xpLevel = '{$userData['xpLevel']}' WHERE userID = '$userId'";
        $DB->save($updateQuery);
        $userData['quota'] = $quota;

        return $userData;
    }
    public function feedback($userId, $rate="", $message=""){
        $DB = new Database();
        $result = $DB->read("SELECT rate FROM userstats WHERE userID = ? LIMIT 1", [$userId]);
        
        if(is_array($result[0])){
            $decoded = json_decode($result[0]['rate'], true);
            if (is_array($decoded)) {
                $userArray = $decoded;
            }

            // Append new feedback entry
            $userArray[] = [
                'rate' => $rate,
                'feedback' => $message,
                'time' => date("Y-m-d H:i:s")
            ];

            // Encode back to JSON
            $userJson = json_encode($userArray);

            // Save updated JSON to DB
            $DB->save("UPDATE userstats SET rate = ? WHERE userID = ? LIMIT 1", [$userJson, $userId]);

            return true;  
        }
        return false;  
    }
    private function followRefer($myId, $followId){
        $DB = new Database();
        $sqlRead = "SELECT followers FROM userstats WHERE userID = '$followId' LIMIT 1";
        $followers = $DB->read($sqlRead);
        
        if(isset($followers[0]['followers'])){
            $followstring = json_decode($followers[0]['followers'],true);
            if(!empty($followstring)){
                if(in_array($myId, $followstring)){
                //unfollow part
                    $keyValue = array_search($myId, $followstring);
                    unset($followstring[$keyValue]);
                    $userstring = json_encode(array_values($followstring));
                    $sqlUpdate = "UPDATE userstats SET followers = '$userstring' WHERE userID = '$followId' LIMIT 1";
                    $DB->save($sqlUpdate);
                }else{
                    $arrIds = $followstring;
                    $arrIds[] = $myId;
                    $arrstring = json_encode($arrIds); 
                    $sqlInsert = "UPDATE userstats SET followers = '$arrstring' WHERE userID = '$followId' LIMIT 1";
                    $DB->save($sqlInsert);
                }
            }else{
                $arrIds[] = $myId;
                $arrstring = json_encode($arrIds);
                $sqlInsert = "UPDATE userstats SET followers = '$arrstring' WHERE userID = '$followId' LIMIT 1";
                $DB->save($sqlInsert);
            }
        }else{
            $arrIds[] = $myId;
            $arrstring = json_encode($arrIds);
            $sqlInsert = "UPDATE userstats SET followers = '$arrstring' WHERE userID = '$followId' LIMIT 1";
            $DB->save($sqlInsert);
        }
    }

    public function followUser($myId, $followId){
        $myId = addslashes($myId);
        $followId = addslashes($followId);
        $DB = new Database();    
        $sqlRead = "SELECT followings FROM userstats WHERE userID = '$myId' LIMIT 1";
        $followings = $DB->read($sqlRead);
        
        if(is_array($followings)){
            if(isset($followings[0]['followings'])){
                $string = json_decode($followings[0]['followings'],true);
                
                if(!empty($string)){
                    if(in_array($followId, $string)){
                    //user is already followed
                        $keyValue = array_search($followId, $string);
                        unset($string[$keyValue]);
                        $userstring = json_encode(array_values($string)); 
                        $sqlUpdate = "UPDATE userstats SET followings = '$userstring' WHERE userID = '$myId' LIMIT 1";
                        $DB->save($sqlUpdate);
                        $this->followRefer($myId, $followId);
                        //decrement post table
                        $sqlDecrement = "UPDATE userstats SET followingCount = followingCount - 1 WHERE userID = '$myId'";
                        $DB->save($sqlDecrement);  
                        $sqlDecrement = "UPDATE userstats SET followerCount = followerCount - 1 WHERE userID = '$followId'";
                        $DB->save($sqlDecrement);  
                    }else{
                        $userIds = $string;
                        $userIds[] = $followId;          
                        $userstring = json_encode($userIds);
                        //insert into user id into table
                        $sqlUpdate = "UPDATE userstats SET followings = '$userstring' WHERE userID = '$myId' LIMIT 1";
                        $DB->save($sqlUpdate);
                        $this->followRefer($myId, $followId);
                        //increment user data
                        $sqlIncrement = "UPDATE userstats SET followingCount = followingCount + 1 WHERE userID = '$myId'";
                        $DB->save($sqlIncrement);
                        //increment follow data
                        $sqlIncrement = "UPDATE userstats SET followerCount = followerCount + 1 WHERE userID = '$followId'";
                        $DB->save($sqlIncrement);
                    }
                }else{
                    $userIds[] = $followId;
                    $userstring = json_encode($userIds);
                    $sqlUpdate = "UPDATE userstats SET followings = '$userstring' WHERE userID = '$myId' LIMIT 1";
                    $DB->save($sqlUpdate);
                    $this->followRefer($myId, $followId);
                    $sqlIncrement = "UPDATE userstats SET followingCount = followingCount + 1 WHERE userID = '$myId'";
                    $DB->save($sqlIncrement);
                    //increment follow data
                    $sqlIncrement = "UPDATE userstats SET followerCount = followerCount + 1 WHERE userID = '$followId'";
                    $DB->save($sqlIncrement);
                }
            }else{//here
                $arr[] = $followId;
                $userstring = json_encode($arr);
                return $arr;
                $sqlInsert = "UPDATE userstats SET followings = '$userstring' WHERE userID = '$myId'";
                $DB->save($sqlInsert);
                $this->followRefer($myId, $followId);
                //increment post table
                $sqlIncrement = "UPDATE userstats SET followingCount = followingCount + 1 WHERE userID = '$myId'";
                $DB->save($sqlIncrement);
                $sqlIncrement = "UPDATE userstats SET followerCount = followerCount + 1 WHERE userID = '$followId'";
                $DB->save($sqlIncrement);
                
            }
        }
    }

    public function getFollow($userId, $followerId){
        $DB = new Database;
        $result = $DB->read(
            "SELECT * FROM userstats WHERE userID = ? LIMIT 1",
            [$followerId]
        );
        if(is_array($result) && isset($result[0]['followers'])){ {
            return json_decode($result[0]['followers'], true) ?? [];
        }
        return [];
        }
    }

    public function refreshDayStreak($userId) {
        $DB = new Database();
        $result = $DB->read("SELECT lastDay, dayStreak FROM userstats WHERE userId = :userId LIMIT 1", ['userId' => $userId]);
        
        if (!$result) {
            // Handle case where userstats doesn't exist
            return;
        }
        $result = $result[0];
       
        $lastDay = date($result['lastDay']);
        if($lastDay == '0000-00-00 00:00:00') {
            $DB->save("UPDATE userstats SET dayStreak = ?, lastDay = ? WHERE userId = ?", 
            [0, date("Y-m-d H:i:s"), $userId]);
        }
      
        $lastDay = date_create($lastDay); 
        $now = date("Y-m-d H:i:s");  
        $now = date_create($now);    // ✅ convert your date() result to DateTime
        
        $interval = date_diff($lastDay, $now); 
        $hoursDifference = ($interval->days * 24) + $interval->h + ($interval->i / 60);


        if ($hoursDifference >= 12) {
            if ($hoursDifference < 24) {
                // Within the 24-hour window, add to streak
                $newStreak = $result['dayStreak'] + 1;
            } else {
                // Over 24 hours, reset streak
                $newStreak = 0;
            }

            // Update userstats
             $DB->save("UPDATE userstats SET dayStreak = ?, lastDay = ? WHERE userId = ?", 
            [
                $newStreak,
                $now->format("Y-m-d H:i:s"),
                $userId
            ]);

        }
    }
    public function dayStreak($userId){
        $DB = new Database();
        $result = $DB->read("SELECT lastDay, dayStreak FROM userstats WHERE userId = :userId LIMIT 1", ['userId' => $userId]);   
        if (!$result) {
            // Handle case where userstats doesn't exist
            return 'N/A';
        }
        return $result[0]['dayStreak'];   
    }
}

?>