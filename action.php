<?php 

include "class/Todo.php";
$todo=new Todo();
// var_dump($_POST);
if(isset($_POST['saveData']) && $_POST['saveData']=="save"){
    $data=[
        "TaskName"=>$_POST['TaskName'],
    ];
    if(isset($_POST['dueDate'])){
        $arr=[
            "dueDate"=>$_POST['dueDate']
        ];
        $data+=$arr;
    }
    $value=$todo->saveData($data);
    echo json_encode($value);
}

if(isset($_POST['saveData']) && $_POST['saveData']=="edit"){
    $data=[
        'task_name'=>$_POST['TaskName'],
        'id'=>$_POST['id']
    ];
    $todo->editData($data);
    // var_dump($todo);
}

if(isset($_GET['getData']) && $_GET['getData']=="all-data"){
    $all=$todo->getData();
    echo json_encode($all);
}

if(isset($_POST['delate']) && $_POST['delate']=="deleteData"){
    $data=['id'=>$_POST['id']];
    $value=$todo->deleteData($data);
    echo $value;
}


?> 