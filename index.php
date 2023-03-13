<?php 
require_once("init.php");
require_once("helpers.php");
require_once("models.php");
require_once("data.php");
$show_complete_tasks = filter_input(INPUT_GET, "show_complete_tasks", FILTER_VALIDATE_INT);
$time_ready = filter_input(INPUT_GET, "tr");
$task_id = filter_input(INPUT_GET, "task_id", FILTER_VALIDATE_INT);
$check = filter_input(INPUT_GET, "check", FILTER_VALIDATE_INT);
$project_id = filter_input(INPUT_GET, "project_id", FILTER_VALIDATE_INT);
if(isset($project_id)) {
    $_SESSION["project_id"] = $project_id;
}

if (isset($_GET['show_complete_tasks'])) {
    if ($_GET['show_complete_tasks'] === '1') {
        $_SESSION['show_complete_tasks'] = 1;
    } else {
        unset($_SESSION['show_complete_tasks']);
    }
}

if(!$con) {
    mysqli_connect_error();
} else {
    $projects = get_projects($con, $user_id);
    if(isset($_GET["tr"])) {
        switch($_GET["tr"]) {
            case "today":
                $tasks = get_tasks_today($con,$_SESSION["project_id"],$user_id);
                break;
            case "nextday":
                $tasks = get_tasks_nextday($con,$_SESSION["project_id"],$user_id);
                break;
            case "defeat":
                $tasks = get_tasks_defeat($con,$_SESSION["project_id"],$user_id);
                break;
            default:
                $tasks = get_tasks($con,$_SESSION["project_id"],$user_id);
                break;
        }
    } else {
        $tasks = get_tasks($con,$_SESSION["project_id"]??null,$user_id);
    }
    if(isset($_GET["task_id"]) && isset($_GET["check"])) {
        $sql = get_update_status_query($con);
        $stmt = db_get_prepare_stmt($con,$sql,[$check,$task_id,$user_id]);
        $res = mysqli_stmt_execute($stmt);
        if(!$res) {
            mysqli_error($con);
        } else {
            header("Location: index.php?show_complete_tasks=".$_SESSION['show_complete_tasks']??0);
        }
    }
}
$page_content = include_template(name: "main.php",data: [
    "projects" => $projects,
    "tasks" => $tasks,
    "show_complete_tasks" => $_SESSION['show_complete_tasks']??0,
]);

$layout_content = include_template(name: "layout.php",data: [
    'content' => $page_content,
    "title" => "Дела в порядке",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
]);

print($layout_content);

