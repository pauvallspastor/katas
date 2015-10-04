<?php
//--------------------------------------------------------------------------------------------------------------------//
// Autor código: Pau Valls                                                                                            //
// Fecha creacion: 04/10/2015                                                                                         //
// Kata 2:   We can briefly summarize the scoring for this form of bowling:                                           //
//    * Each game, or "line" of bowling, includes ten turns, or "frames" for the bowler.                              //
//    * In each frame, the bowler gets up to two tries to knock down all the pins.                                    //
//    * If in two tries, he fails to knock them all down, his score for that frame is the total number of             //
//	    pins knocked down in his two tries.                                                                           //
//    * If in two tries he knocks them all down, this is called a "spare" and his score for the frame is ten          //
//      plus the number of pins knocked down on his next throw (in his next turn).                                    //
//    * If on his first try in the frame he knocks down all the pins, this is called a "strike". His turn is          //
//      over, and his score for the frame is ten plus the simple total of the pins knocked down in his next           //
//      two rolls.                                                                                                    //
//	  * If he gets a spare or strike in the last (tenth) frame, the bowler gets to throw one or two more              //
//      bonus balls, respectively. These bonus throws are taken as part of the same turn. If the bonus throws         //
//      knock down all the pins, the process does not repeat: the bonus throws are only used to calculate the         //
//      score of the final frame.                                                                                     // 
//    * The game score is the total of all frame scores.                                                              //
//--------------------------------------------------------------------------------------------------------------------//




//******************************************************************************//
// Funcion f_valor_siguiente_jugada_strike($i);
// 		Input:  indice del frame
// 		Output: puntos(string);puntos(integer)  dos valores separados por ;
//******************************************************************************//
function f_valor_siguiente_jugada_strike($i)
{
	global $v_frames;
	if ($v_frames[$i+1][0] == "X")
		if ($v_frames[$i+2][0] == "X")		
			return "10+10;20";
		else
			return "10+" . f_valor_jugada($i+2) . ";" . 10+f_valor_jugada($i+2);
	else
		return f_valor_jugada($i+1) . ";" . f_valor_jugada($i+1);

} // fin de la funcion f_valor_siguiente_jugada_strike




//******************************************************************************//
// Funcion f_valor_siguiente_jugada_spare($i);
// 		Input:  indice del frame
// 		Output: puntos(string);puntos(integer)  dos valores separados por ;
//******************************************************************************//
function f_valor_siguiente_jugada_spare($i)
{
	global $v_frames;
	if ($v_frames[$i+1][0] == "X")
		return "10;10";
	else
		return $v_frames[$i+1][0] . ";" . $v_frames[$i+1][0];

} // fin de la funcion f_valor_siguiente_jugada_spare



//******************************************************************************//
// Funcion f_valor_jugada($i);
// 		Input:  indice del frame
// 		Output: devuelve el valor en puntos de una jugada (sin tener en cuenta strike o spare)
//******************************************************************************//
function f_valor_jugada($i)
{
	global $v_frames;
	if (($v_frames[$i][0] == "X") or ($v_frames[$i][1] == "/"))
		return 10;
	else
		return $v_frames[$i][0] + $v_frames[$i][1];
} //fin de la funcion f_valor_jugada




//------------------------------------------------------------------------------------------//
//------------------------------------ INICIO PROGRAMA -------------------------------------//
//------------------------------------------------------------------------------------------//


//---------------------- Datos de entrada ------------------------------------
$scoring = "XXXXXXXXXXXX";
//$scoring = "5/5/5/5/5/5/5/5/5/5/5";
//$scoring = "9-9-9-9-9-9-9-9-9-9-";




//------------------------- Creamos un vector con cada jugada ----------------
$index = 1; $try=1;
$scoring = str_replace("-", "0", $scoring);
for ($i=0; $i < strlen($scoring); $i++)
{
	$v_frames[$index] = $v_frames[$index].$scoring[$i];
	if (($scoring[$i] == "X") or ($try == 2)) { $index++; $try = 1;	}
	else $try++;	
} // fin del for que crea el vector de jugadas

echo "<br>";
print_r($v_frames);
echo "<br><br>";


//------------ Recorremos las jugadas y mostramos los puntos -----------------
$resultado_literal = ""; 
$resultado_valor   = "";
for ($i=1; $i <= 10; $i++)
{	
	$valor_jugada = 0;
	$valor_jugada_literal = 0;
	$valor_jugada_puntos  = 0;
	
	//-------- STRIKE ---------//
	if ($v_frames[$i][0] == "X")
	{
		$jugada = f_valor_siguiente_jugada_strike($i);
		$valor_jugada = split(";", $jugada);
		$valor_jugada_literal = "10+" . $valor_jugada[0];
		$valor_jugada_puntos = 10 + $valor_jugada[1];
	}
	else
	{
		$valor_jugada_literal = $v_frames[$i][0];	
		$valor_jugada_puntos  = $v_frames[$i][0];			
	} 
	
	//--------- SPARE ----------//
	if (strlen($v_frames[$i]) == 2) 
		if ($v_frames[$i][1] == "/")
		{
			$jugada = f_valor_siguiente_jugada_spare($i);
			$valor_jugada = split(";", $jugada);
			$valor_jugada_literal = "10+" . $valor_jugada[0];
			$valor_jugada_puntos = 10 + $valor_jugada[1];
		}
		else
		{
			$valor_jugada_literal = $v_frames[$i][0] + $v_frames[$i][1];	
			$valor_jugada_puntos  = $v_frames[$i][0] + $v_frames[$i][1];			
		} // fin de la segunda jugada


	//Acumulamos los resultados
	$resultado_literal = $resultado_literal . " (" . $valor_jugada_literal . ") +";
	$resultado_valor = $resultado_valor + $valor_jugada_puntos;		 
	
} // fin del for que recorre las jugadas


//---------------------- Mostramos Resultado ----------------------------//
$resultado_literal = substr($resultado_literal, 0, strlen($resultado_literal)-1);
echo "<br>Resultado: " . $resultado_literal;
echo "<br>Puntos : " . $resultado_valor;

//-----------------------------------------------------------------------------------------//
//------------------------------------  FIN  PROGRAMA -------------------------------------//
//-----------------------------------------------------------------------------------------//

?>
