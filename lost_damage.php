<?php require 'app/controller.php'; session_start(); ?>
<?php $inventory = $connect -> viewAllLost(); ?>
<?php $viewAllProd = $connect -> ViewAllProducts(); ?>
<?php
if(!isset($_SESSION['logged_in'])){
	header("location: index.php");
}

	// Deducting products from Lost Products
	if(isset($_POST['submit_lost'])){

		$connect -> id =  $_POST['prod_name'];
		$connect -> no_of_lost = $_POST['no_of_lost'];
		$connect -> type = $_POST['type'];

		if(!empty($_POST['prod_name']) || !empty($_POST['no_of_lost']) || !empty($_POST['type'])){

			$product = $connect -> ViewSingleProduct();
			while($view = mysqli_fetch_assoc($product)){

				// Add to inventory
				$connect -> id = $view['prod_id'];
				$connect -> quantity = $_POST['no_of_lost'];
				$connect -> status = "Lost / Damage Item";
				$connect -> fullname = $_SESSION['fname'].' '.$_SESSION['lname'];
				$connect -> date_added = date('m-d-Y - h:i:s A');				
				$connect -> AddToInventory();

				// Update Product Details
				$new = ($view['quantity'] - $_POST['no_of_lost']);
				$connect -> new_quantity = $new;
				$connect -> UpdateProductQuantity();						

				// Add to Lost/Damage Table
				$connect -> addLostDamage();					
			}

				echo '<script>alert("Successfully added.")</script>';
				echo "<meta http-equiv='refresh' content='0;url=lost_damage.php'>";						
		}
		else{
				echo '<script>alert("Please don\'t leave it blank.")</script>';
				echo "<meta http-equiv='refresh' content='0;url=lost_damage.php'>";			
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Order & Inventory | Dashboard</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="home.php" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							Order and Inventory
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/images/<?php echo $_SESSION['profile_img'];?>">
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $_SESSION['fname']; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

								<li>
									<a href="profile.php?user_id=<?php echo $_SESSION['user_id'];?>">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="logout.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>
 
<!-- 				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div>
 -->
				<ul class="nav nav-list">
					<li class="">
						<a href="home.php">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="products.php">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text"> Products </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-basket"></i>
							<span class="menu-text"> Orders </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="active">
								<a href="orders_pending.php">
									<i class="menu-icon fa fa-caret-right"></i>
									<span class="fa fa-warning"></span>&nbsp;
									Pending Orders
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="orders_success.php">
									<i class="menu-icon fa fa-caret-right"></i>
									<span class="fa fa-check"></span>
									Successful Orders
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="orders_cancelled.php">
									<i class="menu-icon fa fa-caret-right"></i>
									<span class="fa fa-hand-stop-o"></span>
									Cancelled Orders
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="inventory.php">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Inventory </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="sales.php">
							<i class="menu-icon fa fa-money"></i>
							<span class="menu-text"> Sales </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="active">
						<a href="lost_damage.php">
							<i class="menu-icon fa fa-trash"></i>
							<span class="menu-text"> Lost / Damage </span>
						</a>

						<b class="arrow"></b>
					</li>

				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="home.php">Home</a>
							</li>
							<li class="active">Lost / Damage</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form method="POST" class="form-search">
								<button class="btn btn-xs btn-success" name="export_lost">
									Export Lost to CSV
								</button>
							</form>
						</div>
						
<!-- 						<div class="nav-search">
							<span class="input-icon">
							<label>Search Date: </label>
							<input type="date" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
							<button name="search_button" class="ace-icon fa fa-search nav-search-icon"></button>
							</span>							
						</div>			 -->

					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								Lost / Damage
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									No. of Lost and Damage Stocks&nbsp;&nbsp;
									<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#lost_damage">
										Add Lost/Damage
									</button>									
								</small>
							</h1>
						</div><!-- /.page-header -->

						<!-- ADD PRODUCT MODAL -->
						<div class="modal fade" id="lost_damage" tab-index="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<center>
											<h3>Lost Product</h3>
										</center>	
									</div>

									<div class="modal-body">
										<form method="POST" autocomplete="off" enctype="multipart/form-data">
											<input type="hidden" name="size" value="1000000">
											<label>Product Name</label>
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-shopping-cart"></span>
												</div>
												<select name="prod_name" class="form-control">
													<option>- - -</option>
													<?php while($view = mysqli_fetch_assoc($viewAllProd)){ ?>
													<option value='<?php echo $view["prod_id"]; ?>'><?php echo $view['prod_name']; ?></option>
													<?php } ?>
												</select>	
											</div>

											<label>No. of Lost Product</label>
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-shopping-cart"></span>
												</div>
												<input type="text" name="no_of_lost" class="form-control">
											</div>											

											<label>Type</label>
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-shopping-cart"></span>
												</div>
												<select class="form-control" name="type">
													<option>- - -</option>
													<option>Lost</option>
													<option>Damaged</option>
												</select>
											</div>											

											<br>
											<button class="btn btn-success" name="submit_lost">Submit!</button>																
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- END OF ADD PRODUCT MODAL -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													<th>Product</th>
													<th>Price</th>
													<th class="hidden-480">No. Remaining Stocks</th>
													<th class="hidden-480">Total Price of Remaining Stocks</th>
													<th>
														<span class="fa fa-shopping-cart">&nbsp;</span>	
														No. of Lost / Damage Stocks
													</th>
													<th>
														Total Price of Lost / Damage Stocks
													</th>
												</tr>
											</thead>

											<tbody>
												<?php if(mysqli_num_rows($inventory) > 0) { 
													while($view = mysqli_fetch_assoc($inventory)){
												?>
													<tr>
														<td><?php echo $view['prod_name']; ?></td>
														<td>&#8369; <?php echo number_format($view['prod_price'], 2)?></td>
														<td><?php echo $view['remaining_quantity']; ?></td>
														<td>&#8369; <?php echo number_format($view['total_price_remaining']); ?></td>
														<td><?php echo $view['total_lost'];?></td>
														<td>&#8369; <?php echo number_format($view['total_price_of_lost']); ?></td>
													</tr>
												<?php } } else {?>
													<tr>
														<td colspan="6">
															<center>
																<h3>No data to show</h3>
															</center>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>				
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Order & Inventory</span>
							Application &copy; 2017-2018
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: ace.vars['old_ie'] ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
	</body>
</html>
