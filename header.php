<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evasão - <?php echo $page_title; ?></title>

    <!-- Bootstrap -->
    <link href="plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="plugins/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css" />

    <!-- Select2 -->
    <link href="plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select -->
    <link href="plugins/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.bootstrap.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.bootstrap4.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.bootstrap4.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.dataTables.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.dataTables.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.foundation.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.foundation.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.jqueryui.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.jqueryui.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.semanticui.css" rel="stylesheet">
    <link href="plugins/datatables.net-bs/css/select.semanticui.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="plugins/jquery/dist/jquery.min.js"></script>
    <script src="plugins/jquery/dist/jquery-1.12.3.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <?php /*
    <!-- FastClick -->
    <script src="plugins/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="plugins/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="plugins/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="plugins/bernii/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="plugins/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="plugins/Flot/jquery.flot.js"></script>
    <script src="plugins/Flot/jquery.flot.pie.js"></script>
    <script src="plugins/Flot/jquery.flot.time.js"></script>
    <script src="plugins/Flot/jquery.flot.stack.js"></script>
    <script src="plugins/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="js/flot/jquery.flot.orderBars.js"></script>
    <script src="js/flot/date.js"></script>
    <script src="js/flot/jquery.flot.spline.js"></script>
    <script src="js/flot/curvedLines.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    */?>
    <!-- Datatables -->
    <script src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables.net/js/dataTables.select.min.js"></script>

    <script src="plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="plugins/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="plugins/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="plugins/jszip/dist/jszip.min.js"></script>
    <script src="plugins/pdfmake/build/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/build/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="plugins/select2/dist/js/select2.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="js/custom.js"></script>

    <!-- Leaftlet -->
    <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-graduation-cap"></i> <span>Evasão</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bem vinda,</span>
                <h2>Renata de Oliveira</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
                  <li><a href="importar-dados.php"><i class="fa fa-upload"></i>Importar Dados</a></li>
                  <li><a href="cursos.php"><i class="fa fa-pencil-square"></i>Cursos</a></li>
                  <li><a href="usuarios.php"><i class="fa fa-user"></i>Usuarios</a></li>
                  <li><a href="configuracoes.php"><i class="fa fa-cogs"></i>Configurar</a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt="">Renata de Oliveria
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;">Perfil</a></li>
                    <li><a href="javascript:;">Configurações</a></li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i>Fazer logoff</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>