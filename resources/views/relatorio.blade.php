


@for ($i = 0; $i <count($Datos); $i++)
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Periodo</th>
	      <th scope="col">Receita Líquida</th>
	      <th scope="col">Custo Fixo</th>
	      <th scope="col">Comissão</th>
	      <th scope="col">Lucro</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@for ($k = 0; $k <count($FechaMedia); $k++)

	  	<?php
	  		if ($Datos[$Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$k]))]==0) {
	  			$Costo=0;
	  		} else{
	  			$Costo=$Datos[$Usuarios[$i]]["CostoFijo"];

	  			$SaldoCosto[$k]=$Datos[$Usuarios[$i]]["CostoFijo"];
	  		}
	  		if (!isset($SaldoCosto)) {
	  			$SaldoCosto[$k]=0;
	  		}
	  	?>
	  		<tr>
		      <th>{{$FechaMedia[$k]}}</th>
		      <td>R$ {{$Datos[$Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$k]))]  }} </td>
		      <td>- R$ {{$Costo}}</td>
		      <td>- R$ {{$Datos[$Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$k]))]  }}</td>
		      <td>R$ {{$Datos[$Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$k]))]  }}</td>
		    </tr>
	  	@endfor
	  	<tr>
	      <th scope="row">SALDO</th>
	      <td><?php echo array_sum($Datos[$Usuarios[$i]]["Ganancias"]) ?></td>
	      <td>- R$<?php echo array_sum($SaldoCosto) ?></td>
	      <td>- R$<?php echo array_sum($Datos[$Usuarios[$i]]["Comision"]) ?></td>
	      <td><?php echo array_sum($Datos[$Usuarios[$i]]["Lucro"]) ?></td>
	    </tr>
	  </tbody>
	</table>
	<br><br>
	@php
		unset($SaldoCosto)
	@endphp
@endfor