<!-- Footer -->
  <!-- <footer class="footer bg-light" style="background: #00354E!important">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
        
          <p class="text-muted small mb-4 mb-lg-0">Copyright &copy;  2010 - <?php print date('Y', time());?> <a href="https://baulphp.com/">BAULPHP.COM</a> .</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
       
        </div>
      </div>
    </div>
  </footer> -->
  <!-- Bootstrap core JavaScript -->
  <!--
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.3.1.js"></script>
  <script src="assets/js/jszip.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.buttons.min.js"></script>
  -->
  <!-- <script src="assets/js/buttons.flash.min.js"></script> -->
  <!--
  <script src="assets/js/pdfmake.min.js"></script>
  <script src="assets/js/vfs_fonts.js"></script>
  <script src="assets/js/buttons.html5.min.js"></script>
  <script src="assets/js/buttons.print.min.js"></script>
  -->
  <script src="assets/dt/datatables.js"></script>
  <?php 
  if (isset($_GET["nxsget"])) {
    $nxsget=str_replace("*","=",$_GET["nxsget"]);
    $nxsget=str_replace("|","&",$nxsget);
  } else {
    $nxsget="";
  }
  if (isset($_GET["nxsrpt"])) {
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('#render-data').DataTable({
		  	rowReorder: {
            selector: 'td:nth-child(2)'
        },
		responsive: true,
		  	"language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
          "paging": true,
          "processing": true,
          'serverMethod': 'post',
          "ajax": "nxs_data.php?nxsrpt=<?php echo $TheRpt.'&'.$nxsget; ?>",
          dom: 'lBfrtip',
          buttons: [
                'csv', 'excel',  'pdf', 'print', 'copy',
          ],
          "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "Todos"]]
      } );
    } );

  </script>
  <?php 
  }
  ?>
</body>
</html>