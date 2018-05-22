$(function () {
    vista = {
        urlbase: $('body').attr('data-url'),
        init: function () {
            vista.events();
            vista.getListTransport();
            vista.getListGDATOS();
        },
        getListTransport: function () {
            vista.tableTransport = $('#tableTransport').DataTable(vista.genericCogDataTable("Service/getListServices", "tableTransport"));
        },
        getListGDATOS: function(){
            vista.tableGDATOS = $('#tableGDATOS').DataTable(vista.genericCogDataTable("Service/getListServices?typeSQL=GDATOS", "tableGDATOS"));
        },
        //Así se llena en función...
        getIngener(obj){
            if(Array.isArray(obj.services) && obj.services.length > 1){
                return obj.services[0].ingSol;
            }else{
                return "Indefinido";
            }
        },

        //------------Obtener ingenieros asignados...------------
        getEngs: function(obj){
            // console.log(obj);
            //contamos la canbtidad de actividades
             var cantActividades = obj.services.length;
             var ing = [];
             var engs= "";
             if (obj.services.length > 0) {
                // En el arreglo ing ingresamos ingeniero asignado para cada actividad
                for (var i = 0; i < cantActividades; i++) {
                    ing[i] = "- " + obj.services[i].user.name + " " + obj.services[i].user.lastname + "<br>";
                }
                //Eliminamos ingenieros duplicados para mostrar unico
                engs = ing.reduce(function(a,b){
                    if (a.indexOf(b) < 0 ) a.push(b);
                    return a;
                  },[]);
             }
             return engs;
        },

        //------------Obtener barras de progreso------------
        getProgress: function(obj){
            var total = parseInt(obj.canceladas) + parseInt(obj.ejecutadas) + parseInt(obj.enviadas) + parseInt(obj.asignadas);
            var porEnviadas = obj.enviadas * 100 / total;
            var porCanceladas = obj.canceladas * 100 / total;
            var porEjecutadas = obj.ejecutadas * 100 / total;
            var avance = porCanceladas + porEjecutadas + porEnviadas;
            var barras = "";
            barras+= "<div class='containerfluid'>";
                barras+= "<div class='row'>";
                  barras+= "<div class='col-md-12'>";
                    barras+= "<div class='progress' style='height: 13px;'>";
                      barras+= "<div class='progress-bar progress-bar-warning progress-bar-striped active' role='progressbar' style='width: " + avance +"%; '>";
                        barras+= "<div style='font-size: 10px; margin-top: -3px;'>" + Math.round(avance, -1) + "%</div>";
                      barras+= "</div>";
                    barras+= "</div>";
                  barras+= "</div>";
                barras+= "</div><br>";

                barras+= "<div class='row'>";
                  barras+= "<div class='col-md-12'>";
                    barras+= "<div class='progress' style='height: 13px;'>";
                      barras+= "<div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' style='width: " + porEjecutadas + "%; '>";
                        barras+= "<div style='font-size: 10px; margin-top: -3px;'>" + Math.round(porEjecutadas, -1) + "%</div>";
                      barras+= "</div>";
                    barras+= "</div>";
                  barras+= "</div>";
                barras+= "</div>";

                barras+= "<div class='row'>";
                  barras+= "<div class='col-md-12'>";
                    barras+= "<div class='progress' style='height: 13px;'>";
                      barras+= "<div class='progress-bar progress-bar-info progress-bar-striped active' role='progressbar' style='width: " + porEnviadas + "%; '>";
                        barras+= "<div style='font-size: 10px; margin-top: -3px;'>" + Math.round(porEnviadas, -1) + "%</div>";
                      barras+= "</div>";
                    barras+= "</div>";
                  barras+= "</div>";
                barras+= "</div>";

                barras+= "<div class='row'>";
                  barras+= "<div class='col-md-12'>";
                    barras+= "<div class='progress' style='height: 13px;'>";
                      barras+= "<div class='progress-bar progress-bar-danger progress-bar-striped active' role='progressbar' style='width: " + porCanceladas + "%; '>";
                        barras+= "<div style='font-size: 10px; margin-top: -3px;'>" + Math.round(porCanceladas, -1) + "%</div>";
                      barras+= "</div>";
                    barras+= "</div>";
                  barras+= "</div>";
                barras+= "</div>";
             barras+= "</div>";
            return barras;

        },

        //-------------Pintando un href...-------------
        getLinkOrden: function(obj){

            var href = "";
            href += '<a class="link-ver-actividades" title="Ver actividades">' + obj.id + '</a><br><br>';
            if (obj.link != "" && obj.link != null) {
                href += "<a type='button' id='btnDrive' href='"+ obj.link +"' target='_blank'><img src= '"+vista.urlbase+"/assets/img/drive.ico' alt='drive' id='imgIcon' /></a>";

            }
            return href;
        },

        getPrioridad: function(obj){
            if (obj.prioridad == 'Alta') {
                return "<spam style='color:red'>"+obj.prioridad+"</spam>";
            }

            return obj.prioridad;
        },

        getDescription: function(obj){
          console.log(obj);
             // console.log(obj.services[0].claroDescription);
            var ini = obj.services[0].claroDescription.substring(0,45);
            var description ="";
            $(document).ready(function(){
                $("#hide"+ obj.id).click(function(){
                    $("#p" + obj.id).hide(500);
                    $("#show" + obj.id).show(500);
                });
                $("#show" + obj.id).click(function(){
                    $("#p" + obj.id).show(500);
                    $("#show" + obj.id).hide(500);
                });
            });

            description += ini;
            description += "<p id='p"+obj.id+"' style='display:none;'> "+obj.services[0].claroDescription.substring(45);
            description += "<a class='miniBoton' id='hide"+obj.id+"'><br>...menos</a>";
             description += " </p>";
            description += "<a class='miniBoton' id='show"+obj.id+"'><br>... mas</a>";
            return description;
        },

        getdateStartP: function (obj){
           //obj.dateStartP = data:;

           var role=$('#session_role').val();

           if (role == 4) {var cambiofecha = '<input class="cambiofecha" type="date" value="'+obj.services[0].dateStartP+'">';
            cambiofecha = cambiofecha + "<button title='Actualizar' class='glyphicon glyphicon-cloud-upload btn-circle'></button>";
             return cambiofecha;
            }else {
               return obj.services[0].dateStartP
            };
        },

        genericCogDataTable: function (url, table) {
            // console.log();
            // $('.contentPrincipal').removeClass('hidden');
            return {
                columns: [
                    {title: "Id orden", data: vista.getLinkOrden},
                    {title: "Fecha creación", data: "creationDate"},
                    {title: "Ingeniero Solicitante", data: "services.0.ingSol"},
                    {title: "Forecast Aprox.", data: "services.0.dateForecast"},

                    {title: "F.Asignacion", data: vista.getdateStartP},
                    {title: "Proyecto", data: "services.0.proyecto"},
                    {title: "Region", data: "services.0.region"},
                    {title: "Ingenieros Asignados", data: vista.getEngs},
                    {title: "Descripción de la orden", data: vista.getDescription},
                    {title: "Prioridad", data: vista.getPrioridad},// Cantidad de actividades
                    {title: "#", data: "services.length"},// Cantidad de actividades
                    {title: "Progress", data: vista.getProgress},// barras de progreso
                ],
                "language": {
                    "url": vista.urlbase + "/assets/plugins/datatables/lang/es.json"
                },
                columnDefs: [{
                        defaultContent: "",
                        targets: 0,
                        orderable: false,
                    }],
                order: [[0, 'desc']],
                "bProcessing": true,
                "serverSide": true,
                drawCallback: function () {
                    // vista.runTimers(table);
                },
                "ajax": {
                    url: vista.urlbase + '/' + url, // json datasource
                    type: "get", // type of method  , by default would be get
                    error: function () {  // error handling code
                        $("#employee_grid_processing").css("display", "none");
                    }
                }
            };
        },
        //Eventos de la ventana.
        events: function () {
            $('#tableTransport').on('click', 'a.link-ver-actividades', vista.onClickVerActividadTr);
            $('#tableGDATOS').on('click', 'a.link-ver-actividades', vista.onClickVerActividadGd);


            $('#btn_fixed2').on('click', function(){
                $(this).hide();
                $('#content_fixed2').removeClass('closed2');
                $('#content_fixed2 #menu_fixed2').removeClass('hidden').hide().fadeIn(500);
            });
            $('#btn_close_fixed2').on('click', function(){
                $('#content_fixed2').addClass('closed2');
                $('#content_fixed2 #menu_fixed2').hide();
                $('#btn_fixed2').fadeIn(500);
            });




            $('#btn_fixed').on('click', function(){
                $(this).hide();
                $('#content_fixed').removeClass('closed');
                $('#content_fixed #menu_fixed').removeClass('hidden').hide().fadeIn(500);
            });
            $('#btn_close_fixed').on('click', function(){
                $('#content_fixed').addClass('closed');
                $('#content_fixed #menu_fixed').hide();
                $('#btn_fixed').fadeIn(500);
            });

            $('#tableTransport').on('click', 'button.btn-circle', vista.TRupdateFecha);
            $('#tableGDATOS').on('click', 'button.btn-circle', vista.GDupdateFecha);

            // $('table').off('click', '.btn-preview', vista.onClickPreviewBtn);
            // $('table').on('click', '.btn-preview', vista.onClickPreviewBtn);
            // $('.tab-tables').on('click', vista.onClickTabTables);
        },

        TRupdateFecha: function(){
             var fecha = $(this);
            var trParent = fecha.parents('tr');
            var input = trParent.find('input').val();
            var datos = vista.tableTransport.row(trParent).data();
            vista.updateFecha(datos,input);
        },

        GDupdateFecha: function(){
             var fecha = $(this);
            var trParent = fecha.parents('tr');
            var input = trParent.find('input').val();
            var datos = vista.tableGDATOS.row(trParent).data();
            vista.updateFecha(datos,input);
        },


        updateFecha: function(datos, input){
            /*var fecha = $(this);
            var trParent = fecha.parents('tr');
            var input = trParent.find('input').val();
            var datos = vista.tableTransport.row(trParent).data();
*/

            $.post(vista.urlbase+"/Service/actualizarfechaAsig",

                {
                    idOrden: datos.id,
                    fecha: input
                },
                // callback
                function(data){
                    var res = JSON.parse(data);
                    console.log(res);
                    if (res == 'ok') {
                        swal("Se actualizo correctamente!", "", "success");

                        /*location.reload(vista.urlbase + "Service/listServices");*/
                        setTimeout('document.location.reload()',1000);
                    }else  swal("Se actualizo correctamente!", "", "error");
                }

            );


        },


        onClickVerActividadTr: function(){
            var aLink = $(this);
            var trParent = aLink.parents('tr');
            var record = vista.tableTransport.row(trParent).data();
            modalEditar(record, record.id, $('#session_id').val(), $('#session_role').val());
        },
        onClickVerActividadGd: function(){
            var aLink = $(this);
            var trParent = aLink.parents('tr');
            var record = vista.tableGDATOS.row(trParent).data();
            modalEditar(record, record.id, $('#session_id').val(), $('#session_role').val());
        },
        onClickTabTables: function () {
            var tab = $(this);
            var path = tab.attr('href');
            sessionStorage.setItem('path_tab_tables', path);
        },
        onClickPreviewBtn: function () {
            var btn = $(this);
            var tr = btn.parents('tr');
            var table = vista[btn.attr('data-table')];
            if (!table) {
                return;
            }
            var record = table.row(tr).data();
            // console.log(tr, record);
            $('#formDetallesBasicos').fillForm(record);
            $('#modalPreview').modal('show');
        },
        // //Temporalmente...
        fillNA: function () {
            return "N/A";
        },
    };

    vista.init();
});
