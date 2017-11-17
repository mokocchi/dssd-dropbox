<?php
$idExpediente = intval($_REQUEST['idExpediente']);
if(!isset($idExpediente)) {
  $idExpediente = 'X';
}
?>

<html>
   <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	 <meta name="viewport" content="width=device-width, initial-scale=1">

	 <!-- Bootstrap -->
	 <link href="./incidentes/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	 <!-- Font Awesome -->
	 <link href="./incidentes/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	 <!-- NProgress -->
	 <link href="./incidentes/vendors/nprogress/nprogress.css" rel="stylesheet">

   	 <!-- Custom Theme Style -->
    	 <link href="./incidentes/build/css/custom.min.css" rel="stylesheet">   
		   
      <title>Aseguradora SSA - Subir Foto</title>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="https://unpkg.com/dropbox/dist/Dropbox-sdk.min.js"></script>
	<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
   </head>
		
   <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="" class="site_title"><i class="fa fa-shield"></i> <span>Aseguradora SSA</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_info">
                                <span>Bienvenid@</span>
                                <h2>Emplead@</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3><a href="" style="color: #fff"><i class="fa fa-home"></i> Inicio </a></h3>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
       <!--                           <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="" alt="">
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="../login/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesi&oacute;n</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>Gesti&oacute;n de Im&aacute;genes</h3>
                            </div>

                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                                                                <!--results-->
                                        <h2>Selecci&oacute;n de Im&aacute;genes <small><span id="results" style="color: #1abb9c"></span></small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        
                                         <div id="pre-auth-section" style="display:none;">
                                            <a href="" id="authlink" class="button">Autenticaci&oacute;n</a>
                                            <p class="info">Una vez autenticado, Ud. podr&aacute; acceder a las im&aacute;genes</p>
                                         </div>
                                         <div id="authed section" style="display:none;">
                                            <p>Ud. ha sido correctamente autenticado.</p>
                                            <ul id="files"></ul>
                                         </div> 

                                        <section class="container main">
                                            <form onSubmit="return uploadFile()">
                                                <input type="hidden" id="access-token" placeholder="Access token" value="<?php echo getenv('access-token'); ?>"/>
                                                <input type="file" id="file-upload" class="btn btn-round btn-dark"/>
                                                <div class="ln_solid"></div>
                                                <input type="submit" value="Agregar Imagen" class="btn btn-round btn-success" />
                                            </form>
                                            
                                            <script>
                                                function uploadFile() {
                                                    var ACCESS_TOKEN = document.getElementById('access-token').value;
                                                    var dbx = new Dropbox({ accessToken: ACCESS_TOKEN });
                                                    var fileInput = document.getElementById('file-upload');
                                                    var file = fileInput.files[0];
                                                    dbx.filesUpload({path: '/'+ <?php echo $idExpediente ?> +'/' + file.name, contents: file})
                                                        .then(function(response) {
                                                    var results = document.getElementById('results');
                                                    $("#results").empty();
                                                    results.appendChild(document.createTextNode('Se subio correctamente la imagen.'));
                                                    console.log(response);
                                                    })
                                                    .catch(function(error) {
                                                        console.error(error);
                                                    });
                                                    return false;
                                                }
                                            </script>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Aseguradora SSA
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <script src="./incidentes/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="./incidentes/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="./incidentes/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="./incidentes/vendors/nprogress/nprogress.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="./incidentes/build/js/custom.min.js"></script>

    </body>
	
  <!--	
   <body>
      <header class="page header">
         <div class="container">
            <nav>
               <h1>
                  ASEGURADORA SSA
               </h1>
               <h2 class="code">
                  GESTION DE IM&Aacute;GENES
               </h2>
            </nav>
         </div>
      </header>
      <div class="container main">
         <div id="pre-auth-section" style="display:none;">
            <a href="" id="authlink" class="button">Autenticaci&oacute;n</a>
            <p class="info">Una vez autenticado, Ud. podr&aacute; acceder a las im&aacute;genes</p>
         </div>
         <div id="authed section" style="display:none;">
            <p>Ud. ha sido correctamente autenticado.</p>
            <ul id="files"></ul>
         </div>
      </div>
      <section class="container main">
         <form onSubmit="return uploadFile()">
            <input type="hidden" id="access-token" placeholder="Access token" value="<?php echo getenv('access-token'); ?>"/>
            <input type="file" id="file-upload"/>
            <button type="submit">AGREGAR IMAGEN</button>
         </form>
         <!--results
         <h2 id="results"></h2>
         <script>
            function uploadFile() {
              var ACCESS_TOKEN = document.getElementById('access-token').value;
              var dbx = new Dropbox({ accessToken: ACCESS_TOKEN });
              var fileInput = document.getElementById('file-upload');
              var file = fileInput.files[0];
              dbx.filesUpload({path: '/'+ <?php echo $idExpediente ?> +'/' + file.name, contents: file})
                .then(function(response) {
                  var results = document.getElementById('results');
                  results.appendChild(document.createTextNode('Cargado!'));
                  console.log(response);
                })
                .catch(function(error) {
                  console.error(error);
                });
              return false;
            }
         </script>
      </section>
   </body>
 -->
</html>

