<?php
/**
 * Clase Config, en esta clase se dan los valores de conexión a la base de datos, los cuales son usados en el
 * controlador principal (/bdt/controller/DAOController.php
 */

trait Config{
    private $hostCfg = "localhost";
    private $usernameCfg = "root";
    private $passwordCfg = "";
    private $dbnameCfg = "bdt";
    private $portCfg = 3306;


    /**
     * @return string
     */
    public function getHostCfg(): string {
        return $this->hostCfg;
    }

    /**
     * @return string
     */
    public function getUsernameCfg(): string {
        return $this->usernameCfg;
    }

    /**
     * @return string
     */
    public function getPasswordCfg(): string {
        return $this->passwordCfg;
    }

    /**
     * @return string
     */
    public function getDbnameCfg(): string {
        return $this->dbnameCfg;
    }

    /**
     * @return int
     */
    public function getPortCfg(): int {
        return $this->portCfg;
    }
}




