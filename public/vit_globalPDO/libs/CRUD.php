<?php

/**
 * Created by PhpStorm.
 * User: mahmood
 * Date: 23/09/2015
 * Time: 09:44
 */
$basedir = realpath(__DIR__);
require($basedir . '/../config/config.php');


class CRUD {


    // ===================================================================================================================
    // VARIABLES
    // ===================================================================================================================

    /**
     * Database Class Data Variables.
     *
     * @access private
     **/
    private $server;
    private $username;
    private $password;
    private $database;
    private $dbh;
    private $object;

    /**
     * Response array.
     *
     * @access public
     **/
    public $response = array();


    // ===================================================================================================================
    // OPEN CONNECTION AND HANDLE SERVER
    // ===================================================================================================================

    /**
     * Automatically Opens Database Connection when Database Class is being instantiated.
     *
     * @access public
     **/
    public function __construct() {

        //get database variables from the environment configuration
        $this->server   = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->database = getenv('DB_NAME');

        $this->openConnection();
    }

    /**
     * Opens Server and Database Connection.
     *
     * @return error message
     * @access public
     **/
    public function openConnection() {
        try {
            $this->dbh = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->database . ";charset=utf8", $this->username, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setServerDetails(PDO::ATTR_SERVER_VERSION, PDO::ATTR_SERVER_INFO, PDO::ATTR_CONNECTION_STATUS);
        } catch (PDOException $e) {
            die("Connection to database failed because: " . $e->getMessage());
        }
    }

    public function setServerDetails($server_version, $server_info, $server_status) {
        $this->server_version = $this->dbh->getAttribute($server_version);
        $this->server_info = $this->dbh->getAttribute($server_info);
        $this->server_status = $this->dbh->getAttribute($server_status);
    }

    public function getServerVersion() {
        return $this->server_version;
    }
    public function getServerInfo() {
        return $this->server_info;
    }
    public function getServerStatus() {
        return $this->server_status;
    }



    // ===================================================================================================================
    // NORMAL QUERY EXECUTE
    // ===================================================================================================================

    /**
     * Executes a query with multiple values and parameters
     *
     * @param $query, SQL query of any type (does not accept input arrays)
     * @param OPTIONAL $param, the array of bindings and values
     * @param OPTIONAL $message, the message to respond
     * @access public
     **/
    public function executeMySQL($query, $params = null) {
        if (is_null($params)) {
            try {
                $this->object = $this->dbh->prepare($query);
                $this->object->execute();

                $this->response["success"] = 1;
            }
            catch (PDOException $e) {
                $this->response["success"] = 0;
                die("Failed to execute MySQL script due to: " . $e->getMessage());
            }
        } else {
            try {

                $this->object = $this->dbh->prepare($query);
                foreach($params as $key => &$value) {
                    if(is_string($value)){
                        $this->object->bindParam($key, $value, PDO::PARAM_STR);
                    } elseif (is_bool($value)){
                        $this->object->bindParam($key, $value, PDO::PARAM_BOOL);
                    } else {
                        $this->object->bindParam($key, $value, PDO::PARAM_INT);
                    }
                }
                $this->object->execute();
                $this->response["success"] = 1;

            }
            catch (PDOException $e) {
                $this->response["success"] = 0;
                die("Failed to execute MySQL script with parameters due to: " . $e->getMessage());
            }
        }
    }


    // ===================================================================================================================
    // TRANSACTION FUNCTIONS
    // ===================================================================================================================

    /**
     * Begins a mysql transaction
     *
     * @access public
     **/
    public function begin() {
        return $this->dbh->beginTransaction();
    }

    /**
     * Commits a mysql transaction
     *
     * @access public
     **/
    public function commit() {
        return $this->dbh->commit();
    }

    /**
     * Rollsback a mysql transaction
     *
     * @access public
     **/
    public function rollback() {
        return $this->dbh->rollback();
    }


    // ===================================================================================================================
    // RETURN FUNCTIONS
    // ===================================================================================================================

    /**
     * Dynamically Counts the total rows of the current object.
     *
     * @return number of rows
     * @access public
     **/
    public function rowCount() {
        return $this->object->rowCount();
    }

    /**
     * Dynamically Fetch the rows of the current object.
     *
     * @return array of data
     * @access public
     **/
    public function rowFetch() {
        return $this->object->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Dynamically Fetch the rows of the current object.
     *
     * @return array of data
     * @access public
     **/
    public function fetchObj() {
        return $this->object->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Gets all data instead of row by row
     *
     * @return array of data
     * @access public
     */
    public function fetchAll() {
        return $this->object->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Dynamically checks if there is a item inserted on the current object's database.
     *
     * @return true or false
     * @access public
     **/
    public function isInserted() {
        return $this->dbh->lastInsertId();
    }

    public function PDOError() {
        return $this->dbh->errorCode();
    }




    // ===================================================================================================================
    // ECHO FUNCTIONS
    // ===================================================================================================================

    /**
     * Echos the Success only
     *
     * @echo success response
     * @access public
     */
    public function echoSuccess() {
        echo json_encode($this->response);
    }

    /**
     * Echos a boolean value
     *
     * @echo boolean response
     * @param $responseString, the String to respond
     * @access public
     */
    public function echoBoolean($responseString) {

        if($this->object->rowCount() > 0) {
            $this->response[$responseString] = true;
        } else {
            $this->response[$responseString] = false;
        }

        echo json_encode($this->response);
    }

    /**
     * Echos the count of the total rows of the current object.
     *
     * @echo number of rows
     * @access public
     **/
    public function echoRowCount() {
        $this->response["rowCount"] = $this->object->rowCount();
        echo json_encode($this->response);
    }

    /**
     * Echos the response Array
     *
     * @echo response array
     * @param $responseString, the String to respond
     * @access public
     */
    public function echoFull($responseString) {
        $this->response["rowCount"] = $this->object->rowCount();
        $this->response[$responseString] = $this->fetchAll();
        echo json_encode($this->response);
    }


    // ===================================================================================================================
    // CONNECTION CLOSE
    // ===================================================================================================================

    /**
     * Automatically closes connection for security purposes.
     *
     * @access public
     **/
    public function closeConnection() {
        if (isset($this->openConnection)) {
            $this->dbh = null;
            unset($this->openConnection);
        }
    }
}

$db = new CRUD();

?>