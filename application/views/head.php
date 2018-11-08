<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="<?php echo base_url(); ?>assets/js/d3.v5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dimple.v2.3.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jsFunc/drawingFunc.js"></script>
  </head>
  <body>
    <?php if(!empty($this->session->flashdata('msg'))){
            echo $this->session->flashdata('msg');
          }
    ?>
    <header>
      <nav class="blue darken-1">
        <div class="container">
          <div class="nav-wrapper">
            <a href="<?php echo base_url('main/c2')?>" class="brand-logo">Logo</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a href="<?php echo base_url('data/input')?>">Olah Data</a></li>
            </ul>
          </div>
        </div>
        <div class="progress" style="display:none;">
          <div class="indeterminate"></div>
        </div>
      </nav>

      <ul class="sidenav" id="mobile-demo">
        <li><a href="sass.html">Olah Data</a></li>
      </ul>

    </header>
