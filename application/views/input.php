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
      <div class="progress" style="display:none;">
        <div class="indeterminate"></div>
      </div>
    </nav>
    <ul class="sidenav" id="mobile-demo">
      <li><a href="sass.html">Olah Data</a></li>
    </ul>
  </header>
  <main>
    <div class="row">
      <div class="col l10 offset-l1">
        <div class="row">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Imput Data</span>
              <div class="card-action">
                <form action="<?php echo base_url().'data/inputData'; ?>" method="post" enctype="multipart/form-data">

                    file: <input type="file" name="upcsv"><br>
                    <input type="submit" value="Submit">
                </form>
              </div>
            </div>
            <div class="card-content">
              <span class="card-title">Olah Data</span>

              <div class="card-action">
                <div class="row">
                  <div class="col l2">
                    Normalisasi Data
                  </div>
                  <div class="col l2">
                    <button type="button" name="button" class="btn" onclick="normalisasiData();">Normalisasi</button>
                  </div>
                  <div class="col 8">
                    <div class="" id="notif-normalisasi">
                      <?php if (count($normal)>0): ?>
                        Terdapat data yang belum di normalisasi
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-action">
                <div class="row">
                  <div class="col l2">
                    K-Means
                  </div>
                  <div class="col l2">
                    <div class="input-field">
                      <select class="" name="" id="nilaiK" >
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                      </select>
                      <label for="">Nilai K</label>
                    </div>
                    <?php if (count($normal)==0): ?>
                      <button type="button" name="button" class="btn" onclick="kMeans();">Kmeans</button>
                    <?php else: ?>
                      <button type="button" name="button" class="btn disabled">Kmeans</button>
                    <?php endif; ?>
                  </div>
                  <div class="col l8">
                    <div class="" id="notif-kMeans">
                      <?php if (count($kluster)>0): ?>
                        Terdapat data yang belum di klusterisasi
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
<script type="text/javascript">
  $('select').formSelect();
  $(document).ready(function(){

    console.log('ready');
  })
  function normalisasiData() {
    console.log('click');
    $('.progress').show();
    $('.btn').addClass('disabled');
    fetch("<?php echo base_url('data/normalisasiData/')?>")
      .then(response=>response.text())
      .then(text=>{
          printNotif('notif-normalisasi',text);
          printNotif('notif-kMeans','')
          console.log('jalan');
          $('.progress').hide();
          $('.btn').removeClass('disabled');
      });
  }
  function kMeans() {
    console.log('click');
    var nilaiK =$( "#nilaiK" ).val();

    console.log(nilaiK);
    $('.progress').show();
    $('.btn').addClass('disabled');
    fetch("<?php echo base_url('data/kMeans/')?>"+nilaiK)
      .then(response=>response.text())
      .then(text=>{
          printNotif('notif-normalisasi','');
          printNotif('notif-kMeans',text)
          console.log('jalan');
          $('.progress').hide();
          $('.btn').removeClass('disabled');
          
      });
  }
  function printNotif(place,data) {
    $(document).find('#'+place).html(data);
  }
</script>
