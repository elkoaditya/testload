String.prototype.trim = function() {
	return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
};

String.prototype.ltrim = function() {
	return this.replace(/^\s+/, '');
}

String.prototype.rtrim = function() {
	return this.replace(/\s+$/, '');
}

String.prototype.fulltrim = function() {
	return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g, '').replace(/\s+/g, ' ');
};

//bagian jQuery
$(function() {
	$(".select").change(function() {
		if ($(this).val() === "")
			$(this).addClass("empty");
		else
			$(this).removeClass("empty");
	});
	$(".select").change();
});
//bagian umum
function dom(id) {
	return document.getElementById(id);
}

function html_decode(string) {
	area = dom('html_decode_area');
	if (!area) {
		$('#container').after('<div id="html_decode_area" style="display: none; left: -9999;" ></div>');
		area = dom('html_decode_area');
	}
	area.innerHTML = string;
	txt = area.innerText;
	area.innerHTML = '';
	return txt;
}

function html_decode_array(list) {
	for (i in list) {
		itext = dom(list[i]);
		// if (!itext) continue;
		itext.value = html_decode(itext.value);
	}
}

function message_window(string, btn) {
	if (!btn)
		btn = {
			Tutup: function() {
				$(this).dialog("close");
			}
		};
	area = dom('message_window');
	if (!area) {
		$('#container-base').after('<div id="message_window" title="Message" style="display: none; left: -9999;" ></div>');
		$("#message_window").dialog({
			modal: true,
			autoOpen: false,
			height: 200,
			width: 400,
			buttons: btn
		});
		area = dom('message_window');
	}//*
	area.innerHTML = string;
	$("#message_window").dialog('open');
//*/
}