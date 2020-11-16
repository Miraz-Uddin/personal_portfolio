<?php

namespace App\Support;
require_once "../config.php";
use PDO;

/**
 *  Database Management
 */
abstract class Database
{

  //  Server Information
  private $host = HOST;
  private $user = USER;
  private $pass = PASSWORD;
  private $db = DATABASE;
  private $conn;

  //  Connect Database
  private function connectDatabase(){
    try {
      return $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db",$this->user,$this->pass);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  /**
   *  Check Single data in Single Colum of a Table
   *  it will return false message if the data exist in the whole colum
   */
  public function dataExistInColum($table, $colum, $data){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT $colum FROM $table WHERE $colum='$data'");
    $stmt -> execute();

    //  Return occurance of data-found with the User id
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = $stmt->rowCount();

    if($num==0){
      return [
        'status'=>false,
        'matched_id'=>0
      ];
    }else{
      return [
        'status'=>true,
        'matched_id'=>$arr['id']
      ];
    }

  }

  /**
   *  Check Single data in Single Colum of a Table
   *  it won't return 'data already exits' message if the data exist in the given id's row
   */
  public function dataExistInColumExcludingId($table, $colum, $data, $id){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT id,$colum FROM $table WHERE id NOT IN ('$id') AND $colum='$data'");
    $stmt -> execute();

    //  Return occurance of data-found with the User id
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = $stmt->rowCount();
    if($num==0){
      return [
        'status'=>false,
        'matched_id'=>0
      ];
    }else{
      return [
        'status'=>true,
        'matched_id'=>$arr['id']
      ];
    }
  }

  /**
   *  Check Single data in Multiple Colum of a Table
   *  return how many times found that data,
   *  if found , then return id also
   */
  public function dataExistInColums($table, array $colum, $data, $condition = 'AND'){
    //  Making a string for Query statement
    $query_string = '';
    foreach($colum as $val){
      $query_string.= " ".$val.'='."'".$data."' ".$condition;
    }
    $query_array =explode(' ',$query_string);
    array_pop($query_array);
    $str = implode(' ',$query_array);

    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT * FROM $table WHERE $str");
    $stmt -> execute();

    //  Return occurance of data-found with the User id
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = $stmt->rowCount();
    if($num==0){
      return [
        'num'=>$num,
        'user_id'=>0,
      ];
    }else{
      return [
        'num'=>$num,
        'user_id'=>$arr['id'],
      ];
    }
  }

  /**
   *  Check Multiple data in Multiple Colum of a Table
   */
  public function datasExistInColums($table, array $data){}


  /**
   *  Check if Password is matched or not
   */
  public function passwordCheck($table, $id, $givenPass){
    //  Connect Database & get the Hash Password from Database
    $stmt = $this -> connectDatabase() -> prepare("SELECT password FROM $table WHERE id=$id");
    $stmt -> execute();
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    $db_pass = $arr['password'];

    //  Verify the Hash Password , if matched return true , else false
    if(password_verify($givenPass,$db_pass)){
      return true;
    }
    else{
      return false;
    }
  }

  /**
   *  get All Data from a Row of given id
   */
  public function getData($table, $id){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT * FROM $table WHERE id=$id");
    $stmt -> execute();
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    return $arr;
  }

  /**
   *  get All Data from a table
   */
  public function getAll($table){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT * FROM $table");
    $stmt -> execute();
    $arr = $stmt->fetchAll();
    return $arr;
  }

  /**
   *  get All Data from a table
   */
  public function getAllExcept($table,$id){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT * FROM $table WHERE deleted_status='No' AND id<>$id");
    $stmt -> execute();
    $arr = $stmt->fetchAll();
    return $arr;
  }

  /**
   *  get All Data from a table except those data that are soft-deleted
   */
  public function getAllDeletedExcept($table,$id){
    //  Connect Database & Run SELECT QUERY
    $stmt = $this -> connectDatabase() -> prepare("SELECT * FROM $table WHERE deleted_status='Yes' AND id<>$id");
    $stmt -> execute();
    $arr = $stmt->fetchAll();
    return $arr;
  }

  /**
   * Create User
   */
  public function create($table,array $arr){
    // Making DATA Array for placeholders Values
    $data=[];
    foreach($arr as $key=>$val){
      $data[$key]=$val;
    }

    //  Making Query String
    $columNames = array_keys($arr);
    $query_string1 = '';
    for($i=0;$i<count($columNames);$i++){
      if($i!=count($columNames)-1){
        $query_string1.= $columNames[$i].',';
      }else{
        $query_string1.= $columNames[$i];
      }
    }
    $query_string1=trim($query_string1);

    $query_string2 = '';
    for($i=0;$i<count($columNames);$i++){
      if($i!=count($columNames)-1){
        $query_string2.= ":".$columNames[$i].',';
      }else{
        $query_string2.= ":".$columNames[$i];
      }
    }
    $query_string2=trim($query_string2);

    $query_string = "(".$query_string1.")VALUES(".$query_string2.")";

    //  Connect Database & Run INSERT QUERY
    $sql_query = "INSERT INTO $table $query_string";
    $stmt = $this -> connectDatabase() -> prepare($sql_query)-> execute($data);

  }

  /**
   * UPDATE DATAS
   */
  public function update($id,$table,array $arr){
    // Making DATA Array for placeholders Values
    $data=[];
    foreach($arr as $key=>$val){
      $data[$key]=$val;
    }

    //  Set ID for Update
    $data['id']=$id;

    //  Making Query String
    $columNames = array_keys($arr);
    $query_string = '';
    for($i=0;$i<count($columNames);$i++){
      if($i!=count($columNames)-1){
        $query_string.= " ".$columNames[$i].'='.":".$columNames[$i].", ";
      }else{
        $query_string.= " ".$columNames[$i].'='.":".$columNames[$i]." ";
      }
    }
    $query_string=trim($query_string);

    //  Connect Database & Run UPDATE QUERY
    $sql_query = "UPDATE $table SET ".$query_string." WHERE id=:id";
    $stmt = $this -> connectDatabase() -> prepare($sql_query)-> execute($data);
  }

  /**
   * Soft Delete Data
   */
  public function softDelete($table,$user_id){
    $data = [
        'deleted_status' => 'Yes',
        'id' => $user_id
    ];
    //  Connect Database & Run UPDATE QUERY
    $stmt = $this -> connectDatabase() -> prepare("UPDATE users SET deleted_status=:deleted_status WHERE id=:id")-> execute($data);
  }

  /**
   *  Restore Data
   */
  public function restore($table,$user_id){
    $data = [
        'deleted_status' => 'No',
        'id' => $user_id
    ];
    //  Connect Database & Run UPDATE QUERY
    $stmt = $this -> connectDatabase() -> prepare("UPDATE users SET deleted_status=:deleted_status WHERE id=:id")-> execute($data);
  }

  /**
   *  Delete Data
   */
  public function delete($table,$user_id){
    //  Connect Database & Run DELETE QUERY
    $stmt = $this -> connectDatabase() -> prepare("DELETE FROM $table WHERE id=$user_id")-> execute();
  }

}

?>
