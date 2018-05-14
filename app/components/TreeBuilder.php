<?php
namespace app\components;

use Yii;

class TreeBuilder
{
    protected $items;
    protected $key;
    protected $parentKey;

    public function __construct($items, $key, $parentKey)
    {
        $this->items = $items;
        $this->parentKey = $parentKey;
        $this->key = $key;
    }

    public function buildTree()
    {
        $items = $this->items;
        $parentKey = $this->parentKey;
        $key = $this->key;

        $return = [];
        if($items) {
            foreach ($items as $item) {
                if($item[$parentKey] == 0){
                    self::recursive($item, $item[$key]);
                    $return[] = $item;
                }
            }
        }
        return $return;
    }

    public function recursive(&$return, $current_id, $onlyIDs = false, $toParent = false){
        $items = $this->items;
        $parentKey = $this->parentKey;
        $key = $this->key;

        $children = [];
        if(!$current_id) return $return;
        for($i=0; $i<count($items); $i++){
            $item = $items[$i];
            $id = ($toParent) ? $item[$key] : $item[$parentKey];
            if($id == $current_id){
                if($onlyIDs){
                    $return[] = $item[$key];
                    self::recursive($return, ((!$toParent) ? $item[$key] : $item[$parentKey]), true, $toParent);
                }else{
                    self::recursive($item, $item[$key]);
                    $children[] = $item;
                }
            }
        }
        if($children) {
            $return['children'] = $children;
        }
    }
}