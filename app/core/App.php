<?php

class App{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $param = [];

    public function __construct(){
        $url = $this->parseURL(); 


        //Untuk Controller      
        if(file_exists('../app/Controllers/' . $url[0] . '.php')){
            $this->controller = $url[0];
            //unset untuk menghpus data yg  diurl
            unset($url[0]);
        }
        require_once '../app/Controllers/' .$this->controller .'.php';
        $this->controller = new $this->controller;

        //Untuk Method
        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        //Untuk parameter
        if(!empty($url)){
            $this->param = array_values($url);
        }

        //Jalanakan controller &method serta kirimkan parameter jika ada
        call_user_func_array([$this->controller,$this->method],$this->param);

    }

    public function parseURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);

            return $url;
        }
    }
}
