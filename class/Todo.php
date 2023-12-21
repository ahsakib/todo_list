<?php

class Todo{

    private $userName="root";
    private $password="";
    private $db="todo";
    private $host="localhost";
    private $db_connect=false;
    private $taskTable="task";
    function __construct(){
        $this->connect();
    }

    private function connect(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if(!$this->db_connect){
            $conn=new mysqli($this->host,$this->userName,$this->password,$this->db);

            if($conn->connect_errno){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->db_connect = $conn;
            }
        }
    }

    function saveData($data){
        // $insertData="INSERT INTO ". $this->taskTable."(task_name) VALUES ('".$data['TaskName']."')";
        $insertData="INSERT INTO ". $this->taskTable."(task_name";
        if(isset($data['dueDate'])){
            $insertData.=",due_date";
        }
        $insertData .= ") VALUES ('" . $data['TaskName'] . "'";

        if (isset($data['dueDate'])) {
            $insertData .= ",'" . $data['dueDate'] . "'";
        }

        $insertData .= ")";


        $result=mysqli_query($this->db_connect,$insertData);

    }

    function editData($data){
        $updateData = 'UPDATE `'.$this->taskTable.'` SET task_name = "'.$data['task_name'].'" WHERE id = "'.$data['id'].'"';
        mysqli_query($this->db_connect, $updateData);
    }

    function getData(){
        $allData = "SELECT * FROM `$this->taskTable` WHERE `complete` != 'y' OR `complete` IS NULL";
        $countCompleteY = "SELECT COUNT(*) AS numComplete FROM `$this->taskTable` WHERE `complete` = 'y'";
        $completeTask=mysqli_query($this->db_connect,$countCompleteY);
        $countResult = mysqli_fetch_assoc($completeTask);
        $numCompleteTask = $countResult['numComplete'];
        
        $result=mysqli_query($this->db_connect,$allData);
        $all=[];
        if($result){
            while($row=mysqli_fetch_assoc($result)){
                $all[]=$row;
            }
        }

         echo json_encode(['data'=>$all,"numCompleteTask"=>$numCompleteTask]);
    }

    function deleteData($data){
        $delete = "DELETE FROM " . $this->taskTable . " WHERE id='" . $data['id'] . "'";
        $result=mysqli_query($this->db_connect,$delete);
        if($result){
            return true;
        }
    }

    function completeDataSave($data){
        $val=$data['completeValue'];
        $id=$data['completeId'];
        $sql = 'UPDATE `'.$this->taskTable.'` SET complete = "'.$val.'" WHERE id = "'.$id.'"';
        $result=mysqli_query($this->db_connect,$sql);

        if($result){
            return true;
        }

    }


    function getCompleteData(){
        $sql="SELECT * FROM `$this->taskTable` WHERE `complete`='y'";

        $result=mysqli_query($this->db_connect,$sql);
        $all=[];
        if($result){
            while($row=mysqli_fetch_assoc($result)){
                $all[]=$row;
            }
        }
        echo json_encode(['success'=>true,'data'=>$all]);
    }

    function getCountCompleteData(){
        $countCompleteY = "SELECT COUNT(*) AS numComplete FROM `$this->taskTable` WHERE `complete` = 'y'";
        $completeTask=mysqli_query($this->db_connect,$countCompleteY);
        $countResult = mysqli_fetch_assoc($completeTask);
        $numCompleteTask = $countResult['numComplete'];

        return $numCompleteTask;
    }


}