<?php require_once('main.php'); ?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>纯 · 色</title>
		<?php
			$res_prefix = "";
			if (isset($_GET['subdir'])){
				$res_prefix = "../";
			}
		?>
		<link href="<?php echo $res_prefix; ?>css/style.css" type='text/css' rel='stylesheet'>
		<script src="<?php echo $res_prefix; ?>js/vue.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:300&display=swap" rel="stylesheet">
		<script src="<?php echo $res_prefix; ?>js/jquery-3.4.1.min.js"></script>
		<script src="<?php echo $res_prefix; ?>js/main.js"></script>
	</head>
	<style id="now_color_definition">
		:root{
			--color: #5e72e4;
			--color-rgb: 94, 114, 228;
		}
	</style>
	<style id="mobile_color_group_container_padding_definition">
		:root{
			--mobile-color-group-container-padding: 0px;
		}
	</style>
	<script>
		<?php
			$notfound = "false";
			$themecolor = "#5e72e4";
			if (!isset($_GET['id']) || empty($_GET['id'])){
				$colorjson = $default_color_json;
			}else{
				if (!check_id($_GET['id'])){
					$colorjson = "[]";
					$notfound = "true";
				}else{
					$sql = "SELECT * FROM palettes where id = '" . esc_str($_GET['id']) . "'";
					$sqlres = mysqli_query($conn, $sql);
					$data = mysqli_fetch_assoc($sqlres);
					if (mysqli_num_rows($sqlres) == 0){
						$colorjson = "[]";
						$notfound = "true";
					}else{
						$themecolor = $data['themecolor'];
						$colorjson = $data['color_json'];
					}
				}
			}
		?>
		var color_json = <?php echo $colorjson; ?>;
		var themecolor = "<?php echo $themecolor; ?>";
		$("#now_color_definition").html(":root{--color: " + themecolor + "; --color-rgb: " + hex2str(themecolor) + ";}");
	</script>
	<body>
		<div id="app">
			<div id="head">
				<div id="title">
					<span id="subtitle">Pure Colors</span>
					纯·色
					<a class="github-link" href="https://github.com/solstice23/purecolor" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 530.97 517.81" width="30" height="30"><defs></defs><path d="M265.47,0C118.88,0,0,118.85,0,265.47,0,382.75,76.06,482.24,181.57,517.35c13.27,2.44,18.12-5.76,18.12-12.79,0-6.31-.23-23-.36-45.15-73.85,16-89.43-35.59-89.43-35.59C97.83,393.16,80.42,385,80.42,385c-24.1-16.47,1.83-16.13,1.83-16.13,26.64,1.87,40.66,27.35,40.66,27.35,23.68,40.57,62.14,28.85,77.26,22.06,2.42-17.16,9.28-28.85,16.86-35.49-58.95-6.7-120.93-29.47-120.93-131.2,0-29,10.35-52.67,27.33-71.23-2.73-6.72-11.84-33.71,2.6-70.25,0,0,22.29-7.14,73,27.21a251.54,251.54,0,0,1,132.93,0C382.65,103,404.9,110.1,404.9,110.1c14.49,36.54,5.37,63.53,2.64,70.25,17,18.56,27.29,42.25,27.29,71.23,0,102-62.07,124.42-121.21,131,9.53,8.2,18,24.4,18,49.16,0,35.49-.33,64.12-.33,72.83,0,7.09,4.79,15.35,18.26,12.76C455,482.15,531,382.72,531,265.47,531,118.85,412.1,0,265.47,0Z" transform="translate(0)" style="fill: var(--color); fill-rule: evenodd;"></path></svg></a>
				</div>
				<div id="info">
					<div id="rgb" class="colorinfo-item"><span class="colorinfo-title">RGB</span>{{ color_rgb_array['R'] }} , {{ color_rgb_array['G'] }} , {{ color_rgb_array['B'] }}</div>
					<div id="hex" class="colorinfo-item"><span class="colorinfo-title">HEX</span>{{ color_uppercase }}</div>
					<div id="hsl" class="colorinfo-item"><span class="colorinfo-title">HSL</span>{{ Math.round(color_hsl_array['h'] * 360)}}° , {{ Math.trunc(color_hsl_array['s'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['s'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>% , {{ Math.trunc(color_hsl_array['l'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['l'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>%</div>
					<div id="gray" class="colorinfo-item"><span class="colorinfo-title">Gray</span>{{ vhex2gray(color) }}</div>
				</div>
			</div>
			<div id="content">
				<?php if (isset($sqlres)) { 
						if (mysqli_num_rows($sqlres) > 0) { ?>
					<div class="palette-info">
						<div class="palette-info-title"><?php echo $data['title'];?></div>
						<div class="palette-info-author">By <?php echo $data['author'];?></div>
						<div class="palette-info-description"><?php echo $data['description'];?></div>
					</div>
				<?php }
					} ?>
				<div v-for="group in list" class="color-group" v-if="notfound == false"><!--正常-->
					<div class="color-group-title">{{ group.name }}</div>
					<div class="color-group-container">
						<div v-for="item in sorted(group.colors , group.autosort)" class="color-item" v-bind:style="'--item-color: ' + item.hex + '; --item-color-rgb: ' + colorhex2str(item.hex) + '; --item-shadow-color-rgb: ' + colorhex2str(item.hex) + ';'" v-bind:hex="item.hex" v-bind:class="{current: color == item.hex , toolight: vistoolight(item.hex) , 'color-group-subtitle': (item.hex == 'subtitle')}">
							<div v-if="item.hex != 'subtitle'" v-bind:style="{background: item.hex}" class="color-preview" v-on:click="vchangecolor(item.hex);"></div>
							<div class="color-name">{{ (item.name == '' || item.name == undefined) ? item.hex : item.name }}</div>
						</div>
					</div>
				</div>
				<div class="notfound" v-if="notfound == true"> <!--404-->
					404<div class="notfound-tip">好像找不到这个色板...</div>
				</div>
			</div>
		</div>
		<div id="wave_container">
			<div id="wave">
				<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
					<defs>
						<path id="gentle-wave" class="transition-delay" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
					</defs>
					<g class="parallax">
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="0"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="3"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="5"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="7"/>
					</g>
				</svg>
			</div>
			<div id="wave_filler" class="transition-delay"></div>
		</div>
		<div id="mask"></div>
		<div id="mask2"></div>
		<div class="fabs">
			<a id="new_palette" class="btn" href="<?php echo $res_prefix; ?>edit.php">
				<svg t="1586497038133" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3568" width="14" height="14"><path d="M426.666667 0h170.666666v1024H426.666667z" fill="#ffffff" p-id="3569"></path><path d="M1024 597.333333V426.666667H0v170.666666z" fill="#ffffff" p-id="3570"></path></svg>
				<span style="width: 1px;display: inline-block;"></span>
				新建
			</a>
			<button id="rand_color" class="btn" onclick="randomcolor();">
				<svg t="1580568273568" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1899" width="18" height="18" style="transform: translateY(2px);"><path d="M768.863 325.733c-48.775 0-170.409 121.182-259.229 207.077-134.661 130.244-261.862 256.802-363.67 256.802h-62.62C57.75 789.612 37 768.828 37 743.223c0-25.604 20.749-46.387 46.342-46.387h62.622c64.335 0 194.592-129.518 299.256-230.745 127.382-123.198 237.392-233.135 323.643-233.135h59.769l-63.418-61.55c-18.113-18.088-18.142-45.665-0.062-63.788 18.08-18.128 47.422-18.164 65.535-0.07l142.708 142.495A46.306 46.306 0 0 1 987 282.83c0 12.308-4.893 24.06-13.604 32.759l-142.71 142.4c-9.043 9.032-20.89 13.328-32.735 13.328-11.875 0-23.749-4.977-32.799-14.05-18.08-18.121-18.05-48.358 0.062-66.445l63.417-65.09h-59.768z m61.824 238.627c-18.113-18.095-47.456-18.066-65.535 0.062-18.08 18.121-18.05 49.237 0.062 67.323l63.417 65.09h-59.768c-38.06 0-101.643-56.357-164.685-115.353-18.69-17.493-48.021-17.394-65.495 1.306-17.486 18.7-16.507 49.382 2.183 66.87 96.042 89.898 160.826 139.952 227.997 139.952h59.769l-63.418 61.549c-18.113 18.087-18.142 46.552-0.062 64.674 9.051 9.072 20.924 13.167 32.799 13.167 11.845 0 23.692-4.74 32.736-13.773l142.708-142.619c8.71-8.7 13.604-20.56 13.604-32.87a46.44 46.44 0 0 0-13.604-32.842L830.687 564.36zM83.342 325.733h62.622c48.84 0 121.646 62.22 179.612 114.893 8.88 8.065 20.026 12.923 31.147 12.923 12.604 0 25.172-4.677 34.315-14.75 17.208-18.954 15.8-49.839-3.146-67.055-90.646-82.365-166.477-138.787-241.928-138.787H83.342C57.749 232.957 37 253.743 37 279.346s20.75 46.387 46.342 46.387z" p-id="1900" fill="#ffffff" style="transition: all .3s ease;"></path></svg>
				<span style="width: 1px;display: inline-block;"></span>
				随机
		</button></div>
	</body>
</html>

<script>
	var app = new Vue({
		el: '#app',
		data: {
			color: themecolor,
			list: color_json,
			notfound: <?php echo $notfound ?>,
			need_password: false
		},
		watch: {
			color: function (newcolor, oldcolor) {
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
			vhex2gray: function(hex){
				return hex2gray(hex);
			},
			sorted: function (numbers , autosort) {
				if (autosort != true){
					return numbers;
				}
				return numbers.slice().sort(function (a,b) {
					if (a.hex == "subtitle" || b.hex == "subtitle"){
						return false;
					}
					a = a.hex;
					b = b.hex;
					let rgb_array1 = hex2rgb(a);
					let rgb_array2 = hex2rgb(b);
					let hsl1 = rgb2hsl(rgb_array1['R'], rgb_array1['G'], rgb_array1['B']);
					let hsl2 = rgb2hsl(rgb_array2['R'], rgb_array2['G'], rgb_array2['B']);
					return hsl1['h'] - hsl2['h'];
				});
			}
		}
	});
	function changecolor(color){
		if ($("body").hasClass("color-refreshing")){
			return;
		}
		app.color = color;
		$("body").removeClass("color-refreshing");
		setTimeout(function(){
			$("body").addClass("color-refreshing");
			$("body").removeClass("toolight");
			if (istoolight(color)){
				$("body").addClass("toolight");
			}
			setTimeout(function(){
				$("body").removeClass("color-refreshing");
			}, 1100);
		} , 50);
	}
	$(window).resize(function(){
		let padding = ((document.body.clientWidth - 25 * 2) % (50 + 50)) / 2;
		$("#mobile_color_group_container_padding_definition").html(':root{--mobile-color-group-container-padding: ' + padding + 'px;}');
	});
	$(window).trigger("resize");
</script>