<?php include("conex.php");
include("conf/sessionconf.php");
	if (!(isset($_SESSION['email'])))

 { header("Location: index.php");
 exit();    }
$link=Conectarse(); 
$id=$_GET['id'];

$result=mysqli_query($link, "select * from persona where id='$id'");?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<HTML>
	 <title>Modificar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #5F9F9F;
}
.Estilo1 {
	font-size: medium;
	font-weight: bold;
}
.Estilo2 {
	color: #000066;
	font-family: Verdana;
	font-size: 15px;
}

.Estilo3 {font-family: Verdana}
.Estilo4 {font-size: 13px}
.Estilo5 {font-family: Verdana; font-size: 13px; }

td { font-size: 12px; }
-->
</style>
   
   </head><body bgcolor="#5F9F9F"><H1 align="center" class="Estilo2">Persona</H1><TABLE BORDERCOLOR="#0000FF" BORDER=0 CELLSPACING=1 CELLPADDING=1 BGCOLOR="#cccccc" align="center">
<FORM ACTION="modificarpersona3.php" method="post">
<?php 
while($row = mysqli_fetch_array($result)){?>
<tr><td>edad</td><td><input align="left" type="value" name="edad" value="<?php echo $row['edad']?>"/></td></tr>
<tr><td>nombre</td><td><input align="left" type="value" name="nombre" value="<?php echo $row['nombre']?>"/></td></tr>
<?php }?><tr><td><input type="hidden" name="id" value="<?php echo $id; ?>"/></td></tr>
<tr><td><INPUT align= "left" TYPE="submit" NAME="accion2" VALUE="Enviar Datos"></td></tr>
</FORM>
</table>
</body>
</html>