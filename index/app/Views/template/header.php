<html>

<head>
    <title>SOStudent</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</head>
<style>
        #main {
            height: 100%;
            }

        footer {
            position: relative;
            left: 0;
            right: 0;
            margin-top: auto;
            }
</style>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo base_url() ?>">SOStudent</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" id="navigationBar">
                <a href="<?php echo base_url(); ?>login"> Home </a>
                <?php if (session()->has('username')) { ?>
                    <a href="<?php echo base_url(); ?>profile"> Profile </a>
                <?php } ?>
                </li>    
            </ul>
            <ul class="navbar-nav my-lg-0">

        </div>
        <form class="form-inline my-2 my-lg-0" style="visibility: hidden;">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <?php if (session()->get('username')) { ?>
            <a class="mx-4" href="<?php echo base_url(); ?>login/logout"> Logout </a>
        <?php } else { ?>
            <a class="mx-4" href="<?php echo base_url(); ?>login"> Login </a>
        <?php } ?>
    </nav>
    <div class="container">

