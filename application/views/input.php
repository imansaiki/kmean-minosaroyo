<!DOCTYPE html>
  <html>
    <form action="<?php echo base_url().'data/inputData'; ?>" method="post" enctype="multipart/form-data">
        bulan: <input type="text" name="bulan"><br>
        tahun: <input type="number" name="tahun"><br>
        file: <input type="file" name="upcsv"><br>
        <input type="submit" value="Submit">
    </form>
  </html>
