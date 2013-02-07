<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form View i </title>
</head>

<body>


<?php echo validation_errors(); ?>

<form action="{base}form" method="post" accept-charset="utf-8">

<h5>Kullanıcı Adı: </h5>
<input type="text" name="username" value="" size="50" />

<h5>Şifre</h5>
<input type="text" name="password" value="" size="50" />

<h5>Şifre Tekrar</h5>
<input type="text" name="passconf" value="" size="50" />

<h5>E-Posta</h5>
<input type="text" name="email" value="" size="50" />

<div><input type="submit" value="Gönder" /></div>
</form>

</body>
</html>