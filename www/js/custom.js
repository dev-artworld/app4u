// jQuery(document).ready(function()
// {
	
		// alert();
// });
/*jQuery('document').ready(function()
{	//plugin_file=japi&task=menus&menus=drive,iron-play
	//http://retouchingwork.com/wordpress_3.5.1/index.php
     jqXHR = jQuery.getJSON("http://retouchingwork.com/wordpress_3.5.1/index.php?callback=?",{plugin_file:'japi',task:'menus',menus:'drive,iron-play'}).done(function( data ) { alert(data); });
 });
*/
// 86400000 (difference )
var device={};
device.platform="Android";
var login_id="";
var fst_exec=0;
var ini_exec=0;
var cache=new Array();
var lowInternetConnection=true;
var preClass="ui-page ui-body-c ui-page-active ui-page-header-fixed ui-page-footer-fixed";
var autoload_arr="";
var curLat="";
var curLong="";
var audioStreamer="";
var cal;
var wip_marker_image = "";
var preMainClass="";
var isMediaRunning = false;
var themeLoadFlag=false;
var geoCurrentLatitude = "";
var geoCurrentLongitude = "";
var loadingTime = 0;
var audio_stream_state = "";
var  currentTemp="";
var devicePlatform = "";
var mainLoadDone=false;
var soundFrameInterval = "";
var liveStreamStatus = 0;
var autoLoadFlag = false;
var choiceline_file_path = "";
var runscriptFlag=false;
var alarmStream = false;
var set_more_padding = false;
var appearance_jsonnav="";
var viewport = {
    width  : $(window).width(),
    height : $(window).height()
};
var THEME = {};
var PAGE_TITLES = {};
var app_splash_screen="";
var setAppBackgrounds="";
var twitterurl="";
var RImageURI="";
function loadInstagram()
{
	 window.open(instagramurl,'_blank','location=no');
}
function loadTwitter()
{
	 window.open(twitterurl,'_blank','location=no');
}
/**
 * To handle ajax request errors
 */
$.ajaxSetup({
  error: function(XHR, textStatus, errorThrown){
   // window.location = "no-connectivity.html";
  }
});
/**
 * To set the App Google Analytics Profile object
 */
function set_analytics_obj(user_id){
	if(typeof(Storage)!=="undefined" && localStorage.getItem("google_analytics_id") != null){
		ga_storage._setAccount(localStorage.getItem("google_analytics_id")); //Replace with your own
			ga_storage._setDomain('none');
			ga_storage._trackPageview('/index.html');
	}
	else
	{
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/infot/getappinfo/'+user_id,
		async: false,
		data: {},
		dataType   : 'jsonp',
		beforeSend: function (data){
			//$.mobile.loading('show');
			//activeLoader('show');
			
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			alert(textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');
			localStorage.setItem("google_analytics_id",res.app_info.google_analytics_id);
			ga_storage._setAccount(res.app_info.google_analytics_id); //Replace with your own
			ga_storage._setDomain('none');
			ga_storage._trackPageview('/index.html');
			get_app_download_stats();
			//$.mobile.loading('show');
			//activeLoader('show');
		}
	});

}
}
function addEventToCal(title,loc,notes, startDate, endDate){
	/*startDate = startDate.split(" ")[0];
	endDate = endDate.split(" ")[0];
	startDate = new Date(startDate);
	endDate = new Date(endDate);*/
	 if(device.platform == "Android"){
		startDate = $D(startDate).strftime("%B %d, %Y %H:%M:%S");
		endDate = $D(endDate).strftime("%B %d, %Y %H:%M:%S");
		startDate = new Date(startDate);
		endDate = new Date(endDate);
		cal=window.plugins.calendar;
		try{
		cal.createEvent(title,loc,notes,startDate,endDate,function(mes){},function(mes){});
		}
		catch(e)
		{
			alert(e);
		}
	}
	else
	{
		s_parts=startDate.split(' ');
		e_parts=endDate.split(' ');
		//alert(s_parts[0]);
		var sd_parts=s_parts[0].split('-');
		var ed_parts=e_parts[0].split('-');

		var st_parts=s_parts[1].split(':');
		var et_parts=e_parts[1].split(':');
		sd_parts[1]=parseInt(sd_parts[1])-1;
		ed_parts[1]=parseInt(ed_parts[1])-1;
		var sd= new Date(sd_parts[0], sd_parts[1], sd_parts[2], st_parts[0], st_parts[1], st_parts[2], 0);
		var ed= new Date(ed_parts[0], ed_parts[1], ed_parts[2], et_parts[0], et_parts[1], et_parts[2], 9000);

		try{
            window.plugins.calendar.createCalendar("WSLP Events",function(message) {  },function(message) { alert("Error: " + message); });
			//window.plugins.calendar.createCalendar('WSLP-Events',function(mes){},function(mes){});
			//window.plugins.calendar.createEventInNamedCalendar(title,loc,notes,sd,ed,'WSLP-Events',function(mes){alert(mes);},function(mes){alert(mes);});
			window.plugins.calendar.createEvent(title,loc,notes,sd,ed,function(mes){alert("Event added successfully");},function(mes){/*alert("end::"+mes);*/});
			//cal.createEvent(title,loc,notes,startDate,endDate,function(mes){},function(mes){});
		}
		catch(e)
		{
			alert(e);
		}
	}

}
function onBackButtonPress()
{
	alert(mainView.history.length);
	alert(JSON.stringify(mainView.history));
	if(mainView.history.length>1)
	{
		mainView.router.back();
		return false;
	}
	else
		return true;
}
function reloadApp()
{
	//window.location='index.html';
	backHistory();
}
function refreshApp(){
	window.location = "index.html";
}
function splashImage(flag)
{

	if(flag)
	{
		jQuery("#reloadAppBtn").hide();
		//loadingTime = 0;
		//jQuery("#reloadAppBtn").html("");
		//.getAttribute("class");
		//obj=document.getElementById('page1');
		//preClass=obj.getAttribute("class");
		//obj.setAttribute("class","ui-page ui-body-c ui-page-active ui-page-header-fixed ui-page-footer-fixed loading-page-con");
		//ui-page ui-body-c ui-page-active ui-page-header-fixed ui-page-footer-fixed
		//$('#page1').addClass('loading-page-con');
		/*setInterval(function(){
			loadingTime++;
			if (loadingTime > 30) {
				jQuery("#reloadAppBtn").show();
			}
		},1000);*/
		setTimeout(function(){
				jQuery("#reloadAppBtn").show();
			},80000);
		document.getElementById(config.core.splash.id).style.display='';
		document.getElementById(config.core.content.id).style.display='none';
	}
	else
	{
		jQuery("#reloadAppBtn").hide();
		//loadingTime = 0;
		//jQuery("#reloadAppBtn").html("");
		//$('#page1').removeClass('loading-page-con');
		obj=document.getElementById('page1');
		//obj.setAttribute("class",preClass);
		document.getElementById(config.core.splash.id).style.display='none';
		document.getElementById(config.core.content.id).style.display='';
	}
}
function clearCache()
{
	cache=new Array();
	writeCachefile();
}
function loadCache()
{
	/*loadTemplate(config.cache.file,function(data){
		cache=JSON.parse(data);
	} );*/
	//alert('ddd');
	//readCachefile();
	//alert('ddd123');
}
function hideSection(sec)
{
	if(isset(config[sec].id))
	{
		document.getElementById(config[sec].id).style.display='none';
	}
}
function showSection(sec)
{
	if(isset(config[sec].id))
	{
		document.getElementById(config[sec].id).style.display='';
	}
}
function setCacheVar(url,p,data)
{
	var flag=false;
	var pos=0;
	for(i=0;i<cache.length;i++)
	{
		if(cache[i].url==url&&JSON.stringify(cache[i].param)==JSON.stringify(p))
		{
			var d = new Date();
			var n = d.getDate();
			n=parseInt(n)+1;
			d.setDate(n);

			cache[i].url=url;
			cache[i].content=data;
			cache[i].param=p;
			cache[i].expiry=d.getTime();
			pos=i;
			break;
		}
	}
	if(!flag)
	{
		var d = new Date();
		var n = d.getDate();
		n=parseInt(n)+1;
		d.setDate(n);
		pos=0;
		if(cache.length>0)
			pos=cache.length;
		cache[pos]=new Object();
		cache[pos].url=url;
		cache[pos].content=data;
		cache[pos].expiry=d.getTime();
		cache[pos].param=p;

	}
	return pos;
}
function getCacheVar(url,param)
{

	var flag=false;
	var content='';
	var d = new Date();
	for(i=0;i<cache.length;i++)
	{

		if(cache[i].url==url&&JSON.stringify(cache[i].param)==JSON.stringify(param))
		{
			content=cache[i].content;
			//if((!lowInternetConnection)&&(d.getTime()>=cache[i].expiry))
			/*if((d.getTime()>=cache[i].expiry))
				return false;
			else*/
				return content;
		}
	}
	return false;
}
function autoLoad()
{

	loadCache();
	customAutoLoadActions();
	/*
	autoload_arr=config.autoload.split(',');

	for(i=0;i<autoload_arr.length;i++)
	{
		//alert(autoload_arr[i]);

        execSection(autoload_arr[i]);
	}
	splashImage(false);
	//setTimeout('checkAndApplyLoginCondition()',3000);
	autoLoadFlag = true;
	customAutoLoadActions();
	*/
}
function logout()
{
	login_id='';
	checkAndApplyLoginCondition();
	loadMiddleTemaplte('login');
}
function userStatu(status)
{

	if(status=='public')
	{
		jQuery('.visible_before_login').each(function() {
			this.style.display='';
		});
		jQuery('.visible_after_login').each(function() {
			this.style.display='none';
		});
	}
	else
	{
		jQuery('.visible_before_login').each(function() {
			this.style.display='none';
		});
		jQuery('.visible_after_login').each(function() {
			this.style.display='';
		});
	}
}
function checkAndApplyLoginCondition()
{

	if(login_id=='')
		userStatu('public');
	else
	{	/*execJsonData(config.user.action.url,{"todo":"is_authenticated","login_id":login_id},function(data){
			if(data.output.message=='Invalid Login Or Session Expired')
			{
				alert('Session Expired');
				login_id="";
				userStatu('public');
			}
			else
				userStatu('authentic');
		},false);*/
		userStatu('authentic');
	}
}
function loadPageContents(pid,menu_title)
{
	execSection('page',pid,menu_title);
}
function loadMiddleTemaplte(tpl)
{
  // alert("main::"+tpl);
  jQuery("body").attr("class","");
  //calicon
  jQuery("#calicon").hide();
  
	currentTemp=tpl;
	if(arguments.length>1)
		config.user[tpl].passParam=arguments[1];
	//activeLoader('show');
	loadTemplate(config.user[tpl].template,function(data){
		jQuery("body").attr("class",tpl+"page");
		if(isset(config.user[tpl].id))
		{
			if(config.user[tpl].id!='')
			{
				document.getElementById(config.user[tpl].id).innerHTML=data;
			}
		}
		else
		{
			document.getElementById(config.core.middle.id).innerHTML=data;
			//document.getElementById(config.core.middle.id).className='maininner-inner-home';
		}
		//alert($('#page1').trigger);
		/*$('#page1').trigger( "create" );
		//$('#page1').trigger( "pagecreate" );
		$('#page1').trigger( "resize" );*/
		if(myScroll!='') iloaded();
		/*if(tpl!='alarm' && tpl!='aroundus')
		{
			if(myScroll!='') iloaded();

		}
		else
		{
			
			if(myScroll!='') 
			{
				myScroll.destroy();
				
				iloaded2();
			
			}
		}*/
		//resize
		//form_id=tpl+"_form";
		// alert("inner::"+tpl);
		pushHistory("loadMiddleTemaplte",tpl);
		window.scrollTo(0,0);
		//activeLoader('hide');
	});
}
function execSection(section)
{

		//alert(section);
		pushHistory("execSection",section);
		switch(config[section].type)
		{
			case 'url_tpl':
				if(isset(config[section].url))
				{

					parameters={};
					if(isset(config[section].param))
						parameters=$.parseJSON("{"+config[section].param+"}");
					execJsonData(config[section].url,parameters,function(data){
						jData=data;
						if(isset(config[jData.cur_obj].template))
						{
							loadTemplate(config[jData.cur_obj].template,function(data2){
								 try {

										result = tmpl(data2,jData.output);
										//alert(config[jData.cur_obj].id);
										document.getElementById(config[jData.cur_obj].id).innerHTML=result;
											//$('#'+config[jData.cur_obj].id).trigger( "create" );
										/*	$('#page1').trigger( "create" );
											//$('#page1').trigger( "pagecreate" );
											$('#page1').trigger( "resize" );*/
											if(myScroll!='') iloaded();
									} catch (e) {
										alert(e);
									}
							});
						}
					});
				}
			break;
			case 'static_tpl':
				if(isset(config[section].template))
				{
					//alert(config[section].template);
					parameters={};

					loadTemplate(config[section].template,function(data2){

								 try {
                                     // alert(data2);
										rvars="";
										if(arguments.length>1)
											rvars=arguments[1];
										result = data2;
										//alert(rvars.section);

									 //document.getElementById(config[section].id).innerHTML=result;

										document.getElementById(config[rvars.section].id).innerHTML=result;
										//alert(document.getElementById(config[rvars.section].id).innerHTML);

											//$('#'+config[jData.cur_obj].id).trigger( "create" );
											/*$('#page1').trigger( "create" );
											//$('#page1').trigger( "pagecreate" );
											$('#page1').trigger( "resize" );*/
											if(myScroll!='') iloaded();
									} catch (e) {
										alert(e);
									}
							});

				}
			break;
			case 'url_encode_tpl':
				if(isset(config[section].url))
				{
					if(arguments.length>1)
						pid=arguments[1];
					if(arguments.length>2)
						mtitle=arguments[2];
					parameters={};
					if(isset(config[section].param))
						parameters=$.parseJSON("{"+config[section].param+',"pid":"'+pid+'"'+"}");
					execJsonData(config[section].url,parameters,function(data){

						page_contents=Base64.decode(data.output.post_contents);
						data.output.post_contents=page_contents;
						data.output.menu_title=mtitle;
						jData=data;
						if(isset(config[jData.cur_obj].template))
						{
							loadTemplate(config[jData.cur_obj].template,function(data2){
								 try {
										result = tmpl(data2,jData.output);
										result=result.replace('--page-contents--',page_contents);
										//alert(result);
										document.getElementById(config[jData.cur_obj].id).innerHTML=result;
										document.getElementById(config[jData.cur_obj].id).className='maininner-inner-home';
										//$('#'+config[jData.cur_obj].id).trigger( "create" );
										/*$('#page1').trigger( "create" );
										//$('#page1').trigger( "pagecreate" );
										$('#page1').trigger( "resize" );*/
										if(myScroll!='') iloaded();
									} catch (e) {
									alert(e);
								}
							});
						}
						else
						{
							document.getElementById(config[jData.cur_obj].id).innerHTML=page_contents;
							document.getElementById(config[jData.cur_obj].id).className='maininner-inner-home';
							//$('#'+config[jData.cur_obj].id).trigger( "create" );
							/*$('#page1').trigger( "create" );
							//$('#page1').trigger( "pagecreate" );
							$('#page1').trigger( "resize" );*/
							if(myScroll!='') iloaded();
						}
					});
				}

				break;
		}

}
function processFunction(func,template)
{
	for(jj=0;jj<dynamicFunctions.length;jj++)
	{
		if(isset(dynamicFunctions[jj]))
		{
			if(template==dynamicFunctions[jj].template)
			{
				if(isset(dynamicFunctions[jj].functions))
					/*for(kk=0;kk<dynamicFunctions[jj].functions;length;kk++)
					{
						if(dynamicFunctions[jj].functions[kk]=='')
					}*/
					for(k in dynamicFunctions[jj].functions )
					{
						if(k==func)
						{

							dynamicFunctions[jj].functions[k]();

						}
					}

				//dynamicFunctions[jj].events.afterProcessAction(data.output);
			}
		}
	}
}

function processAction(cflag,section,todo)
{
	activeLoader('show');
	var param=new Object();
	flag=true;
	param.todo=todo;
	form='';
	if(arguments.length>3)
		form=arguments[3];
	task="";
	if(arguments.length>4)
		template=arguments[4];
	if(arguments.length>5)
		actionUrl=arguments[5];
	else
		actionUrl=config[section].action.url;
	if(arguments.length>6)
	{
		task=arguments[6];
		param.todo.task=task;
	}
	
	if(form!='')
	{
		//$("#"+form).validationEngine({promptPosition : "topLeft"});
		//if($("#"+form).validationEngine('validate'))
		if(1)
		{
			formObj=document.getElementById(form);
			for(j=0;j<formObj.elements.length;j++)
			{
				param[formObj.elements[j].name]=formObj.elements[j].value;
			}
		}
		else
			flag=false;
	}
	if(flag)
	{	
		execJsonData(actionUrl,param,function(data){
				
				if(!(data.output.login_id==undefined||data.output.login_id==null||data.output.login_id==""))
				{
					login_id=data.output.login_id;
				}
			for(jj=0;jj<dynamicFunctions.length;jj++)
			{
				if(isset(dynamicFunctions[jj]))
				{

					if(template==dynamicFunctions[jj].template)
					{

						activeLoader('hide');
						dynamicFunctions[jj].events.afterProcessAction(data.output);
					}
				}
			}
		},cflag);
	}

}
function reCreateDom()
{
	/*
	$('#page1').trigger( "create" );
	//$('#page1').trigger( "pagecreate" );
	$('#page1').trigger( "resize" );*/
	if(myScroll!='') iloaded();
}



function getLocation()
{
    navigator.geolocation.getCurrentPosition(onGeoSuccess, onGeoError);
}
function onGeoError(error) {
    alert('code: '    + error.code    + '\n' +
          'message: ' + error.message + '\n');
}
function uploadMediaPhoto()
{
	gmarker="";
	wip_marker_image="";
    navigator.camera.getPicture(uploadPhotoCall,
                                uploadFailed,
                                { quality: 45,
                                destinationType: Camera.DestinationType.FILE_URI,
                                sourceType: Camera.PictureSourceType.CAMERA,
                                MediaType:Camera.MediaType.VIDEO
                                }
                                );
			//activeLoader('show');

}
function uploadMapMediaPhoto(gm)
{
	gmarker=gm;
    navigator.camera.getPicture(uploadPhotoCall,
                                uploadFailed,
                                { quality: 45,
                                destinationType: navigator.camera.DestinationType.FILE_URI,
                                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY,
                                MediaType:Camera.MediaType.VIDEO
                                }
                                );

		activeLoader('show');
}
function emailImgLoad()
{
	//alert('image loader');
	if(gmarker=='')
		if(myScroll!='') iloaded();
	activeLoader('hide');
}
function uploadFailed(message){
	//alert('get picture failed');
    activeLoader('hide');
}
function uploadPhotoCall(imageURI) {
	
	if (imageURI.substring(0,21)=="content://com.android"){
	  photo_split=imageURI.split("%3A");
	  imageURI="content://media/external/images/media/"+photo_split[1];
	}
	localStorage.setItem('imageURI',imageURI);
	RImageURI=imageURI;
    /*var options = new FileUploadOptions();
    options.fileKey="file";
    options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
    options.mimeType="image/jpeg";

    var params = {};
    params.value1 = "test";
    params.value2 = "param";

    options.params = params;
    var ft = new FileTransfer();
    myApp.showIndicator();
    ft.upload(imageURI, encodeURI("http://mario.cyberxautomation.com/plugins-scripts/wip_upload/upload.php"), mediaUploadwin, mediaUploadfail, options);*/
	myApp.hideIndicator();
	mainView.router.reloadPage("submit-reciept-detail.html");
}
function uploadReceiptImg()
{
	 var options = new FileUploadOptions();
    options.fileKey="file";
    options.fileName=RImageURI.substr(RImageURI.lastIndexOf('/')+1);
    options.mimeType="image/jpeg";

    var params = {};
    params.value1 = "test";
    params.value2 = "param";

    options.params = params;
    var ft = new FileTransfer();
    myApp.showIndicator();
    ft.upload(RImageURI, encodeURI("http://mario.cyberxautomation.com/plugins-scripts/wip_upload/upload.php"), mediaUploadwin, mediaUploadfail, options);
}
function mediaUploadwin(r) {
	
	var wip_image_obj =  JSON.parse(r.response);
	wip_marker_image = wip_image_obj.name;
	localStorage.setItem("resPath",wip_marker_image);
	RImageURI="";
	//jQuery("#photo_to_send").html('<img onload="emailImgLoad()" src="https://'+config.application.server+'/filemgr/'+wip_marker_image+'" />');
	
    /*alert("Code = " + r.responseCode);
    alert("Response = " + r.response);
    alert("Sent = " + r.bytesSent);*/
	
}

function mediaUploadfail(error) {
	myApp.hideIndicator();
    /*alert("An error has occurred: Code = " + error.code);
    alert("upload error source " + error.source);
    alert("upload error target " + error.target);*/
}

function onGeoSuccess(position)
{
    curLat=position.coords.latitude;
    curLong=position.coords.longitude;
}


function onGeoCurrSuccess(position)
{
    curLat=position.coords.latitude;
    curLong=position.coords.longitude;
	localStorage.setItem("geoCurrentLatitude",curLat);
    localStorage.setItem("geoCurrentLongitude",curLong);

}
function getCurrentLocation()
{

   navigator.geolocation.getCurrentPosition(onGeoCurrSuccess, onGeoError);
}

var myaudioURL = '';
var myaudio = new Audio(myaudioURL);
var isPlaying = false;
var readyStateInterval = null;

function playPauseMusicStream(button,urlToStream)
{
	if(device.platform == "Android"){
		if(localStorage.getItem("liveStreamStatus")!=null)
				liveStreamStatus=localStorage.getItem("liveStreamStatus");
		if (liveStreamStatus == 0 || liveStreamStatus == 3 || liveStreamStatus == 4) {
			//$.mobile.loading('show');
activeLoader('show');
			jQuery(button).removeClass('play-radio-stream');
			jQuery(button).addClass('pause-radio-stream');
			playAudio(urlToStream);
		}else if (liveStreamStatus == 2) {
			jQuery(button).removeClass('pause-radio-stream');
			jQuery(button).addClass('play-radio-stream');
			stopAudio();
		}

    }else{
		if (audio_stream_state == "isStopped" || audio_stream_state == "isWaiting" || audio_stream_state == "" || audio_stream_state == "isIdle") {
			//$.mobile.loading('show');
activeLoader('show');
			jQuery(button).removeClass('play-radio-stream');
			jQuery(button).addClass('pause-radio-stream');
			playBgMusic(urlToStream);
		}else if (audio_stream_state == "isPlaying") {
			jQuery(button).removeClass('pause-radio-stream');
			jQuery(button).addClass('play-radio-stream');
			stopBgMusic();
		}
    }

	/*if (jQuery(button).hasClass('play-radio-stream')) {
			//jQuery(button).val('Pause');
			jQuery(button).removeClass('play-radio-stream');
			jQuery(button).addClass('pause-radio-stream');
	       // alert('dddddd234');
			//playBgMusic(urlToStream);
			stopAudio();
			if(isMediaRunning != false)
			{
				$.mobile.loading('show');
activeLoader('show');
				setTimeout(function(){
					playAudio(urlToStream);
					$.mobile.loading('hide');
activeLoader('hide');
				},10000);
			}
			else
			{
				playAudio(urlToStream);
				isMediaRunning=true;
			}
		}
		else {
			//jQuery(button).val('Play');
			jQuery(button).removeClass('pause-radio-stream');
			jQuery(button).addClass('play-radio-stream');
			//stopBgMusic();
			stopAudio();
		}*/

}
var audioStreamer;
function playBgMusic(urlToStream)
{
	if(device.platform == "Android"){
		//alert('wwwwww');
		audioStreamer = window.plugins.audioStream;

		//alert(audioStreamer.setStreamType);
		audioStreamer.setStreamType("mp3");
		//alert(urlToStream);
		//alert(audioStreamer.play);
	   // alert('ddddddd');
	   // alert(playbackMusicStateChanged);
	   // alert(onBgMusicError);
		audioStreamer.play(urlToStream,playbackMusicStateChanged,onBgMusicError);

		///alert(navigator);

		navigator.notification.activityStart();
	}
	else
	{
		
        myaudioURL = urlToStream;
        myaudio = new Audio(myaudioURL);

        myaudio.play();

        readyStateInterval = setInterval(function(){
                                         if (myaudio.readyState <= 2) {
                                         }
                                         },1000);
        myaudio.addEventListener("timeupdate", function() {

                                }, false);
        myaudio.addEventListener("error", function() {
                                 console.log('myaudio ERROR');
                                 }, false);
        myaudio.addEventListener("canplay", function() {
                                 console.log('myaudio CAN PLAY');
                                 }, false);
        myaudio.addEventListener("waiting", function() {
                                 isPlaying = false;
                                 audio_stream_state="isStopped";
                                 }, false);
        myaudio.addEventListener("playing", function() {
                                 isPlaying = true;
                                 audio_stream_state="isPlaying";
                                 $.mobile.loading('hide');
                                 }, false);
        myaudio.addEventListener("ended", function() {
                                 }, false);
	}
	//$.mobile.loading('hide');
activeLoader('hide');
}
function stopBgMusic()
{
    //alert(audioStreamer.stop);
    //audioStreamer = window.plugins.audioStream;
	if(device.platform == "Android"){
		audioStreamer.stop(playbackMusicStateChanged,onBgMusicError);
	}
	else
	{
	    isPlaying = false;
		audio_stream_state="isStopped";
		clearInterval(readyStateInterval);
		myaudio.pause();
		myaudio = null;
	}
}
function playbackMusicStateChanged(state)
{
    audioStreamer = window.plugins.audioStream;
    console.log("state: "+state);
	audio_stream_state = state;
    switch (state) {
        case "isPlaying":
            console.log("Stream is playing");
            progressTimer = setInterval("console.log(audioStreamer.progress + ' seconds')",300);
            break;
        case "isStopped":
            console.log("Stream is stopped");
            clearInterval(progressTimer);
            break;
        case "isWaiting":
            console.log("Stream is waiting");
            break;
        default:

    }

}
function onBgMusicError(error) {
    audioStreamer = window.plugins.audioStream;
    console.log(e.message);
}

function setMainClass(r,a,bg_img)
{
    if(r!='')
        jQuery('#page1').removeClass(r);
    else
        jQuery('#page1').removeClass(preMainClass);
    jQuery('#page1').addClass( a );
    document.getElementsByClassName(a)[0].setAttribute("style",'background: url("'+bg_img+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');
    preMainClass=a;
}

function setMoreClass(r, a, bg_img){
	if(r!='')
	    jQuery('#page1').removeClass(r);
	else
	    jQuery('#page1').removeClass(preMainClass);
	jQuery('#page1').addClass( a );
	//more_bg_img = resizeImgToDeviceSize('http://dev.jotacms.com/filemgr/Level%200%20Backgrounds/WSLP-Default-Background.png');
	//more_bg_img = resizeImgToDeviceSize(more_bg_img);
	jQuery("."+a).css("background", "url("+bg_img+") top right repeat-y");
	//jQuery("."+a).css("background", "url('../media/template-images/background-1.jpg') top right repeat-y");
	jQuery("."+a).css("background-attachment", "fixed !important");
	preMainClass=a;
}
function mail_fan_pic(){
	if (wip_marker_image != "") {
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/emailphotot/sendemailpic/',
		async: true,
			 dataType   : 'jsonp',
		data: {user_id:config.application.user, image_name:wip_marker_image},
		beforeSend: function (data){
			//$.mobile.loading('show');
activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			alert(textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');
			alert(res.msg);
		}
	});
	}else{
		var d = new Date();
		second_exec = d.getTime();
		time_gap=second_exec-ini_exec;
		if(time_gap>2000)
		{
			alert("Please choose image first.")
			
				var dd = new Date();
				fst_exec = dd.getTime();
		}

	}
}


function sharethis(text,sub,filepath)
{
	 if(device.platform == "Android"){

		window.plugins.share.show({
			subject: sub,
			text: text},
			function() {
				captureEvent(device.platform + "-" + config.application.user, 'Templates', 'App Share');
			}, // Success function
			function() {alert('Share failed')} // Failure function
		);

	}
	else
	{
    //alert(window.plugins.SocialSharing.available);
		/*window.plugins.SocialSharing.available(function(isAvailable) {
			if (isAvailable) {
				// use a local image from inside the www folder:
				window.plugins.SocialSharing.share(text, sub, filepath);
				captureEvent(device.platform + "-" + config.application.user, 'Templates', 'App Share');
			}
		});*/
        window.plugins.socialsharing.share(text, sub, filepath);
        captureEvent(device.platform + "-" + config.application.user, 'Templates', 'App Share');
	}
}

function get_share_app_url(){
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/appsharet/getappurl/'+config.application.user,
		async: true,
			 dataType   : 'jsonp',
		data: {},
		beforeSend: function (data){
			//$.mobile.loading('show');
activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			alert(textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');
			message = "I am using "+config.application.name+" App. You can download it from here:\nApple: " + res.apple_url+"\nAndroid: "+res.android_url;
			sharethis(message,"I am using "+config.application.name+" App","");
		}
	});
}

/* Function to register User for Event */
function register_user_for_event(event_id){
	if(localStorage.getItem("eventid-"+event_id) == "attending"){
		alert("You are already attending this event.");
	}else{
		jQuery.ajax({
			type: "POST",
			url: 'https://'+config.application.server+'/eventst/saveattendinguserinfo',
			async: true,
			data: {'user_id':config.application.user, 'event_id':event_id},
			beforeSend: function (data){
				//$.mobile.loading('show');
activeLoader('show');
			},
			error: function (XHR, textStatus, errorThrown){
				//$.mobile.loading('hide');
activeLoader('hide');
				alert(textStatus);
			},
			complete: function (XHR, textStatus){
				//$.mobile.loading('hide');
activeLoader('hide');
			},
			success: function(res){
				//$.mobile.loading('hide');
activeLoader('hide');
				localStorage.setItem("eventid-"+event_id, "attending");
				number_of_user_attending = parseInt(jQuery("#attending_persons_count").html());
				jQuery("#attending_persons_count").html(number_of_user_attending + 1);
				alert("Your attendance has been recorded for this event.");
			}
		});
		/*localStorage.setItem("eventid-"+event_id, "attending");
		number_of_user_attending = parseInt(jQuery("#attending_persons_count").html());
		jQuery("#attending_persons_count").html(number_of_user_attending + 1);
		alert("Your attendance has been recorded for this event.");*/
	}
}

function resizeImgToDeviceSize(img_url){
 var bg_image =img_url;
 var widths   =jQuery(document).width();
 var heights  =jQuery(document).height();
 return bg_image_url = 'https://'+config.application.server+'/phpThumb/phpThumb.php?src='+bg_image + '&w=' +widths +'&h='+heights+'&zc=1&hash=47db60e11d23dda928e0a154d488512a';
}
function HEXtoRGB()
{
 this.hexToRGB = function(hex)
 {
  return this.hexToR(hex) + ',' + this.hexToG(hex) + ',' + this.hexToB(hex) + ',' + '0.3';
 }
 this.hexToR = function(hex)
 {
  return parseInt((this.cutHex(hex)).substring(0,2),16);
 }
 this.hexToG = function(hex)
 {
  return parseInt((this.cutHex(hex)).substring(2,4),16);
 }
 this.hexToB = function(hex)
 {
  return parseInt((this.cutHex(hex)).substring(4,6),16)
 }
 this.cutHex = function(hex)
 {
  return (hex.charAt(0)=="#") ? hex.substring(1,7):hex;
 }

}

function setThemeAppearance(user_id)
{
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/appearancet/getappearance/'+user_id,
		async: false,
		dataType   : 'jsonp',
		beforeSend: function (data){
			//$.mobile.loading('show');
			activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
			activeLoader('hide');
			alert('Request Status: ' + textStatus);

		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
			activeLoader('hide');
		},
		success: function(res){
			themeLoadFlag=true;
			var htr = new HEXtoRGB();

			//$.mobile.loading('hide');
			activeLoader('hide');
			//var theme = JSON.parse(res);
			var theme = res;
			console.log(theme);
			THEME['appearance'] = theme.appearance;
			THEME['backgrounds'] = theme.backgrounds;
			homeThemeLoad();
			initColorLoad();
		}
	});
}
function initColorLoad()
{
		var htr = new HEXtoRGB();
	var colors = THEME.appearance;
	//jQuery('.custom-navbar a').css('background' : 'url("'+colors.tab_background+'") no-repeat'});
	/*jQuery('.more-page-navigationbar h1').css({'color' : '#' + colors.navigationbar.nvtext, 'text-shadow' : '1px 1px 0 #' + colors.navigationbar.nvshadow });
	jQuery('.more-page-navigationbar').css('background' , '#' + colors.navigationbar.nvbar);
	jQuery('.even-row').css({'background' : 'rgba(' + htr.hexToRGB(colors.evenrow.evbar) + ')', 'color' : '#' + colors.evenrow.evtext });
	jQuery('.odd-row').css({'background' : 'rgba('+ htr.hexToRGB(colors.oddrow.odbar) + ')', 'color' : '#' + colors.oddrow.odtext });
	jQuery('body, input, select, textarea, button, .ui-btn').css({'font-family' : colors.font.fontFamily ,  'src' : "url('"+colors.font.src	+"')" });*/

}
function setMoreColorTheme(user_id)
{
	if(themeLoadFlag)
		initColorLoad();
	else
		setThemeAppearance(config.application.user);
}
function isEvenNumber(n)
{
	return (n % 2 == 0) ? true : false ;
}
function setSplashAsBackground(user_id){
	if(app_splash_screen!= ""){

			document.getElementById('page1').setAttribute("style",'background: url("'+app_splash_screen+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');

	  }
	  else
	{
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/infot/getsplashscreen/'+user_id,
		async: false,
			 dataType   : 'jsonp',
		beforeSend: function (data){
			//$.mobile.loading('show');
                //activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			//alert('Request Status: ' + textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');

			if (res) {
				//setMoreClass('', 'background-more-page', res);
				//jQuery('.main-container').css({'color' : '#fff', 'background' : 'url("'+res+'") no-repeat 50% 0%', 'background-size' : 'cover'});
				//document.getElementsByClassName('main-container')[0].setAttribute("style",'background: url("'+res.app_splash_screen+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');
				app_splash_screen=res.app_splash_screen;
				document.getElementById('page1').setAttribute("style",'background: url("'+res.app_splash_screen+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');
			}
		}
	});
	}
}
function setMorePageBackground(user_id){
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/infot/getmorepagebackground/'+user_id,
		async: false,
			 dataType   : 'jsonp',
		beforeSend: function (data){
			//$.mobile.loading('show');
                activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			//alert('Request Status: ' + textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');
			if (res) {

				//jQuery('.main-container').css({'color' : '#fff', 'background' : 'url("'+res+'") no-repeat 50% 0%', 'background-size' : 'cover'});
				setMainClass('', 'background-more-page', res.more_page);
			}
		}
	});
}
/**
 * To get the user input the secret code of coupon and if code is correct, then stamp the user card/coupon
 * @param  {String} stampCardSecret secret code of coupon
 */
function getCouponStamped(repeated_coupon_id, stampCardSecret, square_count){
	var d = new Date();
		second_exec = d.getTime();
		time_gap=second_exec-fst_exec;
		if(time_gap>2000)
		{
			
			var stamp_code = prompt("Please hand your device to the business representative who will stamp your card.","");
			if (stamp_code != null && stamp_code == stampCardSecret)
			{
				var today = jDateTime.getDateTime();
				var localAssocUserRepeatedCheckIns                 = {};
				obj_userRepeatedCheckIns = jQuery.parseJSON(localStorage.getItem("userRepeatedCheckIns-"+repeated_coupon_id));
				if (obj_userRepeatedCheckIns == null || obj_userRepeatedCheckIns[repeated_coupon_id] === undefined) {
					num_repeated_user_checkins = 1;
				}else{
					console.log(obj_userRepeatedCheckIns[repeated_coupon_id]);
					num_repeated_user_checkins = obj_userRepeatedCheckIns[repeated_coupon_id].counts + 1;
				}
				if( num_repeated_user_checkins <= square_count ){
					localAssocUserRepeatedCheckIns[repeated_coupon_id] = {'user_id':config.application.user, 'repeated_coupon_id':repeated_coupon_id, 'checkin_time' : today, 'counts':num_repeated_user_checkins};
					var userRepeatedCheckIns                           = JSON.stringify(localAssocUserRepeatedCheckIns);
					localStorage.setItem("userRepeatedCheckIns-"+repeated_coupon_id, userRepeatedCheckIns);
				}
				if( square_count == num_repeated_user_checkins)
				{
					updateRepeatedStampCard(num_repeated_user_checkins, square_count);
					alert("You have checked in total number of times, get coupon redeemed.");
					loadMiddleTemaplte('redeemrewardcoupon',{id: repeated_coupon_id });
				}else if ( num_repeated_user_checkins > square_count ) {
					alert("You have already checked in total number of times, get coupon redeemed.");
					loadMiddleTemaplte('redeemrewardcoupon',{id: repeated_coupon_id });
				}else{
					updateRepeatedStampCard(num_repeated_user_checkins, square_count);
					//alert('You have successfuly checked-in for this event.');
				}
				var dd = new Date();
				fst_exec = dd.getTime();	
			}else{
				alert("You have entered a wrong code.");
				var dd = new Date();
				fst_exec = dd.getTime();	
			}
	}
 }

/**
 * To update the progress bar
 * @param  {int} percent
 * @param  {object} $element
 */
function updateProgressBar(percent, $element) {
	var progressBarWidth = percent * $element.width() / 100;
	$element.find('div').animate({ width: progressBarWidth }, 500);/*.html(percent + "%&nbsp;")*/
	jQuery("#progressCount").html(percent + "%&nbsp;");
}
/**
 * Update the stamps and the progress meter to know how many checkins have been made and huch many remained.
 * @param  {int} totalCheckinCounts The number of checkins by user
 * @param  {int} square_count       Total number of checkins to be done
 */
function updateRepeatedStampCard(totalCheckinCounts, square_count){
	var li_style = 'style="width:25%"';
	if(square_count  % 3 == 0)
	{
	li_style = 'style="width:33%"';
	}
	jQuery('.circle-section').html("");
	num_unchecked_stamps = square_count - totalCheckinCounts;
	if (totalCheckinCounts > 0) {
	 	for(i=1; i<= totalCheckinCounts;i++){
	 		jQuery('.circle-section').append('<li '+li_style+'><img src="media/images/circle-img-white.png" /></li>');
	 	}
 		var progress_scale = 100/square_count;
 		if (totalCheckinCounts < progress_scale){

		progress_bar_value = totalCheckinCounts * progress_scale ;
		//$('#progress-bar').val( progress_bar_value );
		//$('#progress-bar').slider('refresh');
		progress_bar_value = Math.round(progress_bar_value);
		updateProgressBar(progress_bar_value, jQuery('#progressBar'));
 		}
	}
	if (num_unchecked_stamps > 0) {
	 	for(i=1; i<= num_unchecked_stamps;i++){
	 		jQuery('.circle-section').append('<li '+li_style+'><img src="media/images/circle-img.png" /></li>');
	 	}
	}
}
/**
 * Hide/Display the relevant newsfeed tab based on user click.
 */
function toggle_newsfeed_tabs(activeTab){
	jQuery("#news_list").children().hide();
	jQuery("#"+activeTab).show();
	jQuery("#"+activeTab).addClass("ui-btn-active");
}
function show_newsfeed(function_name)
{
//alert(login_id);
	processAction(false,'news','getjson','','templates/newsfeed_template.html','https://'+config.application.server+'/newsfeed/' + function_name + '/' + login_id + '/Model_newsfeed/' );

}
function show_newsfeed11()
{
	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/newsfeed/clarksonnewsfeed/'+config.application.user+'/Model_newsfeed/',
		async: false,
			 dataType   : 'jsonp',
		beforeSend: function (data){
			//$.mobile.loading('show');
                activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			//alert('Request Status: ' + textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//res = JSON.parse(res);
			var html = '';
			total_newsfeed_tabs = parseInt(res[0].google) + parseInt(res[0].twitter) + parseInt(res[0].rss);
			if (total_newsfeed_tabs <= 1) {
				jQuery("#newsfeed-tabs").hide();
			}
			if(res[0].google == 1)
			{
				html += "<li id='newsfeed-tab-google' class=\"newsfeed\" onclick=\"show_newsfeed('clarksongoogle');toggle_newsfeed_tabs('newsfeed_google'); applyActiveClass('newsfeed-tab-google','newsfeed-tab-twitter','newsfeed-tab-rss');\"><a class=\"ui-link ui-btn\" href=\"javascript:void(0);\">Google</a></li>";
			}
			if(res[0].twitter == 1)
			{
				html += "<li id='newsfeed-tab-twitter' class=\"newsfeed\" onclick=\"show_newsfeed('clarksontwitter');toggle_newsfeed_tabs('newsfeed_twitter'); applyActiveClass('newsfeed-tab-twitter','newsfeed-tab-google','newsfeed-tab-rss');\"><a  class=\"ui-link ui-btn\" href=\"javascript:void(0);\">Twitter</a></li>";
			}
			if(res[0].rss == 1)
			{
				html += "<li id='newsfeed-tab-rss' class=\"newsfeed\" onclick=\"show_newsfeed('clarksonrss');toggle_newsfeed_tabs('newsfeed_rss'); applyActiveClass('newsfeed-tab-rss','newsfeed-tab-twitter','newsfeed-tab-google');\"><a class=\"ui-link ui-btn\" href=\"javascript:void(0);\">RSS</a></li>";
			}
			jQuery("#newsfeed-tabs").html(html);
			jQuery(jQuery("#newsfeed-tabs li")[0]).click();
			reCreateDom();
			jQuery(document).ready(function(){
				if (total_newsfeed_tabs <= 1) {
				 jQuery("#newsfeed-tabs").hide();
				}else if(total_newsfeed_tabs == 2){
				 jQuery(".newsfeed").addClass("newsfeed1");
				}else{
				 jQuery(".newsfeed").removeClass("newsfeed1");
				}
		   });

		}
	});

}

/**
 * Show runtime popup in app with custom message and callback function
 * @param  {String} message 		Message to show
 * @param  {String} popupafterclose Name of the Callback function
 */
function runtimePopup(message, popupafterclose) {
	/*
	var template = "<div data-role='popup' class='ui-content messagePopup' style='width:80%'>"
	+ "<a href='#' data-role='button' data-theme='g' data-icon='delete' data-iconpos='notext' "
	+ " class='ui-btn-right closePopup'>Close</a> <span> "
	+ message + " </span> </div>";
	popupafterclose = popupafterclose ? popupafterclose : function () {};

	$.mobile.activePage.append(template).trigger("create");

	$.mobile.activePage.find(".closePopup").bind("tap", function (e) {
		$.mobile.activePage.find(".messagePopup").popup("close");
	});
	$.mobile.activePage.find(".messagePopup").popup().popup("open").bind({
		popupafterclose: function () {
		$(this).unbind("popupafterclose").remove();
		popupafterclose();
		}
	});*/
}

var deviceready = false;
var mediaVar = null;
var status = null;
var isIOS = false;
var recordFileName = "choiceline.mp3";

function onBodyLoad()
{
    document.addEventListener("deviceready", onDeviceReady, false);
    deviceready = true;
}

function record()
{
    createMedia(function(){
        status = "recording";
        mediaVar.startRecord();
    },onStatusChange);
}

function createMedia(onMediaCreated, mediaStatusCallback){
    if (mediaVar != null) {
        onMediaCreated();
        return;
    }

    if (typeof mediaStatusCallback == 'undefined')
        mediaStatusCallback = null;
    if (device.platform == "Android") {
    	recordFileName = "choiceline.mp3";
        mediaVar = new Media(recordFileName, function(){
            log("Media created successfully");
        }, onError, mediaStatusCallback);
        onMediaCreated();
    } else{
    	//first create the file
    	recordFileName = "choiceline.wav";
    	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){
    	    fileSystem.root.getFile(recordFileName, {
    	        create: true,
    	        exclusive: false
    	    }, function(fileEntry){
    	        log("File " + recordFileName + " created at " + fileEntry.fullPath);
		choiceline_file_path = fileEntry.fullPath;
    	        mediaVar = new Media(fileEntry.fullPath, function(){
    	            log("Media created successfully");
    	        }, onError, mediaStatusCallback); //of new Media
    	        onMediaCreated();
    	    }, onError); //of getFile
    	}, onError); //of requestFileSystem
    }
}

function stop()
{
    if (mediaVar == null)
        return;

    if (status == 'recording')
    {
    	jQuery("#startStopRecord").src("media/template-images/choiceline-stop.png");
        mediaVar.stopRecord();
        log("Recording stopped");
    }
    else if (status == 'playing')
    {
    	jQuery("#emailRecording").src("media/template-images/choiceline-stop.png");
        mediaVar.stop();
        log("Play stopped");
    }
    else
    {
        log("Nothing stopped");
    }
    status = 'stopped';
}

function playRecording()
{
    createMedia(function(){
        status = "playing";
        if (device.platform == "Android") {
	        recordFileName = "choiceline.mp3";
		mediaVar1 = new Media(recordFileName,function(){
			log('Media Created successfully');
		},onPlayError, onStatusChange);
	     mediaVar1.play();
		}else{
					   /*
					//alert('play here');
				recordFileName = "choiceline.wav";
					window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){
				fileSystem.root.getFile(recordFileName, {
				create: true,
				exclusive: false
				}, function(fileEntry){
				log("File " + recordFileName + " created at " + fileEntry.fullPath);
				mediaVar1 = new Media(fileEntry.fullPath, function(){
									//  alert(mediaVar1);
					log("Media created successfully");
				}, onPlayError, onStatusChange); //of new Media
				}, onPlayError); //of getFile
			}, onPlayError); //of requestFileSystem
			*/
			mediaVar.play();	
		}
	//alert(mediaVar);
	//alert(mediaVar.getDuration());
	//alert(JSON.stringify(mediaVar));

       
    });
}

function onStatusChange()
{
    if (arguments[0] == 4) //play stopped
    {
		jQuery("#playPauseRecording").attr("src", "media/template-images/choiceline-arrow-right.png");
		stopSoundGraph();
        /*$("#recordBtn").show();
        $("#stopBtn").hide();
        $("#playBtn").show();*/
    }
}

function onSuccess()
{
    //do nothing
}

function onError(err)
{
    if (typeof err.message != 'undefined')
        err = err.message;
    alert("Error : " + err);
}
function onPlayError(){
	stopSoundGraph();
	jQuery("#playPauseRecording").attr("src", "media/template-images/choiceline-arrow-right.png");
	alert("Please create a recording first");
}
function log(message)
{
    if (isIOS)
        console.log(message);
    else
        console.log(message);
}

function choiceline_recording_buttons(button){
	if (button.id == "startStopRecord") {
		
		if(jQuery("#startStopRecord").attr("src") == "media/template-images/choiceline-record.png"){
			jQuery("#startStopRecord").attr("src", "media/template-images/choiceline-stop.png");
			record();
			startSoundGraph();
		}else{
			
			jQuery("#startStopRecord").attr("src", "media/template-images/choiceline-record.png");
			stopSoundGraph();
			mediaVar.stopRecord();
			
		}
		//startStopRecord();
	}else if (button.id == "emailRecording") {
		if(device.platform == "Android"){
		    choiceline_file_path = "/mnt/sdcard/choiceline.mp3";
		}
		var objSubject;
		var objEmail;
		var objDes;

	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/choicelinet/choicelinedetails/'+login_id,
		async: true,
			 dataType   : 'jsonp',
		data: {user_id:config.application.user},
		beforeSend: function (data){
		},
		error: function (XHR, textStatus, errorThrown){
			alert(textStatus);
		},
		complete: function (XHR, textStatus){
		},
		success: function(res){
			//res = JSON.parse(res);
			objSubject = res.subject;
			objEmail = res.email;
			objDes = res.description;

		var ops = {
				  callback: function(result){console.log(result);},
				  subject: objSubject,
				  body: objDes,
				  toRecipients: [objEmail],
				  ccRecipients: [],
				  bccRecipients: [],
				  isHTML: true,
				  attachments: [choiceline_file_path]
				};
		 if(device.platform == "Android"){
			window.plugins.emailComposer.showEmailComposerWithCallback(ops.callback, ops.subject, ops.body, ops.toRecipients, ops.ccRecipients, ops.bccRecipients, ops.isHTML, ops.attachments);
		 }
		   else
            {

                window.plugin.email.open({
                                         to:          ops.toRecipients, // email addresses for TO field
                                         cc:          ops.ccRecipients, // email addresses for CC field
                                         bcc:         ops.bccRecipients, // email addresses for BCC field
                                         attachments: ops.attachments, // paths to the files you want to attach or base64 encoded data streams
                                         subject:    ops.subject, // subject of the email
                                         body:        ops.body, // email body (could be HTML code, in this case set isHtml to true)
                                         isHtml:     ops.isHTML, // indicats if the body is HTML or plain text
                                         });

            }
		}
	});
	}else if(button.id == "playPauseRecording"){
		if(jQuery("#playPauseRecording").attr("src") == "media/template-images/choiceline-arrow-right.png"){
			jQuery("#playPauseRecording").attr("src", "media/template-images/choiceline-stop.png");
			playRecording();
			startSoundGraph();
		}else{
			jQuery("#playPauseRecording").attr("src", "media/template-images/choiceline-arrow-right.png");
			stopSoundGraph();
			mediaVar1.stop();
			
		}
		//playPauseRecording();
	}
}

/**
 * If user wants to Play Live Music, then he will be redirected to Live Music page.
 */
function openLiveMusicTemplate(){
	var response = confirm("Do you want to play FM");
	if (response == true){
		alarmStream = true;
		loadMiddleTemaplte('radio_detail',{id:'18'});
	}else{
	  return false;
	}
}
function setAlarm() {
	//alert(SpinningWheel);
	//var now = new Date();
	var hours = { };
	var minutes = { };
	//var hours = { 1: '1', 2: '2', 3: '3', 4: '4', 5: '5', 6: '6', 7: '7', 8: '8', 9: '9', 10: '10', 11: '11', 12: '12' };
	//var minutes = { 1: '1', 2: '2', 3: '3', 4: '4', 5: '5', 6: '6', 7: '7', 8: '8', 9: '9', 10: '10', 11: '11', 12: '12' };
	var am_pm = { 'AM': 'AM', 'PM': 'PM' };

	for( var i = 1; i <= 12; i += 1 ) {
		hours[i] = i;
	}

	for( var i = 0; i < 60; i += 1 ) {
		j = (i < 10) ? ("0" + i) : i;
		minutes[i] = j;
	}

	SpinningWheel.addSlot(hours, 'center');
	SpinningWheel.addSlot(minutes, 'center');
	SpinningWheel.addSlot(am_pm, 'center');

	SpinningWheel.setCancelAction(cancelRoller);
	SpinningWheel.setDoneAction(doneRoller);

	SpinningWheel.open();
}

function doneRoller() {
	var results = SpinningWheel.getSelectedValues();
	//console.log(JSON.stringify(results));
	selHours = results.keys[0];
	selMins = results.values[1];
	selAmPm = results.keys[2];
	alarmTime = selHours + ":" + selMins + selAmPm;
	alert(alarmTime);
	localStorage.setItem("alarmTime", alarmTime);
	document.getElementById('alarmMessage').innerHTML = alarmTime;
	alarmTime = $D(alarmTime);
	if(device.platform == "Android") {
		notification.add({
	        id: 1,
	        date: new Date(alarmTime),
	        message: "Time to Get Up",
	        subtitle: "Get Ready",
	        ticker: "Alarm",
	        sound: "http://50.7.129.122:8219",
	        repeatDaily: false
	    });
	}else{
			/*window.addNotification({
		    fireDate        : new Date(alarmTime),
		    alertBody       : "WSLP Alarm",
		    soundName       : "beep.caf",
		    badge           : 0,
		    notificationId  : 125498,
		    foreground      : function(notificationId){
				openLiveMusicTemplate();
		    },
		    background  : function(notificationId){
				openLiveMusicTemplate();
		    }
		});*/
        noteID=Math.floor((Math.random()*10000)+1);
        window.plugin.notification.local.add({
            id              :noteID,
            message         :'WSLP Alarm',
            date            :new Date(alarmTime),
            badge           : 0,
            sound           :"www/beep.caf"

        });
	}
}

function cancelRoller() {
	//document.getElementById('alarmMessage').innerHTML = 'cancelled!';
}

function cancelAlarm(){
	if(device.platform == "Android") {
		notification.cancel(1);
	}else{
		//window.cancelNotification("125498", function(notificationId){alert(notificationId);});
		//window.cancelAllNotifications();
		 window.plugin.notification.local.cancel(pnoteID2,function () {});
	}
	localStorage.setItem("alarmTime", null);
	document.getElementById('alarmMessage').innerHTML = 'NO ALARM';
}

/**
 * Get the current latitude and Longitude of a Location
 */
function getCLL()
{
 if(navigator.geolocation)
 {
  navigator.geolocation.getCurrentPosition(function(position){
   CURRENT_LATITUDE = position.coords.latitude;
   CURRENT_LONGITUDE = position.coords.longitude;
      localStorage.setItem("geoCurrentLatitude",CURRENT_LATITUDE);
      localStorage.setItem("geoCurrentLongitude",CURRENT_LONGITUDE);

  },function(err){alert(err);});
 }
 else
  alert("navigator.geolocation is not available");

}

/**
 * To create a sound graph
*/
function animateSoundGraph(){
	var messages = ["1", "3", "5", "7", "9", "11", "13", "15", "17", "19", "21", "23", "31", "32"];
	random_frame = messages[Math.floor(Math.random() * messages.length)];
	jQuery("#soundanimate").attr("src", "media/images/soundgraph/sound_bar_"+random_frame+".png");
}

function stopSoundGraph(){
	clearInterval(soundFrameInterval);
	jQuery("#soundanimate").attr("src", "media/images/soundgraph/sound_bar_baseline.png");
}

function startSoundGraph(){
	soundFrameInterval = setInterval(function(){animateSoundGraph()},100);
}
function resetRemoveRewardCoupon(isReusable, rewardCouponID){
	rewardsData = jQuery.parseJSON(localStorage.getItem("userRepeatedCheckIns-"+rewardCouponID));
	if (isReusable == 1) {
		rewardsData[rewardCouponID].counts = 0;
	}else{
		rewardsData[rewardCouponID].counts = "usedReward";
	}
	localRewardsData = JSON.stringify(rewardsData);
	localStorage.setItem("userRepeatedCheckIns-"+rewardCouponID, localRewardsData);
	popHistory();
	popHistory();
	popHistory();
	popHistory();
	loadMiddleTemaplte("repeatrewards");
}

function captureEvent(category, action, opt_label){
	try{
		//_gaq.push(['_trackEvent', category, action, opt_label]);
		ga_storage._trackEvent(category, action, opt_label, 670);
	}catch(err){
	}
}
function get_app_download_stats(){
  if(typeof(Storage)!=="undefined" && localStorage.getItem("is_app_installed") == null){
    var userAgent = navigator.userAgent.toLowerCase();
    if ((userAgent.search("android") > -1)){
      device_type = 'Android';
    }
    if ((userAgent.search("iphone") > -1)){
      device_type = 'iPhone';
    }
    if ((userAgent.search("ipad") > -1)){
      device_type = 'iPad';
    }
    if ((userAgent.search("ipod") > -1)){
      device_type = 'iPod';
    }
    if (navigator.appVersion.indexOf("Win")!=-1){
      device_type = 'Windows';
    }
    if (navigator.appVersion.indexOf("Mac")!=-1){
      device_type = 'Mac';
    }
    if (typeof(device_type) !== 'undefined') {
      captureEvent(device.platform + "-" + config.application.user, 'Downloads', device_type);
      localStorage.setItem("is_app_installed", "yes");
    }
  }
}
/**
 * Set the custom style to apply on home page.
 */
function setHomePageStyle(){
		//document.getElementById("page1").style.minHeight = $(window).height();

}
/**
 * Function to call actions on home page load
 */
function customAutoLoadActions(){

	
	setHomePageStyle();
	//set_analytics_obj(config.application.user);
	/*
	app.initialize();
	
	setSplashAsBackground(config.application.user);
	setMoreColorTheme(config.application.user);
	//setThemeAppearance(config.application.user);
	if(device.platform == "Android"){
		var recordFileName = "choiceline.mp3";
	}else{
		var recordFileName = "choiceline.wav";
	}*/
}
/**
 * Function to compare OS versions
 */
function compareVersions(a, b) {
    var i, cmp, len, re = /(\.0)+[^\.]*$/;
    a = (a + '').replace(re, '').split('.');
    b = (b + '').replace(re, '').split('.');
    len = Math.min(a.length, b.length);
    for( i = 0; i < len; i++ ) {
        cmp = parseInt(a[i], 10) - parseInt(b[i], 10);
        if( cmp !== 0 ) {
            return cmp;
        }
    }
    return a.length - b.length;
}
function getVersion(a, b) {
	if (device.platform == "Android" && compareVersions(a, b) > 0) {
		return "current version";
	}else{
		return b;
	}
}
/**
 * This Funtion displays the roller on Car Finder page on clicking on Alarm buttonbutton
 */
 var pnoteID="";
function setParkingAlarm() {
	/*var hours = { };
	var minutes = { };
	var am_pm = { 'AM': 'AM', 'PM': 'PM' };

	for( var i = 1; i <= 12; i += 1 ) {
		hours[i] = i;
	}

	for( var i = 0; i < 60; i += 1 ) {
		j = (i < 10) ? ("0" + i) : i;
		minutes[i] = j;
	}

	SpinningWheel.addSlot(hours, 'center');
	SpinningWheel.addSlot(minutes, 'center');
	SpinningWheel.addSlot(am_pm, 'center');

	SpinningWheel.setCancelAction(cancelRoller);
	SpinningWheel.setDoneAction(doneParkingRoller);

	SpinningWheel.open();*/




	var options = {
	  date: new Date(),
	  mode: 'time'
	};

	datePicker.show(options, function(time){
                    

	alarmTime=time;
	
	

	
	//alarmTime = $D(alarmTime);
		if(device.platform == "Android") {
			notification.add({
				id: 2,
				date: new Date(alarmTime),
				message: "Where I Parked",
				subtitle: "Parking Alarm",
				ticker: "Parking Alarm",
				repeatDaily: false
			});
		}else{
			/*window.addNotification({
				fireDate        : new Date(alarmTime),
				alertBody       : "Parking Alarm",
				badge           : 0,
				notificationId  : 125499,
				foreground      : function(notificationId){
					//openLiveMusicTemplate();
				},
				background  : function(notificationId){
					//openLiveMusicTemplate();
				}
			});*/
			pnoteID=Math.floor((Math.random()*10000)+1);
                    
			  window.plugin.notification.local.add({
                                         id              :pnoteID,
                                         message         :'Where I Parked',
                                         date            :alarmTime
                                         //badge           : 0,
                                         //sound           :"beep.caf"

                                                   },function(){},{});
                    //openLiveMusicTemplate();
		}


	});



}
/**
 * Function executes when user chooses time from roller on Car Finder page
 */
function doneParkingRoller() {
	var results = SpinningWheel.getSelectedValues();
	selHours = results.keys[0];
	selMins = results.values[1];
	selAmPm = results.keys[2];
	alarmTime = selHours + ":" + selMins + selAmPm;
	alarmTime = $D(alarmTime);
	notification.add({
        id: 1,
        date: new Date(alarmTime),
        message: "Where I Parked",
        subtitle: "Get Ready",
        ticker: "Parking Alarm",
        repeatDaily: false
    });
}
function setTemplateBackground(user_id, template_name){

	jQuery.ajax({
		type: "POST",
		url: 'https://'+config.application.server+'/appearancet/getpagebackground/'+user_id,
		async: false,
			 dataType   : 'jsonp',
		data: {'keyval':template_name},
		beforeSend: function (data){
			//$.mobile.loading('show');
                activeLoader('show');
		},
		error: function (XHR, textStatus, errorThrown){
			//$.mobile.loading('hide');
activeLoader('hide');
			//alert('Request Status: ' + textStatus);
		},
		complete: function (XHR, textStatus){
			//$.mobile.loading('hide');
activeLoader('hide');
		},
		success: function(res){
			//$.mobile.loading('hide');
activeLoader('hide');
			if (res) {
				jQuery("#page1").addClass("background-pushnote-page");
				document.getElementsByClassName('background-pushnote-page')[0].setAttribute("style",'background: url("'+res+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');
			}
		}
	});
}

function homeThemeLoad()
{
	var res = THEME.appearance;
	if (res.tab_background)
	{
		setTimeout(function(){
			home_items = document.getElementsByClassName("custom-footer-navbar")[0].getElementsByClassName("footer-nav-list");
			home_items_length = home_items.length;
			for(var index1=0; index1 < home_items_length; index1++)
			{
				home_items[index1].getElementsByTagName("a")[0].setAttribute("style",'background: url("'+res.tab_background+'") !important;');
			}
		}, 5000);
	}
	if(res.tab_background_border_color)
	{
		//jQuery(".custom-navbar .ui-block-c a").css('border','1px solid #' + res.tab_background_border_color + '');
		setTimeout(function(){
			home_items = document.getElementsByClassName("custom-footer-navbar")[0].getElementsByClassName("footer-nav-list");
			home_items_length = home_items.length;
			for(var index1=0; index1 < home_items_length; index1++)
			{
				home_items_style = home_items[index1].getElementsByTagName("a")[0].getAttribute("style");
				home_items[index1].getElementsByTagName("a")[0].setAttribute("style", home_items_style+' border: 1px solid #' + res.tab_background_border_color + ' ');
			}
		}, 5000);
	}


}
function setTabBackground(userkey)
{
	if(themeLoadFlag)
		homeThemeLoad();
	else
		setThemeAppearance(config.application.user);
}
/**
 * Function to load home page from any template
 */
function loadHomePage(){
	execSection('login');
	setSplashAsBackground(config.application.user);
	setMoreColorTheme(config.application.user);
	setHomePageStyle();
}
/**
 * To override the backbutton functionality.
 */
function onBackKeyDown() {
    // Handle the back button
	//reloadApp();
	if(mainView.history.length>2)
	{
		mainView.router.back();
		return false;
	}
	else
		navigator.app.exitApp();
    
}
document.addEventListener("deviceready", onDeviceReady, false);
document.addEventListener("offline", checkConnectivity, false);
function onDeviceReady() {
	checkConnectivity();
	document.addEventListener("backbutton", onBackKeyDown, false);
}
/**
 * Check Internet connection
 */
function checkConnectivity() {
/*	var networkState = navigator.connection.type;
	var states = {};
	states[Connection.UNKNOWN]  = 'Unknown connection';
	states[Connection.ETHERNET] = 'Ethernet connection';
	states[Connection.WIFI]     = 'WiFi connection';
	states[Connection.CELL_2G]  = 'Cell 2G connection';
	states[Connection.CELL_3G]  = 'Cell 3G connection';
	states[Connection.CELL_4G]  = 'Cell 4G connection';
	states[Connection.NONE]     = 'No network connection';
 	if(networkState == Connection.NONE){
 		window.location = "no-connectivity.html";
 	}
	*/
}
var myScroll='';
var myScroll2='';
function iloaded() {
	//alert(document.body.innerHTML);
	myScroll = new IScroll(document.getElementById('iwrapper'),{ hScrollbar: false, vScrollbar: false , mouseWheel: true, click: true });
	mainLoadDone=true;

}
function iloaded2() {
	//alert(document.body.className);
	//myScroll2 = new IScroll(document.getElementById('iwrapper'),{ hScrollbar: false, vScrollbar: false , mouseWheel: true});
	//mainLoadDone=true;

}

document.addEventListener('touchmove', function (e) { /*e.preventDefault();*/ }, false);
function mainLoadFunc(){
if(mainLoadDone)
	{	
//$.mobile.loading('hide');
activeLoader('hide');
	}
else
	{
		//$.mobile.loading('show');
//activeLoader('show');
		setTimeout("mainLoadFunc()",10);
	}
}
//setTimeout("mainLoadFunc()",1000);

function setTemplatePageHeight(divid){
	//document.getElementById(divid).style.height = ($(window).height()-44)+"px";
}
function replaceFooter(cpid)
{
	
	document.getElementById('navigation_div').innerHTML=document.getElementById(cpid).innerHTML;
	document.getElementById(cpid).innerHTML='';
	document.getElementById('navigation_div').style.display='';
}
function activeLoader(opt)
{
	/*if(opt=='hide')
	{
			$('#status').html('');
            $('#status').fadeOut(); // will first fade out the loading animation
			$('#preloader').delay(650).fadeOut('slow'); // will fade out the white DIV that covers the website.
			$('body').delay(650).css({'overflow':'visible'});
	}
	else
	{
        
        
			$('#status').fadeIn(); // will first fade out the loading animation
			$('#preloader').delay(650).fadeIn('slow'); // will fade out the white DIV that covers the website.
			$('body').delay(650).css({'overflow':'hidden'});
            $('#status').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			
        
    }*/
}
var pnoteID2="";

function getNativeTime()
{
	var options = {
	  date: new Date(),
	  mode: 'time'
	};

	datePicker.show(options, function(time){
	  

	alarmTime=time;
	localStorage.setItem("alarmTime", alarmTime.getHours()+":"+alarmTime.getMinutes());
	

	document.getElementById('alarmMessage').innerHTML = alarmTime.getHours()+":"+alarmTime.getMinutes();
	//alarmTime = $D(alarmTime);
		if(device.platform == "Android") {
			notification.add({
				id: 1,
				date: new Date(alarmTime),
				message: "Time to Get Up",
				subtitle: "Get Ready",
				ticker: "Alarm",
				sound: "http://50.7.129.122:8219",
				repeatDaily: false
			});
		}else{
			/*window.addNotification({
				fireDate        : new Date(alarmTime),
				alertBody       : "WSLP Alarm",
				soundName       : "beep.caf",
				badge           : 0,
				notificationId  : 125498,
				foreground      : function(notificationId){
					openLiveMusicTemplate();
				},
				background  : function(notificationId){
					openLiveMusicTemplate();
				}
			});*/
                    
                    pnoteID2=Math.floor((Math.random()*10000)+1);
                    
                    window.plugin.notification.local.add({
                                                         id              :pnoteID2,
                                                         message         :"Time to Get Up",
                                                         date            :alarmTime,
                                                         //badge           : 0,
                                                         sound           :"www/beep.caf"
                                                         
                                                         },function(){},{});
                   
		}


	});
}


function showNotifications()
{
	jQuery.ajax({
					type: "POST",
					url: 'https://'+config.application.server+'/notifications/toJson/'+login_id+'/Model_notifications/',
					async: false,
					data: {},
					beforeSend: function (data){
						$.mobile.loading('show');
					},
					error: function (XHR, textStatus, errorThrown){
						$.mobile.loading('hide');
					},
					complete: function (XHR, textStatus){
						$.mobile.loading('hide');
					},
					success: function(res){
						var o = JSON.parse(res);
						o = o.output;
						var html = '';
						for(var i in o)
						{
									html += '<div class="white-box">';
										html += '<p>'+o[i].notification;


											contentLink = "";
											if(o[i].content != ""){
												var myObject = eval('(' + o[i].content + ')');

												for(var key in myObject)
												{
													featureLink = myObject[key].onclick;
													featureCaption = myObject[key].caption;
													html += '<a href="javascript:void(0);" onclick="'+featureLink+'">'+featureCaption+'</a>'
												}
											}


										html += '</p>';
										html += '<div class="date-tab">';
											html += '<p class="date">'+o[i].date+'</p>';
											html += '<p class="back-arrow"><a href="#"><img src="media/template-images/back-arrow-1.png" /></a></p>';
											html += '<div class="clear"></div>';
										html += '</div>';
									html += '</div>';

						 }
						 document.getElementById('notifications_list').innerHTML = html;
					}
				});




}
function loadJSFilesAfterEvent()
{
	/*if(device.platform == "Android")
		loadjscssfile('js/childbrowser-functions.js','js');
	else
			loadjscssfile('js/childbrowser-functions-iphone.js','js');
			*/
}
function loadjscssfile(filename, filetype){
  /*  if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script');
        fileref.setAttribute("type","text/javascript");
        fileref.setAttribute("src", filename);
    }
    else if (filetype=="css"){ //if filename is an external CSS file
        var fileref=document.createElement("link");
        fileref.setAttribute("rel", "stylesheet");
        fileref.setAttribute("type", "text/css");
        fileref.setAttribute("href", filename);
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref);*/
}
 document.addEventListener('deviceready', loadJSFilesAfterEvent, false);
 function getAppearanceValue(key,returnVal)
 {
		if(appearance_jsonnav!='')
	   {
			
			for(i=0;i<appearance_jsonnav.length;i++)
		   {
				if(appearance_jsonnav[i].keyval==key)
			   {
					return appearance_jsonnav[i][returnVal];
			   }
		   }
	   }
	   else
       {
			return false;
	   }
 }
 function setPageBackground(key)
 {
	//$('#page1').css('background','url('+ img +') no-repeat fixed 0 0 / 100% 100% rgba(0, 0, 0, 0)');
	bg_img=getAppearanceValue(key,"background");
	if(bg_img&&(bg_img.indexOf(".png")>-1||bg_img.indexOf(".jpg")>-1||bg_img.indexOf(".gif")>-1))
		document.getElementById('page1').setAttribute("style",'background: url("'+bg_img+'") !important; background-size:'+viewport.width+'px '+viewport.height+'px !important; background-repeat:repeat-y !important;');
 }
 
 function applyActiveClass(activeid,id2,id3)
 {
	 jQuery("#"+activeid).addClass("newsfeed-active");
	 jQuery("#"+id2).removeClass("newsfeed-active");
	 jQuery("#"+id3).removeClass("newsfeed-active");
 }
  function AppBackgrounds()
{
	jQuery.ajax
	({
		url:'https://jotacms.com/collegeservice/select_backgrounds/867dbff02526',
		success:function(res)
		{
			backgroundData=res;
			localStorage.setItem('backgroundData',backgroundData);
			localStorage.setItem('testing','testing');
			console.log(backgroundData);
			// for(var back in backgroundData)
			// {
				// alert(backgroundData[back].footer_image);
			// }
		}
	});

	
	
}	
	
	
	//AppBackgrounds();

 function loadBackFooterImage(id)
 {
	var backimg="";
	var footimg="";
	var url="";
	var data=JSON.parse(localStorage.getItem('backgroundData'));
	for(var i in  data)
	{
		if(data[i].subpage_name==id)
		{
			backimg=data[i].background_image.replace("https:","");
			footimg=data[i].footer_image;
			url=data[i].add_url;
			break;
		}
	}
	jQuery(".page").css("background-image","url('"+backimg+"'");	
	jQuery("#"+id+"_footer").html('<img src="'+footimg+'" onclick="openadd(\''+url+'\')">');		
	
}

function openadd(url)
{
	window.open(url);
}

function processContol(ctrlID,data)
{
 var ii=0;
 var ctrlhtml=jQuery("#"+ctrlID+"_ctrl").html();
 var html="";
 for(ii=0;ii<data.length;ii++)
 {
  if(isset(data[ii]))
  {
   var temp=ctrlhtml;
   for(key in data[ii])
            {
                var find = '{{'+key+'}}';
                var re = new RegExp(find, 'g');
                temp=temp.replace(re,eval('data['+ii+'].'+key));
                //alert('{{'+key+'}}::'+eval('data['+ii+'].'+key));
            }
            for(key in config.application)
            {
                var find = '{{'+key+'}}';
                var re = new RegExp(find, 'g');
                temp=temp.replace(re,eval('config.application.'+key));
            }
                //prompt('dddd',temp);
   html=html+temp;
   
  }
 }
   // alert(console.log);
// console.log(html);
    jQuery("#"+ctrlID+"_placeholder").html(html);
}
/*
function processContol(ctrlID,data)
{
	var ii=0;
	var ctrlhtml=jQuery("#"+ctrlID+"_ctrl").html();
	var html="";
	for(ii=0;ii<data.length;ii++)
	{
		if(isset(data[ii]))
		{
			var temp=ctrlhtml;
			for(key in data[ii])
				temp=temp.replace('{{'+key+'}}',eval('data['+ii+'].'+key),"gi");
			for(key in config.application)
				temp=temp.replace('{{'+key+'}}',eval('config.application.'+key),"gi");

			html=html+temp;
			
		}
	}
	jQuery("#"+ctrlID+"_placeholder").html(html);
}*/

function fileSelected() { 
	var count = document.getElementById('fileToUpload').files.length; 
		document.getElementById('details').innerHTML = ""; 
		for (var index = 0; index < count; index ++) 
		{ 
			 var file = document.getElementById('fileToUpload').files[index]; 
			 var fileSize = 0; 
			 if (file.size > 1024 * 1024) {
				fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB'; 
			}	
			else {
				fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB'; 
			}
			document.getElementById('details').innerHTML = file.name;
		} 
	jQuery("#uploadButton").show();
	uploadFile();	
}

  function uploadFile() { 
	var fd = new FormData(); 
		  var count = document.getElementById('fileToUpload').files.length; 
		  for (var index = 0; index < count; index ++) 
		  { 
				 var file = document.getElementById('fileToUpload').files[index]; 
				 fd.append("myfile", file); 
		  }	
		  myApp.showIndicator();
	var xhr = new XMLHttpRequest(); 
	xhr.upload.addEventListener("progress", uploadProgress, false); 
	xhr.addEventListener("load", uploadComplete, false); 
	xhr.addEventListener("error", uploadFailed, false); 
	xhr.addEventListener("abort", uploadCanceled, false); 
	xhr.open("POST", "http://"+config.application.server+"/garageStar/savetofile.php");		
	xhr.send(fd); 
  }

  function uploadProgress(evt) { 
	if (evt.lengthComputable) { 
	  var percentComplete = Math.round(evt.loaded * 100 / evt.total); 
	  document.getElementById('progress').innerHTML = percentComplete.toString() + '%'; 
	} 
	else { 
	  document.getElementById('progress').innerHTML = 'unable to compute'; 
	} 
  }

  function uploadComplete(evt) { 
	/* This event is raised when the server send back a response */ 	
	document.getElementById('uploadedImageName').value = evt.target.responseText;
	document.getElementById('uploadedImageName').value="http://"+config.application.server+"/uploads/"+evt.target.responseText;
	myApp.hideIndicator();
	myApp.alert("Uploaded");

  }

  function uploadFailed(evt) { 
	myApp.alert("There was an error attempting to upload the file."); 
  }

  function uploadCanceled(evt) { 
	myApp.alert("The upload has been canceled by the user or the browser dropped the connection."); 
  } 
  

function getImagesUrls(folderName){
	var data;
	$.ajax({
		url:"http://"+config.application.server+"/pushnotification/getImagesUrls",
		type:"POST",
		data:{"folderName":folderName},
		async:false,
		success:function(result){									
			data = result;
		}
	});
	return data;
}