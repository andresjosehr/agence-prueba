      window.relatorio=function (url) {
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

                    function getRandomRgb() {
                      var num = Math.round(0xffffff * Math.random());
                      var r = num >> 16;
                      var g = num >> 8 & 255;
                      var b = num & 255;
                      return 'rgba(' + r + ', ' + g + ', ' + b + ', .5)';
                    }

                  function InizializarBarChar() {
                  var Datase=[];
                  for (var i = 0; i <= size; i++) {
                    var e=0; var k=0; var valores=[]; 
                     $.each( Datos, function( usr, tipo ) {
                      $.each( tipo, function( este, valor ) {
                        valores[k] = new Array();
                        e=0;
                        $.each( valor, function( h1, h2 ) {
                            valores[k][e]=h2;
                            e++;
                          });
                          k++;
                        });
                      });
                    Datase[i] ={
                                  label: Usuarios[i],
                                  data: valores[i],
                                  backgroundColor: getRandomRgb(),

                              }
                    }
                    BarChart(FechaMedia, Datase)
                  }
