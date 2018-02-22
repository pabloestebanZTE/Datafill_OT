function showMessage(mensaje){
        if(mensaje == "ok"){
          swal({
            title: "Bien hecho!",
            text: "Actividad aignada satisfactoriamente",
            type: "success",
            confirmButtonText: "Ok"
          });
        } 
        if(mensaje == "error") {
          swal({
            title: "error!",
            text: "Actividades ya existentes ",
            type: "error",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "no existe") {
          swal({
            title: "error!",
            text: "Actividades no existen ",
            type: "error",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "no seleccionado") {
          swal({
            title: "No seleccionaste un ingeniero!",
            text: "intenta de nuevo ",
            type: "info",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "actualizado") {
          swal({
            title: "Bien hecho!",
            text: "Actividades actualizadas satisfactoriamente\nCorreos enviados",
            type: "success",
            confirmButtonText: "Ok"
          });
        }
      }