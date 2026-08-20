<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/models/index.php';
class Setting
{
    private Models $model;

    public function __construct()
    {
        $this->model = new Models();
    }
    public function get($option){
        $allowedoption = ['background-color', 'language', 'profileVisibility', 'onlineStatus', 'currency'];
        if(!in_array($option, $allowedoption)){
            return false;
        }
        $setting = $this->model->getSettings($_SESSION['userID']);
        switch($option){
            case 'background-color':
                return $setting['theme'];
            case 'language':
                return $setting['language'];
            case 'profileVisibility':
                return $setting['profileVisibility'];
            case 'onlineStatus':
                return $setting['onlineStatus'];
            case 'currency':
                return $setting['currency'];
            default:
                return false;
        }
    }
}