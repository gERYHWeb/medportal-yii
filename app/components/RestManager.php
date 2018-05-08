<?php
namespace app\components;

use Yii;
use linslin\yii2\curl\Curl;
use yii\base\Component;
use yii\helpers\Url;

class RestManager extends Component
{
    protected $curl;
    protected $request;
    protected $url;
    protected $data;
    public $isRawData = false;
    public $isRoute = true;
    protected $prefix = 'api/';
    protected $host = '@backend';
    protected $cache = [];
    public $responseType = 'array';

    /**
     * Initializes this component for sending restfull requests.
     */
    public function init()
    {
        parent::init();
        $this->request = Yii::$app->request;
        $this->curl = new Curl();
        $this->curl->setHeaders([
            'client_language' => 'ru',
            'client_country' => 'kz',
            'client_ip_address' => $this->request->getUserIP(),
            'client_user_agent' => $this->request->getUserAgent(),
        ]);
    }

    public function defaultLanguage() {
        $response = $this->get("help/default-language");
        if(isset($response['res']) && $response['res'] != "") {
            $_lang_site = json_decode($response['res'], true);

            if(isset($_lang_site["result"]) && $_lang_site["result"] != "" && isset($_lang_site["data"]["language"]) && $_lang_site["data"]["language"] != "") {
                $this->default_language = $_lang_site["data"]["language"];
                $this->default_id_language = $_lang_site["data"]["id_lang"];
            }
        }
    }

    public function dependencies() {
        $response = $this->get('help/dependencies');
        return $response;
    }

    public function cities() {
        $response = $this->get('help/cities');
        return $response;
    }

    public function vipAdverts() {
        $adverts = $this->get('adverts', array_merge([
            'random' => true,
            'isVip' => true
        ], $this->request->get()));
        dd($adverts);

        $vip = json_decode($get_vip, true);
        if(isset($vip['result']) && $vip['result'] == true && isset($vip['data'])) {
            return $this->view->params["vip_adverts"] = $vip['data'];
        }
    }

    public function advertByCategory($name_category) {
        $result = false;

        $response = $this->get('advert/get-list-advert-category', [
            'name_category' => $name_category
        ]);

        if(isset($response['res']) && $response['res'] != "") {
            $_list_adverts = json_decode($response['res'], true);

            if(isset($_list_adverts["result"]) && $_list_adverts["result"] != "" && isset($_list_adverts["data"])) {
                $this->list_advert = $_list_adverts["data"];
                $result = true;
            }
        }

        return $result;
    }


    public function profile() {
        if(count($this->view->params["profile_user"]) == 0) {
            $get_prof = $this->rest->get('user/profile', [
                'token' => $_SESSION['token']
            ]);
            $res = json_decode($get_prof['res'], true);

            if(isset($res['result']) && $res["result"] == true && isset($res["data"])) {
                $this->view->params["profile_user"] = $res["data"];
            }
        }
    }

    public function page() {
        $url = preg_replace("/^(.*)\?.*/","$1",Yii::$app->request->getUrl());
        if(!$this->view->params["page_info"]) {
            $url = Yii::$app->params['root_rest_url'] . "help/get-page-info?url=" . urlencode($url);
            $response = $this->rest->get($url);
            $res = json_decode($response['res'], true);

            if(isset($res['result']) && $res["result"] == true && isset($res["data"])) {
                $page = $res["data"];
                $this->setViewParams([
                    "page_info" => $page,
                    "title" => $page['seo_title'],
                    "description" => $page['seo_desc']
                ]);
            }
        }
    }

    public function post($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("post");
        return $result;
    }

    public function put($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("put");
        return $result;
    }

    public function patch($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("patch");
        return $result;
    }

    public function delete($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("delete");
        return $result;
    }

    public function head($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("head");
        return $result;
    }

    public function get($url, $data = [])
    {
        $this->url = $url;
        $this->data = $data;
        $result = $this->request("get");
        return $result;
    }

    protected function beforeSend($result)
    {
        if($this->isRoute){
            $this->url = Url::to("{$this->host}/{$this->prefix}{$this->url}");
        }
        return $result;
    }

    protected function afterSend($result)
    {
        $result = $this->setToCache($this->url, $result);
        if($this->responseType == "array"){
            $result = json_decode($result, true);
        }
        return $result;
    }

    protected function request($type)
    {
        $data = $this->data;
        $curl = $this->curl;
        if($result = $this->getFromCache($this->url)){
            return $result;
        }
        $result = $this->beforeSend($result);
        $curl = $this->curl;
        $url = $this->url;
        switch ($type) {
            case "get":
                if ($data) {
                    $curl->setGetParams($data);
                }
                $result = $curl->get($url);
                break;
            case "head":
                if ($data) {
                    $curl->setGetParams($data);
                }
                $result = $curl->head($url);
                break;
            case "post":
                if ($data) {
                    if (!$this->isRawData) {
                        $curl->setPostParams($data);
                    } else {
                        $curl->setRawPostData($data);
                    }
                }
                $result = $curl->post($url);
                break;
            case "patch":
                if ($data) {
                    $curl->setPostParams($data);
                }
                $result = $curl->patch($url);
                break;
            case "put":
                if ($data) {
                    $curl->setPostParams($data);
                }
                $result = $curl->put($url);
                break;
            case "delete":
                if ($data) {
                    $curl->setPostParams($data);
                }
                $result = $curl->delete($url);
                break;
        }
        $result = $this->afterSend($result);
        return $result;
    }

    protected function getFromCache($key){
        return (isset($this->cache[$key])) ? $this->cache[$key] : false;
    }

    protected function setToCache($key, $value){
        return $this->cache[$key] = $value;
    }

    public function setHost($host){
        $this->host = preg_replace("/\/$/", "", $host);
    }

    public function getHost(){
        if(strpos($this->host, '@')){
            return Yii::getAlias($this->host);
        }else{
            return $this->host;
        }
    }
}