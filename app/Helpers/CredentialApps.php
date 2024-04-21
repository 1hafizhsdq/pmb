<?php

namespace App\Helpers;

use App\Models\Aplikasi;
use App\Models\Cofigs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CredentialApps {
    public static function check(){
        $config = Aplikasi::find(1);
        
        if(strtotime(date('Y-m-d')) > strtotime($config->expired_apps)){
            Session::flash('message', 'Serial Number Apps expired, please contact developer to activation your serial number!');
            return false;
        }

        return true;
    }
}