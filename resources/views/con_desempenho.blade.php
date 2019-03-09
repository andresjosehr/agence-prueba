<!DOCTYPE html>
<html>
<head>
	<title>Agency</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/custom.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
</head>
<body>

	<style>
		.outer {
		  display: table;
		  position: absolute;
		  top: 0;
		  left: 0;
		  height: 100%;
		  width: 100%;
		}

		.middle {
		  display: table-cell;
		  vertical-align: middle;
		}

		.inner {
		  margin-left: auto;
		  margin-right: auto;
		  width: 100%;
		  /*whatever width you want*/
		}
	</style>

    <div class="jumbotron home_jumbotron">
	   <div class="row cont">
		  <div class="col-md-2 ghost-col">
		    <div class="row">
		      <div class="col-md-12 percont">
		        Periodo
		      </div>
		      <div class="col-md-12 conscont" style="height: 248px">
		      	<div class="outer">
				  <div class="middle">
				    <div class="inner" align="center">
		        		Consultores
		        	</div>
		          </div>
		    	</div>
		      </div>
		    </div>
		  </div>
		  <div class="col-md-8 ghost-col ghostcont">
		    <div class="row">
		      <div class="col-md-12 fechcont">
		      	<div class="col-md-3">
		      		<div class="outer" style="height: 37px">
							  <div class="middle">
							    <div class="inner">
								    <div class="input-group date">
										  <input type="text" class="form-control" id="FechaInicio" placeholder="Inicio">
										  <div class="input-group-addon">
										    <span class="glyphicon glyphicon-th"></span>
										  </div>
										</div>
									</div>
								</div>
							</div>
		      	</div>
		      	<div class="col-md-3">
		      		<div class="outer" style="height: 37px">
							  <div class="middle">
							    <div class="inner">
								    <div class="input-group date">
										  <input type="text" class="form-control" id="FechaFin" placeholder="Fin">
										  <div class="input-group-addon">
										    <span class="glyphicon glyphicon-th"></span>
										  </div>
										</div>
									</div>
								</div>
							</div>
		      	</div>
		      </div>
		      <div class="col-md-12" style="text-align: -webkit-center;height: 248px;">
		      	<div class="outer">
						  <div class="middle">
						    <div class="inner">
				        <select multiple="multiple" id="my-select" name="my-select[]">
				        	@foreach($Consultores as $Consultor)
						      <option value='{{$Consultor->co_usuario}}'>{{$Consultor->no_usuario}}</option>
						    @endforeach
					    </select>
					</div>
				  </div>
				</div>
			      </div>
		    </div>
		  </div>
		  <div class="col-md-2" align="center">
		    <div class="outer">
					<div class="middle">
					  <div class="inner">
					  	<div style="max-width: 100px">
				    <button onclick="relatorio('<?php echo Request::root(); ?>/relatorio')" class="btn btn-primary btn-block">Relatório</button><br>
				    <button onclick="relatorio('<?php echo Request::root(); ?>/pizza')" class="btn btn-secondary btn-block">Grafico</button><br>
						<button class="btn btn-success btn-block">Pizza</button>
						</div>
				  </div>
				</div>
		  </div>
	   </div>
    </div>


    <div id="contenedor"></div>
    <div style="height: 100px;width: 100%;text-align: -webkit-center; margin-top: 50px;" class="content_chart"> 
    	<div style="height: 100px;width: 100px;">
    		<canvas id="myChart" width="100px" height="100px"></canvas>
    	</div>
    </div>


<script>
var ctx = document.getElementById("myChart").getContext('2d');

function dynamicColors() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };
function Pizza(Usuarios, Ganancias, Num) {

         var dynamicColorss = [];

         for (var i =0 ; i < Num; i++) {
         	dynamicColorss[i]=dynamicColors();
         }

	var oilCanvas = document.getElementById("myChart");

	Chart.defaults.global.defaultFontFamily = "Lato";
	Chart.defaults.global.defaultFontSize = 18;

	var oilData = {
	    labels: Usuarios,
	    datasets: [
	        {
	            data: Ganancias,
	            backgroundColor: dynamicColorss
	            
	        }]
	};

	var pieChart = new Chart(oilCanvas, {
	  type: 'pie',
	  data: oilData,
	  showDatapoints: true,
		  options: {
		  	maintainAspectRatio: false,
		  	legend: {
            display: false
         },
         tooltips: {
            enabled: true
         }
     }
	});


}


</script>

<script>
	function relatorio(url) {

		$.ajaxSetup({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
			var year  = document.getElementById('FechaFin').value.split("-")[1];
			var month = document.getElementById('FechaFin').value.split("-")[0];
			var yeari  = document.getElementById('FechaInicio').value.split("-")[1];
			var monthi = document.getElementById('FechaInicio').value.split("-")[0];
			lastday = new Date(year, month, 0);
			var date1=new Date(yeari, monthi, 1);//Remember, months are 0 based in JS
			var date2=new Date(year, month, lastday.getDate());
			var Diff=diff_months(date1, date2);
			var FechaMedio = [];

			if (Diff>=3) {
				for (var i = 1; i <=Diff-2 ; i++) {

					date1.setMonth(date1.getMonth()+1);
					if (date1.getMonth()<10) {
						var monthinter="0"+date1.getMonth()
					} else{
						var monthinter=date1.getMonth()
					}
					if (monthinter=="00") {
						monthinter=12;
						date1.setYear(date1.getFullYear()-1)
					}
					if (monthinter=="01") {
						date1.setYear(date1.getFullYear()+1)
					}
					FechaMedio[i]=date1.getFullYear()+"-"+monthinter;
				}

				if (i<6) {
					date1.setMonth(date1.getMonth()+1);
						if (date1.getMonth()<10) {
							var monthinter="0"+date1.getMonth()
						} else{
							var monthinter=date1.getMonth()
						}
					if (monthinter=="00") {
							monthinter=12;
							date1.setYear(date1.getFullYear()-1)
						}
						if (monthinter=="01") {
							date1.setYear(date1.getFullYear()+1)
					}
					FechaMedio[i]=date1.getFullYear()+"-"+monthinter;
				}

				FechaMedio[0]=yeari+"-"+monthi;
			} else{
				if (Diff>=2) {
					FechaMedio[0]=yeari+"-"+monthi;
					FechaMedio[1]=year+"-"+month;
				} else{
					FechaMedio[0]=yeari+"-"+monthi;
				}
			}
			if (Diff>6) {
				Diff=Diff-1;
			}
			

		$("#contenedor").load(url,{
			Usuarios: $('select').val(),
			FechaInicio: "01-"+document.getElementById('FechaInicio').value,
			FechaFin: lastday.getDate()+"-"+document.getElementById('FechaFin').value,
			Diff: Diff,
			FechaMedio: FechaMedio

		})
	}
	function diff_months(dt2, dt1) {
			  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
			   diff /= (60 * 60 * 24 * 7 * 4);
			  return Math.abs(Math.round(diff)); 
	}
	window.onload= function () {
		$('#my-select').multiSelect()

		$('.date').datepicker({
		    format: "mm-yyyy",
		    startView: "years", 
		    minViewMode: "months",
		    defaultDate : '01-2005',
		});

		$('.date2').datepicker({
		    format: "mm-yyyy",
		    startView: "years", 
		    minViewMode: "months",
		    defaultDate : '01-2005',
		});
	}
</script>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
</body>
</html>