$(function () {
    vistaRF = {
        init: function () {
            vistaRF.events();
            vistaRF.getListRF();
        },

        getListRF: function(){           
            $.post(baseurl + "/RF/getListRF",
                function (data) {
                    var obj = JSON.parse(data);
                    vistaRF.printTableRF(obj);
                }
            );
        },

        //Eventos de la ventana.
        events: function () {
            $.post(baseurl + '/RF/getByStatusNewChange', function(data) {
                var obj = JSON.parse(data);
                // Contadores de los botones
                $('#nuevosBadge').html(obj.cantNews);
                $('#cambiosBadge').html(obj.cantChanges);
                //al darle clic al boton Nuevos, envio actividades nuevas
                $('#nuevos').on('click', function(){
                    vistaRF.onClickVerActividadNueva(obj.news);
                });

                //al darle clic al boton cambios, envio actividades con cambios y log de los id
                $('#cambios').on('click', function(){
                    vistaRF.onClickVerActividadCambio(obj.changes, obj.logChanges);
                });

                //al darle clic al boton historial de la tabla rf o tabla cambios
                $('#tableRF').on('click', 'a.ver-log', vistaRF.onClickVerLogTr);
                $('#tableEventosChanges').on('click', 'a.ver-log', vistaRF.onClickVerLogTrChanges);

                // control del scroll para las tablas anchas de rf
                $(".lg-cntr").mCustomScrollbar({
                    axis:"x",
                    theme:"rounded-dark",
                    scrollInertia: 8,
                    advanced:{autoExpandHorizontalScroll:true},
                    scrollButtons:{
                            enable:true,
                            scrollType:"stepped"
                        },
                });


            });
        
        },

        // mostrar modal eventos nuevos
         onClickVerActividadNueva: function(obj){
            $('#ModalEventosNuevos').modal('show');
            $('#titleEvent').html('Detalle total de actividades RF nuevas');
            vistaRF.printTableEvents(obj);             
         }, 

         // mostrar modal eventos con cambios y su log
         onClickVerActividadCambio: function(activities, log){
            $('#ModalEventosCambios').modal('show');
            $('#titleEventChanges').html('Detalle total de actividades RF con Cambios');
            vistaRF.printTableEventsChanges(activities);
            vistaRF.printTablelog(log);
         },

        //pintamos la tabla de eventos 
        printTableEvents: function(data){
            // limpio el cache si ya habia pintado otra tabla
            if(vistaRF.tableModalEvents){
                //si ya estaba inicializada la tabla la destruyo
                vistaRF.tableModalEvents.destroy();
            }
            ///lleno la tabla con los valores enviados
            vistaRF.tableModalEvents = $('#tableEventos').DataTable(vistaRF.configTable(data,[
                    {title: "ID",             data: vistaRF.getID},
                    {title: "Archivo",        data: vistaRF.getFile,           visible: false},
                    {title: "Observaciones",  data: vistaRF.getObservations,   visible: false},
                    {title: "Peso Orden",     data: vistaRF.getOrderW,         visible: false},
                    {title: "F Revisión",     data: vistaRF.getDateRewiew,     visible: false},
                    {title: "F Crudo",        data: vistaRF.getDateRaw,        visible: false},
                    {title: "F OTGDRT",       data: vistaRF.getDateOTGDRT,     visible: false},
                    {title: "ID BSS",         data: vistaRF.getIDBSS,          visible: false},                   
                    {title: "Tipo",           data: vistaRF.getType,           visible: false},
                    {title: "Elemento",       data: vistaRF.getElement},
                    {title: "Remedy",         data: vistaRF.getRemedy},
                    {title: "F Solicitada",   data: vistaRF.getDateS},
                    {title: "Solicitante",    data: vistaRF.getRequestedBy},
                    {title: "Estado",         data: vistaRF.getStatus},
                    {title: "F Asignada",     data: vistaRF.getDateAssigned},
                    {title: "Ingeniero",      data: vistaRF.getEngineer},
                    {title: "Fecha Envio ",   data: vistaRF.getDateSend},
                    {title: "Mes Facturacion",data: vistaRF.getMonthB},
                    {title: "Modulo",         data: vistaRF.getModule},
                    {title: "F Factura",      data: vistaRF.getDateBill},
                    {title: "Cod",            data: vistaRF.getTipo}
                ]));
        },

         //pintamos la tabla de eventos 
        printTableEventsChanges: function(data){
            // limpio el cache si ya habia pintado otra tabla
            if(vistaRF.tableModalEventsChanges){
                //si ya estaba inicializada la tabla la destruyo
                vistaRF.tableModalEventsChanges.destroy();
            }
            ///lleno la tabla con los valores enviados
            vistaRF.tableModalEventsChanges = $('#tableEventosChanges').DataTable(vistaRF.configTable(data,[
                    {title: "ID",             data: vistaRF.getID},
                    {title: "Archivo",        data: vistaRF.getFile,            visible: false},
                    {title: "Observaciones",  data: vistaRF.getObservations,    visible: false},
                    {title: "Peso Orden",     data: vistaRF.getOrderW,          visible: false},
                    {title: "F Revisión",     data: vistaRF.getDateRewiew,      visible: false},
                    {title: "F Crudo",        data: vistaRF.getDateRaw,         visible: false},
                    {title: "F OTGDRT",       data: vistaRF.getDateOTGDRT,      visible: false},
                    {title: "ID BSS",         data: vistaRF.getIDBSS,           visible: false},                   
                    {title: "Tipo",           data: vistaRF.getType,            visible: false},
                    {title: "F Factura",  data: vistaRF.getDateBill,            visible: false},
                    {title: "F Solicitada",   data: vistaRF.getDateS},
                    {title: "Elemento",       data: vistaRF.getElement},
                    {title: "Remedy",         data: vistaRF.getRemedy},
                    {title: "Solicitante",    data: vistaRF.getRequestedBy},
                    {title: "Estado",         data: vistaRF.getStatus},
                    {title: "F Asignada",     data: vistaRF.getDateAssigned},
                    {title: "Ingeniero",      data: vistaRF.getEngineer},
                    {title: "Fecha Envio ",        data: vistaRF.getDateSend},
                    {title: "Modulo",         data: vistaRF.getModule},
                    {title: "Mes Facturacion",data: vistaRF.getMonthB},
                    {title: "Cod",         data: vistaRF.getTipo},
                    {title: "Opc", data: vistaRF.getButtonsChanges} 
                ]));
        },

        //pintamos la tabla de log
        printTablelog: function(data){
            // limpio el cache si ya habia pintado otra tabla
            if(vistaRF.tableModalLog){
                //si ya estaba inicializada la tabla la destruyo
                vistaRF.tableModalLog.destroy();
            }
            ///lleno la tabla con los valores enviados
            vistaRF.tableModalLog = $('#tableLog').DataTable(vistaRF.configTableLog(data,[                                       
                    {title: "ORDEN",               data: "K_IDORDER"},
                    {title: "ANTES",               data: "N_OLD"},
                    {title: "AHORA",               data: "N_NEW"},
                    {title: "COLUMNA CAMBIADA",    data: vistaRF.getColumn},
                    {title: "FECHA MODIFICACION",  data: "D_DATE_MOD"}
                ]));
        },

        // Datos de configuracion del datatable para log
        configTableLog: function (data, columns, onDraw) {
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


        //pintamos la tabla de actividades rf
        printTableRF: function(data){
            ///lleno la tabla con los valores enviados
            vistaRF.tableRFActivities = $('#tableRF').DataTable(vistaRF.configTable(data,[
                    {title: "ID",             data: vistaRF.getID},
                    {title: "Archivo",        data: vistaRF.getFile,            visible: false},
                    {title: "Observaciones",  data: vistaRF.getObservations,    visible: false},
                    {title: "Peso Orden",     data: vistaRF.getOrderW,          visible: false},
                    {title: "F Revisión",     data: vistaRF.getDateRewiew,      visible: false},
                    {title: "F Crudo",        data: vistaRF.getDateRaw,         visible: false},
                    {title: "F OTGDRT",       data: vistaRF.getDateOTGDRT,      visible: false},
                    {title: "ID BSS",         data: vistaRF.getIDBSS,           visible: false},                   
                    {title: "Tipo",           data: vistaRF.getType,            visible: false},
                    {title: "Mes Facturacion",data: vistaRF.getMonthB,          visible: false},
                    {title: "F Factura",  data: vistaRF.getDateBill,            visible: false},
                    {title: "F Solicitada",   data: vistaRF.getDateS},
                    {title: "Elemento",       data: vistaRF.getElement},
                    {title: "Remedy",         data: vistaRF.getRemedy},
                    {title: "Solicitante",    data: vistaRF.getRequestedBy},
                    {title: "Estado",         data: vistaRF.getStatus},
                    {title: "F Asignada",     data: vistaRF.getDateAssigned},
                    {title: "Ingeniero",      data: vistaRF.getEngineer},
                    {title: "Fecha Envio ",        data: vistaRF.getDateSend},
                    {title: "Modulo",         data: vistaRF.getModule},
                    {title: "Cod",         data: vistaRF.getTipo},
                    {title: "Opc", data: vistaRF.getButtons}
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
              // lengthMenu:[[15,25,50,-1],[[15,25,50,'All']] ],
              columnDefs: [{
                      defaultContent: "",
                      // targets: -1,
                      orderable: false,
                  }],
              order: [[0, 'asc']],
              drawCallback: onDraw,
              dom: 'Bfrtip',
              buttons: ['colvis']
            }
        },



        //===============================INICIO CALCULO DE VALORES DATOS TABLAS===============================//
        /*"K_ID"*/
        getID: function(obj){
            color = (obj.N_STATUS_MOD == 2) ? 'color_igual': (obj.N_STATUS_MOD == 0) ? 'color_nuevo': 'color_cambio';
            return  '<span class="' + color + '"><b>' + obj.K_ID + '</b></span>';
        },
        /*"N_TYPE"*/
        getType: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_TYPE + '</b></span>';
        },
        /*"N_ELEMENT"*/
        getElement: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_ELEMENT + '</b></span>';
        },
        /*"N_FILE"*/
        getFile: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_FILE + '</b></span>';
        },
        /*"N_OBSERVATIONS"*/
        getObservations: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_OBSERVATIONS + '</b></span>';
        },
        /*"N_REMEDY"*/
        getRemedy: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_REMEDY + '</b></span>';
        },
        /*"N_ORDER_W"*/
        getOrderW: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_ORDER_W + '</b></span>';
        },
        /*"N_MONTH_B"*/
        getMonthB: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_MONTH_B + '</b></span>';
        },
        /*"N_idBSS"*/
        getIDBSS: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_idBSS + '</b></span>';
        },
        /*"N_REQUESTED_BY"*/
        getRequestedBy: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_REQUESTED_BY + '</b></span>';
        },
        /*"N_STATUS"*/
        getStatus: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_STATUS + '</b></span>';
        },
        /*"N_MODULE"*/
        getModule: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_MODULE + '</b></span>';
        },
        /*"N_TIPO"*/
        getTipo: function(obj){
            return  '<span class="' + color + '"><b>' + obj.N_TIPO + '</b></span>';
        },

        // Retorna la fecha en formato AAAA-MM-DD
        getDateRewiew: function(obj){
            color = (obj.N_STATUS_MOD == 2) ? 'color_igual': (obj.N_STATUS_MOD == 0) ? 'color_nuevo': 'color_cambio';
            return  '<span class="' + color + '"><b>' + obj.D_REVIEW.substr(0,10) + '</b></span>';
        },
        getDateRaw: function(obj){
            return  '<span class="' + color + '"><b>' + obj.D_RAW.substr(0,10) + '</b></span>';
            
        },
        getDateOTGDRT: function(obj){            
            return  '<span class="' + color + '"><b>' + obj.D_OTGDRT.substr(0,10) + '</b></span>';
        },
        getDateS: function(obj){
            return  '<span class="' + color + '"><b>' + obj.D_DATE_S.substr(0,10) + '</b></span>';
        },
        getDateAssigned: function(obj){
            return  '<span class="' + color + '"><b>' + obj.D_DATE_ASSGINED.substr(0,10) + '</b></span>';
        },
        getDateSend: function(obj){
            return  '<span class="' + color + '"><b>' + obj.D_DATE_SENT.substr(0,10) + '</b></span>';
        },
        getDateBill: function(obj){
            return  '<span class="' + color + '"><b>' + obj.D_BILL.substr(0,10) + '</b></span>';
        },
        getEngineer: function(obj){
            var ingeniero = 'Sin Definir';
            if (obj.K_ASSIGNED_TO == "1030565500") {
                ingeniero = "David Arevalo";                
            }else if (obj.K_ASSIGNED_TO == "1016028754") {
                ingeniero = "Lina Casallas";
            }
            return  '<span class="' + color + '"><b>' + ingeniero + '</b></span>';
        },
        // dibujo el boton de opciones
        getButtons: function (obj) {
            var boton = '';
            if (obj.K_IDORDER != null) {
                boton = '<div class="btn-group">'
                        + '<a class="btn btn-default btn-xs ver-log" data-toggle="tooltip" title="Historial"><span class="fa fa-fw fa-info"></span></a>'
                        + '</div>';                
            }
            return boton;
        },

        // Dibujo boton de opciones
        getButtonsChanges: function(obj){
            return '<div class="btn-group">'
                        + '<a class="btn btn-default btn-xs ver-log" data-toggle="tooltip" title="Historial"><span class="fa fa-fw fa-info"></span></a>'
                        + '</div>';
        },

        //de la tabla log retorno nombre de la columna afectada
        getColumn: function(obj){
            var columna = '';
            switch(obj.N_COLUMN) {
                case "D_DATE_S":
                        columna = 'FECHA SOLICITADA';
                    break;
                case "N_REQUESTED_BY":
                        columna = 'SOLICITADA POR';
                    break;
                case "N_STATUS":
                        columna = 'ESTADO';
                    break;
                case "N_TYPE":
                        columna = 'TIPO';
                    break;
                case "N_ELEMENT":
                        columna = 'ELEMENTO';
                    break;
                case "D_DATE_ASSGINED":
                        columna = 'FECHA ASIGNADA';
                    break;
                case "K_ASSIGNED_TO":
                        columna = 'ASIGNADA A';
                    break;
                case "D_DATE_SENT":
                        columna = 'FECHA ENVIADA';
                    break;
                case "N_FILE":
                        columna = 'ARCHIVO';
                    break;
                case "N_OBSERVATIONS":
                        columna = 'OBSERVACIONES';
                    break;
                case "N_MODULE":
                        columna = 'MODULO';
                    break;
                case "N_REMEDY":
                        columna = 'REMEDY';
                    break;
                case "N_ORDER_W":
                        columna = 'PESO ORDEN';
                    break;
                case "D_BILL":
                        columna = 'FECHA FACTURA';
                    break;
                case "N_MONTH_B":
                        columna = 'MES FACTURACIÓNB';
                    break;
                case "D_RAW":
                        columna = 'FECHA CRUDO';
                    break;
                case "D_REVIEW":
                        columna = 'FECHA REVISIÓN';
                    break;
                case "D_OTGDRT":
                        columna = 'FECHA OTGDRT';
                    break;
                case "N_idBSS":
                        columna = 'ID BSS';
                    break;
                case "N_TIPO":
                        columna = 'CÓDIGO';
                    break;                
            }
            return columna;
        },


        //==========================================FIN CALCULO DATOS TABLAS===========================================//

        // Al darle clic al boton historial "log" de tabla rf
        onClickVerLogTr: function(){
            var aLinkLog = $(this);
            var trParent = aLinkLog.parents('tr');
            var record = vistaRF.tableRFActivities.row(trParent).data();
            vistaRF.getLogById(record);
        },

       // Al darle clic al boton historial "log" de tabla cambios
        onClickVerLogTrChanges: function(){
            var aLinkLog = $(this);
            var trParent = aLinkLog.parents('tr');
            var record = vistaRF.tableModalEventsChanges.row(trParent).data();
            vistaRF.getLogById(record);
        },

        // Muestra el modal del id clickiado
        getLogById: function(obj){
            $.post( baseurl + '/RF/getLogById', {id: obj.K_ID}, function(data) {
                var obj = JSON.parse(data);
                vistaRF.showModalHistorial(obj);
            });
        },

        // Muestra modal detalle historial log por id
        showModalHistorial: function(obj){
            $('#ModalHistorialLog').modal('show');
            $('#titleEventHistory').html('Historial Cambios de orden ' + obj.K_IDORDER + '');
            vistaRF.printTableHistory(obj);
        },

        //pintamos la tabla de log
        printTableHistory: function(data){
            // limpio el cache si ya habia pintado otra tabla
            if(vistaRF.tableModalHistory){
                //si ya estaba inicializada la tabla la destruyo
                vistaRF.tableModalHistory.destroy();
            }
            ///lleno la tabla con los valores enviados
            vistaRF.tableModalHistory = $('#tableHistorialLog').DataTable(vistaRF.configTableLog(data,[                                       
                    {title: "ORDEN",              data: "K_IDORDER"},
                    {title: "ANTES",              data: "N_OLD"},
                    {title: "AHORA",              data: "N_NEW"},
                    {title: "COLUMNA CAMBIADA",   data: vistaRF.getColumn},
                    {title: "FECHA MODIFICACION", data: "D_DATE_MOD"}
                ]));
        },



    };

    vistaRF.init();
});