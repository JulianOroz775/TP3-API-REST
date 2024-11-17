<?php
    
    require_once 'libs/router.php';

    require_once 'app/controllers/vehiculo.api.controller.php';
  
    $router = new Router();

   
// le cargamos la rutas al router
    #                 endpoint        verbo      controller              metodo
    $router->addRoute('vehiculos'      , 'GET',     'VehiculosApiController',   'getAll');
    $router->addRoute('vehiculos/:id'  , 'GET',     'VehiculosApiController',   'get'   );
    $router->addRoute('vehiculos/:id'  ,'DELETE',   'VehiculosApiController',   'delete');
    $router->addRoute('vehiculos'      ,'POST',     'VehiculosApiController',   'create');
    $router->addRoute('vehiculos/:id'   ,'PUT',     'VehiculosApiController',   'update');
    $router->addRoute('vehiculos/:id/vendido', 'PUT','VehiculosApiController',   'setVendido');

    //             ejecuto la ruta( get(resourse))
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);