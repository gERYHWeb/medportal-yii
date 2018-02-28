<?php

/*
 * @class: DBModel
 * @description: Middleware class for db objects
 */

namespace app\models;

use yii\db\ActiveRecord;

class DBModel extends ActiveRecord
{
    static $primaryKey;

    public static function getAll() {
        $class = get_called_class();
        $pk = static::$primaryKey;
        return $class::find()->orderBy($pk)->all();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    // Альтернатива mysql_real_escape_string()
    public static function mysqlEscapeString($data) {
        $data = str_replace("\\", "\\\\", $data);
        $data = str_replace("'", "\\'", $data);
        $data = str_replace('"', '\\"', $data);
        $data = str_replace("\x00", "\\x00", $data);
        $data = str_replace("\x1a", "\\x1a", $data);
        $data = str_replace("\r", "\\r", $data);
        $data = str_replace("\n", "\\n", $data);
        return($data);
    }

    public static function clearString($string){
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        return self::mysqlEscapeString($string);
    }

    public static function preVals($value){
        if(!$value) return [];
//        $connection = \Yii::$app->db;
        $bindVals = [];
        if(is_string($value)){
            $bindVals['value'] = $value;
        }else if(is_array($value)){
            foreach ($value as $k => $item) {
                if($item != ''){
                    $bindVals[$k] = self::clearString($item);
                }
            }
        }else return [];
        return $bindVals;
    }

    public static function preSQLParams(&$bindVals, $type = "update"){
        if(!$bindVals) return "";
        $i=0;
        $sql = "";
        $sqlVals = "";
        foreach ($bindVals as $key => $val) {
            $chkLast = ($i != (count($bindVals)-1));
            $val = ":$key";
            if($type == "update"){
                $sql .= "`$key`=$val";
            }else if($type == "insert"){
                $sql .= "`$key`";
                $sqlVals .= $val;
            }
            if($chkLast){
                $sql .= ", ";
                $sqlVals .= ", ";
            }
            $i++;
        }
        if($type == "insert"){
            $sql = "($sql) VALUES ($sqlVals)";
        }
        return $sql;
    }
}
