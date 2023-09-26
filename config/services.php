<?
    require_once "./database.php";
    
    $jsonData = file_get_contents('php://input');

    $data = json_decode($jsonData, true); // get request POST from frontend

    $database = new Database(); // define database class 

    $results = array();

    session_start();
    
    if(!isset($_SESSION['username'])){
        echo "Access denied!";
        exit();
    }


    if($_POST['action'] == "create_user"){
        $user = $_POST['user'];
        if($database->create_user($user) == "1"){
            $results['status'] = "1";
            $results['message'] = "User has been inserted!";
        }else{
            $results['status'] = "0";
            $results['message'] = "Error : " . $database->create_user($user);
        }
    }else if ($_POST['action'] == "getUsers"){
        if($database->getUsers()){
            $results['status'] = "1";
            $results['data'] = $database->getUsers();
        }else{
            $results['status'] = "0";
            $results['data'] = "Error : " .$database->getUsers();
        }
    }else if ($_POST['action'] == "getUserById"){
        if(empty($_POST['user_id'])) {
            $results['status'] = "0";
            $results['messagee'] = "user_id is require!";
        }else{
            $userid = $_POST['user_id'];
            if($database->getUserById($userid)){
                $results['status'] = "1";
                $results['data'] = $database->getUserById($userid); // $results['data']['data'] , $results['data']['row']
            }else{
                $results['status'] = "0";
                $results['message'] = "Error : " .$database->getUserById($userid);
            }
        }
    }else if ($_POST['action'] == "editUser"){
        if(empty($_POST['user_id'])) {
            $results['status'] = "0";
            $results['messagee'] = "user_id is require!";
        }else{
            $userid = $_POST['user_id'];

            $rowuser = $database->getUserById($userid);

            if(empty($_POST['data'])){
                $results['status'] = "0";
                $results['messagee'] = "data is require!";
            }else if($rowuser['row'] > 0){
                if($database->editUser($userid,$data['data'])){
                    $results['status'] = "1";
                    $results['message'] = "User has been updated!";
                }else{
                    $results['status'] = "0";
                    $results['message'] = "Error : " .$database->editUser($userid,$data['data']);
                }
            }else{
                $results['status'] = "0";
                $results['message'] = "Error : " .$database->editUser($userid,$data['data']);
            }
        }
    }else if ($_POST['action'] == "deleteUser"){
        if(empty($_POST['user_id'])){
            $results['status'] = "0";
            $results['message'] = "user_id is require!"; 
        }else{
            $userid = $_POST['user_id'];
            if($database->deleteUser($userid)){
                $results['status'] = "1";
                $results['message'] = "User has been deleted!";
            }else{
                $results['status'] = "0";
                $results['message'] = "Error : " . $database->deleteUser($userid);
            }
        }
    }

    echo json_encode($results);
?>