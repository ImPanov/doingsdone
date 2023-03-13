<?php
function validate_length($value,$min_size,$max_size) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min_size or $len > $max_size) {
            return "значение должно быть от $min_size до $max_size";
        }
    }
    return null;
}
function validate_email($email) {
    if ($email) {
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return "Введите корректный email";
        }
    }
    return null;
}
function validate_project($id, $allowed_list) {
    if ($id) {
        if(!in_array($id,$allowed_list)) {
            return "this project haven't got projects";
        }
    }
    return null;
}
function validate_date($date) {
    if($date) {
        if (is_date_valid($date)) {
            $now = date_create("now");
            $d = date_create($date);
            $diff = date_diff($d, $now);
            $interval = $diff->format("%d");
                if ($interval < 0) {
                    return "Дата должна быть больше или равна текущей";
                };
        } else {
            return "Содержимое поля «дата завершения» должно быть датой в формате «ГГГГ-ММ-ДД»";
        }
    }
    return null;
    
}