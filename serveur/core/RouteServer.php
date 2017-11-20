<?php

/**
 * Created by PhpStorm.
 * User: MatrixOfDeath
 * Date: 22/03/2017
 * Time: 11:48
 */
class RouteServer
{
    public static function getService()
    {
        list($serviceName) = explode('/', $_GET['p']);
        return $serviceName ? $serviceName : false;
    }
}