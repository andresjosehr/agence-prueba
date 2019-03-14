@for ($i = 0; $i <count($Datos); $i++)
  <table class="cust_tat" cellspacing=1 cellpadding=3 width="100%" 
                  bgcolor=#cccccc  id="pesquisaAvancada">
                <tbody>
                  <tr bgcolor=#efefef>
                    <td colspan=5><span class="style3">{{$No_User[$i]["no_usuario"]}}</span> </td>
                  </tr>
                  <tr bgcolor=#fafafa>
                    <td nowrap><div align="center"><strong>Per&iacute;odo</strong></div></td>
                    <td><div align="center"><strong>Receita L&iacute;quida </strong></div></td>
                    <td><div align="center"><strong>Custo Fixo </strong></div></td>
                    <td><div align="center"><strong>Comiss&atilde;o</strong></div></td>
                    <td><div align="center"><strong>Lucro</strong></div></td>
                  </tr>
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
                  <tr bgcolor=#fafafa>
                    <td nowrap>{{$FechaMedia[$k]}}</td>
                    <td><div align="right">R$ {{$Datos[$Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$k]))]  }} </div></td>
                    <td><div align="right">- R$ {{$Costo}}</td></div></td>
                    <td><div align="right">- R$ {{$Datos[$Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$k]))]  }}</div></td>
                    <td><div align="right">R$ {{$Datos[$Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$k]))]  }}     </div></td>
                  </tr>
                  @endfor
                  <tr bgcolor=#efefef>
                    <td nowrap bgcolor="#efefef"><strong>SALDO</strong></td>
                    <td><div align="right"><font color="#000000">R$ <?php  echo array_sum($Datos[$Usuarios[$i]]["Ganancias"]) ?>   </font></div></td>
                    <td><div align="right"><font color="#000000">R$ <?php echo array_sum($SaldoCosto) ?>                      </font></div></td>
                    <td><div align="right"><font color="#000000">R$ <?php echo array_sum($Datos[$Usuarios[$i]]["Comision"]) ?></font></div></td>
                    <td><div align="right"><font color="#0000FF">R$ <?php  echo array_sum($Datos[$Usuarios[$i]]["Lucro"]) ?>       </font></div></td>
                  </tr>
                </tbody>
              </table>
  <br><br>
  @php
    unset($SaldoCosto)
  @endphp
@endfor

