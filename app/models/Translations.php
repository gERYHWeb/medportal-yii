<?php

	namespace app\models;

	use Yii;
	use yii\db\ActiveRecord;

	class Translations extends ActiveRecord {

		public static function tableName() {
			return 'translations';
		}

		public function getValueByKey($key = false, $lang = "ru") {
			$result = false;
			if($key != false) {
				$key = trim($key);
				try {
					$connection = \Yii::$app->db;
					$sql = "SELECT value FROM translations WHERE link = '$key' AND lang='$lang'";

					$_result = $connection->createCommand($sql)->queryOne();
					if(isset($_result) && isset($_result['value'])) {
						$result = $_result['value'];
					} else {
						$result = $lang . "_" . $key;
					}
				} catch(Exception $e) {
					Yii::error('Translations.getValueByKey', print_r($e, true));
					throw new Exception("Error : " . $e);
				}
			}

			return $result;
		}

		public function listTranslations($lang = "ru") {
			$result = array();
			try {
				$url = Yii::$app->params['root_rest_url'] . "help/translations?language=" . $lang;
				$_res = Utility::getData($url);
				if (isset($_res) && isset($_res["data"]) && isset($_res["result"]) && $_res["result"] == true) {
					$result = $_res["data"];
				}
			} catch(Exception $e) {
				Yii::error('Translations.listTranslations', print_r($e, true));
				throw new Exception("Error : " . $e);
			}

			return $result;
		}

		public function setValueByKey($key = false, $value = false) {
			$result = false;
			if($key != false) {
				$key = trim($key);
				try {
					$connection = \Yii::$app->db;
					$sql = "SELECT val FROM config WHERE link = '$key'";
					$_result = $connection->createCommand($sql)->queryOne();
					if(isset($_result) && isset($_result['val'])) {
						$sql = "UPDATE config SET val = \"" . $value . "\" WHERE link=\"" . $key . "\"";
					} else {
						$sql = "INSERT INTO config (link, val) VALUES ('$key','$value')";
					}
					$result = $connection->createCommand($sql)->execute();
				} catch(Exception $e) {
					Yii::error('Config.getValueByKey', print_r($e, true));
					throw new Exception("Error : " . $e);
				}
			}

			return $result;
		}
	}
