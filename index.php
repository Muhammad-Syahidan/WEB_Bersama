<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/index.css">
  <title>Web 3B</title>
</head>
<body>

<div>
  <div class="text-center view-login" id="welcome-box">
    <h2>Selamat Datang</h2>
    <p class="text-info">Web 3B</p>
    <button onclick="document.getElementById('id01').style.display='flex'; document.getElementById('welcome-box').style.display='none';">Login</button>
  </div>
</div>
  
<div id="id01" class="modal">
  
    <form class="modal-content animate" data-bs-theme="dark" action="assets/ceklogin.php" method="post"><div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'; document.getElementById('welcome-box').style.display='block';" class="close" title="Close Modal">&times;</span><img src="img/LogoV.gif" alt="Avatar" class="avatar">
      </div>

    <div class="container">
      <label for="auth">Authorize</label>
      <select class="form-select" aria-label="Default select example" name="auth" id="auth">
        <option value="Administrator">Administrator</option>
        <option value="Gudang">Gudang</option>
        <option value="Penjualan">Penjualan</option>
        <option value="User">Pemasaran</option>
        <option value="Ahli">Ahli</option>

      </select>

      <label for="user"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="user" required>

      <label for="pasw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pasw" required>
        
      <button type="submit">Login</button>
    </div>



<script>

var modal = document.getElementById('id01');



window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    document.getElementById('welcome-box').style.display='block';
  }
}
</script>

</body>
</html>
