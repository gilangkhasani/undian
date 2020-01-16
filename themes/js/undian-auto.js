
var timer = setInterval(function(){}, 1000);
var timerAmbil = setInterval(function(){}, 1000);
clearInterval(timer);
clearInterval(timerAmbil);
function PlaySound(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.play();
}
function PlaySoundLoop(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.loop = true;
    thissound.play();
}

function StopSound(soundobj) {
    var thissound=document.getElementById(soundobj);
    thissound.pause();
    thissound.currentTime = 0;
}

$(document).ready(function(){
	$('#generate').html(convertToDigit($('#generate').html()));		
	$('.validate-numeric').keyup(function(){
		if(isNaN($(this).val())){
			alert('Harus Numeric!!!');
			$(this).val(0);
		}
	});
	$('select[name=select-durasi]').change(function(){
		$('input:text[name=durasi]').val($(this).val());
		if($(this).val() == 10){
			$('#lottery').attr('src', '../../themes/sound/10-detik.mp3')
		}else if($(this).val() == 15){
			$('#lottery').attr('src', '../../themes/sound/15-detik.mp3');
		}else if($(this).val() == 20){
			$('#lottery').attr('src', '../../themes/sound/20-detik.mp3');
		}else if($(this).val() == 25){
			$('#lottery').attr('src', '../../themes/sound/25-detik.mp3');
		}else if($(this).val() == 30){
			$('#lottery').attr('src', '../../themes/sound/30-detik.mp3');
		}else{
			$('#lottery').attr('src', '../../themes/sound/5-detik.mp3');
		}
	})
	
	$('.validate-min1').focusout(function(){
		if(isNaN($(this).val())){
			alert('Harus Numeric!!!');
			$(this).val(0);
		}else{
			if($(this).val() < 1){
				alert('minimal 1')
				$(this).val(1);
			}
		}
	});
	
	$('.validate-min2').focusout(function(){
		if(isNaN($(this).val())){
			alert('Harus Numeric!!!');
			$(this).val(0);
		}else{
			if($(this).val() < 2){
				alert('minimal 1')
				$(this).val(2);
			}
		}
	});
	$('#submit').click(function(){
		$('input:hidden[name=status-batal]').val("0");
		var idproject = $('input:hidden[name=project]').val();
		$('#submit').hide();
		$('.load-image').show();
		$.ajax({
			type:"get",
			url: "../../page/user/undian/ajax_get_pemenang.php",
			dataType:'json',
	        error: function (request,status, error) {
	            console.log(request);
	        },
			data:{kategori:'list-peserta', project:idproject}
		}).done(function(data){
			var peng_jml_pemenang = $('input:text[name=peng_jml_pemenang]').val();
			var waktunya = 1;
							// console.log(waktunya+" == "+peng_jml_pemenang);
			$('.load-image').hide();
			if(parseInt(data.jumlah) < peng_jml_pemenang){
				alert('Sisa peserta sebanyak '+data.jumlah+', silahkan masukan Pengaturan Jumlah Pemenang kurang dari/ sama dengan '+data.jumlah);
				$('#submit').show();
			}else{
				$('#submit').hide();
				$('#tombol').removeAttr("disabled");
				$('#kembali').show();
				$('#notif-click').show();
				$('input:text[name=peng_jml_pemenang]').attr('readonly', 'readonly');
				$('input:text[name=durasi]').attr('readonly', 'readonly');
				$('input:text[name=periode]').attr('readonly', 'readonly');
				$('select[name=hadiah]').attr('disabled', true);
				$('select[name=select-durasi]').attr('disabled', true);
				// clearInterval(timerAmbil);
				// timerAmbil = null;
				// clearInterval(timer);
				var timer = null, 
				timerAmbil = null,
				interval = 100,
				listPeserta = data.data;
				// clearInterval(timerAmbil);
					// timerAmbil = null;
				// clearInterval(timer);

				var i = 1;
				$("#tombol").click(function() {
					var statusBatal = $('input:hidden[name=status-batal]').val();
					console.log(statusBatal);
					if (statusBatal == 0) {
						var isiTombol = $(this).is(':checked');
						if (isiTombol) {
							if($.isEmptyObject(listPeserta)){
								alert('List Peserta Kosong');
								clearInterval(timer);
					  			timer = null;
								$("#ambil").hide();
								$("#stop").hide();
								$('#start').show();
							}else{
								$("#stop").show();
								$('#kembali').hide();
								if (timer !== null) return;
								PlaySoundLoop('lottery');
								timer = setInterval(function () {
									if($.isEmptyObject(listPeserta)){
										$('#generate').html(convertToDigit('XXXXXXXXXX'));
									}else{
										var random_name = fetch_random(listPeserta);
										value = random_name.data.fielda;
										$("#generate").html(convertToDigit(value));
										$('.digit a').fadeOut(100);
										if (i % 2 == 0) {
											$('.digit').css('background', 'url(../../themes/image/bg-counter.png)');
										}else{
											$('.digit').css('background', 'url(../../themes/image/bg-counter-change.png)');
										}
										i++;
										// $("#ambil").show();
										$("#start").hide();
										// $('#stop').show();
										// $('#stop').focus();
									}
								}, interval); 


								var intervalAmbil = $('input:text[name=durasi]').val() * 1000;
								timerAmbil = setInterval(function () {
									// ambil(listPeserta);
									// console.log(ambil(listPeserta));
									ambil(listPeserta);
									if(waktunya == peng_jml_pemenang){
										clearInterval(timer);
										clearInterval(timerAmbil);
					  					// timerAmbil = null;
										StopSound('lottery');
										$('#submit').show();
										$('#stop').hide();
										$('#start').hide();
										$('#kembali').hide();
										$('#notif-click').hide();
										$('#generate').html(convertToDigit('XXXXXXXXXX'));
										$('input:text[name=peng_jml_pemenang]').removeAttr('readonly');
										$('input:text[name=durasi]').removeAttr('readonly');
										$('input:text[name=periode]').removeAttr('readonly');
										$('select[name=hadiah]').attr('disabled', false);
										$('select[name=select-durasi]').attr('disabled', false);
										$('#tombol').attr("disabled", true);
										$('#tombol').prop("checked", false);
									}
									console.log(waktunya);
									waktunya++;
								}, intervalAmbil);
							}
						}else{
							clearInterval(timer);
				  			//timer = null;
							clearInterval(timerAmbil);
				  			//timerAmbil = null;
				  			StopSound('lottery');
				  			StopSound('applause');
				  			$('#generate').html(convertToDigit('XXXXXXXXXX'));
							$("#ambil").hide();
							$("#stop").hide();
							$('#start').hide();
							$('#notif-click').hide();
							$('#submit').show();
							$('input:text[name=peng_jml_pemenang]').removeAttr('readonly');
							$('input:text[name=durasi]').removeAttr('readonly');
							$('input:text[name=periode]').removeAttr('readonly');
							$('select[name=hadiah]').attr('disabled', false);
							$('select[name=select-durasi]').attr('disabled', false);
							$('#tombol').attr("disabled", true);
							$('#tombol').prop("checked", false);
						}
					}else{
						clearInterval(timer);
			  			//timer = null;
						clearInterval(timerAmbil);
			  			//timerAmbil = null;
			  			StopSound('lottery');
			  			StopSound('applause');
			  			$('#generate').html(convertToDigit('XXXXXXXXXX'));
						$("#ambil").hide();
						$("#stop").hide();
						$('#start').hide();
						$('#notif-click').hide();
						$('#submit').show();
						$('input:text[name=peng_jml_pemenang]').removeAttr('readonly');
						$('input:text[name=durasi]').removeAttr('readonly');
						$('input:text[name=periode]').removeAttr('readonly');
						$('select[name=hadiah]').attr('disabled', false);
						$('select[name=select-durasi]').attr('disabled', false);
						$('#tombol').attr("disabled", true);
						$('#tombol').prop("checked", false);
						$('input:hidden[status-batal]').val("0");
					}
				});
				
				// $("#ambil").click(function() {
				// 	ambil(listPeserta);
				// });
			}
		});
	});
	
	/*$('#kembali').click(function(){
		$('#tombol').prop("checked", true);
		$('#tombol').click();
		$('#submit').show();
		$('#start').hide();
		$('#kembali').hide();
		$('#notif-click').hide();
		$('input:text[name=peng_jml_pemenang]').removeAttr('readonly');
		$('input:text[name=durasi]').removeAttr('readonly');
		$('input:text[name=periode]').removeAttr('readonly');
		$('select[name=hadiah]').attr('disabled', false);
		$('select[name=select-durasi]').attr('disabled', false);
		// $('#tombol').attr("disabled", true);
		// $('#tombol').prop("checked", false);
	});*/
	$('#kembali').click(function(){
		$('input:hidden[name=status-batal]').val("1");
		$('#tombol').click();
		$('#submit').show();
		$('#start').hide();
		$('#kembali').hide();
		$('#notif-click').hide();
		$('input:text[name=peng_jml_pemenang]').removeAttr('readonly');
		$('input:text[name=durasi]').removeAttr('readonly');
		$('input:text[name=periode]').removeAttr('readonly');
		$('select[name=hadiah]').attr('disabled', false);
		$('select[name=select-durasi]').attr('disabled', false);
		// $('#tombol').attr("disabled", true);
		// $('#tombol').prop("checked", false);
	});
});

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

function cleartime(){
	clearInterval(timerAmbil);
	timerAmbil = null;
	clearInterval(timer);
	timer = null;
}
function ambil(listPeserta){
	var randomname = fetch_random(listPeserta);
	var id_hadiah = $('select[name=hadiah] option:selected').val();
	var periode =  $('input:text[name=periode]').val();
	var id_peserta = randomname.data.id_peserta;
	var pemenang = randomname.data.fielda;
	var valuesnya = {'id_peserta' : id_peserta,
		'id_hadiah' : id_hadiah,
		'periode' : periode,
		'selector':'#list_pemenang',
		'pemenang' : pemenang,
		'id_project' : $('input:hidden[name=project]').val()
		};
	// PlaySound('applause');
	StopSound('lottery');
	PlaySoundLoop('lottery');
	$('#append-list-pemenang').append('<span class="msisdn-menang">'+pemenang+'</span>');
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
		$('input:text[name=pemenang]').val(data.jumlah_pemenang);
		$('.list-pemenang').html(data.list_pemenang);
	});
}