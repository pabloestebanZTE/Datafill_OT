$(function () {
    mostrar = {
        init: function () {
            mostrar.events();
        },

        //Eventos de la ventana.
        events: function () {
            //Al darle click al boton "proximos"
            $('#proximos').on('click', mostrar.onClickVerProximos);

        },
        //Al darle click al boton "proximos"
        onClickVerProximos: function() {
            $.post(baseurl + "/SpecialServices/getProximas",
              // {
                // "mes": mes,
                // "tipo": tipo
              // },
                function (data) {
                    // var obj = JSON.parse(data);
                    // vista.showModalTable(obj, mes, tipo);
                }
            );
        },








    };

    mostrar.init();
});