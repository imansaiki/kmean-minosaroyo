<!DOCTYPE html>
<?php if(!empty($this->session->flashdata('msg'))){
        echo $this->session->flashdata('msg');
      }
?>
  <html>
    <form action="<?php echo base_url().'data/inputData'; ?>" method="post" enctype="multipart/form-data">

        file: <input type="file" name="upcsv"><br>
        <input type="submit" value="Submit">
    </form>
  </html>
