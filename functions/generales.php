<?php

function valida_datapicker($f_inicio){
                     
$cadena_de_texto = $f_inicio;
$cadena_buscada   = 'Enero';
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
if ($posicion_coincidencia === false) {
    $cadena_buscada   = 'Febrero';
    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
    if ($posicion_coincidencia === false) {
        $cadena_buscada   = 'Marzo';
        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
        if ($posicion_coincidencia === false) {
            $cadena_buscada   = 'Abril';
            $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
            if ($posicion_coincidencia === false) {
                $cadena_buscada   = 'Mayo';
                $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                if ($posicion_coincidencia === false) {
                    $cadena_buscada   = 'Junio';
                    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                    if ($posicion_coincidencia === false) {
                        $cadena_buscada   = 'Julio';
                        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $cadena_buscada   = 'Agosto';
                            $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $cadena_buscada   = 'Septiembre';
                                $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    $cadena_buscada   = 'Octubre';
                                    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                                    if ($posicion_coincidencia === false) {
                                        $cadena_buscada   = 'Noviembre';
                                        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                                        if ($posicion_coincidencia === false) {
                                            $cadena_buscada   = 'Diciembre';
                                            $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                                            if ($posicion_coincidencia === false) {
                                                
                                            }else{
                                                $mes = '12';
                                            }
                                        }else{
                                            $mes = '11';
                                        }
                                    }else{
                                        $mes = '10';
                                    }
                                }else{
                                    $mes = '09';
                                }
                                            }else{
                                $mes = '08';
                            }
                        }else{
                            $mes = '07';
                        }
                    }else{
                        $mes = '06';
                    }
                }else{
                    $mes = '05';
                }
            }else{
                $mes = '04';
            }
        }else{
            $mes = '03';
        }
    }else{
        $mes = '02';
    }
    } else {
        $mes = '01';
    }
// echo "<br>";

$rest = substr("$cadena_de_texto", $posicion_coincidencia-3,2);
//echo $rest."<br>"; 
$dia=$rest;
$cntc = strlen($cadena_buscada); 
$rest = substr("$cadena_de_texto", $posicion_coincidencia,$cntc);
//echo $rest."<br>";

$rest = substr("$cadena_de_texto", $posicion_coincidencia+$cntc+1,4);
//echo $rest."<br>";
$ano=$rest;
$fecha=$ano."-".$mes."-".$dia;

//echo $fecha."<br>";

    return $fecha; 
} 