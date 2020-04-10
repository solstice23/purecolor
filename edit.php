<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>纯 · 色</title>
		<link href="css/style.css" type='text/css' rel='stylesheet'>
		<script src="js/vue.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:300&display=swap" rel="stylesheet">
		<script src='js/jquery-3.4.1.min.js'></script>
		<script src='js/pickr.min.js'></script>
		<link href="css/pickr-monolith.min.css" type='text/css' rel='stylesheet'>
	</head>
	<style id="now_color_definition">
		:root{
			--color: #5e72e4;
			--color-rgb: 94, 114, 228;
		}
	</style>
	<script>
		var editing_id = 0;
	</script>
	<body>
		<div id="app" class="edit" v-bind:class="{toolight: vistoolight(color)}">
			<div id="head-edit">
				<div id="title" class="editpage-title">
					{{id == 0 ? "新建色卡" : "基于该色卡新建"}}
					<div id="subtitle">{{title == "" ? "纯 · 色" : title}}</div>
				</div>
			</div>
			<div id="content-edit">
				<div id="palette-info" class="form-group" style="border: none;background: transparent;">
					<div style="margin:auto;width: max-content;">
						<div class="palette-info-input-box">
							<span class="palette-info-input-label">名称</span>
							<input class="palette-info-input" maxlength="100" autocomplete="off" v-model="title"/>
						</div>
						<div class="palette-info-input-box">
							<span class="palette-info-input-label">作者</span>
							<input class="palette-info-input" maxlength="50" autocomplete="off" v-model="author"/>
						</div>
						<div class="palette-info-input-box">
							<span class="palette-info-input-label">介绍</span>
							<textarea class="palette-info-input" rows="3" style="resize: none;font-size: 16px;" v-model="description"></textarea>
						</div>
						<div class="palette-info-input-box">
							<span class="palette-info-input-label">主题色</span>
							<input class="palette-info-input" maxlength="50" autocomplete="off" v-model.lazy="color" v-bind:class="{wrong: !vcheckhex(color)}" v-on:change="color = vtofullhex(color)" style="text-transform: uppercase;" />
							<div class="palette-info-input-description">一个 HEX 色值。主题色是进入色卡页面未选择颜色时的默认颜色。</div>
						</div>
					</div>
				</div>
				<transition-group name="color-group-transition" tag="div">
					<div v-for="(group,index) in list" class="color-group form-group color-group-transition" v-bind:key="group.key">
						<input class="color-group-title-edit" placeholder="分组标题" autocomplete="off" v-model="group.name"></input>
						<div class="color-group-container">
							<!--<div v-for="item in group.colors" class="color-item-edit" v-bind:style="'--item-color: ' + item.hex + '; --item-color-rgb: ' + colorhex2str(item.hex) + '; --item-shadow-color-rgb: ' + colorhex2str(item.hex) + ';'" v-bind:hex="item.hex" v-bind:class="{current: color == item.hex , toolight: vistoolight(item.hex) , 'color-group-subtitle': (item.hex == 'subtitle')}">
								<div v-if="item.hex != 'subtitle'" v-bind:style="{background: item.hex}" class="color-preview-edit"></div>
								<input class="color-name-edit" placeholder="颜色名称" autocomplete="off" v-model="item.name"></input>
							</div>-->
							<transition-group name="color-item-edit-transition" tag="div">
								<color-item-edit v-for="(item,colorindex) in group.colors" v-bind:color="item" v-bind:groupid="index" v-bind:colorindex="colorindex" v-bind:count="group.colors.length" v-bind:key="item.key"></color-item-edit>
								<div class="add-color color-item-edit-transition" v-on:click="addcolor(index)" key="'addcolor'">+ 添加颜色</div>
								<div class="color-item-edit-transition" style="text-align: right;margin-top: 15px;" v-bind:key="'color-item-operations'">
									<button class="moveup-group" v-bind:disabled="index == 0" v-on:click="moveupgroup(index)">上移</button>
									<button class="movedown-group" v-bind:disabled="index == list.length - 1" v-on:click="movedowngroup(index)">下移</button>
									<button class="remove-group" v-on:click="removegroup(index)">删除</button>
								</div>
							</transition-group>
						</div>
					</div>
					<div id="add_group" class="color-group-transition" v-on:click="addgroup" v-bind:key="'addgroup'">+ 添加分组</div>
					<button id="submit" class="color-group-transition" onclick="submit();" v-bind:key="'submit'">发布</button>
					<div class="errormsg" v-if="errormsg != ''" v-bind:key="'errormsg'" v-html="errormsg"></div>
				</transition-group>
			</div>
			<form id="form" action="submit.php" method="POST" style="display: none;">
				<input name="title" v-model="title"/>
				<textarea name="description" v-model="description"></textarea>
				<input name="author" v-model="author"/>
				<input name="themecolor" v-model="color"/>
				<textarea name="color_json" v-html="JSON.stringify(list)"></textarea>
			</form>
			<div id="mask2"></div>
		</div>
	</body>
</html>

<script src="js/main.js"></script>
<script>
	var app = new Vue({
		el: '#app',
		data: {
			color: '#5e72e4',
			id: editing_id,
			list: new Array(),
			title: '',
			author: '',
			description: '',
			errormsg: ''
		},
		watch: {
			color: function (newcolor, oldcolor) {
				if (!checkhex(newcolor)){
					newcolor = "#5e72e4";
				}
				$("#now_color_definition").html(":root{--color: " + newcolor + "; --color-rgb: " + hex2str(newcolor) + ";}");
			}
		},
		computed: {
			color_uppercase: function () {
				return this.color.toUpperCase();
			},
			color_rgb: function () {
				return hex2str(this.color);
			},
			color_rgb_array: function () {
				return hex2rgb(this.color);
			},
			color_hsl_array: function () {
				let rgb_array = hex2rgb(this.color);
				return rgb2hsl(rgb_array['R'], rgb_array['G'], rgb_array['B']);
			}
		},
		methods:{
			colorhex2str: function (color) {
				return hex2str(color);
			},
			vchangecolor: function(color){
				changecolor(color);
			},
			vistoolight: function(color){
				return istoolight(color);
			},
			vcheckhex: function(hex){
				return checkhex(hex);
			},
			vtofullhex: function(hex){
				return tofullhex(hex);
			},
			vhex2gray: function(hex){
				return hex2gray(hex);
			},
			addgroup: function(){
				this.list.push({
					"name": "",
					"colors": [],
					"key": randomfrom(1,999999999)
				});
			},
			moveupgroup: function(index){
				this.list[index] = this.list.splice(index - 1, 1, this.list[index])[0];
			},
			movedowngroup: function(index){
				this.list[index] = this.list.splice(index + 1, 1, this.list[index])[0];
			},
			removegroup: function(index){
				this.list.splice(index, 1);
			},
			addcolor: function(groupid){
				this.list[groupid].colors.push({"hex": getrandomcolor_except_toolight() , "name": "" , "key": randomfrom(1,999999999)});
			}
		}
	});
	Vue.component('color-item-edit', {
		props: ['color', 'groupid', 'colorindex', 'count'],
		template: `
			<div class="color-item-edit color-item-edit-transition" v-bind:style="'--item-color: ' + color.hex + '; --item-color-rgb: ' + colorhex2str(color.hex) + '; --item-shadow-color-rgb: ' + colorhex2str(color.hex) + ';'" v-bind:hex="color.hex" v-bind:class="{current: color == color.hex , toolight: vistoolight(color.hex)}">
				<div v-bind:style="{background: color.hex}" class="color-preview-edit"></div>
				<div style="flex: 1;padding-left: 10px;padding-right: 10px;">
					<input class="color-hex-edit" placeholder="色值" autocomplete="off" v-model="color.hex" style="width: 120px;" v-bind:class="{wrong: !vcheckhex(color.hex)}" v-on:change="color.hex = vtofullhex(color.hex)"></input>
					<input class="color-name-edit" placeholder="颜色名称" autocomplete="off" v-model="color.name" style="width: calc(100% - 130px);float: right;"></input>
				</div>
				<button class="moveup-color-item" v-on:click="moveupcolor(groupid, colorindex)" v-bind:disabled="colorindex == 0">↑</button>
				<button class="movedown-color-item" v-on:click="movedowncolor(groupid, colorindex)" v-bind:disabled="colorindex == count - 1">↓</button>
				<button class="remove-color-item" v-on:click="removecolor(groupid, colorindex)">×</button>
			</div>
		`,
		methods:{
			colorhex2str: function (color) {
				return hex2str(color);
			},
			vchangecolor: function(color){
				changecolor(color);
			},
			vistoolight: function(color){
				return istoolight(color);
			},
			vcheckhex: function(hex){
				return checkhex(hex);
			},
			vtofullhex: function(hex){
				return tofullhex(hex);
			},
			vhex2gray: function(hex){
				return hex2gray(hex);
			},
			removecolor: function(groupid, colorindex){
				app.list[groupid].colors.splice(colorindex, 1);
			},
			moveupcolor: function(groupid, colorindex){
				app.list[groupid].colors[colorindex] = app.list[groupid].colors.splice(colorindex - 1, 1, app.list[groupid].colors[colorindex])[0];
			},
			movedowncolor: function(groupid, colorindex){
				app.list[groupid].colors[colorindex] = app.list[groupid].colors.splice(colorindex + 1, 1, app.list[groupid].colors[colorindex])[0];
			}
		}
	});
</script>
<script>
	function submit(){
		app.errormsg = "";
		if (app.title.length == 0){
			app.errormsg += "请填写名称</br>";
		}
		if (app.author.length == 0){
			app.errormsg += "请填写作者</br>";
		}
		if (!checkhex(app.color)){
			app.errormsg += "请填写正确的主题色值</br>";
		}
		if (app.list.length == 0){
			app.errormsg += "请至少新建一个分组</br>";
		}
		for (let item of app.list){
			if (item.colors.length == 0){
				app.errormsg += "分组中至少需要有一个颜色</br>";
				break;
			}
		}
		let hexwrong = false;
		for (let item of app.list){
			for (let color of item.colors){
				if (!checkhex(color.hex)){
					app.errormsg += "请检查色值是否正确</br>";
					hexwrong = true;
					break;
				}
			}
			if (hexwrong){
				break;
			}
		}
		if (app.errormsg != ""){
			return;
		}
		$("#submit").addClass("sending");
		setTimeout(function(){
			$.ajax({
				url : "submit.php",
				type : "POST",
				dataType : "json",
				data : {
					title: app.title,
					description: app.description,
					author: app.author,
					themecolor: app.color,
					color_json: JSON.stringify(app.list)
				},
				success : function(result){
					if (result.status == "failed"){
						$("#submit").removeClass("sending");
						app.errormsg = result.msg;
					}else{
						window.location.href = "p/" + result.id;
					}
				},
				error : function(xhr){
					$("#submit").removeClass("sending");
					app.errormsg = "发布失败";
				}
			});
		}, 400);
	}
</script>