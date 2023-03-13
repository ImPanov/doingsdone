<?php
require_once("models.php");
require_once("init.php");
require_once("helpers.php");
require_once("validator.php");
require_once("data.php");
$projects = get_projects($con,$user_id);
$projects_id = array_column($projects,"id");
$page_content = include_template("add-task.php", [
    "projects" => $projects,
]);
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $required = ["name","project"];
    $errors = [];

    $rules = [
        "name" => function ($value) {
            return validate_length($value,4,32);
        },
        "project" => function ($value) use ($projects_id) {
            return validate_project($value,$projects_id);
        },
        "date" => function ($value) {
            return validate_date($value);
        },        
    ];

    $task = filter_input_array(INPUT_POST,[
        "name" => FILTER_DEFAULT,
        "project" => FILTER_DEFAULT,
        "date" => FILTER_DEFAULT,
    ],true);

    foreach($task as $field => $value) {
        if(isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field]=$rule($value);
        }
        if(in_array($field, $required) && empty($value)) {
            $errors[$field] = "строка $field должна быть заполнена";
        }
    }
    $errors = array_filter($errors);

    if($_FILES['file-lot']['error']==UPLOAD_ERR_OK) {
        $name = $_FILES['file-lot']['name'];
        $tmp_name = $_FILES['file-lot']['tmp_name'];
        $task['file-lot'] = 'uploads/'.$name;
        move_uploaded_file($tmp_name,'uploads/'.$name);
    } else {
        $errors["file"] = "Загрузите файл";
    }

    if(count($errors)) {
        $page_content = include_template("add-task.php",[
            "task" => $task,
            "errors" => $errors,
            "projects" => $projects,
        ]);        
    } else {      
        $task["date"]=$task["date"]." 23:59:59";  
        $res = add_task($con,$task,$user_id);   
        if ($res) {
            header("Location: /index.php");
        } else {
            $error = mysqli_error($con);
        }     
    }
}
$layout_content = include_template(name: "layout.php",data: [
    'content' => $page_content,
    "title" => "Добавление задачи",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
]);

print($layout_content);
