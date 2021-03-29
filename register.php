<!DOCTYPE html>
<html>

<body>

    <head>
        <title>onMelody</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/password.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            #search {
                margin-left: 200px;
            }

            #search_submit {
                border-color: black;
            }

            #search_submit:hover {
                color: white
            }

            #footer {

                margin-top: 30px;
            }
        </style>
    </head>
    <nav style="border-radius:5px" class="navbar navbar-expand-lg navbar-light bg-info container">
        <a class="navbar-brand text-light font-italic" href="index.php">online-Melody</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="ALLkaroke.php">Karoke Musics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="genre.php">Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="latest_tracks.php">Latest Tracks</a>
                </li>

                <li class="nav-item">
                    <?php if (isset($_SESSION['user'])) { ?>
                        <!-- <a class="nav-link text-danger" href="logount_process.php">Logout</a> -->
                        <a class="nav-link text-light" href="#">My Account</a>
                    <?php } else { ?>
                        <a class="nav-link text-light" href="login.php">Login</a>
                    <?php } ?>

                </li>
                <li class="nav-item">
                    <a class="btn btn-primary p-2 btn-sm mt-1" style="margin-left:10px" href="admin_song_upload.php">UPLOAD NEW MUSIC</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-dark my-2 my-sm-0" id="search_submit" type="submit">Search</button>
                <?php if (isset($_SESSION['user'])) { ?>
                    <a class="nav-link text-danger" href="logount_process.php">Logout</a>
                <?php } ?>
            </form>
        </div>
    </nav>

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION['message']['type'] ?>  m-3">
            <?php
            echo ($_SESSION['message']['body']);
            unset($_SESSION['message']);
            ?>
        </div>
    <?php    } ?>

    <div class="container pt-2 pt-md-5">

        <div class="row">
            <div class="col-md-6 mt-2">
                <h2 class="text-center text-dark mb-2">Register</h2>
                <form action="register_process.php" method="post">
                    <div class="row">
                        <div class="col">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required="" placeholder="Enter first name">

                        </div>
                        <div class="col">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control " id="last_name" name="last_name" required="" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="username">Email</label>
                            <input type="email" class="form-control" id="username" name="username" required="" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Password">Password</label>
                            <input type="password" minlength="8" maxlength="12" required title="8 to 12 characters" class="form-control" id="password" name="password" required="" placeholder="Password">
                            <p id="result" class="text-danger"></p>
                        </div>
                        <div class="col">
                            <label for="Password">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" required="" placeholder="Confirm Password">
                            <p id="msg"></p>
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary float-right mt-2">Register</button>
                </form>
            </div>

        </div>
    </div>
    <?php include './files/footer.php' ?>
    <script>
        $('#cpassword').keyup(function() {
            var password = $('#password').val();
            if (password != $(this).val()) {
                $('#msg').html("password does not match");
            } else {
                $('#msg').html("");
            }
        })
        $(document).ready(function() {
            $('#password').keyup(function() {
                $('#result').html(checkStrength($('#password').val()))
            })

            function checkStrength(password) {
                var strength = 0
                if (password.length < 6) {
                    $('#result').removeClass()
                    $('#result').addClass('short text-danger')
                    return 'Too short'
                }
                if (password.length > 7) strength += 1
                // If password contains both lower and uppercase characters, increase strength value.
                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
                // If it has numbers and characters, increase strength value.
                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
                // If it has one special character, increase strength value.
                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
                // If it has two special characters, increase strength value.
                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
                // Calculated strength value, we can return messages
                // If value is less than 2
                if (strength < 2) {
                    $('#result').removeClass()
                    $('#result').addClass('weak text-danger')
                    return 'Weak'
                } else if (strength == 2) {
                    $('#result').removeClass()
                    $('#result').addClass('good text-primary')
                    return 'Good'
                } else {
                    $('#result').removeClass()
                    $('#result').addClass('strong text-success')
                    return 'Strong'
                }
            }
        });
    </script>