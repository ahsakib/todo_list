<?php 

include "class/Todo.php";
$todo=new Todo();

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

    $todo->getData();

}

if(isset($_POST['saveData']) && $_POST['saveData']=="edit"){
    $data=[
        'task_name'=>$_POST['TaskName'],
        'id'=>$_POST['id']
    ];
    $todo->editData($data);
}

if(isset($_GET['getData']) && $_GET['getData']=="all-data"){
    $todo->getData();
}

if(isset($_POST['delate']) && $_POST['delate']=="deleteData"){
    $data=['id'=>$_POST['id']];
    $value=$todo->deleteData($data);
    echo $value;
}

if(isset($_POST['completeId'])){
    $completeData=$todo->completeDataSave($_POST);
    $countData=$todo->getCountCompleteData();

    echo json_encode(['data'=>$completeData,"count"=>$countData]);

}

if(isset($_POST['getCompleteData'])){
    $todo->getCompleteData();
}
?> 