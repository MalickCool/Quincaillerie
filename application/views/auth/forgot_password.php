<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?= base_url("/assets/vendor/bootstrap/css/bootstrap.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/vendor/font-awesome/css/font-awesome.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/vendor/magnific-popup/magnific-popup.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/vendor/bootstrap-datepicker/css/datepicker3.css") ?>" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/stylesheets/theme.css") ?>" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/stylesheets/skins/default.css") ?>" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/stylesheets/theme-custom.css") ?>">

    <!-- Head Libs -->
    <script src="<?= base_url("assets/vendor/modernizr/modernizr.js") ?>"></script>

</head>
<body>
<!-- start: page -->
<section class="body-sign">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="<?= base_url("assets/images/logo.png") ?>" height="54" alt="" />
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> <?php echo lang('forgot_password_heading');?></h2>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <p class="m-none text-semibold h6"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                </div>

                <?php echo form_open("auth/forgot_password");?>
                    <div class="form-group mb-none">
                        <div class="input-group">
                            <input name="identity" type="email" id="identity" placeholder="E-mail" class="form-control input-lg" />
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-lg" type="submit">Envoyer</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2019. Tous droits Reservé. Template  <a href="">ESC Technologie</a>.</p>
    </div>
</section>
<!-- end: page -->

<!-- Vendor -->
<script src="<?= base_url("assets/vendor/jquery/jquery.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap/js/bootstrap.js") ?>"></script>
<script src="<?= base_url("assets/vendor/nanoscroller/nanoscroller.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js") ?>"></script>
<script src="<?= base_url("assets/vendor/magnific-popup/magnific-popup.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery-placeholder/jquery.placeholder.js") ?>"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?= base_url("assets/javascripts/theme.js") ?>"></script>

<!-- Theme Custom -->
<script src="<?= base_url("assets/javascripts/theme.custom.js") ?>"></script>

<!-- Theme Initialization Files -->
<script src="<?= base_url("assets/javascripts/theme.init.js") ?>"></script>

</body>
</html>