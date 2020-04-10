<?php
	$sql_host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$sql_db_name = "purecolor";
	$conn = mysqli_connect($sql_host, $sql_username, $sql_password);
	if(!$conn){
		die(mysqli_error());
	}
	mysqli_select_db($conn, $sql_db_name);

	$default_color_json = '
	[
		{
			"name": "Argon",
			"colors": [
				{"hex": "#5e72e4" , "name": "Argon"}
			],
			"autosort" : false
		},
		{
			"name": "Material 标准颜色",
			"colors": [
				{"hex": "#F44336" , "name": "Red"},
				{"hex": "#E91E63" , "name": "Pink"},
				{"hex": "#9C27B0" , "name": "Purple"},
				{"hex": "#673AB7" , "name": "Deep Purple"},
				{"hex": "#3F51B5" , "name": "Indigo"},
				{"hex": "#2196F3" , "name": "Blue"},
				{"hex": "#03A9F4" , "name": "Light Blue"},
				{"hex": "#00BCD4" , "name": "Cyan"},
				{"hex": "#009688" , "name": "Teal"},
				{"hex": "#4CAF50" , "name": "Green"},
				{"hex": "#8BC34A" , "name": "Light Green"},
				{"hex": "#CDDC39" , "name": "Lime"},
				{"hex": "#FFEB3B" , "name": "Yellow"},
				{"hex": "#FFC107" , "name": "Amber"},
				{"hex": "#FF9800" , "name": "Orange"},
				{"hex": "#FF5722" , "name": "Deep Orange"},
				{"hex": "#795548" , "name": "Brown"},
				{"hex": "#9E9E9E" , "name": "Grey"},
				{"hex": "#607D8B" , "name": "Blue Grey"}
			],
			"autosort" : false
		},
		{
			"name": "清新",
			"colors": [
				{"hex": "#cb7574" , "name": "石红"},
				{"hex": "#ec8a64" , "name": "橘橙"},
				{"hex": "#f7c280" , "name": "浅杏"},
				{"hex": "#dfe291" , "name": "酪黄"},
				{"hex": "#aae2b1" , "name": "明绿"},
				{"hex": "#97c3c6" , "name": "浅葱"},
				{"hex": "#95c7e0" , "name": "秋波"},
				{"hex": "#9aaec7" , "name": "雾霾"},
				{"hex": "#99a5cd" , "name": "山梗"},
				{"hex": "#b99ed3" , "name": "藤萝"},
				{"hex": "#f48fb1" , "name": "嫩粉"},
				{"hex": "#ddb5be" , "name": "石蕊"},
				{"hex": "#bbb9ba" , "name": "亚麻"},
				{"hex": "#f5ece7" , "name": "珍珠"},
			],
			"autosort" : false
		},
		{
			"name": "Rainbow",
			"colors": [
				{"hex": "#7e79e2" , "name": "薰衣草"},
				{"hex": "#627abc" , "name": "深蓝色"},
				{"hex": "#1197cf" , "name": "亮蓝色"},
				{"hex": "#85cefb" , "name": "蓝色"},
				{"hex": "#5ea8c1" , "name": "烟灰蓝"},
				{"hex": "#3cc4c5" , "name": "夏日绿"},
				{"hex": "#92e3da" , "name": "蓝绿色"},
				{"hex": "#9fdc96" , "name": "绿色"},
				{"hex": "#c9e472" , "name": "柑橘绿"},
				{"hex": "#f7ff98" , "name": "柠檬黄"},
				{"hex": "#eedd68" , "name": "黄色"},
				{"hex": "#febb41" , "name": "金色"},
				{"hex": "#f7a97b" , "name": "杏橙色"},
				{"hex": "#ec8a64" , "name": "金红色"},
				{"hex": "#eb686d" , "name": "珊瑚粉"},
				{"hex": "#f74449" , "name": "红色"},
				{"hex": "#e1534a" , "name": "朱红色"},
				{"hex": "#c92642" , "name": "深红色"},
				{"hex": "#ee9cb3" , "name": "粉色"},
				{"hex": "#da6da1" , "name": "赤紫色"},
				{"hex": "#a86fc7" , "name": "紫色"},
				{"hex": "#9b80a9" , "name": "灰紫色"},
				{"hex": "#b3b2b7" , "name": "灰色"},
				{"hex": "#636267" , "name": "深灰色"},
				{"hex": "#68574f" , "name": "棕色"}
			],
			"autosort" : false
		},
		{
			"name": "Colourful",
			"colors": [
				{"hex": "subtitle" , "name": "Light"},
				{"hex": "#ffaab2" , "name": "荧光粉"},
				{"hex": "#ffbbb0" , "name": "荧光橙"},
				{"hex": "#f4f597" , "name": "荧光黄"},
				{"hex": "#acd7b7" , "name": "荧光绿"},
				{"hex": "#a2c1de" , "name": "荧光蓝"},
				{"hex": "#c5b8d1" , "name": "荧光紫"},
				{"hex": "subtitle" , "name": "Mild"},
				{"hex": "#ef8f91" , "name": "樱红"},
				{"hex": "#e1bd4b" , "name": "金黄"},
				{"hex": "#b2c16f" , "name": "苹果绿"},
				{"hex": "#98ded8" , "name": "水蓝"},
				{"hex": "#93bdf0" , "name": "深蓝"},
				{"hex": "#aaaaaa" , "name": "亚麻灰"},
				{"hex": "subtitle" , "name": "Macaron"},
				{"hex": "#fa92b5" , "name": "芭比粉"},
				{"hex": "#ac94db" , "name": "梦幻紫"},
				{"hex": "#43bec5" , "name": "晴空蓝"},
				{"hex": "#c6ce86" , "name": "青柠"},
				{"hex": "#fb9b5e" , "name": "蜜柚橘"},
				{"hex": "#f5592c" , "name": "甜心橙"},
				{"hex": "subtitle" , "name": "Retro"},
				{"hex": "#4a8fa1" , "name": "黛绿"},
				{"hex": "#6893ac" , "name": "夕雾"},
				{"hex": "#d4646b" , "name": "勃艮第红"},
				{"hex": "#e57464" , "name": "山茶红"},
				{"hex": "#6c6845" , "name": "雪松"},
				{"hex": "#7e5334" , "name": "焦糖棕"}
			],
			"autosort" : false
		}
	]';
?>