$(function () {
    vista = {
        init: function () {      
            vista.events();
            // vista.getGraficAsignadas();
            // vista.getGraficEnviadas();
            // vista.getGraficCanceladas();
            // vista.getGraficEjecutadas();
            console.log(baseurl);
            vista.getGrafics();
        },

        getGrafics: function () {
            var paramMeses = vista.getArregloMeses();//["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"];
            var paramAsignadas = [120,139,150,211,116,125,120];
            var paramEnviadas = [85,79,100,101,76,75,60];
            var paramCanceladas = [25,39,50,51,26,25,10];
            var paramEjecutadas = [65,59,80,81,56,55,40];

            var ctx = $("#myChart");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: paramMeses,//horizontal
                    datasets: [
                        {
                            //asignadas
                            label: 'Asignadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(125, 125, 125, 0.2)",
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
                            data: paramAsignadas,//vertical
                            spanGaps: false,
                        },
                        {
                            //enviadas
                            label: 'Enviadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 0, 255, 0.2)",
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
                            data: paramEnviadas,//vertical
                            spanGaps: false,
                        },
                        {
                            //canceladas
                            label: 'Canceladas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 0, 0, 0.2)",
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
                            data: paramCanceladas,//vertical
                            spanGaps: false,
                        },{
                            //ejecutadas
                            label: 'Ejecutadas',
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(0, 255, 0, 0.2)",
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
                            data: paramEjecutadas,//vertical
                            spanGaps: false,
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });


            
        },

        /**
         * Este metodo sirve para tal cosa...
         * @param {boolean} var1
         * @example {name: "", x: ""}
         * @returns {undefined}
         */
        getArregloMeses: function (var1) {
            $.post(baseurl + "/Service/getMonthsWorked",
               function(data){
                var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                mesesTrabajados = [];
                     
                var obj = JSON.parse(data);
                for (var i = 0; i < obj.length; i++) {
                    var indice = obj[i].meses.substr(4);
                      console.log(indice);
                    console.log(meses[01]);
//                    console.log(obj[i].meses.substr(4));
                }

                

               });
        },

        
        //Eventos de la ventana.
        events: function () {
            //
            
        }
              
    };

    vista.init();
});