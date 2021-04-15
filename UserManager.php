<?php
class UserManager {
    
   public  function login($db) {
        $args = [
        'email' => FILTER_SANITIZE_EMAIL,
        'passwd' => FILTER_SANITIZE_MAGIC_QUOTES]; 
        
        $dane = filter_input_array(INPUT_POST, $args);
        $email = $dane["email"];
        $passwd = $dane["passwd"];
        $user_id = $db->selectUser($email, $passwd, "users");

        if ($user_id >= 0) {
            session_start();
            $db->delete("DELETE FROM logged_in_users WHERE user_id=$user_id");
            $date= new DateTime;
            $czas=$date->format('Y-m-d H:i:s');
            $sessionId= session_id(); 
            $db->insert("INSERT INTO logged_in_users VALUES('$sessionId', '$user_id', '$czas')");
        }

    return $user_id;
    }

    public function register($db){
        $args = [
            'login' => FILTER_SANITIZE_MAGIC_QUOTES,
            'passwd' => FILTER_SANITIZE_MAGIC_QUOTES,
            'email' => FILTER_SANITIZE_EMAIL];
        
        $dane = filter_input_array(INPUT_POST, $args);
        $login = $dane["login"];
        $passwd=password_hash($dane["passwd"],PASSWORD_DEFAULT);
        $email = $dane["email"];
        $tmp=$db->select("SELECT * FROM users WHERE login='$login' OR email='$email'");
        if(count($tmp)>0){
            echo "Podany login został użyty!";
        }
        else{
            $db->insert("INSERT INTO users VALUES(NULL, '$login', '$email', '$passwd')");
        }    
        
    }

    function logout($db) {
        session_start();
        $session_id= session_id(); 
        if ( isset($_COOKIE[session_name()]) ) {
            setcookie(session_name(),'', time() - 42000, '/');
        }
        session_destroy();
        
        $db->delete("DELETE FROM logged_in_users WHERE session_id='$session_id'");
    }



        function getLoggedInUser($db, $session_id) {
            $user_id=$db->selectID($session_id);
            return $user_id;
        }
       
    }

       
?>
       
