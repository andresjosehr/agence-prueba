<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoUsuario;
use App\CoFatura;
use DB;


class con_desempenhoController extends Controller{
    public function index(){


		$Consultores= CoUsuario::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
				     ->where([
							    ['PERMISSAO_SISTEMA.CO_SISTEMA', '=', '1'],
							    ['PERMISSAO_SISTEMA.IN_ATIVO', '=', 'S'],
							])
				     ->whereIn('PERMISSAO_SISTEMA.IN_ATIVO', array(0, 1, 1))
						    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
						    ->get();

						    return view("agency.con_desempenho", ["Consultores" => $Consultores]);
    }

    public function relatorio(Request $Request)
    {	
    	  $Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  // $Datos["Custo"] = DB::table("CAO_SALARIO")->whereIn("co_usuario", $Request->Usuarios)->get();

    	  $Fact= CoFatura::join('CAO_OS', 'CAO_FATURA.CO_OS', '=', 'CAO_OS.CO_OS')
    	  					->join('CAO_USUARIO', 'CAO_OS.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
    	  					->join('CAO_SALARIO', 'CAO_SALARIO.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
				     ->where([
							    ['DATA_EMISSAO', '>=', $Request->FechaInicio],
							    ['DATA_EMISSAO', '<=', $Request->FechaFin],
							])
				     ->whereIn('CAO_USUARIO.CO_USUARIO', $Request->Usuarios)
				     ->orderBy("DATA_EMISSAO", "ASC")
						    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
						    ->get();

			$Fact = json_decode(json_encode($Fact), true);

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					for ($k=0; $k <count($Fact) ; $k++) { 
						if (date("Y-m", strtotime($FechaMedia[$j]))==date("Y-m", strtotime($Fact[$k]["data_emissao"])) && $Fact[$k]["co_usuario"]==$Request->Usuarios[$i]) {
							if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])) {
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]+($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100));
								$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]+((($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100))*$Fact[$k]["comissao_cn"])/100);
								$Datos[$Request->Usuarios[$i]]["CostoFijo"]=$Fact[$k]["brut_salario"];
								$Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=($Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])+($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]-($Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])-$Datos[$Request->Usuarios[$i]]["CostoFijo"]);
							} else{
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100);
								$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=(($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100))*$Fact[$k]["comissao_cn"])/100;
								$Datos[$Request->Usuarios[$i]]["CostoFijo"]=$Fact[$k]["brut_salario"];$Fact[$k]["data_emissao"];
								$Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]-($Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])-$Datos[$Request->Usuarios[$i]]["CostoFijo"];
							}
							
						} 
					}
					

				}
					
			}	

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))])) {
					} else{
						$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
					}
				}
			}

			return view("agency.relatorio", ["Datos" => $Datos, "FechaMedia" => $FechaMedia, "Usuarios" => $Request->Usuarios]);

    }

    public function Pizza(Request $Request){

    	 $Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  // $Datos["Custo"] = DB::table("CAO_SALARIO")->whereIn("co_usuario", $Request->Usuarios)->get();

    	  $Fact= CoFatura::join('CAO_OS', 'CAO_FATURA.CO_OS', '=', 'CAO_OS.CO_OS')
    	  					->join('CAO_USUARIO', 'CAO_OS.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
    	  					->join('CAO_SALARIO', 'CAO_SALARIO.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
				     ->where([
							    ['DATA_EMISSAO', '>=', $Request->FechaInicio],
							    ['DATA_EMISSAO', '<=', $Request->FechaFin],
							])
				     ->whereIn('CAO_USUARIO.CO_USUARIO', $Request->Usuarios)
				     ->orderBy("DATA_EMISSAO", "ASC")
						    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
						    ->get();

			$Fact = json_decode(json_encode($Fact), true);

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					for ($k=0; $k <count($Fact) ; $k++) { 
						if (date("Y-m", strtotime($FechaMedia[$j]))==date("Y-m", strtotime($Fact[$k]["data_emissao"])) && $Fact[$k]["co_usuario"]==$Request->Usuarios[$i]) {
							if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])) {
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]+($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100));
							} else{
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100);
							}
							
						} 
					}
					

				}
					
			}	

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				$Usuarios[$i]=$Request->Usuarios[$i];
				if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"])) {
					$Ganancias[$i]=array_sum($Datos[$Request->Usuarios[$i]]["Ganancias"]);
				} else{
					$Ganancias[$i]=0;
				}
				for ($j=0; $j <count($FechaMedia); $j++) {
					if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))])) {
					} else{
						$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
					}
				}
			}

			function random_color_part() {
			    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			}
			function random_color() {
			    return random_color_part() . random_color_part() . random_color_part();
			}

			$DataEmp=' <graph caption="Participação na Receita" bgColor="F1f1f1" decimalPrecision="1" showPercentageValues="1" showNames="1" numberPrefix="" showValues="1" showPercentageInLabel="1" pieYScale="45" pieBorderAlpha="40" pieFillAlpha="70" pieSliceDepth="15" pieRadius="100">';
			$Data='';
			for ($i=0; $i <count($Request->Usuarios); $i++) { 
				$Data=$Data.'<set value="'.array_sum($Datos[$Request->Usuarios[$i]]["Ganancias"]).'" name="'.$Request->Usuarios[$i].'" color="'.random_color().'" /> ';
			}
			$DataEnd='</graph>';
			$Pizza=$DataEmp.$Data.$DataEnd;



				$file = fopen(public_path()."/charts/data_pizza.xml", "w");

				fwrite($file, $Pizza . PHP_EOL);

				fclose($file);
				return view("agency.pizzachart.pizza");
    }

    public function grafico(Request $Request){
    	$Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  // $Datos["Custo"] = DB::table("CAO_SALARIO")->whereIn("co_usuario", $Request->Usuarios)->get();

    	  $Fact= CoFatura::join('CAO_OS', 'CAO_FATURA.CO_OS', '=', 'CAO_OS.CO_OS')
    	  					->join('CAO_USUARIO', 'CAO_OS.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
    	  					->join('CAO_SALARIO', 'CAO_SALARIO.CO_USUARIO', '=', 'CAO_USUARIO.CO_USUARIO')
				     ->where([
							    ['DATA_EMISSAO', '>=', $Request->FechaInicio],
							    ['DATA_EMISSAO', '<=', $Request->FechaFin],
							])
				     ->whereIn('CAO_USUARIO.CO_USUARIO', $Request->Usuarios)
				     ->orderBy("DATA_EMISSAO", "ASC")
						    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
						    ->get();

			$Fact = json_decode(json_encode($Fact), true);

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					for ($k=0; $k <count($Fact) ; $k++) { 
						if (date("Y-m", strtotime($FechaMedia[$j]))==date("Y-m", strtotime($Fact[$k]["data_emissao"])) && $Fact[$k]["co_usuario"]==$Request->Usuarios[$i]) {
							if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])) {
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]+($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100));
							} else{
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100);
							}	
						} 
					}
				}
			}	

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))])) {
					} else{
						$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
						$Datos[$Request->Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$j]))]=0;
					}
				}
			}

			function random_color_part() {
			    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			}
			function random_color() {
			    return random_color_part() . random_color_part() . random_color_part();
			}


			$DataEmpEmp='<graph bgColor="F1f1f1" caption="Performance Comercial" subCaption="Janeiro de 2007 a Maio de 2007" showValues="0" divLineDecimalPrecision="2" formatNumberScale="2" limitsDecimalPrecision="2" PYAxisName="" SYAxisName="" decimalSeparator="," thousandSeparator="." SYAxisMaxValue="32000" PYAxisMaxValue="32000">';
			$labels='';

			for ($i=0; $i <count($FechaMedia); $i++) {
				$labels=$labels.'<category name="'.$FechaMedia[$i].'" hoverText="'.$FechaMedia[$i].'" />';
			}
			$labels="<categories>".$labels."</categories>";


			for ($i=0; $i <count($Request->Usuarios); $i++) {
				$Data[$i]='';
				for ($j=0; $j <count($FechaMedia); $j++) {
					if ($j==0) {
						$DataEmp='<dataset seriesName="'.$Request->Usuarios[$i].'" color="#'.random_color().'" numberPrefix="R$ ">';
					}
					$Data[$i]=$Data[$i].'<set value="'.$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))].'" />';
					if ($j==count($FechaMedia)-1) {
						$Data[$i]=$DataEmp.$Data[$i].'</dataset>';
					}
				}
			}


			$Dataset="";
			for ($i=0; $i <count($Data); $i++) {
				$Dataset=$Dataset.$Data[$i];
			}

			$Salario=DB::table("CAO_SALARIO")->select("brut_salario")
									->whereIn('CO_USUARIO', $Request->Usuarios)->get();
			$Salario = json_decode(json_encode($Salario), true);
			$Sal=0;
			for ($i=0; $i <count($Salario) ; $i++) { 
				$Sal=$Sal+$Salario[$i]["brut_salario"];
			}
			if ($Salario!=0) {
				 $Sal= $Sal/count($Request->Usuarios);
			} else{
				 $Sal= 0;
			}

			$CostoFijo='';
			for ($i=0; $i <count($FechaMedia); $i++) { 
				$CostoFijo=$CostoFijo.'<set value="'.$Sal.'" /> ';
			}
			$CostoFijo='<dataset lineThickness="3" seriesName="Custo Fixo Médio" numberPrefix="R$ " parentYAxis="S" color="FF0000" anchorBorderColor="FF8000">'.$CostoFijo."</dataset>";

			$Grafico=$DataEmpEmp.$labels.$Dataset.$CostoFijo."</graph>";
			$file = fopen(public_path()."/charts/data_line_bar.xml", "w");

			fwrite($file, $Grafico . PHP_EOL);
			fclose($file);

			return view("agency.barchart.barchart");


				
    }
}
