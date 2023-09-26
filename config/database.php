<?
    require "../vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    define('DB_HOST',$_ENV['DB_HOST']);
    define('DB_USER',$_ENV['DB_USER']);
    define('DB_PASS',$_ENV['DB_PASS']);
    define('DB_NAME',$_ENV['DB_NAME']);

    // users , products , user_address, product_type
    class Database {
 
        private $dbhost = DB_HOST;
        private $dbuser = DB_USER;
        private $dbpass = DB_PASS;
        private $dbname = DB_NAME;
        private $connect = null;

        public function __construct(){
        try {
            $conn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect = $conn;
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function create_user($user){
            if($user['username'] != "" && $user['useremail'] != ""){
                $user['userpass'] = MD5($user['userpass']);
                try {
                    $sql = "INSERT INTO users (username, userpass, useremail,fname,lname,user_phone) VALUES (?,?,?,?,?,?)";
                    $stmt= $this->connect->prepare($sql);
                    $username = $user['username'];
                    $userpass = $user['userpass'];
                    $useremail = $user['useremail'];
                    $fname = $user['fname'];
                    $lname = $user['lname'];
                    $user_phone = $user['user_phone'];
                    $stmt->execute([$username,$userpass,$useremail,$fname,$lname,$user_phone]);

                } catch (PDOException $e) {
                    return $e->getMessage();
                }

                return 1;

            }
        }

        public function getUsers(){
            try {
                $sql = "SELECT * FROM users";
                $stmt= $this->connect->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public function getUserById($userid){
            try {
                $sql = "SELECT * FROM users AS `user`
                            LEFT JOIN user_address AS address ON user.user_id = address.user_id
                                WHERE user.user_id = ?";
                $stmt= $this->connect->prepare($sql);
                $stmt->execute([$userid]);
                $count = $stmt->rowCount();
                if($count) {
                    $result['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result['row'] = $count;
                }else{
                    $result['row'] = $count;
                }
                return $result;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public function editUser($userid , $data){
            try {
                $sql = "UPDATE users SET fname = ? , lname = ? , user_phone = ? WHERE user_id = ?";
                $stmt= $this->connect->prepare($sql);
                $stmt->execute([$data['fname'],$data['lname'],$data['user_phone'] , $userid]);
                return "1";
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public function deleteUser($userid){
            try {
                $sql = "DELETE FROM users WHERE user_id = ?";
                $stmt= $this->connect->prepare($sql);
                $stmt->execute([$userid]); // array("user_id"=> $userid)
                return "1";
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    $database = new Database();
?>