<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if ($_SESSION['message'] != "") {
?>
        <script>
            alert($_SESSION['message']);
        </script>
    <?php
    }
    $_SESSION['message'] = "";

    ?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Admin manage Users</title>
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
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <!-- Graph CSS -->
        <link href="css/font-awesome.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="js/jquery-2.1.4.min.js"></script>
        <!-- //jQuery -->
        <!-- tables -->
        <link rel="stylesheet" type="text/css" href="css/table-style.css" />
        <link rel="stylesheet" type="text/css" href="css/basictable.css" />
        <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#table').DataTable({});

            });
        </script>
        <!-- //tables -->
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
        <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- lined-icons -->
        <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
        <!-- //lined-icons -->
    </head>

    <body>
        <div class="page-container">
            <!--/content-inner-->
            <div class="left-content">
                <div class="mother-grid-inner">
                    <!--header start here-->
                    <?php include('./includes/header.php'); ?>
                    <div class="clearfix"> </div>
                </div>
                <!--heder end here-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Songs</li>
                </ol>
                <div class="agile-grids">
                    <!-- tables -->

                    <div class="agile-tables">
                        <div class="w3l-table-info">
                            <div class="container">
                                <h2>Manage Songs</h2>
                                <table id="table" class="table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Song Name</th>
                                            <th>Song</th>
                                            <th>Uploaded By</th>
                                            <th>User ID </th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sql = "SELECT * from songs";
                                        $query = mysqli_query($conn, $sql);
                                        $cnt = 1;
                                        if (mysqli_num_rows($query) > 0) {
                                            while ($result = $query->fetch_assoc()) {                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo $result['song_name'] ?></td>
                                                    <td>
                                                        <audio controls>
                                                            <source src="horse.ogg" type="audio/ogg">
                                                            <source src="./../uploads/<?php echo $result['song_mp3']; ?>" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>

                                                    </td>
                                                    <?php
                                                    $id = $result['user_id'];
                                                    $sql2 = "SELECT first_name,last_name,username from users where `user_id` ='$id'";
                                                    $query2 = mysqli_query($conn, $sql2);
                                                    $arr = $query2->fetch_assoc();
                                                    // $name = $arr['first_name'] . " " . $arr['last_name'];

                                                    ?>
                                                    <td><?php echo htmlentities($arr['first_name']) . " " . htmlentities($arr['last_name']); ?></td>
                                                    <td><?php echo htmlentities($result['user_id']); ?><input type="hidden" id="song_id" value="<?php echo $result['song_id'] ?>"></td>


                                                    <?php
                                                    if ($result['verify'] == 0) {
                                                    ?>
                                                        <td colspan="2"><a href="approve.php?user_name=<?php echo $arr['username'] ?>&song_id=<?php echo $result['song_id'] ?>&action=1" class="btn btn-info">Approve</a>
                                                            <a href="delete_songs.php?user_name=<?php echo $arr['username'] ?>&song_id=<?php echo ($result['song_id']); ?>" class="btn btn-danger" title="">Reject</a>
                                                        </td>
                                                    <?php
                                                    } else {
                                                        echo "<td colspan='2'>APPROVED"; ?>
                                                        <!-- <a href="approve.php?user_name=<?php echo $arr['username'] ?>&song_id=<?php echo $result['song_id'] ?>&action=0" class="btn btn-danger">Reject</a> -->
                                                        <a href="delete_songs.php?user_name=<?php echo $arr['username'] ?>&song_id=<?php echo ($result['song_id']); ?>" class="btn btn-danger" title="">Delete</a></td>

                                                    <?php }
                                                    ?>

                                                </tr>
                                        <?php $cnt = $cnt + 1;
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </table>


                    </div>
                    <!-- script-for sticky-nav -->
                    <script>
                        $(document).ready(function() {
                            var navoffeset = $(".header-main").offset().top;
                            $(window).scroll(function() {
                                var scrollpos = $(window).scrollTop();
                                if (scrollpos >= navoffeset) {
                                    $(".header-main").addClass("fixed");
                                } else {
                                    $(".header-main").removeClass("fixed");
                                }
                            });

                        });
                    </script>
                    <!-- /script-for sticky-nav -->
                    <!--inner block start here-->
                    <div class="inner-block">

                    </div>
                    <!--inner block end here-->
                    <!--copy rights start here-->
                    <?php include('includes/footer.php'); ?>
                    <!--COPY rights end here-->
                </div>
            </div>
            <!--//content-inner-->
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

    </body>
    <script>
        $(document).on('click', '#approved', function(e) {
            e.preventDefault();
            var song_id = $('#song_id').val();
            var action = 1;
            $.ajax({
                url: "approve.php",
                type: "post",

                data: {
                    action: action,
                    song_id: song_id
                },
                success: function(data) {
                    window.location = 'manage_songs.php';
                }
            });
        });
        $(document).on('click', '#reject', function(e) {
            e.preventDefault();
            var song_id = $('#song_id').val();
            var action = 0;
            $.ajax({
                url: "approve.php",
                type: "post",

                data: {
                    action: action,
                    song_id: song_id
                },
                success: function(data) {
                    window.location = 'manage_songs.php';
                }
            })
        })
    </script>

    </html>
<?php } ?>