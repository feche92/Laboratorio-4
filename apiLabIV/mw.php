<?php

require_once "AccesoDatos.php";
require_once "Anteojos.php";
use \Firebase\JWT\JWT as JWT;

class MW {
    public function VerificarSeteado($request,$response,$next) {
        $array=$request->getParsedBody();
        if(isset($array['correo']) && isset($array['clave'])) {
            $response=$next($request,$response);
        }
        else{
            try{
                throw new Exception();
            }
            catch(Exception $e) {
                $obj=new stdclass();
                $obj->mensaje="los valores no estan seteados";
                echo json_encode($obj);
            }
        }
        return $response;
    }

    public static function VerificarVacio($request,$response,$next) {
        $array=$request->getParsedBody();
        if($array['correo']=='' || $array['clave']=='') {
            try{
                throw new Exception();
            }
            catch(Exception $e) {
                $obj=new stdclass();
                $obj->mensaje="los valores estan vacios";
                echo json_encode($obj);
            }
        }
        else {
            $response=$next($request,$response);
        }
        return $response;
    }

    public function VerificarUsuario($request,$response,$next) {
        $array=$request->getParsedBody();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE correo=:correo && clave=:clave");
        $consulta->bindValue(':correo',  $array['correo'], PDO::PARAM_STR);
        $consulta->bindValue(':clave',  $array['clave'], PDO::PARAM_STR);
        $consulta->execute();
        $fila=$consulta->fetch();
        if($fila['correo']=='' && $fila['clave']=='') {
            try{
                throw new Exception();
            }
            catch(Exception $e) {
                $obj=new stdclass();
                $obj->mensaje="El usuario no existe";
                echo json_encode($obj);
            }
            
        }
        else {
            $response=$next($request,$response);
        }
        return $response;
    }

    public function VerificarToken($request,$response,$next) {
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
    }
    catch(Exception $e) {
        $obj=new stdclass();
        $obj->mensaje="TOKEN no valido";
        echo json_encode($obj);
    }
        $response=$next($request,$response);
        return $response;
    }

    public static function VerificarPropietario($request,$response,$next) {
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='propietario' || $decodificado->data[1]->perfil=='propietario') {
                $response=$next($request,$response);
            }
            else{
                echo "Usted no es propietario";
            }
        }
        else {
            if($decodificado->data[0]->perfil=='propietario') {
                $response=$next($request,$response);
            }
            else {
                echo "Usted no es propietario";
            }
        }
        return $response;
        /*$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE id=:id");
        $consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $fila=$consulta->fetch();
        if($fila['perfil']!='propietario') {
            try{
                throw new Exception();
            }
            catch(Exception $e) {
                $obj=new stdclass();
                $obj->mensaje="Usted no es propietario";
                echo json_encode($obj);
            }
        }
        else {
            $response=$next($request,$response);
        }
        return $response;*/
    }

    public function VerificarEncargado($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='encargado' || $decodificado->data[1]->perfil=='encargado') {
                $response=$next($request,$response);
            }
            else{
                echo "Usted no es encargado";
            }
        }
        else {
            if($decodificado->data[0]->perfil=='encargado') {
                $response=$next($request,$response);
            }
            else {
                echo "Usted no es encargado";
            }
        }
        return $response;
    }

    public function ListadoAnteojos($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='encargado' || $decodificado->data[1]->perfil=='encargado') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerAnteojos();
                $arrayJson=array();
                foreach($listado as $value) 
                {
                    $obj=new stdclass();
                    $obj->color=$value->color;
                    $obj->marca=$value->marca;
                    $obj->precio=$value->precio;
                    $obj->aumento=$value->aumento;
                    $arrayJson[]=$obj;
                }
                echo json_encode($arrayJson);
                $response=$next($request,$response);
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='encargado') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerAnteojos();
                $arrayJson=array();
                foreach($listado as $value) 
                {
                    $obj=new stdclass();
                    $obj->color=$value->color;
                    $obj->marca=$value->marca;
                    $obj->precio=$value->precio;
                    $obj->aumento=$value->aumento;
                    $arrayJson[]=$obj;
                }
                echo json_encode($arrayJson);
                $response=$next($request,$response);
            }
            else {
                $response=$next($request,$response);
            }
        }
        return $response;
    }

    public static function ListadoAnteojosID($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        $array=$request->getParsedBody();
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='propietario' || $decodificado->data[1]->perfil=='propietario') {
                if(isset($_GET['id'])) {
                    echo $_GET['id'];
                    $anteojo=new Anteojos();
                    $listado=$anteojo->TraerAnteojos();
                    $arrayJson=array();
                    foreach($listado as $value) 
                    {
                        if($value->id==$_GET['id'])
                        {
                            $obj=new stdclass();
                            $obj->id=$value->id;
                            $obj->color=$value->color;
                            $obj->marca=$value->marca;
                            $obj->precio=$value->precio;
                            $obj->aumento=$value->aumento;
                            $arrayJson[]=$obj;
                            break;
                        }
                        
                    }
                    echo json_encode($arrayJson);
                    $response=$next($request,$response);
                }
                else {
                    $anteojo=new Anteojos();
                    $listado=$anteojo->TraerAnteojos();
                    echo json_encode($listado);
                    $response=$next($request,$response);
                }
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='propietario') {
                if(isset($_GET['id'])) {
                    echo $_GET['id'];
                    $anteojo=new Anteojos();
                    $listado=$anteojo->TraerAnteojos();
                    $arrayJson=array();
                    foreach($listado as $value) 
                    {
                        if($value->id==$_GET['id'])
                        {
                            $obj=new stdclass();
                            $obj->id=$value->id;
                            $obj->color=$value->color;
                            $obj->marca=$value->marca;
                            $obj->precio=$value->precio;
                            $obj->aumento=$value->aumento;
                            $arrayJson[]=$obj;
                            break;
                        }
                        
                    }
                    echo json_encode($arrayJson);
                    $response=$next($request,$response);
                }
                else {
                    $anteojo=new Anteojos();
                    $listado=$anteojo->TraerAnteojos();
                    echo json_encode($listado);
                    $response=$next($request,$response);
                }
            }
            else {
                $response=$next($request,$response);
            }
        }
        
    return $response;        
    }

    public function ListadoColores($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='encargado' || $decodificado->data[1]->perfil=='encargado') {
                $cantidad=0;
                $bandera=true;
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerAnteojos();
                for($i=0;$i<count($listado);$i++)
                {
                    $bandera=true;
                    for($j=0;$j<=$i-1;$j++)
                    {
                        if($listado[$i]->color==$listado[$j]->color) {
                            $bandera=false;
                            break;
                        }
                    }
                    if($bandera) {
                        $cantidad++;
                    }
                }
                echo "Hay ".$cantidad." colores distintos";
                $response=$next($request,$response);
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='encargado') {
                $cantidad=0;
                $bandera=true;
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerAnteojos();
                for($i=0;$i<count($listado);$i++)
                {
                    $bandera=true;
                    for($j=0;$j<=$i-1;$j++)
                    {
                        if($listado[$i]->color==$listado[$j]->color) {
                            $bandera=false;
                            break;
                        }
                    }
                    if($bandera) {
                        $cantidad++;
                    }
                }
                echo "Hay ".$cantidad." colores distintos";
                $response=$next($request,$response);
            }
            else {
                $response=$next($request,$response);
            }
        }
        return $response;
    }

    public static function ListadoVentas($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='empleado' || $decodificado->data[1]->perfil=='empleado') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerVentas();
                echo json_encode($listado);
                $response=$next($request,$response);
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='empleado') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerVentas();
                echo json_encode($listado);
                $response=$next($request,$response);
            }
            else {
                $response=$next($request,$response);
            }
        }
        return $response;
    }

    public function ListadoVentasFecha($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if($decodificado->data[0]->perfil=='propietario' || $decodificado->data[1]->perfil=='propietario') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerVentas();
                $array=$request->getParsedBody();
                $arrayJson=array();
                foreach($listado as $value) 
                {
                    if($value->fecha==$_GET['fecha'])
                    {
                        $obj=new stdclass();
                        $obj->id=$value->id;
                        $obj->id_anteojos=$value->id_anteojos;
                        $obj->cantidad=$value->cantidad;
                        $obj->fecha=$value->fecha;
                        $arrayJson[]=$obj;
                    }
                        
                }
                echo json_encode($arrayJson);
                $response=$next($request,$response);
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='propietario') {
                $anteojo=new Anteojos();
                $listado=$anteojo->TraerVentas();
                $array=$request->getParsedBody();
                $arrayJson=array();
                foreach($listado as $value) 
                {
                    if($value->fecha==$_GET['fecha'])
                    {
                        $obj=new stdclass();
                        $obj->id=$value->id;
                        $obj->id_anteojos=$value->id_anteojos;
                        $obj->cantidad=$value->cantidad;
                        $obj->fecha=$value->fecha;
                        $arrayJson[]=$obj;
                    }
                        
                }
                echo json_encode($arrayJson);
                $response=$next($request,$response);
            }
            else {
                $response=$next($request,$response);
            }
        }
        return $response;
    }

    public function MontoTotal($request,$response,$next) { 
        $token=$request->getHeader('token');
        $decodificado=JWT::decode(
            $token[0],
            'miClave',
            ['HS256']
        );
        if(count($decodificado->data)>1) {
            if(($decodificado->data[0]->perfil=='empleado' || $decodificado->data[0]->perfil=='encargado') || ($decodificado->data[1]->perfil=='empleado' || $decodificado->data[1]->perfil=='encargado')) {
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(anteojos.precio*ventas.cantidad) FROM `ventas` INNER JOIN anteojos ON anteojos.id=ventas.id_anteojos");
                $consulta->execute();
                $dato=$consulta->fetch();
                echo "Monto total=".$dato[0];
                $response=$next($request,$response);
            }
            else{
                $response=$next($request,$response);
            }
        }
        else {
            if($decodificado->data[0]->perfil=='empleado' || $decodificado->data[0]->perfil=='encargado') {
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(anteojos.precio*ventas.cantidad) FROM `ventas` INNER JOIN anteojos ON anteojos.id=ventas.id_anteojos");
                $consulta->execute();
                $dato=$consulta->fetch();
                echo "Monto total=".$dato[0];
                $response=$next($request,$response);
            }
            else {
                $response=$next($request,$response);
            }
        }
        return $response;
    }

}

?>