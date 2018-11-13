<?php

require_once "AccesoDatos.php";
use \Firebase\JWT\JWT as JWT;

class Usuario {

    public function AgregarUsuario($request,$response,$next) {
        $array=$request->getParsedBody();
        //$foto=$request->getUploadedFiles();
        //$nombre=$foto['foto']->getClientFilename();
        //$extension=explode(".",$nombre);
        //$extension=array_reverse($extension);
        $destino=$array['apellido'].".".$array['perfil'].".jpg";
        //$foto['foto']->moveTo("fotos/".$destino);
        move_uploaded_file($_FILES["foto"]["tmp_name"],"fotos/". $destino);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `usuario` (`id`, `correo`, `clave`, `nombre`, `apellido`, `perfil`, `foto`) VALUES (null, :correo, :clave, :nombre, :apellido, :perfil, :foto);");
        $consulta->bindValue(':correo',  $array['correo'], PDO::PARAM_STR);
        $consulta->bindValue(':clave',  $array['clave'], PDO::PARAM_STR);
        $consulta->bindValue(':nombre',  $array['nombre'], PDO::PARAM_STR);
        $consulta->bindValue(':apellido',  $array['apellido'], PDO::PARAM_STR);
        $consulta->bindValue(':perfil',  $array['perfil'], PDO::PARAM_STR);
        $consulta->bindValue(':foto',  $destino, PDO::PARAM_STR);
        //$consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $response=$next($request,$response);
        return $response;
    }

    public function TraerUsuarios($request,$response,$next) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario");
        $consulta->execute();
        $datos=$consulta->fetchall();
        $arrayJson=array();
        foreach($datos as $value) 
        {
            $obj=new stdclass();
            $obj->id=$value['id'];
            $obj->correo=$value['correo'];
            $obj->clave=$value['clave'];
            $obj->nombre=$value['nombre'];
            $obj->apellido=$value['apellido'];
            $obj->perfil=$value['perfil'];
            $obj->clave=$value['foto'];
            $arrayJson[]=$obj;
        }
        echo json_encode($arrayJson);
        $response=$next($request,$response);
        return $response;
    }
}

?>