<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

      <footer>
        <div class="clearfix">
          <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2015 TalentsNotes</h6></li>
          </ul>
          <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
        </div>
      </footer>
    </div>
  </div>
</div>
  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="<?php echo base_url() ?>scripts/jquery.js"></script>
  
  <!-- scripts concatenated and minified via build script -->
  <script src="<?php echo base_url() ?>plugins/plugins.js"></script>
  <script src="<?php echo base_url() ?>scripts/scripts.js"></script>
  <script src="<?php echo base_url() ?>scripts/animator.min.js"></script>

    <!-- End loading page level scripts-->

  <!-- end scripts -->
      
  <!-- Print dinamical files js -->
	<?php 
	if( !empty( $scripts ) ):
		foreach( $scripts as $key => $value ):			
			echo $value;		
		endforeach;				
	endif;
	?>
 
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/enquire.min.js"></script>                   <!-- Load Enquire -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/velocity.min.js"></script>         <!-- Load Velocity for Animated Content -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/velocity.ui.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/wijets.js"></script>             <!--     Wijet-->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/prettify.js"></script>        <!-- Code Prettifier  -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->
 <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/icheck.min.js"></script>              <!-- iCheck -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/jquery.mousewheel.min.js"></script> <!-- Mousewheel support needed for Mapael -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/application.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/demo.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/demo-switcher.js"></script>
  <!-- End loading site level scripts -->
  <!-- Load page level scripts-->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/jquery.easypiechart.js"></script>       <!-- EasyPieChart -->
  <script type="text/javascript" src="<?php echo base_url() ?>scripts/nuevo/demo-index.js"></script>                  <!-- Initialize scripts for this page-->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>