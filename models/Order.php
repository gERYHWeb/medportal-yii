<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends DBModel
{
    static $primaryKey = "order_id";

    public static function tableName() {
        return 'orders';
    }

    public function afterFind(){
        $this->specialization = Consts::findOne($this->specialization)->attributes;
        $this->degree = Consts::findOne($this->degree)->attributes;
    }

    public static function updateOrder($post){
        $result = [ "result" => false, "msg" => "undefined_order" ];
        if(!(int)$post['order_id'] || $post['data']) {
            $order = Order::findOne($post['order_id']);
            if ($order) {
                $save = false;
                if (isset($post['data']['status'])) {
                    $save = true;
                    $order->status = (int)$post['data']['status'];
                }
                if ($save) {
                    $order->update();
                    $result["result"] = true;
                    $result["msg"] = "success_order_updated";
                } else {
                    $result["msg"] = "invalid_data";
                }
            }
        }
        return $result;
    }
}

    // Alternate method for addOrder

    //public function addOrder( $params ) {
    //    $result = false;
    //    if ( $params ) {
    //        try {
    //            $connection = \Yii::$app->db;
    //            $bindVals = self::preVals($params);
    //            $sql        = "INSERT INTO orders " . self::preSQLParams($bindVals, "insert");
    //            $_result    = $connection->createCommand( $sql )
    //                ->bindValues($bindVals)
    //                ->execute();
    //            if ( $_result ) {
    //                $result = \Yii::$app->db->getLastInsertID();
    //            }
    //        } catch ( Exception $e ) {
    //            Yii::error( 'Order.addOrder', print_r( $e, true ) );
    //            throw new Exception( "Error : " . $e );
    //        }
    //    }
    //
    //    return $result;
    //}
?>