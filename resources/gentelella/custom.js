      function relatorio(url) {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
            var FechaInicio  = document.getElementById("YearI").value+"-"+document.getElementById("MonthI").value;
            var FechaFin  = document.getElementById("YearF").value+"-"+document.getElementById("MonthF").value;
            
            var User=$("#list2 option").map(function() {return $(this).val();}).get()

              if (User=="") {
                alert("Debes seleccionar un consultor");
              } else{
                if (FechaInicio>FechaFin) {
                  alert("La fecha de inicio debe ser menor que la fecha final")
                } else{
                   $("#contenedor").load(url,{
                    Usuarios: $("#list2 option").map(function() {return $(this).val();}).get(),
                    FechaInicio: FechaInicio,
                    FechaFin: FechaFin
                  })
                }

              }
        }

                    window.getRandomRgb=function() {
                      var num = Math.round(0xffffff * Math.random());
                      var r = num >> 16;
                      var g = num >> 8 & 255;
                      var b = num & 255;
                      return 'rgba(' + r + ', ' + g + ', ' + b + ', .5)';
                    }
                  var Datase=[];
                  window.InizializarBarChar=function() {
                  for (var i = 0; i <= size; i++) {
                    Datase[i] ={
                                  label: Usuarios[i],
                                  data: valorcito[i],
                                  backgroundColor: getRandomRgb(),

                              }
                    }
                    return Datase;
                  }


                  window.BarChart=function(Fecha, Datica) {
                    var ctx = document.getElementById('bar_chart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Fecha,
                            datasets: Datica
                        },
                        options: {
                            tooltips: {
                              display: true
                            }
                        }
                    });
                  }

                  window.PrincipioBar=function() {
                    FechaMedia=JSON.parse(FechaMedia);
                    Datos=JSON.parse(Datos);
                    Usuarios=JSON.parse(Usuarios);
                  }

                  Object.size = function(obj) {
            var size = 0, key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
        };

        window.PrincipioPie=function() {
          Usuarios=JSON.parse(Usuarios);
        Data=JSON.parse(Data);
        Color=JSON.parse(Color);
        }

                     window.getRandomRgb=function() {
                      var num = Math.round(0xffffff * Math.random());
                      var r = num >> 16;
                      var g = num >> 8 & 255;
                      var b = num & 255;
                      return 'rgba(' + r + ', ' + g + ', ' + b + ', 0.5)';
                    }
                    window.PieChart=function() {
                      new Chart(document.getElementById("pie_chart"), {
                                type: 'pie',
                                data: {
                                  labels: Dat["Usuarios"],
                                  datasets: [{
                                    label: "Population (millions)",
                                    backgroundColor: Color,
                                    data: Dat["Ganancias"]
                                  }]
                                },
                                options: {
                                
                                }
                            });
                    }


                        window.onload= function(){
                            $('#date1').datepicker({
                                autoclose: true,
                                minViewMode: 1,
                                format: 'yyyy-mm',
                            }).on('changeDate', function(selected){
                                    startDate = new Date(selected.date.valueOf());
                                    startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                                    $('.to').datepicker('setStartDate', startDate);
                                }); 

                            $('#date2').datepicker({
                                autoclose: true,
                                minViewMode: 1,
                                format: 'yyyy-mm',
                            }).on('changeDate', function(selected){
                                    FromEndDate = new Date(selected.date.valueOf());
                                    FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                                    $('.from').datepicker('setEndDate', FromEndDate);
                                });
                            $('#my-select').multiSelect()
                          }

                               window.relatorio=function (url, loader) {
                                    $.ajaxSetup({
                                      headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                      }
                                    });
                                      var FechaInicio  = document.getElementById("date1").value;
                                      var FechaFin  = document.getElementById("date2").value;
                                      var User = [];
                                      $.each($("#my-select option:selected"), function(){            
                                          User.push($(this).val());
                                      });
                                        if (User=="") {
                                          alert("Debes seleccionar un consultor");
                                        } else{
                                          if (FechaInicio>FechaFin) {
                                            alert("La fecha de inicio debe ser menor que la fecha final")
                                          } else{
                                             MostrarLoaders(loader);
                                             $("#contenedor").load(url,{
                                              Usuarios: User,
                                              FechaInicio: FechaInicio+"-01",
                                              FechaFin: FechaFin+"-28"
                                            })
                                          }

                                        }
                                  }

                                  window.MostrarLoaders=function(num) {
                                    $(".btn"+num ).fadeOut(250, function () {
                                      $(".load"+num).fadeIn(250);
                                    });
                                  }

                                  window.OcultarLoaders=function(num) {
                                    $(".load"+num ).fadeOut(250, function () {
                                      $(".btn"+num).fadeIn(250);
                                    });
                                  }