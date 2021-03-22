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
                margin-left: 370px;
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
        <a class="navbar-brand text-light font-italic" href="index.php">onMelody</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Latest Tracks</a>
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
                        <div class="col">
                            <label for="username">Email</label>
                            <input type="email" class="form-control" id="username" name="username" required="" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Password">Password</label>
                            <input type="password" minlength="8" maxlength="12" required title="8 to 12 characters" class="form-control" id="password" name="password" required="" placeholder="Password">

                        </div>
                        <div class="col">
                            <label for="Password">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" required="" placeholder="Confirm Password">
                            <p id="msg" class="text-danger"></p>
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary float-right mt-2">Register</button>
                </form>
            </div>
            <div class="col-md-6 pt-5 mt-5">
                <!-- <div class="" style="border:dotted"> -->
                <div class="req-container">
                    <p class="text-dark h4">Password:</p>
                    <ul>
                        <li id="req-length"><span class="glyphicon glyphicon-remove-circle"> </span>&nbsp6 characters</li>
                        <li id="req-upper"><span class="glyphicon glyphicon-remove-circle"> </span>&nbspone uppercase</li>
                        <li id="req-lower"><span class="glyphicon glyphicon-remove-circle"> </span>&nbspone lowercase</li>
                        <li id="req-digit"><span class="glyphicon glyphicon-remove-circle"> </span>&nbspone digit</li>
                        <li id="req-special"><span class="glyphicon glyphicon-remove-circle"> </span>&nbspone special character</li>
                    </ul>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
    <?php include './files/footer.php' ?>
    <script>
        $(function() {
            "user strict";

            /**
             * start password checking logic
             */
            password.init();
            $('#cpassword').keyup(function() {
                var password = $('#password').val();
                if (password != $(this).val()) {
                    $('#msg').html("password does not match");
                } else {
                    $('#msg').html("");
                }
            })
        });

        /**
         * Hold functions related to client side password validation
         */
        var password = (function() {
            "use strict";

            var minPasswordLength = 6;

            var _hasLowerCase = /[a-z]/;
            var _hasUpperCase = /[A-Z]/;
            var _hasDigit = /\d/;
            // match special characters except space
            var _hasSpecial = /(_|[^\w\d ])/;

            var password = [];
            var password2 = [];

            var hasEightCharsListItem,
                hasUpperCaseListItem,
                hasLowerCaseListItem,
                hasSpecialListItem,
                hasDigitListItem;

            // Enforces that password2 = password, and display an error message if it does not
            var mustMatch = function() {

                if (password.val() !== password2.val()) {
                    // show not matching error
                    password2.addClass('invalid');
                    return false;
                }

                password2.removeClass('invalid');
                return true;
            };

            // check validation and adjust classes
            var checkAndSwitchClasses = function(has, $element) {
                if (has) {
                    $element.find(".glyphicon").removeClass("glyphicon-remove-circle").removeClass('invalid').addClass('valid').addClass("glyphicon-ok-circle");
                    return true;
                }

                $element.find(".glyphicon").removeClass("glyphicon-ok-circle").removeClass('valid').addClass('invalid').addClass("glyphicon-remove-circle");
                return false;

            };

            // Enforces server side password rules on the client for convenience
            var enforceRules = function() {

                $('.invalid').removeClass('invalid');

                var pw = password.val().toLowerCase();

                var hasEight = pw.length >= minPasswordLength;
                var hasLower = _hasLowerCase.test(password.val());
                var hasUpper = _hasUpperCase.test(password.val());
                var hasDigit = _hasDigit.test(password.val());
                var hasSpecial = _hasSpecial.test(password.val());

                checkAndSwitchClasses(hasEight, hasEightCharsListItem);
                checkAndSwitchClasses(hasLower, hasLowerCaseListItem);
                checkAndSwitchClasses(hasUpper, hasUpperCaseListItem);
                checkAndSwitchClasses(hasDigit, hasDigitListItem);
                checkAndSwitchClasses(hasSpecial, hasSpecialListItem);

                if (pw.length === 0) $('.invalid').removeClass('invalid');

                // don't move forward until the password is actually *good*
                /*        if (!(hasEight && hasLower && hasUpper && hasDigit && hasSpecial)) {
                            return false;
                        }*/

                if (mustMatch() && (hasEight && hasLower && hasUpper && hasDigit && hasSpecial)) {
                    $('#submit').addClass('valid');
                } else {
                    $('#submit').removeClass('valid');
                }
            };

            return {

                init: function() {
                    // hook all password/password2 fields on a page
                    password = $('#password');
                    password2 = $('#cpassword');

                    // hook all req list items
                    hasEightCharsListItem = $('#req-length');
                    hasUpperCaseListItem = $('#req-upper');
                    hasLowerCaseListItem = $('#req-lower');
                    hasSpecialListItem = $('#req-special');
                    hasDigitListItem = $('#req-digit');

                    password.keyup(enforceRules);
                    password2.keyup(enforceRules);

                }
            };
        }());
    </script>