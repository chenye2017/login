<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/12/13
 * Time: 15:11
 */

namespace Chenye2017\Login;

/*use Guzzle\Http\Client;*/


class Login
{
    protected $clientId;
    protected $redirectUri;
    protected $state;
    protected $qqAuthorizeUrl = 'https://graph.qq.com/oauth2.0/authorize';
    protected $getTokenUrl = 'https://graph.qq.com/oauth2.0/token';
    protected $getOpenIdUrl = 'https://graph.qq.com/oauth2.0/me?access_token=';
    protected $getUserinfoUrl = 'https://graph.qq.com/user/get_user_info';
    protected $clientSecret;
    protected $guzzleOptions = [];

    public function __construct($clientId, $redirectUri, $state = '')
    {
        $this->clientId    = $clientId;
        $this->redirectUri = $redirectUri;
        $this->state       = $state;
    }

    public function myCurl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (count($data) > 0 ) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }*/

    /**
     * 返回第三方登陆的qq登陆地址
     * @return string
     */
    public function LoginAddress()
    {
        $url   = $this->qqAuthorizeUrl;
        $data  = [
            'response_type' => 'code',
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'state'         => $this->state
        ];
        $query = http_build_query($data);
        $url   = $url . '?' . $query;
        return $url;
    }

    public function getUser($code, $state = '')
    {
        // 获取accessToken
        $data  = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'          => $code,
            'redirect_uri'  => $this->redirectUri
        ];
        $query = http_build_query($data);
        $url   = $this->getTokenUrl . '?' . $query;

        $resAccessToken = $this->myCurl($url);
        $resAccessToken = json_decode($resAccessToken, true);
        $accessTokenArr = [];
        parse_str($resAccessToken, $accessTokenArr); // 拆分结果存入变量arr中
        $accessToken = $accessTokenArr['access_token'];

        // 获取openid
        $url = $this->getOpenIdUrl . $accessToken;
        $resOpenId = $this->myCurl($url);
        // callback( {"client_id":"YOUR_APPID","openid":"YOUR_OPENID"} ); 返回结构
        $num = strrpos($resOpenId, ':');
        $resOpenId = substr($resOpenId, $num);
        $start  = strpos($resOpenId, '"');
        $end    = strrpos($resOpenId, '"');
        $openid = substr($resOpenId, $start + 1, $end - $start - 1);
// openid = C78FBCE1F9041715BE92435B19F5F895;

        // 获取用户信息
        $url  = $this->getUserinfoUrl;
        $data = [
            'access_token'       => $accessToken,
            'oauth_consumer_key' => $this->clientId,
            'openid'             => $openid
        ];
        $url  = $url . '?' . http_build_query($data);//var_dump($url);
        $resUserInfo  = $this->myCurl($url,$data);
        $resUserInfo = json_decode($resUserInfo, true);
        return $resUserInfo;
    }
}