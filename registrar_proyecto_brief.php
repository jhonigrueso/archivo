      <?php
      require("layout/head.php");
      require("layout/menu.php");
      ?>
      <!--main-container-part-->
      <div id="content">
        <p>
          <!--breadcrumbs-->
        </p>
        <div id="content-header">
          <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a></div>
        </div>
        <!--End-breadcrumbs-->

        <!--Action boxes-->
        <?php
        $resultado = 0;
        $mensaje = "";
        $version = 0;
        $idchecklist = 0;
        $idItem = $_REQUEST['id'];


        $prodCoti = $general->datosProductoCotizacion($idItem);
        $oportunidad = $general->datosCotizacionID($prodCoti['id_cotizacion']);
        if ($oportunidad['f_cotizacion']) {
          $direccion = 'ver_cotizacion.php';
        }else{
          $direccion = 'ver_oportunidad.php';
        }

        ?>


        <div class="container-fluid">
          <h3>REGISTRAR PROYECTO BRIEF - <?php echo $idItem ?>
          </h3>

          <?php if ($mensaje != "") { ?>
            <div class="alert alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
              <?php echo $mensaje; ?></div>
          <?php } ?>



          <div class="row-fluid">

            <div class="span12">
              <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                  <h5>PROYECTO:</h5>
                </div>

                <div class="widget-content nopadding">
                  <form action="<?php echo $direccion ?>?id=<?php echo $idItem ?>" method="post" class="form-horizontal">

                    <?php
                    $formulario = array();
                    if ($usuario['nivel'] >= 10) {

                      $preguntas = $general->preguntasDocumento("BRIEF PROYECTO");


                      foreach ($preguntas as $pregunta) {
                        $resp = $general->respuestaPregunta($pregunta['id'], $_REQUEST['id']);
                        if ($pregunta['valores'] == '') {
                          if ($resp['respuesta'] != '') {
                            $pregunta['valores'] = $resp['respuesta'];
                          } else {
                          }
                        }

                        $formulario[] = array('tipo' => $pregunta['tipo'], 'id' => $pregunta['id'], 'etiqueta' => $pregunta['pregunta'], 'valor' => $pregunta['valores'], 'seleccion' => $resp['respuesta'], 'descripcion' => $pregunta['tip']);
                        $formulario[] =  array('tipo' => 'hidden', 'id' => 'p_brief', 'valor' => $_REQUEST['id']);
                      }
                    }

                    echo $general->crearFormulario($formulario);
                    ?>


                    <div class="form-actions">
                      <button type="submit" class="btn btn-inverse">
                        Solicitar revision de proyecto
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="js/bootstrap.min.js"></script>
      <?php require("layout/footer.php");
      ?>