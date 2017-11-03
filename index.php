<?php
$idExpediente = intval($_REQUEST['idExpediente']);
if(!isset($idExpediente)) {
  $idExpediente = 'X';
}
?>

<html>
   <head>
      <title>Subir foto</title>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="https://unpkg.com/dropbox/dist/Dropbox-sdk.min.js"></script>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   </head>
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
         <!--results-->
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
</html>

