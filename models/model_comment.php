<?php

class Model_Comment
{
    private $ID;
    private $Title;
    private $Data;
    private $Date;
    private $UserID;
    private $Moderated;
    private $UserName;

    private function convertToModel($DB_Array)
    {
        $this->ID = $DB_Array['id'];
        $this->Title = $DB_Array['title'];
        $this->Data = $DB_Array['data'];
        $this->Date = $DB_Array['dt'];
        $this->UserID = $DB_Array['userid'];
        $this->Moderated = $DB_Array['moderated'];
        $this->UserName = isset($DB_Array['username']) ? $DB_Array['username'] : "";
    }

    private function connvertToArray()
    {
        $array['id'] = $this->ID;
        $array['title'] = $this->Title;
        $array['data'] = $this->Data;
        $array['dt'] = $this->Date;
        $array['userid'] = $this->UserID;
        $array['moderated'] = $this->Moderated;
        $array['username'] = $this->UserName; //Bug

        return $array;
    }

    public function __construct($ID, $Title = null, $Data = null, $Date = null, $UserID = null, $Moderated = null)
    {
        if (is_null($Data) && is_null($UserID) && is_null($Moderated)) {
            $this->convertToModel($ID);
        } else {
            $this->ID = $ID;
            $this->Title = $Title;
            $this->Data = $Data;
            $this->Date = $Date;
            if ($Date == null) {
                $this->Date = time("Y-m-d H:M:S");
            }
            $this->UserID = $UserID;
            $this->Moderated = $Moderated;
            $this->UserName = "Unknown user";
        }
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getTitle()
    {
        return $this->Title;
    }

    public function getData()
    {
        return $this->Data;
    }

    public function getDate()
    {
        return $this->Date;
    }

    public function getUserID()
    {
        return $this->UserID;
    }

    public function getModerated()
    {
        return $this->Moderated ? "1" : "0";
    }

    public function getUserName()
    {
        return $this->UserName;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function setTitle($title)
    {
        $this->Title = $title;
    }

    public function setData($Data)
    {
        $this->Data = $Data;
    }

    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    public function setUserID($UserID)
    {
        $this->UserID = $UserID;
    }

    public function setModerated($Moderated)
    {
        $this->Moderated = $Moderated;
    }

    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

    public function toArray()
    {
        return $this->connvertToArray();
    }
}