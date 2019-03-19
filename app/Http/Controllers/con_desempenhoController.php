<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoUsuario;
use App\CoFatura;
use App\User;
use DB;


class con_desempenhoController extends Controller{
    public function index(){


		$Consultores= CoUsuario::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
				     ->where([
							    ['permissao_sistema.co_sistema', '=', '1'],
							    ['permissao_sistema.in_ativo', '=', 'S'],
							])
				     ->whereIn('permissao_sistema.co_tipo_usuario', array(0, 1, 2))
				     ->orderBy("no_usuario", "ASC")
						    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
						    ->get();

						    return view("gentelella.panel_de_control", ["Consultores" => $Consultores]);
    }











    //********************************************************************//
    //Funcion en la que se recogen los valores del bonton RELATORIO       //
    //********************************************************************//

    public function relatorio(Request $Request)
    {	
    	  $Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  $Fact= CoFatura::join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
    	  					->join('cao_usuario', 'cao_os.co_usuario', '=', 'cao_usuario.co_usuario')
    	  					->join('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
				     ->where([
							    ['data_emissao', '>=', $Request->FechaInicio],
							    ['data_emissao', '<=', $Request->FechaFin],
							])
				     ->whereIn('cao_usuario.co_usuario', $Request->Usuarios)
				     ->orderBy("data_emissao", "ASC")
						    ->getQuery() 
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

			return view("gentelella.relatorio", ["Datos" => $Datos, "FechaMedia" => $FechaMedia, "Usuarios" => $Request->Usuarios, "No_User" => json_decode(json_encode(User::select("no_usuario")->whereIn('co_usuario', $Request->Usuarios)->get()), true)]);

    }

    //********************************************************************//
    //Funcion en la que se recogen los valores del bonton Pizza           //
    //********************************************************************//

    public function Pizza(Request $Request){

    	 $Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  $Fact= CoFatura::join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
    	  					->join('cao_usuario', 'cao_os.co_usuario', '=', 'cao_usuario.co_usuario')
    	  					->join('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
				     ->where([
							    ['data_emissao', '>=', $Request->FechaInicio],
							    ['data_emissao', '<=', $Request->FechaFin],
							])
				     ->whereIn('cao_usuario.co_usuario', $Request->Usuarios)
				     ->orderBy("data_emissao", "ASC")
						    ->getQuery() 
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

			
			for ($i=0; $i <count($Request->Usuarios); $i++) { 
				$Data[$i]=array_sum($Datos[$Request->Usuarios[$i]]["Ganancias"]);
				$Color[$i]="#".self::random_color();
			}
			$Usuarios = User::select("no_usuario")->whereIn('co_usuario', $Request->Usuarios)->get();
			for ($i=0; $i <count($Usuarios) ; $i++) { 
				$Usr[$i]=$Usuarios[$i]->no_usuario;
			}
			?><script>
	         	var Data = '<?php echo json_encode($Data) ?>'
	         	var Color = '<?php echo json_encode($Color) ?>'
	         	var Usuarios = '<?php echo json_encode($Usr) ?>'
	         	PrincipioPie();
			</script><?php
				return view("gentelella.pie_chart");
    }


    //********************************************************************//
    //Funcion en la que se recogen los valores del bonton Grafico         //
    //********************************************************************//

    public function grafico(Request $Request){
    	$Request->FechaInicio = date("Y-m-d", strtotime($Request->FechaInicio));
		  $Request->FechaFin = date("Y-m-d", strtotime($Request->FechaFin));

		  $l=0;
		  for($i=$Request->FechaInicio;$i<=$Request->FechaFin;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
			  $FechaMedia[$l]=$i;
			  $l++;
			}

    	  

    	  $Fact= CoFatura::join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
    	  					->join('cao_usuario', 'cao_os.co_usuario', '=', 'cao_usuario.co_usuario')
    	  					->join('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
				     ->where([
							    ['data_emissao', '>=', $Request->FechaInicio],
							    ['data_emissao', '<=', $Request->FechaFin],
							])
				     ->whereIn('cao_usuario.co_usuario', $Request->Usuarios)
				     ->orderBy("data_emissao", "ASC")
						    ->getQuery() 
						    ->get();

			$Fact = json_decode(json_encode($Fact), true);

			for ($i=0; $i <count($Request->Usuarios); $i++) {
				for ($j=0; $j <count($FechaMedia); $j++) {
					for ($k=0; $k <count($Fact) ; $k++) { 
						if (date("Y-m", strtotime($FechaMedia[$j]))==date("Y-m", strtotime($Fact[$k]["data_emissao"])) && $Fact[$k]["co_usuario"]==$Request->Usuarios[$i]) {
							if (isset($Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))])) {
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]+($Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100));
								$CostoFijoBarra[$i]=$Fact[$k]["brut_salario"];
							} else{
								$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($Fact[$k]["data_emissao"]))]=$Fact[$k]["valor"]-(($Fact[$k]["valor"]*$Fact[$k]["total_imp_inc"])/100);
								$CostoFijoBarra[$i]=$Fact[$k]["brut_salario"];
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
					}
					$Valores[$i][$j]=$Datos[$Request->Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$j]))];
				}


			}



			$Usuarios = User::select("no_usuario")->whereIn('co_usuario', $Request->Usuarios)->get();
			for ($i=0; $i <count($Usuarios) ; $i++) { 
				$Usr[$i]=$Usuarios[$i]->no_usuario;
			}
			$CostoFijoPromedio = array_sum($CostoFijoBarra)/count($Request->Usuarios);
			?><script>
						
				var valorcito ='<?php echo json_encode($Valores); ?>';
				valorcito=JSON.parse(valorcito);
	         	var FechaMedia = '<?php echo json_encode($FechaMedia); ?>';
	         	var Datos = '<?php echo json_encode($Datos); ?>';
	         	var Usuarios = '<?php echo json_encode($Usr) ?>'
	         	var CostoFijoPromedio = '<?php echo $CostoFijoPromedio ?>'
	         	PrincipioBar();
				var size = Object.size(Datos);
				var valores=InizializarBarChar();

			</script><?php
			return view("gentelella.bar_chart",["Usuarios" => $Request->Usuarios, "FechaMedia" => $FechaMedia]);

    }


    public function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			}
	public function random_color() {
	    return self::random_color_part() . self::random_color_part() . self::random_color_part();
	}

}
