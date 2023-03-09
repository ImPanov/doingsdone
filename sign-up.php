<?php 
require_once("init.php");
require_once("models.php");
require_once("data.php");
require_once("validator.php");
require_once("helpers.php");

if (!$con) {
    $error = mysqli_connect_error();
}
$page_content = include_template("sign-up.php", [
]);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $required = ['email', 'password', 'name'];
    $errors = [];

    $rules = [
        'name' => function ($value) {
            return validate_length($value, 4, 32);
        },
        'email' => function ($value) {
            return validate_email($value);
        },
        'password' => function ($value) {
            return validate_length($value, 4, 64);
        }
    ];

    $user = filter_input_array(INPUT_POST, [
        'name' => FILTER_DEFAULT,
        'email' => FILTER_VALIDATE_EMAIL,
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
        $errors['fail'] = "kk";
            $page_content = include_template("sign-up.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
    } else {
        $users_data = get_user($con);
        $emails = array_column($users_data, 'email');
        $names = array_column($users_data, 'user_name');
        if(in_array($user['name'],$names)) {
            $errors['name'] = 'Такое имя уже существует';
        }
        if(in_array($user['email'],$emails)) {
            $errors['email'] = 'Такой email уже существует';
        }
        if (count($errors)) {
            
        $errors['fail'] = "kk";
            $page_content = include_template("sign-up.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
        } else {
            $sql = add_user($con);
            $user['password'] = password_hash($user["password"], PASSWORD_DEFAULT);
            $stmt = db_get_prepare_stmt($con, $sql, $user);
            $res = mysqli_stmt_execute($stmt);

            if($res) {
                header('Location: /sign-in.php');
            } else {
                $error = mysqli_error($con);
            }
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
