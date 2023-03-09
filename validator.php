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