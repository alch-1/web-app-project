<?php

class Database {

    // specify your own database credentials
    private $host = "remotemysql.com";
    private $db_name = "Qjp8Kx5E0Y";
    private $username = "Qjp8Kx5E0Y";
    private $password = "fx2AFGMUsX";
    private $port = 3306;   // Check in PHPMyAdmin for port number
    public $conn;

    // get the database connection
    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=" . $this->port, 
                $this->username, 
                $this->password);

            $this->conn->exec("set names utf8");
        }
        catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function dbImportSQL($sql, $db, $needle = '')
    {   
        //$db = $this->getConnection();
        $sentences = explode( $needle . ';', $sql);
        // PREPARE THE QUERIES
        $var_l = count($sentences);
        $s_temp = '';
        for($var_k=0;$var_k<$var_l;$var_k++) {
            $s = $s_temp.$sentences[$var_k];
            if(!empty($s) && trim($s)!='') {
                $s .= $needle;
                $simple_comma = substr_count($s, "'");
                $scaped_simple_comma = substr_count($s, "\'");
                if(($simple_comma-$scaped_simple_comma)%2==0) {
                    $sentences[$var_k] = $s;
                    $s_temp = '';
                    //echo "[OK] ".$s." <br />";
                } else {
                    unset($sentences[$var_k]);
                    $s_temp = $s.";";
                    //echo "[FAIL] ".$s." <br />";
                }
            } else {
                unset($sentences[$var_k]);
            }
        }

        foreach($sentences as $s) {
            $s = trim($s);
            if( !empty($s) ) {
                $s = trim($s);// . $needle;
                $stmt = $db->prepare($s);
                $stmt->execute();
            }
        }
        return true;
    }
}

?>