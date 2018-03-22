$(function () {
    mostrar = {
        init: function () {
            mostrar.events();
        },

        //Eventos de la ventana.
        events: function () {
            //Llamamos las actividades proximas a entregar
            mostrar.getActividadesAEntregar()
            

        },
        // Traigo todas las actividades que deben entregar con prioridad
        getActividadesAEntregar: function() {
            $.post(baseurl + "/SpecialServices/getProximas",
                function (data) {
                    var obj = JSON.parse(data);
                    // Pintar los contadores de los botones
                    $('#proximosBadge').html(obj.proximas.length);
                    $('#hoyBadge').html(obj.hoy.length);
                    $('#expiradosBadge').html(obj.vencidas.length);

                    //al darle clic al boton proximas y envimos solo las actividades proximas
                    $('#proximos').on('click', function(){
                        mostrar.onClickVerActividadProxima(obj.proximas);
                    });
                    //al darle clic al boton hoy y envimos solo las actividades para entregar hoy
                    $('#hoy').on('click', function(){
                        mostrar.onClickVerActividadHoy(obj.hoy);
                    });

                    //al darle clic al boton hoy y envimos solo las actividades para entregar hoy
                    $('#expirados').on('click', function(){
                        mostrar.onClickVerActividadVencida(obj.vencidas);
                    });


                }
            );
        },

        //Mostrar modal y lo lleno con p¿act proximas
        onClickVerActividadProxima: function(obj){
            $('#ModalEventosProximos').modal('show');
            $('#titleEvent').html('Detalle total de actividades <b>Proximas a entregar</b> evidencias');
            mostrar.printTableEvents(obj);
        },

        //MOstrar modal y lleno co actividades para entregar hoy
        onClickVerActividadHoy: function(obj){
            $('#ModalEventosProximos').modal('show');
            $('#titleEvent').html('Detalle total de actividades con evidencia para <b>Hoy</b>');
            mostrar.printTableEvents(obj);

        },

        //Mostrar modal y lleno co actividades para entregar vencidas
        onClickVerActividadVencida: function(obj){
            $('#ModalEventosProximos').modal('show');
            $('#titleEvent').html('Detalle total de actividades envio de evidencia <b>Vencidas</b>');
            mostrar.printTableEvents(obj);
        },


        //pintamos la tabla de eventos especiales
        printTableEvents: function(data){
            // limpio el cache si ya habia pintado otra tabla
            if(mostrar.tableModalEvents){
                //si ya estaba inicializada la tabla la destruyo
                mostrar.tableModalEvents.destroy();
            }
            ///lleno la tabla con los valores enviados
            mostrar.tableModalEvents = $('#tableEventosPrioritarios').DataTable(mostrar.configTable(data,[
                    {title: "Orden", data: "orden"},
                    {title: "ID", data: "id"},
                    {title: "Tipo", data: "tipo"},
                    {title: "Cant", data: "cantidad"},
                    {title: "Ingeniero", data: "ingeniero"},
                    {title: "Proyecto", data: "proyecto"},
                    {title: "Solicitante", data: "solicitante"},
                    {title: "Asignación", data: "asignacion"},
                    {title: "Primera Entrega", data: "fEnvio1"},
                    {title: "  ", data: mostrar.getPrimeraEntrega},
                    {title: "Segunda Entrega", data: "fEnvio2"},
                    {title: "  ", data: mostrar.getSegundaEntrega}
                    
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

        //Si el primer link (link1) viene llleno o nulo
        getPrimeraEntrega: function(obj){
            var check = ""; 
            if (obj.link1 == null || obj.link1 == "") {
                check += '<img src="'+baseurl+'/assets/img/empty.png" alt="sin enviar" width="25" title="Sin Enviar">';
            }
            else{
                check += '<img src="'+baseurl+'/assets/img/check.png" alt="evidencia Enviada" width="25" title="evidencia Enviada">';
            }
            return check;                
        },

        getSegundaEntrega: function(obj){
            var check = ""; 
            if (obj.link2 == null || obj.link2 == "") {
                check += '<img src="'+baseurl+'/assets/img/empty.png" alt="sin enviar" width="25" title="Sin Enviar">';
            }
            else{
                check += '<img src="'+baseurl+'/assets/img/check.png" alt="evidencia Enviada" width="25" title="evidencia Enviada">';
            }
            return check;            
        },





    };

    mostrar.init();
});