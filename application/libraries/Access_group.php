<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_group {

    public function menu($array, $value)
    {
        $result = FALSE;
        foreach($array as $list){
            if ($list == $value){
                $result = TRUE;
                break;
            }
        }
        return $result;
    }
    
}