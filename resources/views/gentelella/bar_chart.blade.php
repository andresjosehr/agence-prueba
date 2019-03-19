
<div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2></h2>
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
                      <div class="x_content x_content_bar">
                        <canvas id="bar_chart" width="400" height="50"></canvas>
                      </div>
                   </div>
                 </div>
                </div>
                <script>

                    var Datica_=[{
                                            label: "Custo Fixo Médio",
                                              type:'line',
                                              data: [@for ($i = 1; $i <count($FechaMedia)+1 ; $i++) CostoFijoPromedio, @endfor],
                                              borderColor: '#EC932F',
                                              backgroundColor: 'transparent'
                                      },@for ($i = 1; $i <count($Usuarios)+1 ; $i++) valores['{{$i-1}}'], @endfor];
                    BarChart(FechaMedia, Datica_);
                    OcultarLoaders("2");
                  </script>
            <br><br>
