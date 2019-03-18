<?php sort($Usuarios); ?>

@for ($i = 0; $i <count($Datos); $i++)
<div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>{{$No_User[$i]["no_usuario"]}}</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div class="table-responsive">
                          <div id="elim<?php echo $i; ?>"></div>
                          <table class="table table-striped jambo_table bulk_action">
                            <thead>
                              <tr class="headings">
                                <th class="column-title">Per&iacute;odo          </th>
                                <th class="column-title">Receita L&iacute;quida</th>
                                <th class="column-title">Custo Fixo            </th>
                                <th class="column-title">Comiss&atilde;o         </th>
                                <th class="column-title">Lucro                   </th>
                              </tr>
                            </thead>

                            <tbody>
                              @for ($k = 0; $k <count($FechaMedia); $k++)
                                <?php
                                  if (isset($Datos[$Usuarios[$i]]["CostoFijo"])) {
                                    $SaldoCosto[$k]=$Datos[$Usuarios[$i]]["CostoFijo"];
                                    $Costo=$Datos[$Usuarios[$i]]["CostoFijo"];

                                  } else{
                                     $SaldoCosto[$k]=0;
                                     $Costo=0;
                                  }
                                ?>
                              <tr class="even pointer">>
                                <td class="">{{$FechaMedia[$k]}}</td></td>
                                <td class="">R$ {{$Datos[$Usuarios[$i]]["Ganancias"][date("Y-m", strtotime($FechaMedia[$k]))]  }} </td>
                                <td class="">- R$ {{$Costo}}                                                                        </td>
                                <td class="">- R$ {{$Datos[$Usuarios[$i]]["Comision"][date("Y-m", strtotime($FechaMedia[$k]))]  }}</td>
                                <td class="">R$ {{$Datos[$Usuarios[$i]]["Lucro"][date("Y-m", strtotime($FechaMedia[$k]))]  }}     </td>
                              </tr>
                              @endfor
                            </tbody>
                            <thead>
                              <tr class="headings">
                                <th class="column-title">Saldo</th>
                                <th class="column-title">R$ <?php  echo array_sum($Datos[$Usuarios[$i]]["Ganancias"]) ?> </th>
                                <th class="column-title">R$ <?php echo array_sum($SaldoCosto) ?>                          </th>
                                <th class="column-title">R$ <?php echo array_sum($Datos[$Usuarios[$i]]["Comision"]) ?>     </th>
                                <th class="column-title">R$ <?php  echo array_sum($Datos[$Usuarios[$i]]["Lucro"]) ?>       </th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                  
                
                      </div>
                    </div>
                  </div>
              </div>

            <br><br>
            <script>
              $.trim($($('#elim<?php echo $i; ?>')[0].nextSibling).remove())
            </script>
              @php
                unset($SaldoCosto)
              @endphp
            @endfor
            <script>
              OcultarLoaders("1");
            </script>
