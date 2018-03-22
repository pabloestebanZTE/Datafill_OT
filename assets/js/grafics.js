$(function () {
    vista = {
        init: function () {
            vista.events();
            vista.getGrafics();
        },

        getGrafics: function () {
            vista.getParams();
        },

        printGrafics: function (params) {
            var ctx = $("#graficsTotal");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: params.meses, //horizontal
                    datasets: [
                        {
                            //asignadas
                            label: 'Asignadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(125, 125, 125, 0.4)",
                            borderColor: "rgba(125, 125, 125, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(125, 125, 125, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(125, 125, 125, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: params.asignadas, //vertical
                            // type: 'line',
                            spanGaps: false,
                            borderWidth: 2,
                        },
                        {
                            //enviadas
                            label: 'Enviadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 0, 255, 0.4)",
                            borderColor: "rgba(0, 0, 255, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(0, 0, 255, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(0, 0, 255, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: params.enviadas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        },
                        {
                            //canceladas
                            label: 'Canceladas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 0, 0, 0.4)",
                            borderColor: "rgba(255, 0, 0, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(255, 0, 0, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(255, 0, 0, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: params.canceladas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        }, {
                            //ejecutadas
                            label: 'Ejecutadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 255, 0, 0.4)",
                            borderColor: "rgba(0, 255, 0, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(0, 255, 0, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(0, 255, 0, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: params.ejecutadas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        }
                    ]
                },
                options: {
                    onClick: vista.clickEventGrafics,
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        },

        // Eventos al darle click en algun punto de las graficas
         clickEventGrafics: function (evt, element){
            // Si no le da click a un espacio de la grafica sin informacion
            if (element != "" ) {
                // Recibe el label de la barra a la que le de clic               
                var param = element[0]._model.label;
                // Si le da clicl a alguna barra de la primera grafica (mes)
                if (param == 'Enero' || param == 'Febrero' || param == 'Marzo' || param == 'Abril' || param == 'Mayo' || param == 'Junio' || param == 'Julio' || param == 'Agosto' || param == 'Septiembre' || param == 'Octubre' || param == 'Noviembre' || param == 'Diciembre') {
                    mesM = param;
                    // funcion para llenar los datos para las gradicas del modal
                    vista.getParamsModal(param);     
                }
                // click en label de tipo para traer detalle de las actividades
                if (param == 'C1' || param == 'C2' || param == 'C3' || param == 'T1' || param == 'T2' || param == 'T3' || param == 'T4' || param == 'T5' || param == 'T6') {
                    vista.getParamsActivities(param,mesM);
                }
            }
        },
        // Trae los datos de las actividades por tipo y por mes
        getParamsActivities: function(tipo, mes){
            $.post(baseurl + "/Grafics/getActivitiesDetails",
              {
                "mes": mes,
                "tipo": tipo
              },
                function (data) {
                    var obj = JSON.parse(data);
                    vista.showModalTable(obj, mes, tipo);
                }
            );

        },
        // mostrar modal de la tabla detalle
        showModalTable: function(obj, mes, tipo){
            $('#tablaModal').modal('show');
            $('#titleType').html('Detalle total de actividades <b>'+tipo+'</b> del mes de <b>'+mes+'</b>');
            vista.printTableModal(obj);
        },

        printTableModal: function(data){
            // console.log(data);
            if(vista.tableModal){
                var tabla = vista.tableModal;
                tabla.clear().draw();
                tabla.rows.add(data);
                tabla.columns.adjust().draw();
                return;
            }
            
            vista.tableModal = $('#tableDetail').DataTable(vista.configTable(data,[
                    {title: "Tipo", data: "tipo"},
                    {title: "Orden", data: "orden"},
                    {title: "Id", data: "id"},
                    {title: "Cant", data: "cant"},
                    {title: "Proyecto", data: "proyecto"},
                    {title: "Solicitante", data: "ingeSol"},
                    {title: "F_Asignación", data: "f_asignacion"},
                    {title: "F_Ejecución", data: "f_ejecucion"},
                    {title: "Ingeniero", data: "ingeniero"},
                    {title: "Estado", data: "estado"}
                    
                ]));
        },
         // Datos de configuracion del datatable
        configTable: function (data, columns, onDraw) {
            return {
              data: data,
              columns: columns,
              "language": {
                  "url": baseurl + "/assets/plugins/datatables/lang/es.json"
              },
              columnDefs: [{
                      defaultContent: "",
                      // targets: -1,
                      orderable: false,
                  }],
              order: [[0, 'asc']],
              drawCallback: onDraw
            }
        },

         // funcion para llenar los datos para las gradicas del modal
        getParamsModal: function(mes){
            $.post(baseurl + "/Grafics/getParamsMonth",
              {
                "mes": mes
              },
                function (data) {
                    var obj = JSON.parse(data);
                    vista.showModal(obj, mes);
                }
            );

        },

        //mostrar modal
        showModal: function (parametros, mes){
            $('#graficsModal').modal('show');
            $('#titleMonth').html('Graficas del mes de <b>'+mes+' </b>');
            // console.log(mes);
            $('#contentModalGrafics').html('<canvas id="modalGrafics" width="400" height="150"></canvas>');
            var ctx = $("#modalGrafics");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["C1","C2","C3","T1","T2","T3","T4","T5","T6"]/*parametros.tipo*/, //horizontal
                    datasets: [
                        {
                            //asignadas
                            label: 'Asignadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(125, 125, 125, 0.4)",
                            borderColor: "rgba(125, 125, 125, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(125, 125, 125, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(125, 125, 125, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: parametros.asignadas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        },
                        {
                            //enviadas
                            label: 'Enviadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 0, 255, 0.4)",
                            borderColor: "rgba(0, 0, 255, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(0, 0, 255, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(0, 0, 255, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: parametros.enviadas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        },
                        {
                            //canceladas
                            label: 'Canceladas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 0, 0, 0.4)",
                            borderColor: "rgba(255, 0, 0, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(255, 0, 0, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(255, 0, 0, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: parametros.canceladas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        }, 
                        {
                            //ejecutadas
                            label: 'Ejecutadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 255, 0, 0.4)",
                            borderColor: "rgba(0, 255, 0, 1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(0, 255, 0, 1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 8,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(0, 255, 0, 1)",
                            pointHoverBorderColor: "rgba(220, 220, 220, 1)",
                            pointHoverBorderWidth: 5,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: parametros.ejecutadas, //vertical
                            spanGaps: false,
                            borderWidth: 2,
                        }
                    ]
                },
                options: {
                    onClick: vista.clickEventGrafics,
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });

        },

        getParams: function () {
            $.post(baseurl + "/Grafics/getParams",
                    function (data) {
                        var obj = JSON.parse(data);
                        vista.printGrafics(obj);
                    }
            );
        },


        //Eventos de la ventana.
        events: function () {
            //

        }

    };

    vista.init();
});