<?php

require_once "AccesoDatos.php";

class Anteojos {
    public function Alta($request,$response,$next) {
        $array=$request->getParsedBody();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `anteojos` (`id`, `color`, `marca`, `precio`, `aumento`) VALUES (NULL, :color, :marca, :precio, :aumento);");
        $consulta->bindValue(':color',  $array['color'], PDO::PARAM_STR);
        $consulta->bindValue(':marca',  $array['marca'], PDO::PARAM_STR);
        $consulta->bindValue(':precio',  $array['precio'], PDO::PARAM_STR);
        $consulta->bindValue(':aumento',  $array['aumento'], PDO::PARAM_STR);
        //$consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $response=$next($request,$response);
        return $response;
    }

    public function TraerAnteojos() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM anteojos");
        $consulta->execute();
        $datos=$consulta->fetchall();
        $arrayJson=array();
        foreach($datos as $value) 
        {
            $obj=new stdclass();
            $obj->id=$value['id'];
            $obj->color=$value['color'];
            $obj->marca=$value['marca'];
            $obj->precio=$value['precio'];
            $obj->aumento=$value['aumento'];
            $arrayJson[]=$obj;
        }
        //echo json_encode($arrayJson);
        //$response=$next($request,$response);
        return $arrayJson;
    }

    public static function AltaVenta($request,$response,$next) {
        $array=$request->getParsedBody();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `ventas` (`id`, `id_anteojos`, `cantidad`, `fecha`) VALUES (NULL, :id_anteojos, :cantidad, :fecha);");
        $consulta->bindValue(':id_anteojos',  $array['id_anteojos'], PDO::PARAM_STR);
        $consulta->bindValue(':cantidad',  $array['cantidad'], PDO::PARAM_STR);
        $consulta->bindValue(':fecha',  $array['fecha'], PDO::PARAM_STR);
        //$consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $response=$next($request,$response);
        return $response;
    }

    public static function TraerVentas() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM ventas");
        $consulta->execute();
        $datos=$consulta->fetchall();
        $arrayJson=array();
        foreach($datos as $value) 
        {
            $obj=new stdclass();
            $obj->id=$value['id'];
            $obj->id_anteojos=$value['id_anteojos'];
            $obj->cantidad=$value['cantidad'];
            $obj->fecha=$value['fecha'];
            $arrayJson[]=$obj;
        }
        //echo json_encode($arrayJson);
        //$response=$next($request,$response);
        return $arrayJson;
    }

    public function BorrarAnteojos($request,$response,$next) {
        $array=$request->getParsedBody();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM anteojos WHERE id = :id");
        $consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $response=$next($request,$response);
        return $response;
    }

    public function ModificarAnteojos($request,$response,$next) { 
        $array=$request->getParsedBody();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `anteojos` SET `color` = :color, `marca` = :marca, `precio` = :precio, `aumento` = :aumento WHERE `id` = :id;");
        $consulta->bindValue(':color',  $array['color'], PDO::PARAM_STR);
        $consulta->bindValue(':marca',  $array['marca'], PDO::PARAM_STR);
        $consulta->bindValue(':precio',  $array['precio'], PDO::PARAM_STR);
        $consulta->bindValue(':aumento',  $array['aumento'], PDO::PARAM_STR);
        $consulta->bindValue(':id',  $array['id'], PDO::PARAM_INT);
        $consulta->execute();
        $response=$next($request,$response);
        return $response;
    }
}