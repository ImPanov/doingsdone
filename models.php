<?php
function add_user($con): string {
    $sql = "INSERT INTO users(user_name,email,password) VALUES (?, ?, ?);";
    return $sql;
}
function add_project($con,$project_name,$user_id) {
    $sql = "INSERT INTO projects(title,user_id) VALUES ('$project_name',$user_id)";
    return mysqli_query($con,$sql);
}
function get_projects($con,$user_id) {
    $sql = "SELECT projects.id, projects.title, projects.user_id, COUNT(tasks.id) AS project_count
    FROM projects
    LEFT JOIN tasks ON tasks.project_id = projects.id
    WHERE projects.user_id = $user_id
    GROUP BY projects.id";
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_tasks($con,$project_id,$user_id) {
    $sql = "SELECT tasks.id, tasks.title, tasks.date_creation, tasks.status, tasks.deadline, tasks.file, projects.title AS project_title
    FROM tasks
    INNER JOIN projects ON tasks.project_id = projects.id    
    WHERE tasks.user_id = $user_id";
    if($project_id) {
        $sql.=" AND projects.id=$project_id";
    }
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_tasks_today($con,$project_id,$user_id) {
    $sql = "SELECT tasks.id, tasks.title, tasks.date_creation, tasks.status, tasks.deadline, tasks.file, projects.title AS project_title
    FROM tasks
    INNER JOIN projects ON tasks.project_id = projects.id
    WHERE tasks.user_id = $user_id AND (tasks.deadline is null OR (CURRENT_TIMESTAMP - tasks.deadline BETWEEN 0 and 86400))";
    if($project_id) {
        $sql.=" AND projects.id=$project_id";
    }
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
function get_tasks_nextday($con,$project_id,$user_id) {
    $sql = "SELECT tasks.id, tasks.title, tasks.date_creation, tasks.status, tasks.deadline, tasks.file, projects.title AS project_title
    FROM tasks
    INNER JOIN projects ON tasks.project_id = projects.id
    WHERE  tasks.user_id = $user_id AND (CURRENT_TIMESTAMP - tasks.deadline BETWEEN 86401 and 172800)";
    if($project_id) {
        $sql.=" AND projects.id=$project_id";
    }
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_tasks_defeat($con,$project_id,$user_id) {
    $sql = "SELECT tasks.id, tasks.title, tasks.date_creation, tasks.status, tasks.deadline, tasks.file, projects.title AS project_title
    FROM tasks
    INNER JOIN projects ON tasks.project_id = projects.id
    WHERE  tasks.user_id = $user_id AND (CURRENT_TIMESTAMP - tasks.deadline < 0 and tasks.status = false)";
    if($project_id) {
        $sql.=" AND projects.id=$project_id";
    }
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_update_status_query($con) { 
    $sql = "UPDATE tasks SET status = ? WHERE id = ? AND tasks.user_id= ? ";
    return $sql;
}
function get_user($con): array {
    $sql = 'SELECT users.id, users.user_name, users.password, users.email FROM users';
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_auth_user($con,$email): array {
    $sql = "SELECT users.id, users.user_name, users.password, users.email FROM users WHERE email = '$email'";    
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}