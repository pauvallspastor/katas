<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body style="font-family:'Courier New', Courier, monospace">

<?php
//--------------------------------------------------------------------------------------------------------------------//
// Autor código: Pau Valls                                                                                            //
// Fecha creacion: 04/10/2015                                                                                         //
// Kata 3: KataGameOfLife                                                                                             //
//      You start with a two dimensional grid of cells, where each cell is either alive or dead. In this version of   //
//      the problem, the grid is finite, and no life can exist off the edges. When calcuating the next generation of  //
//      the grid, follow these rules:                                                                                 // 
//                                                                                                                    //
//   1. Any live cell with fewer than two live neighbours dies, as if caused by underpopulation.                      // 
//   2. Any live cell with more than three live neighbours dies, as if by overcrowding.                               //
//   3. Any live cell with two or three live neighbours lives on to the next generation.                              //
//   4. Any dead cell with exactly three live neighbours becomes a live cell.                                         //
//                                                                                                                    //
//   You should write a program that can accept an arbitrary grid of cells, and will output a similar grid showing    //
//   the next generation.                                                                                             //     
//--------------------------------------------------------------------------------------------------------------------//




//******************************************************************************//
// Funcion f_valor_nueva_generacion($row,$col)
// 		Input:  fila,columna
// 		Output: estado de la celda segun sus vecinas (viva = *, muerta = .
//******************************************************************************//
function f_valor_nueva_generacion($row,$col)
{
	global $grid;
	
	if (f_numero_de_vecinas($row,$col) < 2) return ".";
	if (f_numero_de_vecinas($row,$col) > 3) return ".";
	if (f_numero_de_vecinas($row,$col) == 2) return $grid[$row][$col];
	if (f_numero_de_vecinas($row,$col) == 3) return "*";

} // fin de la funcion f_valor_nueva_generacion



//******************************************************************************//
// Funcion f_numero_de_vecinas($row,$col)
// 		Input:  fila,columna
// 		Output: numero de celdas vecinas vivas
//******************************************************************************//
function f_numero_de_vecinas($row,$col)
{
	global $grid;
	global $next_grid;
	global $max_col;
	global $max_row;	
	
	$vecinas = 0;
	//Izquierda
	if (($col-1 >= 1) and ($grid[$row][$col-1] == "*")) $vecinas++;
	
	//Derecha
	if (($col+1 <= $max_col) and ($grid[$row][$col+1] == "*")) $vecinas++;
			
	//Arriba
	if (($row-1 >= 1) and ($grid[$row-1][$col] == "*")) $vecinas++;

	//Abajo
	if (($row+1 <= $max_row) and ($grid[$row+1][$col] == "*")) $vecinas++;
			
	//Izquierda Abajo
	if (($col-1 >= 1) and ($row+1 <= $max_row) and ($grid[$row+1][$col-1] == "*")) $vecinas++;			

	//Derecha Abajo 
	if (($col+1 <= $max_col) and ($row+1 <= $max_row) and ($grid[$row+1][$col+1] == "*")) $vecinas++;			

	//Izquierda Arriba
	if (($col-1 >= 1) and ($row-1 >= 1) and ($grid[$row-1][$col-1] == "*")) $vecinas++;		

	//Derecha Arriba
	if (($col+1 <= $max_col) and ($row-1 >= 1) and ($grid[$row-1][$col+1] == "*")) $vecinas++;		

	return $vecinas;
} // fin de la funcion f_numero_de_vecinas






//------------------------------------------------------------------------------------------//
//------------------------------------ INICIO PROGRAMA -------------------------------------//
//------------------------------------------------------------------------------------------//


//---------------------- Datos de entrada ------------------------------------
//Estas filas podrian ser el resultado de recorrer un fichero de texto
$fila[1]= "........";
$fila[2]= "....*...";
$fila[3]= "...**...";
$fila[4]= "........";

//Estos valores vendrían determinados por el fichero de entrada
$max_col = 8;
$max_row = 4;

//Inicializamos varibles
$grid = "";
$next_grid = "";



//Montamos la mtriz 4x8 (se podrian usar variables para el nº de filas y columnasm: asi podria aceptar cualquier matriz
echo "<br>Generacion 1<br>";
for($row=1; $row<=$max_row; $row++)
{
	for($col=1; $col<=$max_col; $col++)
	{
		//A partir de los datos de entrada montamos la matriz
		$grid[$row][$col] = $fila[$row][$col-1];
		
		//Mostramos la matriz original
		echo $grid[$row][$col];
		
	} // fin del for que recorre las columnas
	echo "<br>";
} // fin del for que recorre las filas


//Calculamos el nuevo estado de cada celda segun sus vecinas
for($row=1; $row<=$max_row; $row++)
	for($col=1; $col<=$max_col; $col++)
		$next_grid[$row][$col] = f_valor_nueva_generacion($row,$col);

//Mostramos la matriz de nueva generacion 
echo "<br>Generacion 2<br>";
for($row=1; $row<=$max_row; $row++)
{
	for($col=1; $col<=$max_col; $col++)
		echo $next_grid[$row][$col];
	echo "<br>";	
}


//-----------------------------------------------------------------------------------------//
//------------------------------------  FIN  PROGRAMA -------------------------------------//
//-----------------------------------------------------------------------------------------//

?>
</body>
</html>
