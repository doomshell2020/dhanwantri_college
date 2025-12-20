<!-- First, include the Webcam.js JavaScript Library -->

		<?= $this->Html->script('jquery.min.js'); ?>
		<?= $this->Html->script('admin/webcam.js'); ?>
	<script>
		$(function(){//alert('tesa')
			//give the php file path
			webcam.set_api_url( '<?php echo SITE_URL; ?>saveimage.php' );
			webcam.set_swf_url( '<?php echo SITE_URL; ?>js/admin/webcam.swf' );
			webcam.set_quality( 100 ); // Image quality (1 - 100)
			webcam.set_shutter_sound( false ); // play shutter click sound
 
			var camera = $('#camera');
			camera.html(webcam.get_html(260, 260));
 
			$('#capture_btn').click(function(){//alert('tetst');
				
				webcam.snap();
			
			});
 
			//after taking snap call show image
			webcam.set_hook( 'onComplete', function(img){
				$('#show_saved_img').html('<img src="<?php echo SITE_URL; ?>' + img + '">');
				$('#camera_wrapper').hide();
				var arr = img.split('/');
			
				$('#image').val(arr[2]);
				webcam.reset();
			});
 
		});
	</script>
	
 <div class="photo-box">
      <div id="camera_wrapper">
        <div id="camera"></div>
        <button id="capture_btn">Capture</button>
      </div>
      <div style="clear:right"></div>
      <!-- show captured image -->
      <div id="show_saved_img" ></div>
    </div>

