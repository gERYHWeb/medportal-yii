<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoryForm extends yii\base\Model
{
       public $status;
       
       public function ruls() {
           return [
               ['status', 'required'],
           ];
       }
}