<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT as JWT;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require './vendor/autoload.php';
require_once "Anteojos.php";
require_once "Usuario.php";
require_once "mw.php";

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('[/]', function (Request $request, Response $response) {    
    return $response;
  
});

$app->get('[/]', function (Request $request, Response $response) {    
    echo "hola";
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
    $consulta->execute();
    $fila=$consulta->fetchall();
    var_dump($fila);  
    return $response;
  
});

$app->get('/mesas/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT codigo,estado FROM mesas");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->codigo=$value['codigo'];
        $obj->estado=$value['estado'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->get('/productos/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->codigo=$value['codigo'];
        $obj->estado=$value['estado'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/mesaEstado/', function (Request $request, Response $response) { 
    $array=$request->getParsedBody();
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado=:estado WHERE codigo=:codigo");
    $consulta->bindValue(':estado',  $array['estado'], PDO::PARAM_STR);
    $consulta->bindValue(':codigo',  $array['codigo'], PDO::PARAM_STR);
    $consulta->execute();
    return $consulta;
});

$app->post('/register/', function (Request $request, Response $response) {
    $array=$request->getParsedBody();
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `usuarios` VALUES (NULL, :correo, :nombre, :tipo, :clave);");
    $consulta->bindValue(':correo',  $array['email'], PDO::PARAM_STR);
    $consulta->bindValue(':clave',  $array['clave'], PDO::PARAM_STR);
    $consulta->bindValue(':tipo',  $array['tipo'], PDO::PARAM_STR);
    $consulta->bindValue(':nombre',  $array['nombre'], PDO::PARAM_STR);
    $consulta->execute();
    $result = array(
		'status' => 'error',
		'code' => 404,
		'message' => 'Hubo un error al registrarte'
	);
	if($consulta) {
	    $result = array(
		'status' => 'success',
		'code' => 200,
		'message' => 'Registrado correctamente'
	);
	}
    return json_encode($result);
});

$app->post('/auto/', function (Request $request, Response $response) {
    $array=$request->getParsedBody();
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `autos` VALUES (NULL, :patente, :marca, :color, :kilometros, :tipo);");
    $consulta->bindValue(':patente',  $array['patente'], PDO::PARAM_STR);
    $consulta->bindValue(':marca',  $array['marca'], PDO::PARAM_STR);
    $consulta->bindValue(':color',  $array['color'], PDO::PARAM_STR);
    $consulta->bindValue(':kilometros',  $array['kilometros'], PDO::PARAM_STR);
    $consulta->bindValue(':tipo',  $array['tipo'], PDO::PARAM_STR);
    $consulta->execute();
    $result = array(
		'status' => 'error',
		'code' => 404,
		'message' => 'Hubo un error al registrar el vehiculo'
	);
	if($consulta) {
	    $result = array(
		'status' => 'success',
		'code' => 200,
		'message' => $array['tipo'].' registrado correctamente'
	);
	}
    return json_encode($result);
});

$app->get('/turno/', function (Request $request, Response $response) {    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT cliente,dia,hora,tipo FROM turnos");
    $consulta->execute();
    $datos=$consulta->fetchall();
    $arrayJson=array();
    foreach($datos as $value) 
    {
        $obj=new stdclass();
        $obj->cliente=$value['cliente'];
        $obj->tipo=$value['tipo'];
        $obj->dia=$value['dia'];
        $obj->hora=$value['hora'];
        $arrayJson[]=$obj;
    }
    return json_encode($arrayJson);
  
});

$app->post('/turno/', function (Request $request, Response $response) {
    $array=$request->getParsedBody();
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `turnos` VALUES (NULL, :cliente, :dia, :hora, :tipo);");
    $consulta->bindValue(':cliente',  $array['cliente'], PDO::PARAM_STR);
    $consulta->bindValue(':dia',  $array['dia'], PDO::PARAM_STR);
    $consulta->bindValue(':hora',  $array['hora'], PDO::PARAM_STR);
    $consulta->bindValue(':tipo',  $array['tipo'], PDO::PARAM_STR);
    $consulta->execute();
    $result = array(
		'status' => 'error',
		'code' => 404,
		'message' => 'Hubo un error al registrar el turno'
	);
	if($consulta) {
	    $result = array(
		'status' => 'success',
		'code' => 200,
		'message' => 'turno registrado correctamente'
	);
	}
    return json_encode($result);
});

$app->post('/login/', function (Request $request, Response $response) {
    $array=$request->getParsedBody();
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT correo,nombre,tipo FROM usuarios WHERE correo=:correo && clave=:clave");
    $consulta->bindValue(':correo',  $array['email'], PDO::PARAM_STR);
    $consulta->bindValue(':clave',  $array['clave'], PDO::PARAM_STR);
    $consulta->execute();
    $result = array(
		'status' => 'error',
		'code' => 404,
		'message' => 'credenciales incorrectas'
	);
    $fila=$consulta->fetchall();
    if(isset($fila[0])) {
        $payload=array(
            'correo' => $fila[0][0],
            'nombre' => $fila[0][1],
            'perfil' => $fila[0][2],
            'app' => 'API REST 2018'
        );
        $token=JWT::encode($payload,'miClave');
        $result = array(
		    'status' => 'success',
		    'code' => 200,
		    'message' => $token
	    );
    }
    return json_encode($result);
});

$app->delete('[/]', function (Request $request, Response $response) {    
    return $response;
  
})->add(\MW::class.':VerificarToken');

$app->put('[/]', function (Request $request, Response $response) {    
    return $response;
  
})->add(\MW::class.':VerificarToken');

/*$app->get('/anteojos/', function (Request $request, Response $response) {    
    return $response;
  
});

$app->post('/usuarios/', function (Request $request, Response $response) {    
    return $response;
  
})->add(\Usuario::class.':AgregarUsuario');

$app->get('[/]', function (Request $request, Response $response) {    
    return $response;
  
})->add(\Usuario::class.':TraerUsuarios');*/

/*$app->group('/login',function () { 
    $this->get('/', function (Request $request, Response $response) {
        $token=$request->getHeader('token');
    if(empty($token[0]) || $token[0]=='') {
        throw new Exception("El token esta vacio");
    }

    try
    {
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        $obj=new stdclass();
        $obj->mensaje="TOKEN OK";
        echo json_encode($obj);
    }
    catch(Exception $e) {
        //throw new Exception("Token no valido--->".$e->getMessage());
        $obj=new stdclass();
        $obj->mensaje="TOKEN no valido";
        echo json_encode($obj);
    }
        
        return $response;
    });
    $this->post('/', function (Request $request, Response $response) {
        $array=$request->getParsedBody();
        $usuario=$array['correo'];
        $clave=$array['clave'];
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo=:correo && clave=:clave");
        $consulta->bindValue(':correo',  $array['correo'], PDO::PARAM_STR);
        $consulta->bindValue(':clave',  $array['clave'], PDO::PARAM_STR);
        $consulta->execute();
        $fila=$consulta->fetchall();
        $payload=array(
            'data' => $fila,
            'app' => 'API REST 2018'
        );
        $token=JWT::encode($payload,'miClave');
        //return $response->withJson($token,200);
        return $token;
    })->add(\MW::class.':VerificarUsuario')->add(\MW::class.'::VerificarVacio')->add(\MW::class.':VerificarSeteado');
});*/

/*$app->group('/ventas',function () {
    $this->get('/', function (Request $request, Response $response) {

    });
    $this->post('/', function (Request $request, Response $response) {

    })->add(\Anteojos::class. '::AltaVenta');
});

$app->delete('[/]', function (Request $request, Response $response) {    
    echo "estoy en el delete";
    return $response;
  
})->add(\Anteojos::class.':BorrarAnteojos')->add(\MW::class.'::VerificarPropietario')->add(\MW::class.':VerificarToken');

$app->put('[/]', function (Request $request, Response $response) {    
    echo "estoy en el put";
    return $response;
  
})->add(\Anteojos::class.':ModificarAnteojos')->add(\MW::class.'::VerificarPropietario')->add(\MW::class.':VerificarEncargado')->add(\MW::class.':VerificarToken');

$app->group('/listados',function () { 
    $this->get('/anteojos/',function(Request $request, Response $response) {
        return $response;
    })->add(\MW::class.'::ListadoAnteojosID')->add(\MW::class.':ListadoColores')->add(\MW::class.':ListadoAnteojos');
    $this->get('/ventas/',function(Request $request, Response $response) { 
        return $response;
    })->add(\MW::class.':MontoTotal')->add(\MW::class.':ListadoVentasFecha')->add(\MW::class.'::ListadoVentas');
});*/

$app->run();

?>