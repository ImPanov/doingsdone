<?php
require_once("data.php");
require_once("helpers.php");
require_once("init.php");
require_once("models.php");
require_once("validator.php");

if (!$con) {
    $error = mysqli_connect_error();
}
$page_content = include_template("sign-in.php", []);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $required = ['email', 'password'];
    $errors = [];

    $rules = [
        'email' => function ($value) {
            return validate_email($value);
        },
        'password' => function ($value) {
            return validate_length($value, 0,100);
        }
    ];

    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,        
    ], true);

    foreach($user as $field => $value) {
        if(isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if(in_array($field,$required) && empty($value)) {
            $errors[$field] = "Поле $field требуется заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
            $page_content = include_template("sign-in.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
    } else {
        $users_data = get_auth_user($con,$user['email']);
        if($users_data) {
            if (password_verify($user['password'],$users_data[0]['password'])) {
                    session_start();
                    $_SESSION['name'] = $users_data[0]['user_name'];
                    $_SESSION['id'] = $users_data[0]['id'];
                    header('Location: /index.php');
            } else {
            $errors['password'] = 'Неверный пароль';
            $page_content = include_template("sign-in.php", [
                'errors' => $errors,
                "user" => $user,
            ]);  
            }
        } else {
            $errors['login'] = 'Неверный логин';
            $page_content = include_template("sign-in.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
        }
    }
}
$layout_content = include_template(name: "layout.php",data: [
    'content' => $page_content,
    "title" => "Дела в порядке",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
]);

print($layout_content);
