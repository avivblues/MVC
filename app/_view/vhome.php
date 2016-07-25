<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FA INFORMATION SYSTEM</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="lib/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="lib/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
		<link href="lib/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link href="lib/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		@media print{
			@page {margin:0;padding:0;}
			#contenthide{display: none !important;}
		}
		.ui-datepicker-calendar {
			display: none;
		}
		</style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
       <?php include $_SERVER["DOCUMENT_ROOT"]."/PROCApps/app/_view/vheader.php";?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="lib/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php 
							if(isset($_COOKIE['access']) && !empty($_COOKIE['user'])) {
								$username = $_COOKIE['iduser'];
								$dept = $_COOKIE['dept'];
								echo $username;
								echo "<span id='username' style='display:none;'>".$username."<span>";
								echo "<span id='dept' style='display:none;'>".$dept."<span>";
							}else{
								$username = "No-Name";
								echo $username;
							}
							?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <div class="sidebar-form">
                        <div class="input-group">
                            <input type="text" id="inpsearchmenu" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button id='btnsearchmenu' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                     <!--/.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
					<div id="leftMenu" class="accordion">
						
                    </div>
				</section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Information</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
					
                </section>

                <!-- Main content -->
                <section class="content">
				</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="lib/js/jquery.min.js" type="text/javascript"></script>
		<script src="lib/js/jquery-ui.min.js" type="text/javascript"></script>
		<!-- ChartJS 1.0.1 -->
		<script src="lib/js/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
		 <script src="lib/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="lib/js/AdminLTE/app.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		// ================
		//  Init Load page
		// ================
		gettingallmenu();
		// ================
		//  get data from Ajax
		// ================
		function gettingallmenu(){
			var tampilkan = $("#leftMenu");
			//tampilkan.empty();
			var hsal = sendAjaxrequest("chome","showallmenu");
			tampilkan.html(hsal);
			//alert(hsal);
		}
		
		$("#inpsearchmenu").keypress(function(){
			if ($("#inpsearchmenu").val()==""){
				gettingallmenu();
			}else{
				gettingkeymenu($("#inpsearchmenu").val());		
			}	
		});
		$("#inpsearchmenu").change(function(){
			if ($("#inpsearchmenu").val()==""){
				gettingallmenu();
			}else{
				gettingkeymenu($("#inpsearchmenu").val());		
			}	
		});
		$("#btnsearchmenu").click(function(){
			if ($("#inpsearchmenu").val()==""){
				gettingallmenu();
			}else{
				gettingkeymenu($("#inpsearchmenu").val());		
			}
		});
		function gettingkeymenu(key){
			$.ajax({
				type:"POST",
				url: "indexajax.php",
				data:"method=chome&function=showkeymenu&key="+key,
				success:function(hsal){
					$("#leftMenu").html(hsal);
				}
			});
		}
		
		});
		</script>
       

    </body>
</html>