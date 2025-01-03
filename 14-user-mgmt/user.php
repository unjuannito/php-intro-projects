<?php 
    class User{

        private $userName;
        private $password;
        private $email;
        private $painter;
        
        private $id;
        public function __construct($BDD, $userName, $password, $email, $painter, $id) {
            $this->userName = $userName;
            $this->password = $password;
            $this->email = $email;
            $this->painter = $painter;
            $this->id = $id;
        }

        public static function getUser($BDD, $userName, $password){
            $resultado = ($BDD->query("SELECT * FROM users WHERE name = \"".$userName."\""))->fetch(PDO::FETCH_ASSOC);
            if(!$resultado){
                $user = -1;
            }else if($resultado["password"] == $password){
                $user = new User($BDD, $resultado["name"], $resultado["password"], $resultado["email"], $resultado["painter_fk"], $resultado["id"]);
                
            }else{
                $user = 0;
            }
            return $user;
        }

        public static function register($BDD, $userName, $password, $email, $pintor, $id){
            try {
                $BDD->exec("INSERT INTO users (id, name, password, email, painter_fk) VALUES (\"".$id."\", \"".$userName."\", \"".$password."\", \"".$email."\", \"".$pintor."\")");
                $user = new User($BDD, $userName, $password, $email, $pintor, $id);
                return $user;
            } catch (\Throwable $th) {
                $devolver["message"] = "Ha habido un problema al crear la cuenta";
                $devolver["errorCode"] = $th->getCode();
                return $devolver;
            }

        }

        public function changueData($BDD, $name, $password, $email, $painter_fk){
            $prepare = $BDD->prepare('UPDATE users SET name = ?, password = ?, email = ?, painter_fk = ? WHERE id = ?');
            $prepare->execute([$name, $password, $email, $painter_fk, $this->id]);
            $this->userName = $name;
            $this->password = $password;
            $this->email = $email;
            $this->painter = $painter_fk;
        }

        public function delateUser($BDD){
            $stmt = $BDD->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$this->id]);

        }

        public static function getNewID($BDD){
            $resultado = ($BDD->query("SELECT MAX(id) as id FROM `users`"))->fetch(PDO::FETCH_ASSOC);
            return $resultado["id"] +1;
        }

        public function getFavouritePaintings($BDD){
            $paintings = ($BDD->query("SELECT * FROM `paintings` WHERE painter_fk = ".$this->painter))->fetchAll(PDO::FETCH_ASSOC);
            return $paintings;
        }

        public static function getClickedPainting($BDD, $id){
            $painting = ($BDD->query("SELECT * FROM `paintings` WHERE id = ".$id))->fetch(PDO::FETCH_ASSOC);
            return $painting;
        }

        public static function getAllPainters($BDD){
            $painters = ($BDD->query("SELECT * FROM `painters`"))->fetchAll(PDO::FETCH_ASSOC);
            return $painters;
        }

        public function getUserName(){    
            return $this->userName;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPainter(){
            return $this->painter;
        }
        public function getId(){
            return $this->id;
        }

    }

?>