# 说明

这是一个 imi WebSocket 项目示例，演示了如何监听日志文件，并通过 Websocket 推送给客户端。

imi 框架：<https://www.imiphp.com>

imi 文档：<https://doc.imiphp.com>

## 涉及文件

WebSocket 控制器：`Module/Test/WebSocketController/TestController.php`

Http 控制器：`Module/Test/ApiController/IndexController.php`

服务层代码：`Module/Test/Service/TestService.php`

监听连接关闭事件：`Module/Test/Listener/OnClose.php`

## 调试

WebSocket 调试工具：<http://www.websocket-test.com/>

**连接：** `ws://127.0.0.1:8081/ws`

**开始监听：**

```js
{"action": "start"}
```

> 开始监听后，会把文件内所有内容按行推送给客户端。

**停止监听：**

```js
{"action": "stop"}
```

**访问接口记录日志：** <http://127.0.0.1:8081/api>

## 社群

**imi 框架交流群：** 17916227 [![点击加群](https://pub.idqqimg.com/wpa/images/group.png "点击加群")](https://jq.qq.com/?_wv=1027&k=5wXf4Zq)

**微信群：**（请注明来意）

<img src="https://cdn.jsdelivr.net/gh/imiphp/imi@2.1/res/wechat.png" alt="imi" width="256px" />

**打赏赞助：**<https://www.imiphp.com/donate.html>
