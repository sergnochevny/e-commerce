<?php

abstract class Model_Model
{

    public static function validData($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = trim($data);
        return $data;
    }
}