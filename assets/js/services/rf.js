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
            $('#titleEvent').html('Detalle total de actividades RF con Cambios');
            vistaRF.printTableEvents(activities);
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
                    {title: "ID",             data: "K_ID"},
                    {title: "Tipo",           data: "N_TYPE",               visible: false},//QUEDA IN  VISIBLE LA COLUMNA
                    {title: "Elemento",       data: "N_ELEMENT",            visible: false},
                    {title: "Archivo",        data: "N_FILE",               visible: false},
                    {title: "Observaciones",  data: "N_OBSERVATIONS",       visible: false},
                    {title: "Remedy",         data: "N_REMEDY",             visible: false},
                    {title: "Peso Orden",     data: "N_ORDER_W",            visible: false},
                    {title: "Mes Facturacion",data: "N_MONTH_B",            visible: false},
                    {title: "F_Revisión",     data: vistaRF.getDateRewiew,  visible: false},
                    {title: "F_Crudo",        data: vistaRF.getDateRaw,     visible: false},
                    {title: "F_OTGDRT",       data: vistaRF.getDateOTGDRT,  visible: false},
                    {title: "ID BSS",         data: "N_idBSS",              visible: false},
                   
                    {title: "F Solicitada",   data: vistaRF.getDateS},
                    {title: "Solicitante",    data: "N_REQUESTED_BY"},
                    {title: "Estado",         data: "N_STATUS"},
                    {title: "F Asignada",     data: vistaRF.getDateAssigned},
                    {title: "Ingeniero",      data: vistaRF.getEngineer},
                    {title: "Fecha Envio ",        data: vistaRF.getDateSend},
                    {title: "Modulo",         data: "N_MODULE"},
                    {title: "F_Factura",  data: vistaRF.getDateBill},
                    {title: "Cod",         data: "N_TIPO"},
                    {title: " ", data: vistaRF.getButtons} 
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
                    {title: "ORDEN",   data: "K_IDORDER"},
                    {title: "ANTES",    data: "N_OLD"},
                    {title: "AHORA",         data: "N_NEW"},
                    {title: "COLUMNA CAMBIADA",     data: "N_COLUMN"},
                    {title: "FECHA MODIFICACION",      data: "D_DATE_MOD"}
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
                    {title: "ID",             data: "K_ID"},
                    {title: "Tipo",           data: "N_TYPE",               visible: false},//QUEDA IN  VISIBLE LA COLUMNA
                    {title: "Elemento",       data: "N_ELEMENT",            visible: false},
                    {title: "Archivo",        data: "N_FILE",               visible: false},
                    {title: "Observaciones",  data: "N_OBSERVATIONS",       visible: false},
                    {title: "Remedy",         data: "N_REMEDY",             visible: false},
                    {title: "Peso Orden",     data: "N_ORDER_W",            visible: false},
                    {title: "Mes Facturacion",data: "N_MONTH_B",            visible: false},
                    {title: "F_Revisión",     data: vistaRF.getDateRewiew,  visible: false},
                    {title: "F_Crudo",        data: vistaRF.getDateRaw,     visible: false},
                    {title: "F_OTGDRT",       data: vistaRF.getDateOTGDRT,  visible: false},
                    {title: "ID BSS",         data: "N_idBSS",              visible: false},
                   
                    {title: "F Solicitada",   data: vistaRF.getDateS},
                    {title: "Solicitante",    data: "N_REQUESTED_BY"},
                    {title: "Estado",         data: "N_STATUS"},
                    {title: "F Asignada",     data: vistaRF.getDateAssigned},
                    {title: "Ingeniero",      data: vistaRF.getEngineer},
                    {title: "Fecha Envio ",        data: vistaRF.getDateSend},
                    {title: "Modulo",         data: "N_MODULE"},
                    {title: "F_Factura",  data: vistaRF.getDateBill},
                    {title: "Cod",         data: "N_TIPO"},
                    {title: " ", data: vistaRF.getButtons} 
                    
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
              drawCallback: onDraw,
              dom: 'Bfrtip',
              buttons: ['colvis']
            }
        },
        // Retorna la fecha en formato AAAA-MM-DD
        getDateRewiew: function(obj){
            return  obj.D_REVIEW.substr(0,10);
        },
        getDateRaw: function(obj){
            return obj.D_RAW.substr(0,10);
        },
        getDateOTGDRT: function(obj){
            return obj.D_OTGDRT.substr(0,10);
        },
        getDateS: function(obj){
            return obj.D_DATE_S.substr(0,10);
        },
        getDateAssigned: function(obj){
            return obj.D_DATE_ASSGINED.substr(0,10);
        },
        getDateSend: function(obj){
            return obj.D_DATE_SENT.substr(0,10);
        },
        getDateBill: function(obj){
            return obj.D_BILL.substr(0,10);
        },
        getEngineer: function(obj){
            if (obj.K_ASSIGNED_TO == "1030565500") {
                return "David Arevalo";                
            }else if (obj.K_ASSIGNED_TO == "1016028754") {
                return "Lina Casallas";
            }else{
                return "Din Definir";
            }
        },
        // dibujo el boton de opciones
        getButtons: function (obj) {
            return '<div class="btn-group">'
                    + '<a href="" class="btn btn-default btn-xs" data-toggle="tooltip" title="Historial"><span class="fa fa-fw fa-info"></span></a>'
                    + '</div>';
        }, 

    };

    vistaRF.init();
});