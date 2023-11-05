<?php

/**
    * https://stackoverflow.com/questions/28474640/overwrite-laravel-5-helper-function
    * composer require funkjedi/composer-include-files
    * Retrieve an old input item.
    *
    * @param  string|null  $key
    * @param  mixed  $default
    * @return mixed
    */
if (!function_exists("old")){
    function old($key = null, $default = null) {
        $request = app('request');
        
        if ($request->getMethod() == "GET" && $key != null){
            //laravel = 9.x
            if ($request->get($key) != null){
                return $request->get($key);
            } else //laravel < 9.x
            if ($request->request->get($key) != null){
                return $request->request->get($key);
            }
        }
        return $request->old($key, $default);
    }
}


?>