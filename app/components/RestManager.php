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
    protected $route;
    protected $parameters;
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
        $app = Yii::$app;
        $this->request = $app->request;
        $this->curl = new Curl();
        $this->setHeaders([
            'client_language' => $app->locale->getLanguage('code'),
            'client_country' => $app->locale->getCountry('code'),
            'client_ip_address' => $app->request->getUserIP(),
            'client_user_agent' => $app->request->getUserAgent(),
        ]);

    }

    public function dependencies($data = []) {
        $response = $this->get('help/dependencies', $data);
        return $response;
    }

    public function cities($data = []) {
        $response = $this->get('help/cities', $data);
        return $response;
    }

    public function vip($data = []) {
        $adverts = $this->get('adverts/vip', $data);
        return $adverts;
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


    public function profile($data = []) {
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

    public function page($data = []) {
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

    public function post($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("post");
        return $result;
    }

    public function put($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("put");
        return $result;
    }

    public function patch($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("patch");
        return $result;
    }

    public function delete($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("delete");
        return $result;
    }

    public function head($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("head");
        return $result;
    }

    public function get($route, $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
        $result = $this->request("get");
        return $result;
    }

    protected function beforeSend($result)
    {
        if($this->isRoute){
            $this->url = Url::to("{$this->host}/{$this->prefix}{$this->route}");
        }
        return $result;
    }

    protected function afterSend($result)
    {
        if($this->responseType == "array"){
            $result = json_decode($result, true);
        }
        $result = $this->setCache($this->route, $result);
        return $result;
    }

    protected function request($type)
    {
        $parameters = $this->parameters;
        $curl = $this->curl;
        if($result = $this->getCache($this->route)){
            return $result;
        }
        $result = $this->beforeSend($result);
        $curl = $this->curl;
        $url = $this->url;
        switch ($type) {
            case "get":
                if ($parameters) {
                    $curl->setGetParams($parameters);
                }
                $result = $curl->get($url);
                break;
            case "head":
                if ($parameters) {
                    $curl->setGetParams($parameters);
                }
                $result = $curl->head($url);
                break;
            case "post":
                if ($parameters) {
                    if (!$this->isRawData) {
                        $curl->setPostParams($parameters);
                    } else {
                        $curl->setRawPostData($parameters);
                    }
                }
                $result = $curl->post($url);
                break;
            case "patch":
                if ($parameters) {
                    $curl->setPostParams($parameters);
                }
                $result = $curl->patch($url);
                break;
            case "put":
                if ($parameters) {
                    $curl->setPostParams($parameters);
                }
                $result = $curl->put($url);
                break;
            case "delete":
                if ($parameters) {
                    $curl->setPostParams($parameters);
                }
                $result = $curl->delete($url);
                break;
        }
        $result = $this->afterSend($result);
        return $result;
    }

    public function getCache($key)
    {
        return (isset($this->cache[$key])) ? $this->cache[$key] : false;
    }

    public function setCache($key, $value)
    {
        return $this->cache[$key] = $value;
    }

    public function setHost($host)
    {
        $this->host = preg_replace("/\/$/", "", $host);
    }

    public function setHeaders($headers = [])
    {
        if($headers) {
            $this->curl->setHeaders($headers);
            return true;
        }
        return false;
    }

    public function getHost()
    {
        if(strpos($this->host, '@')){
            return Yii::getAlias($this->host);
        }else{
            return $this->host;
        }
    }
}