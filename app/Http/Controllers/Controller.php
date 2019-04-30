<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function pp($printData,$die=0){
        if(!empty($printData)){
        echo '<pre>'; print_r($printData); echo '</pre>';
        }
        if($die==1){
            die();
           }
    }
}
