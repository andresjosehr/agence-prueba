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
