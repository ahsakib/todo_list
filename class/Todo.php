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
        if($result){
            return [
                'TaskName' => $data['TaskName'],
                'id'=>mysqli_insert_id($this->db_connect)
            ];
        }
    }

    function editData($data){
        $updateData = 'UPDATE `'.$this->taskTable.'` SET task_name = "'.$data['task_name'].'" WHERE id = "'.$data['id'].'"';
        mysqli_query($this->db_connect, $updateData);
    }

    function getData(){
        $allData='SELECT * FROM '.$this->taskTable;
        $result=mysqli_query($this->db_connect,$allData);
        $all=[];
        if($result){
            while($row=mysqli_fetch_assoc($result)){
                $all[]=$row;
            }
        }
        return $all;
    }

    function deleteData($data){
        $delete = "DELETE FROM " . $this->taskTable . " WHERE id='" . $data['id'] . "'";
        $result=mysqli_query($this->db_connect,$delete);
        if($result){
            return true;
        }
    }


}