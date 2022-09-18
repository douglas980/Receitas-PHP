<?php
namespace app\site\controller;

class AboutController
{
      public function __construct()
      {
   
      } 

      public function index(){
        echo "estamos na Index da about";
      }
      public function teste($name = ''){

        echo $name . '<<<<<<<<< TESTE!!!! :D';

      }
} 