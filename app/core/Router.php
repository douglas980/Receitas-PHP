<?php

namespace app\core;

class Router{
    private $uriEx; #Propriedade que podemos acessar no escopo de classe como um todo

    public function __construct()
    {
        $this->init();
        $this->execute();
    }

    private function init()
    { #Função privada, pois devemos manter essa função apenas dentro da Router. Não podemos chamar essa função fora da Router .. ex: index.php
        $uri = $_SERVER['REQUEST_URI']; #URI RETORNA O QUE VEM DEPOIS DE LOCALHOST

        $uri= str_replace('?', '/', $uri); #trocando tudo que vier em interrogação para barra na uri

        $ex = explode('/', $uri); #explodindo na barra para quebrar localhost e o my-receitas da uri
        $ex = array_values(array_filter($ex)); #array_filtre remove indices em branco .. array_values reeordena o array

        for($i = 0; $i < UNSET_COUNT; $i++) #i começa com a posição zero para o UNSET_COUNT cortar o my-receita da uri, pois o my-receita é o posição 0 no array
        unset($ex[$i]);  #Unset sempre vai falar quantos caras a gente quer remover sempre começando do indice 0
        
        $this->uriEx = $ex = array_values(array_filter($ex));
       
    }

    private function execute()
    {
        $class = 'HomeController';
        $method = 'index';

        #verificando se existe a controller
        # Caso exista, ele irá retornar a controller, caso não exista por padrão ele retornará a HomeController.
        #Controller indice 0
        if(isset($this->uriEx[0])){
            $c= 'app\\site\\controller\\' . ucfirst($this->uriEx[0]) . 'Controller';
            if(class_exists($c)){
                $class = ucfirst($this->uriEx[0]) . 'Controller';

            }
        }

        $controller = 'app\\site\\controller\\' . $class;

        #Método indice 1
        #Verificando se existe o método .. caso exista ele retornará o método buscado .. caso não ele retornará index por padrão
        if(isset($this->uriEx[1])){
            if(method_exists($controller, $this->uriEx[1])){
                $method = $this->uriEx[1];

            }
        }

        call_user_func_array(
            [
                new $controller(),
                $method
            ],
            $this->getParams()
        );
    }

    #Depois do método indice 1, o que vier será parametros
    private function getParams(){
        $p = [];
        #count inicia a contagem a partir do 1... ele precisa ser maior que dois, pois a posição 1 neste caso será a controller, a 2 os métodos e da 3 em diante os parametros
        if(count($this->uriEx) > 2 ){
            for($i = 2; $i < count($this->uriEx); $i++)
            $p[] = $this->uriEx[$i];

        }

        return $p;
    }
}