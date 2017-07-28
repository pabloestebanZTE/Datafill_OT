<!DOCTYPE html>
<html lang="en">
<head>
    <title>asignar actividad</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/css/styleHeader.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link rel='stylesheet' href='assets/fullcalendar/fullcalendar.css' />
        <script src='assets/fullcalendar/lib/jquery.min.js'></script>
        <script src='assets/fullcalendar/lib/moment.min.js'></script>
        <script src='assets/fullcalendar/fullcalendar.js'></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

 <script>

    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: '2017-05-12',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2017-05-01'
                },
                {
                    title: 'Long Event',
                    start: '2017-05-07',
                    end: '2017-05-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-05-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-05-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2017-05-11',
                    end: '2017-05-13'
                },
                {
                    title: 'Meeting',
                    start: '2017-05-12T10:30:00',
                    end: '2017-05-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2017-05-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2017-05-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2017-05-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2017-05-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2017-05-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2017-05-28'
                }
            ]
        });
        
    });

 </script>

    <style>

        body {
            margin: 40px 10px;
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
        }

        #calendar {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
  <header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo"><img id="logo" src="assets/img/logo2.png" /></a>
            </div>
            <!-- Collect the nav links for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="cam"><a href="#home">HOME</a></li>
                        <li class="cam"><a href="#services">SERVICIOS</a>
                            <ul>
                                <li><a href="">AGENDAR ACTIVIDAD</a></li>
                                <li><a href="">VER ACTIVIDAD</a></li>
                                <li><a href="">ASIGNAR ACTIVIDAD</a></li>
                            </ul>
                        </li>
                    <li class="cam"><a href="#price-sec">PRICING</a></li>
                    <li class="cam"><a href="#contact-sec">CONTACT</a></li>   
                </ul>
            </div>
        </div>
    </nav>
  </header>
<!------------------------------------------------fin header------------------------------------------------>
     <br><br>

<div class="container">
    <form class="well form-horizontal" action=" " method="post"  id="contact_form">
              <center>
                 <legend >Asignar Actividad</legend>
              </center>
            <fieldset class="col-md-6 control-label">

                <!-- Select Basic -->
           
                <div class="form-group"> 
                  <label class="col-md-3 control-label">ID Orden</label>
                    <div class="col-md-8 selectContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                    <select name="orden" class="form-control selectpicker" required >
                      <option value="" >ID Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>
                      <option>Id Orden</option>      
                    </select>
                  </div>
                </div>
                </div>

                <!-- Text input-->

                <div class="form-group">
                  <label class="col-md-3 control-label">ID Actividad</label>  
                  <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                  <input  name="idActividad" placeholder="ID Actividad" class="form-control" required type="text">
                    </div>
                  </div>
                </div>

                <!-- Select Basic -->
                   
                <div class="form-group"> 
                  <label class="col-md-3 control-label">Tipo</label>
                    <div class="col-md-8 selectContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                    <select name="tipo" class="form-control selectpicker" required>
                      <option value="" >seleccione tipo de Actividad</option>
                      <option>tipo A1</option>
                      <option>tipo A2</option>
                      <option>tipo A3</option>
                      <option>tipo C1</option>
                      <option>tipo C2</option>
                      <option>tipo C3</option>
                      <option>tipo H1</option>
                      <option>tipo H2</option>
                      <option>tipo H3</option>      
                    </select>
                  </div>
                </div>
                </div>

                <!--text informacion-->

                    <div class="form-group">
                      <label class="col-md-3 control-label">Información Tarea</label>
                       <div class="col-md-8 inputGroupContainer">
                       <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                             <p>informacion del tipo de actividad o la tarea a realizar por la persona asignada 
                              y el tiempo amximo para la realizacion de la misma</p>
                       </div> 
                        </div>                
                    </div>

            </fieldset>
        <!----fin seccion izquierda form---->
        <!----inicio seccion derecha form---->

            <fieldset >

                <!-- Select Basic -->
                   
                <div class="form-group"> 
                  <label class="col-md-3 control-label">Sitio</label>
                    <div class="col-md-8 selectContainer">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
                        <select name="sitio" class="form-control selectpicker" required>
                          <option value="" >seleccione el lugar</option>
                          <option>Sitio 1</option>
                          <option>sitio 2</option>
                          <option>Sitio 3</option>
                          <option>Sitio 4</option>
                          <option>Sitio 5</option>
                          <option>Sitio 6</option>
                          <option>Sitio 7</option>
                          <option>Sitio 8</option>
                          <option>Sitio 9</option>      
                        </select>
                     </div>
                    </div>
                </div>

                <!-- Date input-->
                      
                <div class="form-group">
                  <label class="col-md-3 control-label">Fecha Forecast</label>  
                    <div class="col-md-8 inputGroupContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input name="fechafc" placeholder="Fecha Forecast" class="form-control" required type="date">
                      </div>
                  </div>
                </div>

                <!-- Text area -->
                  
                <div class="form-group">
                  <label class="col-md-3 control-label">Observaciones</label>
                    <div class="col-md-8 inputGroupContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <textarea class="form-control" name="observaciones" placeholder="Observaciones"></textarea>
                      </div>
                  </div>
                </div>

                <!-- Select Basic -->

                <div class="form-group"> 
                  <label class="col-md-3 control-label">Ingeniero</label>
                    <div class="col-md-8 selectContainer">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <select name="ingeniero" class="form-control selectpicker" required>
                          <option value="" >Seleccione el Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>
                          <option>Ingeniero</option>      
                        </select>
                     </div>
                    </div>
                </div>
            </fieldset>
        <!-----fin seccion derecha---->

        <!-- Button -->
        <center>
            <div class="form-group">
                <label class="col-md-12 control-label"></label>
                 <div class="col-md-12">
                     <button type="submit" class="btn btn-primary" >Crear <span class="glyphicon glyphicon-ok"></span></button>
                </div>
            </div>
        </center>

    </form>
</div>
 
<!------------ /.container ------------>

<!--calendar-->

<div id='calendar'></div>
</body>
</html>