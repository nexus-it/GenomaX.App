  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> <?php echo $_SESSION["VERSION_CONTROL"]; ?>
    </div>
    <strong>  Powered By: <a href="https://nexus-it.co">Nexus-IT.co</a>.</strong> &copy;
  </footer>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <div id="gxWindowsTabs" class="row">
      <div class="col-md-12">
        <h3 class="control-sidebar-heading">Opciones Activas</h3>
      </div>
      <div  class="col-md-12">
        <ul id="gxtabs" class="row">
          <li role="presentation" id="gxt0" class="active ">
            <a href="#Window_0" aria-controls="dashboard" role="tab" data-toggle="tab" aria-expanded="true" ><div class="col-md-12"> Inicio </div></a>
          </li>
        </ul>
      </div>
    </div>
        <!-- /.control-sidebar-menu -->
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper  #TodoAll -->
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/chart.js/Chart.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/raphael/raphael.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/morris.js/morris.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/moment/min/moment.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="themes/<?php echo $_SESSION["THEME_DEFAULT"] ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script type="text/javascript">
  $('#gxtabs a:last').tab('show');
</script>
