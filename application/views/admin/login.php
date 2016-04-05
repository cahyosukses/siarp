<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SYSCMS | LOGIN</title>
    <link rel="icon" href="<?php echo media_url('ico/favicon.jpg'); ?>" type="image/x-icon">

    <!-- Bootstrap core CSS -->

    <link href="<?php echo media_url() ?>/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo media_url() ?>/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo media_url() ?>/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?php echo media_url() ?>/css/custom.css" rel="stylesheet">

    <script src="<?php echo media_url() ?>/js/jquery.min.js"></script>

        <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
            <![endif]-->

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
              <![endif]-->

          </head>

          <body role="login"><br><br><br>

            <div class="col-md-12 col-lg-3 col-sm-12 col-xs-12 center-margin">

                <div class="panel panel-default">

                  <div class="panel-body">
                    <section class="login_content">
                        <form role="form" action="<?php echo site_url('admin/auth/login') ?>" method="post">
                            <?php
                            echo form_open(current_url(), array('role' => 'form', 'class' => 'form-signin'));
                            if (isset($_GET['location'])) {
                                echo '<input type="hidden" name="location" value="';
                                if (isset($_GET['location'])) {
                                    echo htmlspecialchars($_GET['location']);
                                }
                                echo '" />';
                            }
                            ?>
                            <h1>Administrator</h1>                            
                            <div class="row">
                            <div class="center-block"> <img width=270 height=250 src="<?php echo media_url() ?>/images/unindra.png" alt="">
                                </div>
                                <hr>
                                <div>
                                    <input autofocus type="text" class="form-control" placeholder="Username" name="username" required="" />
                                </div>
                                <div>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required="" />
                                </div>
                                <div>
                                    <button class="sun-flower-button" type="submit" >Login</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="separator">

                                    <div class="clearfix"></div>
                                    <br />
                                    <div>
                                        <p>© <?php echo pretty_date(date('Y-m-d'), 'Y',FALSE) ?> All Rights Reserved Privacy and Terms</p>
                                    </div>
                                </div>
                            </form>
                            <!-- form -->
                        </section>
                        <!-- content -->
                    </div>
                </div>
            </div>

        </body>

        </html>