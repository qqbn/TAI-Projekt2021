<?php
class Baza {
 private $mysqli; 
 public function __construct($serwer, $user, $pass, $baza) {
 $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
 if ($this->mysqli->connect_errno) {
    printf("Nie udało sie połączenie z serwerem: %s\n",$this->mysqli->connect_error);
 exit();
 }
 /* zmien kodowanie na utf8 */
 if ($this->mysqli->set_charset("utf8")) {
 //udało sie zmienić kodowanie
 }

 } //koniec funkcji konstruktora
 function __destruct() {
 $this->mysqli->close();
 }
 

 public function select($sql) {
    $tab=array();
    if ($result = $this->mysqli->query($sql)) {
    $ile = $result->num_rows; //ile wierszy
        while ($row = $result->fetch_object()) {
            $tab[]=$row;
         }
    $result->close(); /* zwolnij pamięć */
    }
return $tab;
 }


 public function selectUser($email, $passwd, $tabela) {
    $id = -1;
    $sql = "SELECT * FROM $tabela WHERE email='$email'";
    if ($result = $this->mysqli->query($sql)) {
        $ile = $result->num_rows;
        if ($ile == 1) {
            $row = $result->fetch_object();
            $hash = $row->passwd;
            if (password_verify($passwd, $hash)){
                $id = $row->user_id; 
            }
        }
    }
    return $id;
}

public function selectID($session_id){
    $user_id=-1;
    $sql="SELECT user_id FROM logged_in_users WHERE session_id='$session_id'";

    if ($result = $this->mysqli->query($sql)) {
        $ile = $result->num_rows;
        if ($ile == 1) {
            $row = $result->fetch_object();
            $user_id = $row->user_id; 
        }

    }

    return $user_id;    

}

 public function insert($sql) {
   $result = $this->mysqli->query($sql);
   if($result===false) {
       echo "Błąd z zapytaniem insert";
   }
 }

 public function delete($sql) {
   $result = $this->mysqli->query($sql);
   if($result===false) {
       echo "Błąd z zapytaniem delete";
 }
}

 public function show($sql) {
    $result = $this->mysqli->query($sql);
    if($result===false) {
        echo "Błąd z zapytaniem select";
    }
 }


}