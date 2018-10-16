<!DOCTYPE html>
<?php if(!empty($this->session->flashdata('msg'))){
        echo $this->session->flashdata('msg');
      }
?>
<html>
<head>
  <meta charset="utf-8">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <header>
    <nav>
      <div class="container">
        <div class="nav-wrapper">
          <a href="<?php echo base_url("main/c2")?>" class="brand-logo">Logo</a>
          <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="active"><a href="<?php echo base_url('data/input')?>" >Olah Data</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
      <li><a href="sass.html">Olah Data</a></li>
    </ul>
  </header>
  <main>
    <form action="<?php echo base_url().'data/inputData'; ?>" method="post" enctype="multipart/form-data">

        file: <input type="file" name="upcsv"><br>
        <input type="submit" value="Submit">
    </form>
  </main>
</body>
</html>
