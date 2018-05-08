<?php
namespace app\components;

use Yii;
use linslin\yii2\curl\Curl;
use yii\base\Component;
use yii\helpers\Url;

class Dependencies extends Component
{
    protected $dependencies;
    protected $request;
    protected $rest;
    protected $result = [];

    /**
     * Initializes this component for create dependencies in files of view.
     */
    public function init()
    {
        parent::init();
        $this->request = Yii::$app->request;
        $this->rest = Yii::$app->rest;
    }

    protected function set($dependence, $data = [])
    {
        if(is_array($dependence)){
            $deps = $dependence;
            foreach($deps as $k => $v){
                if((int)$k){
                    $dependencies[$v] = [];
                }else{
                    $dependencies[$k] = $v;
                }
            }
        }else {
            $dependencies = $this->dependencies;
            $dependencies[$dependence] = $data;
        }
    }

    protected function collect()
    {
        $dependencies = $this->dependencies;
        if($dependencies){
            foreach ($dependencies as $dependency => $data) {
                if(property_exists($this->rest, $dependency)) {
                    $this->result[$dependency] = $this->rest->$dependency($data);
                }
            }
        }
    }

}