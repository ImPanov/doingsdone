<?php 
require_once("init.php");
require_once("helpers.php");
require_once("models.php");
require_once("data.php");
require_once("validator.php");
$page_content = include_template("add-project.php", [
]);
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $project = filter_input(INPUT_POST,"name");
    $error = '';

    if(empty($project)) {
        $error="поле \"Название\" должно быть заполнено";
    } elseif (validate_length($project,4,32)) {
        $error="длина названия должна быть от 4 до 32";
    }
    if($error) {
        $page_content = include_template("add-project.php", [
            "project" => $project,
            "error" => $error,
        ]);
    } else {
        $res = add_project($con,$project,$user_id);
        if($res) {
            header("Location: index.php"); 
        } else {
            mysqli_error($con);
        }
    }
}
$layout_content = include_template(name: "layout.php",data: [
    'content' => $page_content,
    "title" => "Добавление проекта",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
]);

print($layout_content);

