<?php namespace App;

use Illuminate\Foundation\Application;

class AcmeApplication extends Application
{

public function publicPath()  
{
    return $this->basePath.'/../public/';
}

}