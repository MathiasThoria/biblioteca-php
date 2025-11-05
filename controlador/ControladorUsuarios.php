<?php
require_once(__DIR__ . "/../modelo/Usuario.php");

class ControladorUsuarios
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    // LISTAR USUARIOS
    public function listar($get = [], $post = [])
    {
        $usuarios = $this->usuarioModel->getAll();
        include(__DIR__ . "/../vista/VistaUsuarios.php");
    }

    // VER USUARIO POR CÉDULA
    public function ver($get = [])
    {
        $cedula = $get['cedula'] ?? null;
        if ($cedula) {
            $usuario = $this->usuarioModel->getByCedula($cedula);
            include(__DIR__ . "/../vista/VistaUsuarioDetalle.php");
        } else {
            echo "No se especificó un usuario.";
        }
    }

    // CREAR NUEVO USUARIO
    public function crear($get = [], $post = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'cedula'  => $post['cedula'],
                'nombre'  => $post['nombre'],
                'apellido'=> $post['apellido'],
                'contrasena' => $post['contrasena'],
                'perfil'     => $post['perfil']
            ];
            $this->usuarioModel->create($datos);
            header("Location: index.php?controlador=usuarios&accion=listar");
            exit;
        } else {
            $usuario = null; // para el formulario vacío
            include(__DIR__ . "/../vista/formularioUsuario.php");
        }
    }

    // EDITAR USUARIO
    public function editar($get = [], $post = [])
    {
        $cedula = $get['cedula'] ?? null;
        if (!$cedula) {
            echo "No se especificó un usuario.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'nombre'   => $post['nombre'],
                'apellido' => $post['apellido']
            ];
            $this->usuarioModel->update($cedula, $datos);
            header("Location: index.php?controlador=usuarios&accion=listar");
            exit;
        } else {
            $usuario = $this->usuarioModel->getByCedula($cedula);
            include(__DIR__ . "/../vista/formularioUsuario.php");
        }
    }

    // ELIMINAR USUARIO
    public function eliminar($get = [])
    {
        $cedula = $get['cedula'] ?? null;
        if ($cedula) {
            $this->usuarioModel->delete($cedula);
        }
        header("Location: index.php?controlador=usuarios&accion=listar");
        exit;
    }

    
    // VALIDAR USUARIO
    public function validar($get = [], $post = []){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cedula = $_POST['cedula'];
            $password = $_POST['password'];           

            // validar login
            $loginDatos = $this->usuarioModel->validarLogin($cedula, $password);
            if ($loginDatos) {
                session_start();
                // Obtener datos completos del usuario
                $usuarioDatos = $this->usuarioModel->getByCedula($cedula);

                // Guardar en sesión, incluyendo perfil desde login
                $_SESSION['usuario'] = [
                    'cedula'   => $usuarioDatos['cedula'],
                    'nombre'   => $usuarioDatos['nombre'],
                    'apellido' => $usuarioDatos['apellido'],
                    'perfil'   => $loginDatos['perfil'] // desde login
                ];

                header("Location: ../vista/VistaMenu.php");
                exit();
            } else {
                $error = "Cédula o contraseña incorrecta";
                //echo "<script>alert('Cédula o contraseña incorrecta');</script>";
                include(__DIR__ . "/../vista/VistaLogin.php");
            }
        } else {
            include(__DIR__ . "/../vista/VistaLogin.php");
        }
    }
    // CERRAR SESIÓN
    public function logout() {
        session_start();      // iniciar sesión si no está iniciada
        session_unset();      // limpiar variables de sesión
        session_destroy();    // destruir la sesión
        header("Location: index.php?controlador=usuarios&accion=validar"); // redirigir al login
        exit();
    }


}
?>
