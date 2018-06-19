<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($contentTitle)){ echo $contentTitle; } ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/responsiv.css" rel="stylesheet" type="text/css">
<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo_fav.ico">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery-1.10.2.js"></script>

<script>var _basePath = '<?php echo base_url(); ?>'</script>
<script>
$(document).ready(function(e) {
	$('.navbar ul > li').hover( function(){
		$(this).find('ul').stop().slideDown('slow');
	},function(){
		$(this).find('ul').stop().slideUp('slow');
	});
	
	$('.fqa h3').click(function(){
		$(this).find('.sign').toggleClass('oppn');
		$(this).next().slideToggle('slow');
	});
	
	$("#show_popup").on("click", function() {
		$("#subscriber_form").show();
	});
	$("#kv_form_close").on('click', function(e){
		$('#subscriber_form').fadeOut('slow');
	});
	
	$(".remove_order").unbind().bind("click", function(){
		//alert('Test');
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
		var result = confirm("Are you sure to delete?");
		if (result) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>CartAdd/removeProduct",
				dataType: "json",
				data:
				{
					product_key:product_key,
				},
				success:function(response)
				{
					//$("#cartSec").html(responce['HTML']);
					//alert(response.process);
					if(response['process'] == 'success') {
						location.reload();
					}
				},
				
			});
		}
	});
	
});
</script>
<style>
 @media screen and (max-width: 440px) {
		#sub_div_form { 
			width: 290px; 
			padding: 35px;
		}
	}
</style>
</head>
<body>
	<div class="ajax_overlay">
    <p class="loader_img"><img src="<?=base_url()?>assets/images/ajax-loader_overlay.gif">
    <br>
    Processing Please wait...</p>
    </div>
<div class="allcntnr">
<div class="topclor"></div>
<!--<header id="mainhead">
<div class="wrap">
<div class="row">
<a href="" class="logo col-md-2"><img src="<?php echo base_url(); ?>assets/images/logo.png" ></a> 
<nav id="mainnav"  class="col-md-8">
<ul>
<li><a href="<?php echo base_url();?>">HOME</a></li>          
<li><a href="<?php echo base_url();?>content/page/about-us">ABOUT US</a></li>          
<li><a href="<?php echo base_url();?>content/page/faq">FAQ</a></li>          
<li><a href="<?php echo base_url();?>content/page/privacy-policy">PRIVACY POLICY</a></li>
</ul>

<?php $customer_id	= $this->session->userdata('customer_id'); ?>
<div class="usersec col-md-2"><?php if(isset($customer_id)){ ?><a href="<?php echo base_url();?>Login/logout"><span class="icon"></span>Logout</a><?php } else{ ?><a href="#login" rel="prettyPhoto" class="inline"><span class="icon"></span>Login</a><?php } ?><a href=""><span class="icon"></span>3item(s)</a></div></div>
</div>
</div>

<div class="clearfix"></div>
</header>-->

<header id="mainhead">
<div class="wrap">
	
<div class="row"><a href="<?=base_url()?>" class="logo col-md-2"><img src="<?php echo base_url(); ?>assets/images/logo.png" ></a> 
<nav class="col-md-6" id="mainnav">
<div class="drpmnu navicn"><div class="" id="nav-icon2">

    <span></span>

    <span></span>

    <span></span>

    <span></span>

    <span></span>

    <span></span>

</div> <span class="men_txt">MENU</span></div>
<ul>
<li><a href="<?php echo base_url();?>">HOME</a></li>          
<li><a href="<?php echo base_url();?>page/about-us">ABOUT US</a></li>          
<li><a href="<?php echo base_url();?>page/faq">FAQ</a></li>          
<li><a href="<?php echo base_url();?>page/privacy-policy">PRIVACY POLICY</a></li>    
<li class="submenu"><a href="#">CATEGORY</a>
<ul>
		<li><a href="<?php echo base_url(); ?>category">Event</a></li>
		<li><a href="<?php echo base_url(); ?>category">River Rafting</a></li>
</ul>
	</li>

</ul>
</nav>

<?php $customer_id	= $this->session->userdata('customer_id');
	$customer_fname	= $this->session->userdata('customer_fname');
	if(isset($_SESSION['Usercart']) && !empty($_SESSION['Usercart'])){
		$cartcnt = count($_SESSION['Usercart']);
	}else{
		$cartcnt = 0;
	}
 ?>
<div class="usersec col-md-4"><?php if(isset($customer_id)){ ?><span class="opnlogfrmm"><span class="icon"></span><span class="usr"><span>Welcome </span> <a href="<?php echo base_url();?>profile/myaccount"><?php if(!empty($customer_fname)){	echo $customer_fname; }?></a> </span><a  href="<?php echo base_url();?>Login/logout">Logout</a></span><?php } else{ ?><a href="" class="opnlogfrmm" id='opnlogfrmm_id'><span class="icon"></span>Login</a><?php } ?><a id="show_popup" href="javascript:void(0);"><span class="icon"></span><span><?php echo $cartcnt;?> item(s)</span></a>
	<div id="subscriber_form" > 
		<div id="sub_div_form"> 
			<a href="javascript:void(0);"><span id="kv_form_close">  X </span></a>
			 <?php $total_price = 0; 
			if(!empty($_SESSION['Usercart'])){
			foreach($_SESSION['Usercart'] as $key => $productDetail) {

				$total_price  += $productDetail['price']*$productDetail['quantity'];
				
			?>
			<div class="main_div" style="margin-top:0px;">
				<div class="col-md-4">
					<img src="<?=$productDetail['cur_img'];?>" style="">
				</div> 
				<div class="cart_title" style="margin-top:0px;float: left;">
				<p><strong>Option:</strong><?php echo $productDetail['option']['name']; ?></p>
					<?php if(!empty($productDetail['option']['meta']['frame_name'])){?>
				   <p><strong>Frame Name:</strong><?php echo $productDetail['option']['meta']['frame_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['option']['meta']['top']['mat_name'])){?>
				   <p><strong>Top Mat:</strong><?php echo $productDetail['option']['meta']['top']['mat_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['middlemat_name'])){?>
				   <p><strong>Middle Mat:</strong><?php echo $productDetail['option']['meta']['middle']['mat_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['option']['meta']['bottom']['mat_name'])){?>
			<p><strong>Bottom Mat:</strong><?php echo $productDetail['option']['meta']['bottom']['mat_name']; ?></p>
				   <?php } ?>
			<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $productDetail['size']; ?></p>
				   
			<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($productDetail['price']*$productDetail['quantity']),2);?></p>
				   
			<p style="margin-top: 5px;"><strong>Quantity:</strong><?=(array_key_exists('quantity',$_SESSION['Usercart'][$key]))?$_SESSION['Usercart'][$key]['quantity']:"1";?></p>
				   
				   <a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order">&nbsp;</a>
				</div>
			</div>
			
			
			
			<?php } ?>
			<div class="last_div">
				<p class="prcese">Total Price : <strong>$<?=number_format($total_price, 2, ".","")?></strong></p>
				<a href="<?php echo base_url(); ?>cartAdd" class="btn btn-info">View Cart</a> <a class="btn btn-success" href="<?php echo base_url(); ?>cartAdd/billingCheckout">Checkout</a>
			</div>
			<?php } else {?>
			 <div class="bdrsdo" style="text-align: center;line-height: 150px;font-size: 22px;">
				<p>Your cart is empty</p>
				<!--<img src="<?=base_url()?>assets/images/empty_cart.jpeg" style="height: 215px;width: auto;">!-->
			 </div>
			<?php } ?>
		</div>
	</div>
</div>
</div>
</div>

	

<div class="clearfix"></div>
</header>
<div id="myOverlay"></div>
<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
<!--header section end-->
<!------------------- Login -------------------->

	<div class="logform poplogfrm" id="poplogfrm">
	<form id="loginform" action="<?php echo base_url();?>Login" method="post" autocomplete="off">
	<h2><img src="<?php echo base_url();?>assets/images/blogin.png" ><br>User Login</h2>
   
	<span class="erro_msg" style="color:red;font-size:15px;display:none"><strong>Your login credentials not matching! Please try again.</strong></span><br/><br/>
	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="useremail" name="useremail" type="text" placeholder="Enter Your Username">      
		  <span class="focus-border"></span> 
		  </div>

	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="password" name="password" type="password" placeholder="Enter Your Password">     
		  <span class="focus-border"></span> 
		  </div>


	<div class="clearfix compimg">
	<div class="com"><a href="<?php echo base_url();?>Login/forgotpassword">Forgot your password?</a></div> 
	<input id="login_bttn" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 loginbttn" type="button"  style="border:0;">
	

	</div>
	</form>
	<a href="" class="pp_close" id="pp_close"></a>
	</div>
	
	<!------------------- End Login -------------------->
<!--body section-->
<script>
$(window).load(function(e) {
	$(document).on("click", "#opnlogfrmm_id", function(e){	
	
		e.preventDefault();
		
		//alert(arr['1']);
		$('#poplogfrm').toggleClass('poplogfrmopn');
		$('.overlay').toggle();
	});
	
	$('#pp_close').click( function(e){
		$(".erro_msg").hide();
		e.preventDefault();
		$('#useremail').val('');
		$('#password').val('');
		$('#poplogfrm').toggleClass('poplogfrmopn');
		$('.overlay').toggle();
		
	});
	});

$(document).on("click", ".loginbttn", function(){	
	$(".erro_msg").hide();
	var email 			= $('#useremail').val();
	var pass 			= $('#password').val();
	
	var atpos				= email.indexOf("@");
	var atlastpos			= email.lastIndexOf("@");
	var dotpos				= email.indexOf(".");
	var dotlastpos			= email.lastIndexOf(".");
	if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos )
		{
			
			alert('Please put a valid email');
			return false;
		}
	
	else if(pass ==''){
		
		alert('Please put a valid password');
			return false;
	}
	else{
	
		$("#myOverlay").show();
		$("#loadingGIF").show();
		//{useremail:email,password:pass}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>Login/',
			data:{useremail:email,password:pass},
			dataType:"html",
			success: function(result){
            				
			if(result != 0){
			//$("#myOverlay").hide();
			//$("#loadingGIF").hide();	
			$("#poplogfrm").hide();
			$("#overlay").hide();
			document.location.href= "<?php echo base_url();?>";	
			//alert(result);
			}
			else{
			$("#myOverlay").hide();
			$("#loadingGIF").hide();	
			$(".erro_msg").show();
			}
			}
		});
	}
		
});</script>