<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>ZOLID LOGIN</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="/Datafill_OT/assets/css/stylelogin.css">


  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>-->

</head>

<body>
  <div id="warp">
  <H2></H2>
  <form id="formu" method="post">
    <div class="admin">
      <div class="rota">
        <h1>ZOLID</h1>
        <input id="username" type="text" name="username" value="" placeholder="Username" required/><br />
        <input id="password" type="password" name="password" value="" placeholder="Password" required/>
         <td><input id="projectList" type="text" name="projectList" list="project" placeholder="seleccione su proyecto" required></td>
            <datalist id="project">
              <option value="Fonade" />
              <option value="Claro" />
              <option value="Telmex VIP" />
              <option value="Facturacion" />
              <option value="project x" />
              <option value="project x" />
              <option value="project x" />
            </datalist>
            </tr>
      </div>
    </div>
    <div class="cms">
      <div class="roti">
        <h1>ZTE</h1>
        <button type="submit" class="button" id="valid" name="valid" onclick = "this.form.action = 'http://localhost/Datafill_OT/index.php/User/loginUser'">Login</button><br />
        <p><a href="#">ZTE</a> <a>And</a> <a href="#">ZTE Colombia</a></p>
      </div>
    </div>
  </form>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="/Datafill_OT/assets/js/index.js"></script>

</body>
</html>
