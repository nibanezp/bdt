<?php
/**
 * Modelo de usuario, en el tenemos lo referente a un usuario
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Valoraciones.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Role.php';

class Usuario{
    use Role;
    use Valoraciones;
    public $id;
    public $username;
    public $password;
    public $email;
    public $nombre;
    public $apellidos;
    public $poblacion;
    public $horas;



    function __construct($id=null, $username=null, $password=null, $email=null, $nombre=null, $apellidos=null,
                         $poblacion=null, $horas=null, $roleId=null, $roleName=null, $valoracion=null, $votos=null) {

        // Valores de usuario
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->poblacion = $poblacion;
        $this->horas = $horas;

        // Valores de rol
        $this->roleId = $roleId;
        $this->roleName = $roleName;

        // Valores de valoracion
        $this->valUserId = $id;
        $this->valoracion = $valoracion;
        $this->votos = $votos;
    }


    // Función para dar de alta a nuevos usuarios.
    public function altaUsuario(){
        $sql = "INSERT INTO users (username, passw, email, nombre, apellidos, poblacion, horas)
        VALUES ('{$this->username}', '{$this->password}', '{$this->email}', '{$this->nombre}', '{$this->apellidos}',
                '{$this->poblacion}', 10);";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función para modificar un usuario en la base de datos.
    public function modificarUsuario(){
        $sql = "UPDATE users
                SET id = '".$this->id."',
                    username = '".$this->username."',
                    passw = '".$this->password."',
                    email = '".$this->email."',
                    nombre = '".$this->nombre."',
                    apellidos = '".$this->apellidos."',
                    poblacion = '".$this->poblacion."',
                    horas = '".$this->horas."',
                    role = '".$this->roleId."'
                WHERE id=".$this->id.";";
        $_SESSION['conn']->executeSql($sql);
        $sql = "UPDATE valoraciones
                SET valoracion = '".$this->valoracion."',
                    votos = '".$this->votos."'
                WHERE userId=".$this->id.";";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función que obtiene un usuario de la base de datos mediante su username.
    public function getUserByUserName($userName){
        $sql = "SELECT * FROM v_users WHERE username='{$userName}';";
        $row = $_SESSION['conn']->getRow($sql);
         if (!is_null($row)) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['passw'];
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->poblacion = $row['poblacion'];
            $this->email = $row['email'];
            $this->horas = $row['horas'];

            $this->roleId = $row['roleId'];
            $this->roleName = $row['roleName'];

            $this->userId =  $row['userId'];
            $this->valoracion = $row['valoracion'];
            $this->votos = $row['votos'];
             return true;
         }
        return false;
    }


    // Función que obtiene un usuario de la base de datos mediante su identificador.
    public function getUserByUserId($userId){
        $sql = "SELECT * FROM v_users WHERE id='{$userId}';";
        $row = $_SESSION['conn']->getRow($sql);
        if (!is_null($row)) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['passw'];
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->poblacion = $row['poblacion'];
            $this->email = $row['email'];
            $this->horas = $row['horas'];

            $this->roleId = $row['roleId'];
            $this->roleName = $row['roleName'];

            $this->userId = $row['userId'];
            $this->valoracion = $row['valoracion'];
            $this->votos = $row['votos'];
            return true;
        }
        return false;
    }


    // Función elimina un usuario de la base de datos mediante su identificador.
    public function eliminarUsuario($userId){
        $sql = "DELETE FROM users WHERE id=$userId;";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función para la actualización de valoraciones de un usuario.
    public function updateValoracion($userId, $valoracion, $voto){
        $sql = "UPDATE valoraciones
                SET valoracion = '".$valoracion."',
                    votos = '".$voto."'
                WHERE userId=".$userId.";";
        return $_SESSION['conn']->executeSql($sql);
    }

    // Función para la actualización de las horas cuando un usuario da sus horas a otro usuario.
    public function pagarHoras($selectedUserId, $horas){
        $sql = "UPDATE users
                SET horas = horas -".$horas."
                WHERE id='".$this->id."';";

        $_SESSION['conn']->executeSql($sql);
        $sql = "UPDATE users
                SET horas = horas +".$horas."
                WHERE id='".$selectedUserId."';";
        return $_SESSION['conn']->executeSql($sql);
    }

    /**
     * @return mixed|null
     */
    public function getRoleId(): mixed {
        return $this->roleId;
    }

    /**
     * @param mixed|null $roleId
     * @return Usuario
     */
    public function setRoleId(mixed $roleId): Usuario {
        $this->roleId = $roleId;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getRoleName(): mixed {
        return $this->roleName;
    }

    /**
     * @param mixed|null $roleName
     * @return Usuario
     */
    public function setRoleName(mixed $roleName): Usuario {
        $this->roleName = $roleName;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValUserId(): mixed {
        return $this->valUserId;
    }

    /**
     * @param mixed|null $valUserId
     * @return Usuario
     */
    public function setValUserId(mixed $valUserId): Usuario {
        $this->valUserId = $valUserId;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValoracion(): mixed {
        return $this->valoracion;
    }

    /**
     * @param mixed|null $valoracion
     * @return Usuario
     */
    public function setValoracion(mixed $valoracion): Usuario {
        $this->valoracion = $valoracion;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getVotos(): mixed {
        return $this->votos;
    }

    /**
     * @param mixed|null $votos
     * @return Usuario
     */
    public function setVotos(mixed $votos): Usuario {
        $this->votos = $votos;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getId(): mixed {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     * @return Usuario
     */
    public function setId(mixed $id): Usuario {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getUsername(): mixed {
        return $this->username;
    }

    /**
     * @param mixed|null $username
     * @return Usuario
     */
    public function setUsername(mixed $username): Usuario {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getPassword(): mixed {
        return $this->password;
    }

    /**
     * @param mixed|null $password
     * @return Usuario
     */
    public function setPassword(mixed $password): Usuario {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getEmail(): mixed {
        return $this->email;
    }

    /**
     * @param mixed|null $email
     * @return Usuario
     */
    public function setEmail(mixed $email): Usuario {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getNombre(): mixed {
        return $this->nombre;
    }

    /**
     * @param mixed|null $nombre
     * @return Usuario
     */
    public function setNombre(mixed $nombre): Usuario {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getApellidos(): mixed {
        return $this->apellidos;
    }

    /**
     * @param mixed|null $apellidos
     * @return Usuario
     */
    public function setApellidos(mixed $apellidos): Usuario {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getPoblacion(): mixed {
        return $this->poblacion;
    }

    /**
     * @param mixed|null $poblacion
     * @return Usuario
     */
    public function setPoblacion(mixed $poblacion): Usuario {
        $this->poblacion = $poblacion;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getHoras(): mixed {
        return $this->horas;
    }

    /**
     * @param mixed|null $horas
     * @return Usuario
     */
    public function setHoras(mixed $horas): Usuario {
        $this->horas = $horas;
        return $this;
    }


}
