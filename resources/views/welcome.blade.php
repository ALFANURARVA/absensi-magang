<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container">

<h2 class="mt-4">Dashboard Absen Magang</h2>

<form action="/absen-masuk" method="POST" enctype="multipart/form-data">
@csrf

<input type="file" name="foto" required class="form-control">

<input type="hidden" name="lokasi" id="lokasi">

<button class="btn btn-success mt-2">
Absen Masuk
</button>

</form>

<form action="/absen-pulang" method="POST">
@csrf

<button class="btn btn-danger mt-2">
Absen Pulang
</button>

</form>

<a href="/riwayat" class="btn btn-primary mt-2">
Riwayat Absensi
</a>

<script>

navigator.geolocation.getCurrentPosition(function(pos){

document.getElementById('lokasi').value =
pos.coords.latitude+','+pos.coords.longitude

})

</script>

</body>
</html>