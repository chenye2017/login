<h1 align="center"> login </h1>

<p align="center"> fast third person login.</p>


## Installing

```shell
$ composer require chenye2017/login dev-master

```

## Usage

获取qq登陆地址

```
use Chenye2017\Login\Login as CLogin
$login = new CLogin($this->clientId, $this->clientSecret, $this->redirectUri, $state); // state 是你可以想传递的任意参数，在回调地址中可以获取到,默认是空
$loginAddress = $login->LoginAddress();
```

取用户信息

```
$login = new CLogin($this->clientId, $this->clientSecret, $this->redirectUri, $state);
$userinfo = $login->getUser($code); // code 是回调地址中的接收到的code,只能用一次
```

返回结果

```
{
    "ret": 0,
    "msg": "",
    "is_lost": 0,
    "nickname": "四月的谎言",
    "gender": "男",
    "province": "安徽",
    "city": "合肥",
    "year": "1994",
    "constellation": "",
    "figureurl": "http://qzapp.qlogo.cn/qzapp/101532880/C78FBCE1F9041715BE92435B19F5F895/30",
    "figureurl_1": "http://qzapp.qlogo.cn/qzapp/101532880/C78FBCE1F9041715BE92435B19F5F895/50",
    "figureurl_2": "http://qzapp.qlogo.cn/qzapp/101532880/C78FBCE1F9041715BE92435B19F5F895/100",
    "figureurl_qq_1": "http://thirdqq.qlogo.cn/qqapp/101532880/C78FBCE1F9041715BE92435B19F5F895/40",
    "figureurl_qq_2": "http://thirdqq.qlogo.cn/qqapp/101532880/C78FBCE1F9041715BE92435B19F5F895/100",
    "is_yellow_vip": "0",
    "vip": "0",
    "yellow_vip_level": "0",
    "level": "0",
    "is_yellow_year_vip": "0",
    "openid": "C78FBCE1F9041715BE92435B19F5F895"
}
```



## TODO
- 添加微博登录
- 添加github登陆
- 添加单元测试
- 拒绝登陆时候的处理

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/chenye2017/login/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/chenye2017/login/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
