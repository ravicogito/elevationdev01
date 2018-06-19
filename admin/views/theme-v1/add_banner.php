<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	 <script> 
		function Checkingform(banner)
		{
			var pattern = /^((http|https|ftp):\/\/)/;
			var banner_type = jQuery(banner).find('#banner_type').val();
			var imgFile = jQuery(banner).find('#bannerimg').val();			
			if(banner_type == '')
			{
				alert('Select Banner Type');
				return false;
			}
			if(imgFile == '')
			{
				alert('Please upload image');
				return false;
			}	
		}
		 
	
      </script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add New Banner
       
      </h1>
     
    </section>

    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

         <?php
         $errMsg = $this->session->flashdata('errorPageMessage');
         $successMsg =  $this->session->flashdata('sucessPageMessage');
       if(!empty($successMsg)) { ?>

       <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $successMsg; ?>
            </div>

      <?php } ?>
	  <?php if(!empty($errMsg)) { ?>

       <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $errMsg; ?>
            </div>

      <?php } ?>

        <form role="form" method="post" action="<?php echo base_url().'Banner/addBanner/';?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
			<div class="event_field">
				
				<div class="form-group">
					<label>Select Page</label>
					<select name="banner_type" id="banner_type" class="form-control">
						?>	
						
						
					</select>
				</div>
				
				<div class="form-group">
					<label for="bannerimg">Upload Banner Image</label>
					<input type="file" id="bannerimg" name="banner_img">
				</div>
				<div class="box-footer">
					<input type="submit" class="btn btn-primary" value="Submit">
				</div>
			</div>
        </form>
        
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->