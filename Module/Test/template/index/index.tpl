<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>imi WebSocket Demo</title>
</head>
<body>
	<h1 style="text-align: center">imi WebSocket Demo</h1>
	<div class="wrap">
		<div><textarea style="width:100%;height:450px" id="textShow" readonly></textarea></div>
		<p>内容：</p>
		<div style="text-align:center">
			<textarea style="width:100%;height:100px" id="textInput" placeholder="回车发送，shift+回车换行"></textarea>
			<button id="btnSend">发送</button>
		</div>
	</div>
	<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
	<script>
        var wsUrl = 'ws://127.0.0.1:8081/ws'; // 修改为你的地址
		function getNowFormatDate() {
			var date = new Date();
			var seperator1 = "-";
			var seperator2 = ":";
			var month = date.getMonth() + 1;
			var strDate = date.getDate();
			if (month >= 1 && month <= 9) {
				month = "0" + month;
			}
			if (strDate >= 0 && strDate <= 9) {
				strDate = "0" + strDate;
			}
			var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
				+ " " + date.getHours() + seperator2 + date.getMinutes()
				+ seperator2 + date.getSeconds();
			return currentdate;
		}
		function fuckXSS(val) {
			var s = "";
			if(val.length == 0) return "";
			s = val.replace(/&/g,"&amp;");
			s = s.replace(/</g,"&lt;");
			s = s.replace(/>/g,"&gt;");
			s = s.replace(/ /g,"&nbsp;");
			s = s.replace(/\'/g,"&#39;");
			s = s.replace(/\"/g,"&quot;");
			return s;
		};
		
		var messageCache = [];

		messageCache.push("Connecting...\r\n");
		var ws = new WebSocket(wsUrl);
 
		ws.onopen = function(evt) {
			console.log(evt)
			messageCache.push("Connection open\r\n\r\n");
		};

		ws.onmessage = function(evt) {
			messageCache.push(getNowFormatDate() + "\r\n" + fuckXSS(evt.data.substring(0, 128)) + "\r\n\r\n");
		};

		ws.onclose = function(evt) {
			messageCache.push("Connection closed\r\n");
		};
	</script>

	<style>
	.wrap{
		width: 1000px;
		margin: 0 auto;
	}
	</style>
</body>
</html>