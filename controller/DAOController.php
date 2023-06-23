<?php
/**
 * Controlador principal desde el cual se enlazan las vistas con los modelos y la base de datos. Desde este controlador
 * se ejecutaran todas las consultas, ya que de un modo u otro he hecho que cualquier query tenga que pasar por este
 * controlador.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/config.php';

class DAOController{
    use Config;
    private $host = "";
    private $username = "";
    private $password = "";
    private $dbname = "";
    private $port = 3306;

    public $conn;


    public function __construct() {

        $this->host = $this->getHostCfg();
        $this->username = $this->getUsernameCfg();
        $this->password = $this->getPasswordCfg();
        $this->dbname = $this->getDbnameCfg();
        $this->port = $this->getPortCfg();


        $this->initDb();
    }


    // Función que crea la conexión a la base de datos.
    private function initDb(): void {
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname, $this->port);
            mysqli_set_charset($this->conn, "utf8");
        } catch(Exception $e) {
            echo "Connection failed: " . mysqli_connect_error() . "\n";
            $this->showAlert("Connection failed: " . mysqli_connect_error() . "\n");

            $fileName = './logs/log_'.date("j.n.Y").'.log';
            $text = date("D M j G:i:s T Y")."\n"."Connection failed: " . mysqli_connect_error()."\n\n";
            file_put_contents($fileName, $text , FILE_APPEND);
        }
    }


    public function getConn() {
        return $this->conn;
    }


    // Función que genera los, principalmente pensada para la ejecución y respuesta de las sentencias sql.
    // Estos logs son guardados en /bdt/logs/
    private function logSql($sql): void{
        $fileName = "./logs/log_".date('j.n.Y').".log";
        $text = date("D M j G:i:s T Y")."\n".$sql."\n\n";
        file_put_contents($fileName, $text, FILE_APPEND);
    }


    // Esta función devuelve un único registro de la base de datos. Pensada para sentencias SELECT.
    public function getRow($sql, $logSql=false): bool|array|null {
        try {
            if ($logSql){$this->logSql($sql);}

            $result = mysqli_query($this->conn, $sql);
            return $result->fetch_assoc();
        }catch(Exception $e){
            $this->showAlert($e->getMessage());
        }
        $text = $e->getMessage()."\nSQL = ".$sql."\n\n";
        $this->logSql($text);
        return false;
    }


    // Esta función ejecuta cualquier sentencia sql y devuelve el resultado, que puede ser un booleano, o el resultado
    // de una sentencia sql. Pensada para sentencias UPDATE, INSERT o DELETE.
    public function executeSql($sql, $logSql=false): mysqli_result|bool|Exception{
        try {
            if ($logSql){$this->logSql($sql);}

            return mysqli_query($this->conn, $sql);
        }catch(Exception $e){
            if (str_contains($e->getMessage(), "users.username_UNIQUE")){
                $this->showAlert("Este username ya esta en uso.");
            }
            elseif (str_contains($e->getMessage(), "users.email_UNIQUE")){
                $this->showAlert("Este email ya esta en uso.");
            }
            else{
                $this->showAlert($e->getMessage());
            }
            $text = $e->getMessage()."\nSQL = ".$sql."\n\n";
            $this->logSql($text);
            return false;
        }
    }


    // Esta función devuelve N registros de la base de datos. Pensada para sentencias SELECT.
    public function getRows($sql, $logSql=false, $mode = MYSQLI_ASSOC): bool|array|null {
        try {
            if ($logSql){$this->logSql($sql);}

            $result = mysqli_query($this->conn, $sql);
            return $result->fetch_all($mode);
        }catch(Exception $e){
           $this->showAlert($e->getMessage());
        }
        $text = $e->getMessage()."\nSQL = ".$sql."\n\n";
        $this->logSql($text);
        return false;
    }


    // Esta función devuelve el ultimo id insertado en la base de datos. Se creo originalmente para inicializar
    // las valoraciones a 0 al darse de alta un nuevo usuario. Posteriormente este proceso se genero mediante un
    // trigger directamente en la base de datos. No ha sido borrada porque me parece interesante mantenerla para futuras
    // mejoras o implementaciones.
    public function getLastInsertedId(): bool|int|null {
        return mysqli_insert_id($this->conn);

    }


    // Esta función muestra un mensaje en forma de alerta de JavaScript con el mensaje que recibe.
    public function showAlert($msg): void{
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    }


}


// Creamos un controlador y lo añadimos a las variables de sesión, de este modo evitamos tener que poner en cada archivo
// una cabecera indicando que la variable "$conn" pertenece a DAOController, como he hecho en los ficheros que contiene
// la carpeta /controller/ajax_ctl

$conn = new DAOController();
if(!isset($_SESSION['conn'])) {
    session_start();
    $_SESSION['conn'] = $conn;
}
