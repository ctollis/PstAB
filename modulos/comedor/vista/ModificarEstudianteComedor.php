<?php
session_start();
require_once("../modelo/modeloComedor.php");


if (isset($_SESSION['cedula'])){  
    $UsuarioActivo = $_SESSION['cedula']; 
    $NombreUsuarioActivo = $_SESSION['username'];
}
if($_SESSION['tipo_usuario'] != "Admin")
{ 
	@session_start();
  	unset($_SESSION["cedula"]); 
  	unset($_SESSION["username"]);
  	session_destroy();
  //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
	echo "<script type='text/javascript'> 
			alert('No tiene permiso para ingresar!');
            location='../../../index.php'
            </script>"; 
} 
?>
<html>
<head>
<link rel="stylesheet" href="CSS/estilo.css"  type "text/css">
<link rel="stylesheet" href="../../recursos/iconos/style.css">
<title>Editar Usuario</title>
</head>
<body>

	<header id="main-header" >
		
		<a id="logo-header" >
		<img src="../../recursos/logo_colegio.png" id="logo_colegio">
			<span class="nombre_sitio">U.E.M Andr&eacutes Bello</span>
			<span class="nombre_seccion">Comedor</span>
		</a>
		<nav>
			<ul>
				<li><a><span class="icon-user"></span>&nbsp&nbsp<?php echo $NombreUsuarioActivo ?></a></li>
				<li><a href="../../usuario/modelo/cerrar_sesion.php" id="bt_cerrar_sesion" >Cerrar Sesi&oacuten</a></li>
			</ul>
		</nav>
		
 		</header>

 		<div id="menu" >
 			<ul>
 			<li><a href="../../pagina_principal/vista_administrador/panel_administrador.php"><span class="icon-home"></span>&nbsp&nbspInicio</a></li>
 				<li><a href="../../usuario/vista/ConsultarUsuarios.php"><span class="icon-users"></span>&nbspGesti&oacuten de Usuarios</a></li>
 				<li><a href="../../inscripcion/vista/inscripciones.php"><span class="icon-text-document"></span>&nbspInscripciones</a></li>
 				<!-- <li><a href="../../estadisticas/vista/estadisticas.php"><span class="icon-bar-graph"></span>&nbspEstadisticas Media</a></li> -->
				<li><a href="../../estadisticas_inicial_basica/vista/estadisticas.php"><span class="icon-bar-graph"></span>&nbspEstadisticas Inicial/B&aacutesica</a></li>
				<li><a href="comedor.php"><span class="icon-new-message"></span>&nbspComedor</a></li>
				
			</ul>
		</div>

		<div id="menu_opciones" >
 			<ul class="nav">
 				
 				<li><a href="RegistrarEstudianteComedor.php"><span class="icon-add-user"></span>&nbsp&nbspRegistrar Estudiante</a></li>
 				<li><a href="ConsultarEstudiantesComedor.php"><span class="icon-list"></span>&nbsp&nbspLista Estudiantes Comedor</a></li>
 				<!-- <li><a href=""><span class="icon-remove-user"></span>&nbsp&nbspEliminar Usuario</a></li> -->
 				<li><a href=""><span class="icon-magnifying-glass"></span>&nbsp&nbspConsultar Asistencia</a></li>
 				
 			</ul>
		</div>
		
<?php 	
    // Captura la variable enviada por URL	  
    $cedula=$_GET['cedula'];
		
	$Usuario = new Comedor();

	$cnn=$Usuario->conectaBD();
	if (!$cnn) { // Si la Conexion  Falla
	   $Usuario->mensajesError(1,$cnn);
	   exit();
	}	             
	
	$Consulta= $Usuario->ejecutaQuery("SELECT * from pstab.lista_comedor WHERE cedula_estu_com='$cedula'"); //Ejecuta el Query en la Base de Datos
	if (!$Consulta) {
	   $Usuario->mensajesError(2,$cnn);
	   exit();
	}

	
			
	// Se obtiene el registro del usuario a editar en el arreglo asociativo para usar los valores para llenar el formulario
	$Registro = $Usuario->recibeRegistro($Consulta);

?>

	<form method="POST" action="../controlador/proModificarEstudiante.php"> 
	

	<table width="50%" border=0  cellpadding="5" cellspacing="5" align="center" class="tabla_editar">
	<tr><td colspan="2"><span class="icon-edit"></span><span class="icon-trash"></span>Modificar o Eliminar usuarios</td></tr>
	<tr>
	<tr>
	<td>C&eacutedula</td><td><input type="text" class="form-control" size="12" maxlength="20" name="cedula_estu_com" value="<?php echo $Registro['cedula_estu_com'];?>" readonly> </td><td><span class="icon-warning"> No puede ser modificado</span></td>
	</tr>
	<td>Nombre:</td><td><input type="text" class="form-control" size="12" maxlength="20" name="nombre" value="<?php echo $Registro['nombre'];?>"></td> 
	</tr>
	<tr>
	<td>Apellido:</td><td><input type="text" class="form-control"  size="12" maxlength="20" name="apellido" value="<?php echo $Registro['apellido'];?>"></td>
	</tr> 
	<tr>
	<td>Grado:</td><td><input type="text" class="form-control"  size="12" maxlength="20" name="grado" value="<?php echo $Registro['grado'];?>"></td>
	</tr> 
	<tr ><br>
	<td align="center"><br><span class="icon-edit"></span><input type="submit" value="Modificar" name="Modificar" onClick="return confirm('Esta seguro que desea modificar el estudiante?')"></td>
	<td align="center"><br><span class="icon-trash"></span><input type="submit" value="Eliminar" name="Eliminar" onClick="return confirm('Esta seguro que desea eliminar el estudiante?')"></td>
	</tr>
	<!-- <tr><td><a href='ConsultarUsuarios.php'><span class="icon-arrow-left"></span>&nbspVolver</a></td></tr> -->
	</table>
	</fieldset>
	</form> 
	
</body>
</html>