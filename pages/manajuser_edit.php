<?php
include "assets/koneksi.php";

    $id = $_GET["id"];

    $sql = "SELECT * FROM user_list WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
            $user = $row['user'];
            $pasw = $row['pasw'];
            $avatar = $row['avatar'];
            $auth = $row['auth'];
            $keterangan = $row['keterangan'];
            $ava = $row['avatar'];
        }
    }

?>

<form action="pages/manajuser_editsave.php?id=<?php echo $id ?>" &ava="<?php echo $ava ?>" method="POST" enctype="multipart/form-data">

    <div class="mb-3 mt-3">
        <label for="user" class="form-label">user:</label>
        <input type="text" class="form-control" id="user" placeholder="Masukkan user anda" name="user" value="<?php echo $user; ?>">
    </div>

    <div class="mb-3">
        <label for="pasw" class="form-label">Password:</label>
        <input type="password" class="form-control" id="pasw" placeholder="Masukan password anda " name="pasw" value="<?php echo $pasw; ?>" >
    </div>

    <div class="mb-3">
        <label for="auth" class="form-label">Authorize: <b> <?php echo $auth; ?> </b></label>
        <select class="form-select" id="auth" name="auth">
            <option>Administrator</option>
            <option>Gudang</option>
            <option>Penjualan</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="avatar" class="form-label">Avatar: </label>
        <input type="file" class="form-control" id="avatar" name="avatar" value="<?php echo $avatar?>">
        <img src="img/<?php echo $avatar ?>" alt="" width = "20%"> 
    </div>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan; ?>">
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-primary">Reset</button>

    <a href="main.php?p=manajusers" class="btn btn-warning">Manajemen User</a>

</form>