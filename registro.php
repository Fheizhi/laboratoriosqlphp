<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Registro</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Formulario de Registro</h2>
    <form action="registro.php" method="POST">
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>
      
      <label for="apellido1">Primer Apellido:</label>
      <input type="text" id="apellido1" name="apellido1" required>
      
      <label for="apellido2">Segundo Apellido:</label>
      <input type="text" id="apellido2" name="apellido2" required>
      
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>
      
      <label for="login">Login:</label>
      <input type="text" id="login" name="login" required>
      
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" maxlength="8" minlength="4" required>
      
      <input type="submit" value="Enviar">
    </form>
  </div>

  <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "basededatos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($password)) {
  die("Todos los campos son obligatorios. Por favor, vuelve e introduce todos los datos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die("El correo electrónico no es válido. Por favor, introduce un correo electrónico válido.");
}

if (strlen($password) < 4 || strlen($password) > 8) {
  die("La contraseña debe tener entre 4 y 8 caracteres.");
}

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  die("El correo electrónico ya está registrado. Por favor, utiliza otro correo electrónico.");
}

$sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, login, password)
        VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$password')";

if ($conn->query($sql) === TRUE) {
  echo "Registro completado con éxito.";
} else {
  echo "Error al registrar los datos: " . $conn->error;
}

$conn->close();
?>