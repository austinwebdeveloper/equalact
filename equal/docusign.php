<?php
session_start();
require_once('db_config.php');
include ('header.php');

$_SESSION['subtotal'] = $_POST['subtotal'];

$_SESSION['shipping'] = $_POST['shipping'];

$_SESSION['bid'] = $_POST['bid'];

$_SESSION['state'] = $_POST['state'];

$_SESSION['zip'] = $_POST['zip'];

$_SESSION['city'] = $_POST['city'];

$_SESSION['firstname'] = $_POST['firstname'];

$_SESSION['lastname'] = $_POST['lastname'];  

      
?>
<style>

input[type="text"] {
    background-color: #f5f5f5;
    border: 0px;
}
</style>
<div class="main-container">


<section class="page-title page-title-4 bg-secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="uppercase mb0">REVIEW DOCUMNET</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <ol class="breadcrumb breadcrumb-2">
                                <li>
                                    <a href="index.html">Home</a>
                                </li>
                                <li>
                                    <a href="#">Shop</a>
                                </li>
                                <li class="active">Cart</li>
								<li class="active">Review</li>
                            </ol>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script>
$( document ).ready(function() {
$("#loading").show();
$("#document").hide();
    $.ajax({url: "ajax_docusign.php?id=<?php echo $_POST['bid']; ?>&fname=<?php echo $_POST['firstname']; ?>&lane=<?php echo $_POST['lastname']; ?>", success: function(result){
    $("#loading").hide(); 
	$("#document").show();
	alert(result);
	$('#document').attr('src', result) 
    }});
});
</script> 

 	<section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="text-center">
                                <h4 class="uppercase">REVIEW Document</h4>
                                <hr>
                            </div>
							
						</div>

						
							
							<div class="col-md-12" class="homefeed">

							<iframe id="document" src="<?php echo $url; ?>" width="100%" height="900px">
								<p>Your browser does not support iframes.</p>
							</iframe>
							
							<div id="loading"><button class="proceess btn_processing">Loading...</button></div>

							</div>
                                                
                        
                    </div>

                </div>
                <!--end of container-->
            </section>
            
<style>
#loading{
text-align:center;
margin-top:5%;
}
@-moz-keyframes bgmove{0%{background-position:0 0}100%{background-position:50px 50px}}
@keyframes bgmove{0%{background-position:0 0}100%{background-position:50px 50px}}
@-webkit-keyframes bgmove{0%{background-position:0 0}100%{background-position:50px 50px}}
@-o-keyframes bgmove{0%{background-position:0 0}100%{background-position:50px 50px}}
@-ms-keyframes bgmove{0%{background-position:0 0}}
.proceess {
    background: #45bf8f;
    color: #fff;
    text-align: center;
    padding: 15px 40px;
    font-size: 12px;
    border-radius: 2px;
    outline: 0;
    border: none;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 2px;	
}
.btn_processing:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: -webkit-gradient(linear,0 0,100% 100%,color-stop(.25,rgba(255,255,255,.2)),color-stop(.25,transparent),color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.2)),color-stop(.75,rgba(255,255,255,.2)),color-stop(.75,transparent),to(transparent));
    background-image: gradient(linear,0 0,100% 100%,color-stop(.25,rgba(255,255,255,.2)),color-stop(.25,transparent),color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.2)),color-stop(.75,rgba(255,255,255,.2)),color-stop(.75,transparent),to(transparent));
    background-image: -o-gradient(linear,0 0,100% 100%,color-stop(.25,rgba(255,255,255,.2)),color-stop(.25,transparent),color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.2)),color-stop(.75,rgba(255,255,255,.2)),color-stop(.75,transparent),to(transparent));
    background-image: -ms-gradient(linear,0 0,100% 100%,color-stop(.25,rgba(255,255,255,.2)),color-stop(.25,transparent),color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.2)),color-stop(.75,rgba(255,255,255,.2)),color-stop(.75,transparent),to(transparent));
    background-image: -moz-linear-gradient(-45deg,rgba(255,255,255,.2) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.2) 50%,rgba(255,255,255,.2) 75%,transparent 75%,transparent);
    z-index: 1;
    -webkit-background-size: 50px 50px;
    -moz-background-size: 50px 50px;
    background-size: 50px 50px;
    -webkit-animation: bgmove .7s linear infinite;
    -o-animation: bgmove .7s linear infinite;
    -ms-animation: bgmove .7s linear infinite;
    -moz-animation: bgmove .7s linear infinite;
    animation: bgmove .7s linear infinite;
}

</style>





</div>
		
            
        
			
<?php


include ('footer.php');

?>			
			