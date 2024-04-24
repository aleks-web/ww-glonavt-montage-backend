<?php

namespace WWCrm;

class Utils {

    /*
        Убирает все кроме цифр
    */
    public function formatTel(string|int $tel) : string|int {
        return preg_replace('/[^0-9]/', '', $tel);
    }

    /*
        Проверяет валидность имени
        
        true возвращается в случае если нет посторонних символов или строка пуста
    */
    public function isValidFio(string|array $fio) : bool {

        $validate = true;

        if (empty($fio)) {
            return true;
        }

        if (is_array($fio)) {
            foreach ($fio as $val) {
                if ($validate) {
                    if (preg_match('/^[а-яА-Яa-zA-Z ]+$/u', $val)) {
                        $validate = true;
                    } else {
                        $validate = false;
                    }
                }
            }
        } else {
            if (preg_match('/^[а-яА-Яa-zA-Z ]+$/u', $fio)) {
                $validate = true;
            } else {
                $validate = false;
            }
        }

        return $validate;
    }

    /*
        Проверяет валидность Email
    */
    public function isValidEmail(string $email) : bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}