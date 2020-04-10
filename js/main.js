function rgb2hsl(R,G,B){
	let r = R / 255;
	let g = G / 255;
	let b = B / 255;

	let var_Min = Math.min(r, g, b);
	let var_Max = Math.max(r, g, b);
	let del_Max = var_Max - var_Min;

	let H, S, L = (var_Max + var_Min) / 2;

	if (del_Max == 0){
		H = 0;
		S = 0;
	}else{
		if (L < 0.5){
			S = del_Max / (var_Max + var_Min);
		}else{
			S = del_Max / (2 - var_Max - var_Min);
		}

		del_R = (((var_Max - r) / 6) + (del_Max / 2)) / del_Max;
		del_G = (((var_Max - g) / 6) + (del_Max / 2)) / del_Max;
		del_B = (((var_Max - b) / 6) + (del_Max / 2)) / del_Max;

		if (r == var_Max){
			H = del_B - del_G;
		}
		else if (g == var_Max){
			H = (1 / 3) + del_R - del_B;
		}
		else if (b == var_Max){
			H = (2 / 3) + del_G - del_R;
		}
		if (H < 0) H += 1;
		if (H > 1) H -= 1;
	}
	return {
		'h': H,//0~1
		's': S,
		'l': L
	};
}
function Hue_2_RGB(v1,v2,vH){
	if (vH < 0) vH += 1;
	if (vH > 1) vH -= 1;
	if ((6 * vH) < 1) return (v1 + (v2 - v1) * 6 * vH);
	if ((2 * vH) < 1) return v2;
	if ((3 * vH) < 2) return (v1 + (v2 - v1) * ((2 / 3) - vH) * 6);
	return v1;
}
function hsl2rgb(h,s,l){
	let r, g, b, var_1, var_2;
	if (s == 0){
		r = l;
		g = l;
		b = l;
	}
	else{
		if (l < 0.5){
			var_2 = l * (1 + s);
		}
		else{
			var_2 = (l + s) - (s * l);
		}
		var_1 = 2 * l - var_2;
		r = Hue_2_RGB(var_1, var_2, h + (1 / 3));
		g = Hue_2_RGB(var_1, var_2, h);
		b = Hue_2_RGB(var_1, var_2, h - (1 / 3));
	}
	return {
		'R': Math.round(r * 255),//0~255
		'G': Math.round(g * 255),
		'B': Math.round(b * 255),
		'r': r,//0~1
		'g': g,
		'b': b
	};
}
function rgb2hex(r,g,b){
	let hex = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
	let rh, gh, bh;
	rh = "", gh ="", bh="";
	while (rh.length < 2){
		rh = hex[r%16] + rh;
		r = Math.floor(r / 16);
	}
	while (gh.length < 2){
		gh = hex[g%16] + gh;
		g = Math.floor(g / 16);
	}
	while (bh.length < 2){
		bh = hex[b%16] + bh;
		b = Math.floor(b / 16);
	}
	return "#" + rh + gh + bh;
}
function hex2rgb(hex){
	//hex: #XXXXXX
	hex = hex.toUpperCase();
	let dec = {
		'0': 0, '1': 1, '2': 2, '3': 3, '4': 4, '5': 5, '6': 6, '7': 7, '8': 8, '9': 9, 'A': 10, 'B': 11, 'C': 12, 'D': 13, 'E': 14, 'F': 15
	};
	return {
		'R': (dec[hex.substr(1,1)] * 16 + dec[hex.substr(2,1)]),//0~255
		'G': (dec[hex.substr(3,1)] * 16 + dec[hex.substr(4,1)]),
		'B': (dec[hex.substr(5,1)] * 16 + dec[hex.substr(6,1)]),
		'r': (dec[hex.substr(1,1)] * 16 + dec[hex.substr(2,1)]) / 255,//0~1
		'g': (dec[hex.substr(3,1)] * 16 + dec[hex.substr(4,1)]) / 255,
		'b': (dec[hex.substr(5,1)] * 16 + dec[hex.substr(6,1)]) / 255
	};
}
function rgb2str(rgb){
	return rgb['R'] + "," + rgb['G'] + "," + rgb['B'];
}
function hex2str(hex){
	return rgb2str(hex2rgb(hex));
}
function hex2gray(hex){
	let rgb_array = hex2rgb(hex);
	return Math.round(rgb_array['R'] * 0.299 + rgb_array['G'] * 0.587 + rgb_array['B'] * 0.114);
}
function istoolight(color){
	if (hex2gray(color) > 255 * 0.78){
		return true;
	}
	return false;
	/*let rgb_array = hex2rgb(color);
	if (rgb2hsl(rgb_array['R'], rgb_array['G'], rgb_array['B'])['l'] > 0.9){
		return true;
	}
	return false;*/
}
function tofullhex(hex){
	hex = hex.toUpperCase();
	if (hex.length == 0){
		return getrandomcolor_except_toolight();
	}
	if ((hex.length == 3 || hex.length == 6) && hex.substr(0,1) != '#'){
		hex = "#" + hex;
	}
	if (hex.length != 4){
		return hex;
	}
	if (hex.substr(0,1) != '#'){
		return hex;
	}
	return "#" + hex.substr(1,1) + hex.substr(1,1) + hex.substr(2,1) + hex.substr(2,1) + hex.substr(3,1) + hex.substr(3,1);
}
function checkhex(hex){
	hex = hex.toUpperCase();
	if (hex.length == 3 || hex.length == 4 || hex.length == 6){
		hex = tofullhex(hex);
	}
	if (hex.length != 7){
		return false;
	}
	if (hex.substr(0,1) != '#'){
		return false;
	}
	let dec = {
		'0': 0, '1': 1, '2': 2, '3': 3, '4': 4, '5': 5, '6': 6, '7': 7, '8': 8, '9': 9, 'A': 10, 'B': 11, 'C': 12, 'D': 13, 'E': 14, 'F': 15
	};
	if (dec[hex.substr(1,1)] == undefined || dec[hex.substr(2,1)] == undefined || dec[hex.substr(3,1)] == undefined || dec[hex.substr(4,1)] == undefined || dec[hex.substr(5,1)] == undefined || dec[hex.substr(6,1)] == undefined){
		return false;
	}
	return true;
}


function randomfrom(a, b){
	return Math.floor(Math.random() * (b - a + 1) + a);
}
function getrandomcolor(){
	return rgb2hex(randomfrom(0,255), randomfrom(0,255), randomfrom(0,255));
}
function getrandomcolor_except_toolight(){
	res = getrandomcolor();
	while (hex2gray(res) > 255 * 0.85){
		res = getrandomcolor();
	}
	return res;
}
function randomcolor(){
	changecolor(getrandomcolor());
}