<?php 
	// Función para ejecutar una consulta SQL y devolver el resultado
	function ejecutar($sql){
		// Conexión a la base de datos utilizando MySQLi
		$mysqli = new mysqli("198.59.144.197", "neuromod_conexion", "7)8S!K{%NBoL", "neuromod_medico");
	
		// Ajuste importante para unificar el juego de caracteres
		$mysqli->set_charset("utf8mb4");
	
		// Verifica si hay un error en la conexión
		if ($mysqli->connect_errno) {
			echo "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
	
		// Ejecuta la consulta SQL pasada como parámetro
		$resultado = $mysqli->query($sql);
	
		// Cierra la conexión con la base de datos
		$mysqli->close();
	
		// Retorna el resultado de la consulta
		return $resultado;
	}
	

	// Función para ejecutar una consulta SQL y devolver el objeto MySQLi, lo que permite obtener el último ID insertado
	function ejecutar_id($sql) {
	    // Conexión a la base de datos utilizando MySQLi
        //$mysqli = new mysqli("174.136.25.64","lamanad1_conexion","7)8S!K{%NBoL", "lamanad1_medico");
		
		$mysqli = new mysqli("198.59.144.197","neuromod_conexion","7)8S!K{%NBoL", "neuromod_medico");
	
		// Ajuste importante para unificar el juego de caracteres
		$mysqli->set_charset("utf8mb4");

	    // Verifica si hay un error en la conexión
	    if ($mysqli->connect_errno) {
	        // Si hay un error, muestra un mensaje con el código y el error, y termina la ejecución
	        echo "Falló la conexión con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	        exit();
	    }

	    // Ejecuta la consulta SQL pasada como parámetro
	    if (!$resultado = $mysqli->query($sql)) {
	        // Si hay un error en la consulta, muestra un mensaje con el código y el error
	        echo "Error en la consulta: (" . $mysqli->errno . ") " . $mysqli->error;
	    }

	    // Retorna el objeto MySQLi para permitir el acceso al último ID insertado
	    return $mysqli; 
	}
	
	function validarSinEspacio($cadena) {
		$cadena = trim($cadena);
		$cadena = str_replace(' ', '', $cadena);
	    return $cadena;
			// // Validar y limpiar los campos de email y celular eliminando espacios en blanco
			// $email = validarSinEspacio($email);
			// $celular = validarSinEspacio($celular);		
	}

    // Función para obtener el nombre del navegador basado en el User-Agent proporcionado
	function ObtenerNavegador($user_agent) {
		// Lista de patrones de User-Agent asociados con nombres de navegadores
		$navegadores = array(
			'Opera' => '/Opera|OPR\//',
			'Mozilla Firefox' => '/Firefox/',
			'Microsoft Edge' => '/Edg(e|iOS|A)/',
			'Google Chrome' => '/Chrome|CriOS/',
			'Safari' => '/Safari/',
			'Internet Explorer' => '/MSIE|Trident/',
			'Konqueror' => '/Konqueror/',
			'Netscape' => '/Netscape/',
			'Lynx' => '/Lynx/',
		);
	
		// Itera sobre la lista de navegadores para encontrar una coincidencia en el User-Agent
		foreach ($navegadores as $navegador => $pattern) {
			// Utiliza preg_match en lugar de eregi
			if (preg_match($pattern, $user_agent)) {
				return $navegador; // Retorna el nombre del navegador si se encuentra una coincidencia
			}
		}
	
		// Si no se encuentra ningún navegador, retorna 'Desconocido'
		return 'Desconocido';
	}
	
    /* Función que devuelve el navegador web actual basado en el User-Agent del servidor */
	function obtenerNavegadorWeb() {
        // Obtiene el User-Agent del navegador desde las variables del servidor
		$agente = $_SERVER['HTTP_USER_AGENT'];
        $navegador = 'Unknown'; // Inicializa el navegador como 'Desconocido'
        $platforma = 'Unknown'; // Inicializa la plataforma como 'Desconocido'
        $version = ""; // Inicializa la versión del navegador como una cadena vacía

        // Obtiene la plataforma del usuario basada en el User-Agent
		if (preg_match('/linux/i', $agente)) {
			$platforma = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $agente)) {
			$platforma = 'mac';
		} elseif (preg_match('/windows|win32/i', $agente)) {
			$platforma = 'windows';
		}

        // Identifica el navegador específico basado en el User-Agent
		if (preg_match('/MSIE/i', $agente) && !preg_match('/Opera/i', $agente)) {
			$navegador = 'Internet Explorer';
			$navegador_corto = "MSIE";
		} elseif (preg_match('/Firefox/i', $agente)) {
			$navegador = 'Mozilla Firefox';
			$navegador_corto = "Firefox";
		} elseif (preg_match('/Chrome/i', $agente)) {
			$navegador = 'Google Chrome';
			$navegador_corto = "Chrome";
		} elseif (preg_match('/Safari/i', $agente)) {
			$navegador = 'Apple Safari';
			$navegador_corto = "Safari";
		} elseif (preg_match('/Opera/i', $agente)) {
			$navegador = 'Opera';
			$navegador_corto = "Opera";
		} elseif (preg_match('/Netscape/i', $agente)) {
			$navegador = 'Netscape';
			$navegador_corto = "Netscape";
		}

        // Define las cadenas que son conocidas para identificar navegadores y versiones
		$known = array('Version', $navegador_corto, 'other');
        // Genera un patrón para buscar la versión en el User-Agent
		$pattern = '#(?'. join('|', $known) .')[/ ]+(?[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $agente, $matches)) {
			// Si no se encuentra la versión, continúa sin ella
		}

        // Obtiene el número de coincidencias encontradas
		$i = count($matches['browser']);
		if ($i != 1) {
            // Si hay más de una coincidencia, selecciona la versión correcta basada en la posición de "Version" en el User-Agent
			if (strripos($agente, "Version") < strripos($agente, $navegador_corto)) { 
				$version = $matches['version'][0];
			} else { 
				$version = $matches['version'][1];
			}
		} else { 
			$version = $matches['version'][0];
		}

        // Si no se encuentra una versión, establece la versión como "?" 
		if ($version == null || $version == "") {
			$version = "?";
		}

        // Retorna un array con los detalles del navegador, incluyendo el agente, nombre, versión y plataforma
		return array('agente' => $agente, 'nombre' => $navegador, 'version' => $version, 'platforma' => $platforma);
	}

	// Función para obtener el día de la semana como una letra
	function dias_semana($d_sem) {
        // Convierte un número de día en la letra correspondiente
		if ($d_sem == 1) { $result = 'L'; } // Lunes
		if ($d_sem == 2) { $result = 'M'; } // Martes
		if ($d_sem == 3) { $result = 'M'; } // Miércoles
		if ($d_sem == 4) { $result = 'J'; } // Jueves
		if ($d_sem == 5) { $result = 'V'; } // Viernes
		if ($d_sem == 6) { $result = 'S'; } // Sábado
		if ($d_sem == 7) { $result = 'D'; } // Domingo
		return $result; // Retorna la letra correspondiente al día
	}

	// Función para calcular la cantidad de meses entre dos fechas
	function meses($fech_ini, $fech_fin) {
        /*
        FELIPE DE JESUS SANTOS SALAZAR, LIFER35@HOTMAIL.COM
        SEP-2010

        ESTA FUNCIÓN NOS REGRESA LA CANTIDAD DE MESES ENTRE 2 FECHAS

        EL FORMATO DE LAS VARIABLES DE ENTRADA $fech_ini Y $fech_fin ES YYYY-MM-DD

        $fech_ini TIENE QUE SER MENOR QUE $fech_fin

        ESTA FUNCIÓN TAMBIÉN SE PUEDE HACER CON LA FUNCIÓN date

        SI ENCUENTRAS ALGÚN ERROR FAVOR DE HACÉRMELO SABER

        ESPERO TE SEA DE UTILIDAD, POR FAVOR NO QUITES ESTE COMENTARIO, GRACIAS
        */

        // Separa los valores del año, mes y día para la fecha inicial en diferentes variables para su mejor manejo
        $fIni_yr = substr($fech_ini, 0, 4); // Año de la fecha inicial
        $fIni_mon = substr($fech_ini, 5, 2); // Mes de la fecha inicial
        $fIni_day = substr($fech_ini, 8, 2); // Día de la fecha inicial

        // Separa los valores del año, mes y día para la fecha final en diferentes variables para su mejor manejo
        $fFin_yr = substr($fech_fin, 0, 4); // Año de la fecha final
        $fFin_mon = substr($fech_fin, 5, 2); // Mes de la fecha final
        $fFin_day = substr($fech_fin, 8, 2); // Día de la fecha final

        // Calcula la diferencia de años entre las dos fechas
        $yr_dif = $fFin_yr - $fIni_yr;

        // La función strtotime nos permite comparar correctamente las fechas
        if (strtotime($fech_ini) > strtotime($fech_fin)) {
            echo 'ERROR -> la fecha inicial es mayor a la fecha final <br>';
            exit(); // Si la fecha inicial es mayor que la final, termina la ejecución
        } else {
            // Si hay exactamente un año de diferencia, calcula los meses entre las fechas
            if ($yr_dif == 1) {
                $fIni_mon = 12 - $fIni_mon;
                $meses = $fFin_mon + $fIni_mon;
                return $meses;
            } else {
                // Si no hay diferencia de años, simplemente resta los meses
                if ($yr_dif == 0) {
                    $meses = $fFin_mon - $fIni_mon;
                    return $meses;
                } else {
                    // Si hay más de un año de diferencia, calcula los meses sumando los meses entre años
                    if ($yr_dif > 1) {
                        $fIni_mon = 12 - $fIni_mon;
                        $meses = $fFin_mon + $fIni_mon + (($yr_dif - 1) * 12);
                        return $meses;
                    } else {
                        echo "ERROR -> la fecha inicial es mayor a la fecha final <br>";
                        exit(); // Si hay un error en las fechas, termina la ejecución
                    }
                }
            }
        }
    }

    /**
     * @function num2letras
     * @abstract Dado un número lo devuelve escrito en letras.
     * @param $num number - Número a convertir.
     * @param $fem bool - Forma femenina (true) o no (false).
     * @param $dec bool - Con decimales (true) o no (false).
     * @result string - Devuelve el número escrito en letra.
     */
	function num2letras($num, $fem = false, $dec = true) {
        // Definición de los valores en texto para unidades, decenas, centenas, etc.
        $matuni[2]  = "dos";
        $matuni[3]  = "tres";
        $matuni[4]  = "cuatro";
        $matuni[5]  = "cinco";
        $matuni[6]  = "seis";
        $matuni[7]  = "siete";
        $matuni[8]  = "ocho";
        $matuni[9]  = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciséis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3]  = 'mill';
        $matsub[5]  = 'bill';
        $matsub[7]  = 'mill';
        $matsub[9]  = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4]  = 'millones';
        $matmil[6]  = 'billones';
        $matmil[7]  = 'de billones';
        $matmil[8]  = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        // Quita los espacios en blanco del inicio y final del número
        $num = trim((string)@$num);
        if ($num[0] == '-') {
            $neg = 'menos '; // Si el número es negativo, añade 'menos'
            $num = substr($num, 1);
        } else {
            $neg = ''; // Si no es negativo, no añade nada
        }

        // Elimina ceros a la izquierda
        while ($num[0] == '0') $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;

        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';

        // Procesa la parte entera y decimal del número
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (! (strpos(".,'''", $n) === false)) {
                if ($punt) break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (! (strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0') $zeros = false;
                    $fra .= $n;
                } else {
                    $ent .= $n;
                }
            } else {
                break;
            }
        }

        $ent = '     ' . $ent;
        if ($dec && $fra && !$zeros) {
            $fin = ' con';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0') {
                    $fin .= ' cero';
                } elseif ($s == '1') {
                    $fin .= $fem ? ' una' : ' un';
                } else {
                    $fin .= ' ' . $matuni[$s];
                }
            }
        } else {
            $fin = '';
        }

        if ((int)$ent === 0) return 'Cero ' . $fin;

        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;

        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 && $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }

            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
                // No hace nada
            } elseif ($n2 < 21) {
                $t = ' ' . $matuni[(int)$n2];
            } elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0) $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            } else {
                $n3 = $num[2];
                if ($n3 != 0) $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }

            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }

            if ($sub == 1) {
                // No hace nada
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '&oacute;n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }

            if ($num == '000') {
                $mils++;
            } elseif ($mils != 0) {
                if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }

            $neutro = true;
            $tex = $t . $tex;
        }

        $tex = $neg . substr($tex, 1) . $fin;
        return ucfirst($tex);
	}

    // Función para convertir un número a letras dependiendo de su longitud
	function numero_letra($numero) {
        // Obtiene la longitud del número
		$cifra = strlen($numero);

        // Convierte el número a letras dependiendo de la cantidad de dígitos
		if ($cifra == 1) {
			$numero_letra = unidad($numero);
		}
		if ($cifra == 2) {
			$numero_letra = decena($numero);
		}
		if ($cifra == 3) {
			$numero_letra = centena($numero);
		}
		if ($cifra == 4) {
			$numero_letra = miles($numero);
		}
		if ($cifra == 5) {
			$numero_letra = decmiles($numero);
		}
		if ($cifra == 6) {
			$numero_letra = cienmiles($numero);
		}

        // Retorna el número convertido a letras
		return $numero_letra;	
	}

    // Función para convertir la unidad de un número a letras
	function unidad($numuero) {
		switch ($numuero) {
			case 9:
				$numu = "NUEVE";
				break;
			case 8:
				$numu = "OCHO";
				break;
			case 7:
				$numu = "SIETE";
				break;
			case 6:
				$numu = "SEIS";
				break;
			case 5:
				$numu = "CINCO";
				break;
			case 4:
				$numu = "CUATRO";
				break;
			case 3:
				$numu = "TRES";
				break;
			case 2:
				$numu = "DOS";
				break;
			case 1:
				$numu = "UN";
				break;
			case 0:
				$numu = "";
				break;
		}
        // Retorna el texto correspondiente a la unidad
		return $numu;	
	}

    // Función para convertir las decenas de un número a letras
	function decena($numdero) {
		if ($numdero >= 90 && $numdero <= 99) {
			$numd = "NOVENTA ";
			if ($numdero > 90)
				$numd = $numd . "Y " . unidad($numdero - 90);
		} else if ($numdero >= 80 && $numdero <= 89) {
			$numd = "OCHENTA ";
			if ($numdero > 80)
				$numd = $numd . "Y " . unidad($numdero - 80);
		} else if ($numdero >= 70 && $numdero <= 79) {
			$numd = "SETENTA ";
			if ($numdero > 70)
				$numd = $numd . "Y " . unidad($numdero - 70);
		} else if ($numdero >= 60 && $numdero <= 69) {
			$numd = "SESENTA ";
			if ($numdero > 60)
				$numd = $numd . "Y " . unidad($numdero - 60);
		} else if ($numdero >= 50 && $numdero <= 59) {
			$numd = "CINCUENTA ";
			if ($numdero > 50)
				$numd = $numd . "Y " . unidad($numdero - 50);
		} else if ($numdero >= 40 && $numdero <= 49) {
			$numd = "CUARENTA ";
			if ($numdero > 40)
				$numd = $numd . "Y " . unidad($numdero - 40);
		} else if ($numdero >= 30 && $numdero <= 39) {
			$numd = "TREINTA ";
			if ($numdero > 30)
				$numd = $numd . "Y " . unidad($numdero - 30);
		} else if ($numdero >= 20 && $numdero <= 29) {
			if ($numdero == 20)
				$numd = "VEINTE ";
			else
				$numd = "VEINTI" . unidad($numdero - 20);
		} else if ($numdero >= 10 && $numdero <= 19) {
			switch ($numdero) {
				case 10:
					$numd = "DIEZ ";
					break;
				case 11:
					$numd = "ONCE ";
					break;
				case 12:
					$numd = "DOCE ";
					break;
				case 13:
					$numd = "TRECE ";
					break;
				case 14:
					$numd = "CATORCE ";
					break;
				case 15:
					$numd = "QUINCE ";
					break;
				case 16:
					$numd = "DIECISEIS ";
					break;
				case 17:
					$numd = "DIECISIETE ";
					break;
				case 18:
					$numd = "DIECIOCHO ";
					break;
				case 19:
					$numd = "DIECINUEVE ";
					break;
			}	
		} else {
			$numd = unidad($numdero);
		}
        // Retorna el texto correspondiente a la decena
		return $numd;
	}

    // Función para convertir las centenas de un número a letras
	function centena($numc) {
		if ($numc >= 100) {
			if ($numc >= 900 && $numc <= 999) {
				$numce = "NOVECIENTOS ";
				if ($numc > 900)
					$numce = $numce . decena($numc - 900);
			} else if ($numc >= 800 && $numc <= 899) {
				$numce = "OCHOCIENTOS ";
				if ($numc > 800)
					$numce = $numce . decena($numc - 800);
			} else if ($numc >= 700 && $numc <= 799) {
				$numce = "SETECIENTOS ";
				if ($numc > 700)
					$numce = $numce . decena($numc - 700);
			} else if ($numc >= 600 && $numc <= 699) {
				$numce = "SEISCIENTOS ";
				if ($numc > 600)
					$numce = $numce . decena($numc - 600);
			} else if ($numc >= 500 && $numc <= 599) {
				$numce = "QUINIENTOS ";
				if ($numc > 500)
					$numce = $numce . decena($numc - 500);
			} else if ($numc >= 400 && $numc <= 499) {
				$numce = "CUATROCIENTOS ";
				if ($numc > 400)
					$numce = $numce . decena($numc - 400);
			} else if ($numc >= 300 && $numc <= 399) {
				$numce = "TRESCIENTOS ";
				if ($numc > 300)
					$numce = $numce . decena($numc - 300);
			} else if ($numc >= 200 && $numc <= 299) {
				$numce = "DOSCIENTOS ";
				if ($numc > 200)
					$numce = $numce . decena($numc - 200);
			} else if ($numc >= 100 && $numc <= 199) {
				if ($numc == 100)
					$numce = "CIEN ";
				else
					$numce = "CIENTO " . decena($numc - 100);
			}
		} else {
			$numce = decena($numc);
		}
        // Retorna el texto correspondiente a la centena
		return $numce;	
	}

    // Función para convertir los miles de un número a letras
	function miles($nummero) {
		if ($nummero >= 1000 && $nummero < 2000) {
			$numm = "MIL " . centena($nummero % 1000);
		}
		if ($nummero >= 2000 && $nummero < 10000) {
			$numm = unidad(floor($nummero / 1000)) . " MIL " . centena($nummero % 1000);
		}
		if ($nummero < 1000)
			$numm = centena($nummero);
        // Retorna el texto correspondiente a los miles
		return $numm;
	}

    // Función para convertir las decenas de mil a letras
	function decmiles($numdmero) {
		if ($numdmero == 10000)
			$numde = "DIEZ MIL";
		if ($numdmero > 10000 && $numdmero < 20000) {
			$numde = decena(floor($numdmero / 1000)) . "MIL " . centena($numdmero % 1000);		
		}
		if ($numdmero >= 20000 && $numdmero < 100000) {
			$numde = decena(floor($numdmero / 1000)) . " MIL " . miles($numdmero % 1000);		
		}		
		if ($numdmero < 10000)
			$numde = miles($numdmero);
        // Retorna el texto correspondiente a las decenas de mil
		return $numde;
	}

    // Función para convertir las centenas de mil a letras
	function cienmiles($numcmero) {
		if ($numcmero == 100000)
			$num_letracm = "CIEN MIL";
		if ($numcmero >= 100000 && $numcmero < 1000000) {
			$num_letracm = centena(floor($numcmero / 1000)) . " MIL " . centena($numcmero % 1000);		
		}
		if ($numcmero < 100000)
			$num_letracm = decmiles($numcmero);
        // Retorna el texto correspondiente a las centenas de mil
		return $num_letracm;
	}	
	
    // Función para convertir los millones a letras
	function millon($nummiero) {
		if ($nummiero >= 1000000 && $nummiero < 2000000) {
			$num_letramm = "UN MILLON " . cienmiles($nummiero % 1000000);
		}
		if ($nummiero >= 2000000 && $nummiero < 10000000) {
			$num_letramm = unidad(floor($nummiero / 1000000)) . " MILLONES " . cienmiles($nummiero % 1000000);
		}
		if ($nummiero < 1000000)
			$num_letramm = cienmiles($nummiero);
        // Retorna el texto correspondiente a los millones
		return $num_letramm;
	}

    // Función para convertir las decenas de millón a letras
	function decmillon($numerodm) {
		if ($numerodm == 10000000)
			$num_letradmm = "DIEZ MILLONES";
		if ($numerodm > 10000000 && $numerodm < 20000000) {
			$num_letradmm = decena(floor($numerodm / 1000000)) . "MILLONES " . cienmiles($numerodm % 1000000);		
		}
		if ($numerodm >= 20000000 && $numerodm < 100000000) {
			$num_letradmm = decena(floor($numerodm / 1000000)) . " MILLONES " . millon($numerodm % 1000000);		
		}
		if ($numerodm < 10000000)
			$num_letradmm = millon($numerodm);
        // Retorna el texto correspondiente a las decenas de millón
		return $num_letradmm;
	}

    // Función para convertir las centenas de millón a letras
	function cienmillon($numcmeros) {
		if ($numcmeros == 100000000)
			$num_letracms = "CIEN MILLONES";
		if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
			$num_letracms = centena(floor($numcmeros / 1000000)) . " MILLONES " . millon($numcmeros % 1000000);		
		}
		if ($numcmeros < 100000000)
			$num_letracms = decmillon($numcmeros);
        // Retorna el texto correspondiente a las centenas de millón
		return $num_letracms;
	}

    // Función para convertir los mil millones a letras
	function milmillon($nummierod) {
		if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
			$num_letrammd = "MIL " . cienmillon($nummierod % 1000000000);
		}
		if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
			$num_letrammd = unidad(floor($nummierod / 1000000000)) . " MIL " . cienmillon($nummierod % 1000000000);
		}
		if ($nummierod < 1000000000)
			$num_letrammd = cienmillon($nummierod);
        // Retorna el texto correspondiente a los mil millones
		return $num_letrammd;
	}	

?>
