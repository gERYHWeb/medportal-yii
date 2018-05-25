<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Breadcrumbs extends Component
{
    protected $homeLink;
    protected $request;
    protected $session;

    /**
     * Initializes this component for create dependencies in files of view.
     */
    public function init()
    {
        parent::init();
        $this->request = Yii::$app->request;
        $this->session = Yii::$app->session;
        $this->homeLink = [
            'label' => Yii::t('yii', 'Home'),
            'url' => Yii::$app->homeUrl,
        ];
    }

    public function get()
    {
        return $this->session->get('breadcrumbs');
    }

    public function clear()
    {
        $this->session->remove('breadcrumbs');
        return $this;
    }

    public function set($items)
    {
        if(!$items){
            return null;
        }else if(isset($items['label']) || is_string($items)){
            $items = [$items];
        }

        $links = [];
        if($items){
            foreach ($items as $item) {
                $links[] = $item;
            }
        }
        $this->session->set('breadcrumbs', $links);
        return $this;
    }

    public function render()
    {
        $breadcrumbs = $this->session->get('breadcrumbs');
        if(!$breadcrumbs){
            return "";
        }else{
            $lastIndex = count($breadcrumbs) - 1;
            unset($breadcrumbs[$lastIndex]['url']);
        }
        return \yii\widgets\Breadcrumbs::widget([
            'homeLink' => $this->homeLink,
            'links' => $breadcrumbs,
        ]);
    }
}