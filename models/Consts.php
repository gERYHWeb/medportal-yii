<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Consts extends DBModel
{
    static $primaryKey = "const_id";

    public static $types = [
        "spec" => "Специалист",
        "degree" => "Степень доктора"
    ];

    public static function tableName() {
        return 'consts';
    }

    public static function updateConst($post){
        $result = [ "result" => false, "msg" => "undefined_const" ];
        $data = $post['data'];
        if(!(int)$post['const_id'] || $data) {
            $model = Consts::findOne($post['const_id']);
            if ($model) {
                $save = false;
                if (self::getType($data['type'])) {
                    $save = true;
                    $model->type = $data['type'];
                }
                if (isset($data['value'])) {
                    $save = true;
                    $model->value = $data['value'];
                }
                if ($save) {
                    $model->update();
                    $result["result"] = true;
                    $result["msg"] = "success_const_updated";
                } else {
                    $result["msg"] = "invalid_data";
                }
            }
        }
        return $result;
    }

	public static function getByType($type) {
        if(!$type) return [];
		$const = Consts::find()->where(["type" => $type])->all();
		return $const;
	}

    public static function getTypes(){
        return self::$types;
    }

    public static function getType($key){
        $key = trim($key);
        return self::$types[$key];
    }
}
?>