<?php
session_start();
include('includes/db.php');
include('includes/root_link.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Admin Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript">
			addEventListener("load", function() {
				setTimeout(hideURLbar, 0);
			}, false);

			function hideURLbar() {
				window.scrollTo(0, 1);
			}
		</script>
		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<!-- Custom CSS -->
		<link href="./css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css" />
		<!-- Graph CSS -->
		<link href="css/font-awesome.css" rel="stylesheet">
		<!-- jQuery -->
		<script src="js/jquery-2.1.4.min.js"></script>
		<!-- //jQuery -->
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

		<!-- lined-icons -->
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<!-- //lined-icons -->
	</head>

	<body>
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include './includes/header.php' ?>
					<?php include './includes/sidebarmenu.php' ?>

					<?php
					include '../files/functions.php';

					$s = count(get_all_songs($conn));
					?>


					<div class="clearfix"></div>
				</div>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo $root_link_admin; ?>dashboard.php">Home</a><i class="fa fa-angle-right"></i>DashBoard</li>
				</ol>
				<!--//four-grids here-->
				<div class="col col-md-12">
					<div class="row">
						<div class="col col-md-5">
							<h4>Today Stats:</h4>
							Visits<span class="pull-right strong">
								<?php
								$visit = mysqli_query($conn, "SELECT count(*) as counts from views");
								$v = $visit->fetch_assoc();
								echo $v['counts'];
								$views = $v['counts'];
								?>
							</span>
							<a href="<?php $root_link_admin;?>dashboard.php"><div class="progress">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "$views%"; ?>"><?php echo $v['counts']; ?></div>
							</div></a>

							Users<span class="pull-right strong">
								<?php
								$fetch_users = mysqli_query($conn, "SELECT count(*) as uc from users");
								$uc = $fetch_users->fetch_assoc();
								$users = $uc['uc'];
								echo $users;
								?></span>
							<a href="<?php $root_link_admin;?>manage-users.php"><div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo "$users%" ?>"><?php echo $users ?></div>
							</div></a>

							Downloads<span class="pull-right strong">
								<?php
								$fetch_downloads = mysqli_query($conn, "SELECT count(*) as uc from downloads");
								$ud = $fetch_downloads->fetch_assoc();
								$download = $ud['uc'];
								echo $download;
								?>
							</span>
							<a href="<?php $root_link_admin;?>dashboard.php"><div class="progress">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($download / $s) . "%"; ?>"><?php echo $download ?></div>
							</div></a>
						</div>

					</div>
				</div>

				<div class="inner-block">

				</div>
			</div>
			<!--inner block end here-->
			<!--copy rights start here-->
			<!-- <?php include('includes/footer.php'); ?> -->


			<!--/sidebar-menu-->
			<?php include('includes/sidebarmenu.php'); ?>
			<div class="clearfix"></div>
		</div>
		<script>
			var toggle = true;

			$(".sidebar-icon").click(function() {
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({
						"position": "absolute"
					});
				} else {
					$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function() {
						$("#menu span").css({
							"position": "relative"
						});
					}, 400);
				}

				toggle = !toggle;
			});
		</script>
		<!--js -->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- /Bootstrap Core JavaScript -->
		<!-- morris JavaScript -->
		<script src="js/raphael-min.js"></script>
		<script src="js/morris.js"></script>
		<script>
			$(document).ready(function() {
				//BOX BUTTON SHOW AND CLOSE
				jQuery('.small-graph-box').hover(function() {
					jQuery(this).find('.box-button').fadeIn('fast');
				}, function() {
					jQuery(this).find('.box-button').fadeOut('fast');
				});
				jQuery('.small-graph-box .box-close').click(function() {
					jQuery(this).closest('.small-graph-box').fadeOut(200);
					return false;
				});

				//CHARTS
				function gd(year, day, month) {
					return new Date(year, month - 1, day).getTime();
				}

				graphArea2 = Morris.Area({
					element: 'hero-area',
					padding: 10,
					behaveLikeLine: true,
					gridEnabled: false,
					gridLineColor: '#dddddd',
					axes: true,
					resize: true,
					smooth: true,
					pointSize: 0,
					lineWidth: 0,
					fillOpacity: 0.85,
					data: [{
							period: '2014 Q1',
							iphone: 2668,
							ipad: null,
							itouch: 2649
						},
						{
							period: '2014 Q2',
							iphone: 15780,
							ipad: 13799,
							itouch: 12051
						},
						{
							period: '2014 Q3',
							iphone: 12920,
							ipad: 10975,
							itouch: 9910
						},
						{
							period: '2014 Q4',
							iphone: 8770,
							ipad: 6600,
							itouch: 6695
						},
						{
							period: '2015 Q1',
							iphone: 10820,
							ipad: 10924,
							itouch: 12300
						},
						{
							period: '2015 Q2',
							iphone: 9680,
							ipad: 9010,
							itouch: 7891
						},
						{
							period: '2015 Q3',
							iphone: 4830,
							ipad: 3805,
							itouch: 1598
						},
						{
							period: '2015 Q4',
							iphone: 15083,
							ipad: 8977,
							itouch: 5185
						},
						{
							period: '2016 Q1',
							iphone: 10697,
							ipad: 4470,
							itouch: 2038
						},
						{
							period: '2016 Q2',
							iphone: 8442,
							ipad: 5723,
							itouch: 1801
						}
					],
					lineColors: ['#ff4a43', '#a2d200', '#22beef'],
					xkey: 'period',
					redraw: true,
					ykeys: ['iphone', 'ipad', 'itouch'],
					labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
					pointSize: 2,
					hideHover: 'auto',
					resize: true
				});


			});
		</script>
	</body>

	</html>
<?php } ?>