function PlaySound(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.play();
}

function StopSound(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.pause();
    thissound.currentTime = 0;
}

$(document).ready(function(){
	$('#generate').html(convertToDigit($('#generate').html()));
	var fproject = $('input:hidden[name=project]').val();
	$.ajax({
		type:"get",
		url: "../../page/user/undian/ajax_get_peserta.php",
		dataType:'json',
        error: function (request,status, error) {
            console.log(request);
        },
		data:{project:fproject}
	}).done(function(data){
		// console.log(data);
		var timer = null, 
		interval = 100,
		timerBG = null,
		listPeserta = data;
		var i=1;
		$("#tombol").click(function() {
			var isiTombol = $(this).is(':checked');
			if (isiTombol) {
				PlaySound('lottery');
				if($.isEmptyObject(listPeserta)){
					alert('List Peserta Kosong');
					clearInterval(timer);
		  			timer = null;
					$("#ambil").hide();
					$("#stop").hide();
					$('#start').show();
				}else{
					if (timer !== null) return;
					timer = setInterval(function () {

						if($.isEmptyObject(listPeserta)){
							$('#generate').html(convertToDigit('XXXXXXXXXX'));
						}else{
							var random_name = fetch_random(listPeserta);
							value = random_name.data.fielda;
							// timer bg
							$("#generate").html(convertToDigit(value));
							$('.digit a').fadeOut(100);
							if (i % 2 == 0) {
								$('.digit').css('background', 'url(../../themes/image/bg-counter.png)');
							}else{
								$('.digit').css('background', 'url(../../themes/image/bg-counter-change.png)');
							}
							i++;
							$("#ambil").show();
							$("#start").hide();
							$('#stop').show();
							// $('#stop').focus();
						}
					}, interval); 
				}
			}else{
				clearInterval(timer);
	  			timer = null;
				$('.digit').css('background', 'url(../../themes/image/bg-counter.png)');

				$("#ambil").hide();
				$("#stop").hide();
				$('#start').show();
				$('#generate').html(convertToDigit('XXXXXXXXXX'));
				StopSound('lottery');
				StopSound('applause');
				// $('#start').focus();
			}
		});


		$("#ambil").click(function() {
			$('#tombol').click();
			ambil(listPeserta);
			$('#tombol').prop("checked", false);
			PlaySound('applause');
			StopSound('lottery');
		});
	});
})

function convertToDigit(str){
	var splitStr = str.split("");
	var output = "";
	$.each(splitStr, function(i, v){
		output = output + '<span class="digit"><a>' + v + '</a></span>';
	});
	return output;
}

function changeBgRand(option){
	if (option == "stop") {
		clearInterval(timerBG);
		timerBG = null;
		$('.digit').css('background', 'url(../../themes/image/bg-counter.png)');
	}else if (option == "start") {
		var i=1;
		timerBG = setInterval(function () {
			if (i % 2 == 0) {
				$('.digit').css('background', 'url(../../themes/image/bg-counter-change.png)');
			}else{
				$('.digit').css('background', 'url(../../themes/image/bg-counter.png)');
			}
			i++;
		}, 100);
	}
	return timerBG;
}

function ambil(listPeserta){
	var randomname = fetch_random(listPeserta);
	var id_hadiah = $('select[name=hadiah] option:selected').val();
	var periode =  $('input:text[name=periode]').val();
	var id_peserta = randomname.data.id_peserta;
	var pemenang = randomname.data.fielda;
	$('#generate').html(convertToDigit(pemenang));
	var valuesnya = {'id_peserta' : id_peserta,
		'id_hadiah' : id_hadiah,
		'periode' : periode,
		'selector':'#list_pemenang',
		'pemenang' : pemenang,
		'id_project' : $('input:hidden[name=project]').val()
		};
	simpanPemenang(valuesnya);
	var hasillist = [];
	$.each(listPeserta, function(i, v){
		if(v.fielda == pemenang){
			delete listPeserta[i];
		}else{
			hasillist.push(listPeserta[i]);
		}
	});
	var listPeserta = [];
	listPeserta = hasillist;
	return listPeserta;
}

function fetch_random(obj) {
    var temp_key, keys = [];
    for(temp_key in obj) {
       if(obj.hasOwnProperty(temp_key)) {
           keys.push(temp_key);
       }
    }
    var randomnya = Math.floor(Math.random() * keys.length);
    return {"data" : obj[keys[randomnya]], "keys":randomnya};
}

function simpanPemenang(valuesnya){
	$.ajax({
		type:"get",
		url: "../../page/user/undian/ajax_simpan_pemenang.php",
		dataType:'json',
        error: function (request,status, error) {
            console.log(request);
        },
		data:valuesnya
	}).done(function(data){
		list_pemenang(valuesnya.id_project);
		/*if(data.status == 'simpan'){
			$(valuesnya.selector).append('<li>'+valuesnya.pemenang+'</li>');
		}*/
	});
}

function list_pemenang(idproject){
	$.ajax({
		type:"get",
		url: "../../page/user/undian/ajax_get_pemenang.php",
		dataType:'json',
        error: function (request,status, error) {
            console.log(request);
        },
		data:{kategori:'manual', project:idproject}
	}).done(function(data){
		console.log(data.jumlah_pemenang);
		$('input:text[name=pemenang]').val(data.jumlah_pemenang);
		$('.list-pemenang').html(data.list_pemenang);
	});
}