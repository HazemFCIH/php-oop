<?php
class Database{
    public $host = 'localhost';
    public $user ='root';
    public $password = '';
    public $DB_name ='myblog';
    public $dbh;
    public $error;
    public $stmt;
    public function __construct(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->DB_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbh = new PDO($dsn,$this->user,$this->password,$options);
        }catch (PDOException $exception){
            $this->error = $exception->getMessage();
        }
    }
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    public function bind($param ,$value , $type = null){
        if(is_null($type)){
            switch (true){
                case is_int($value):
            $type = PDO::PARAM_INT;
            break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type  = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;

            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    public function execute(){
        return $this->stmt->execute();
    }
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchALL(PDO::FETCH_ASSOC);
    }

}