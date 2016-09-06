<?php

abstract class Model_Model
{

    public function validData($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = substr($data, 0, 155);

        return array('data' => $data);
    }
}