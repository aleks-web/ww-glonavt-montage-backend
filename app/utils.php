<?php

namespace WWCrm;

class Utils {

    public function formatTel(string|int $tel) : string|int {
        return preg_replace('/[^0-9]/', '', $tel);
    }

}