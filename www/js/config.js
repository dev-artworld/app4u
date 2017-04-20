var config=new Object();
var dfCounter=0;
var dynamicFunctions=new Array();
var reqCounter=0;
var firstRequest=true;
function parseResponse(rhtml)
{
		vtext=rhtml.split("*/-->");
		resObj=new Object();
		if(vtext.length>1)
		{
			var_text=vtext[0].replace('<!--/*','');
			var_text=var_text.toLowerCase();
			var_text_arr=var_text.split('\n');
			var_str='{';
			for(t=0;t<var_text_arr.length;t++)
			{
				txt=var_text_arr[t].replace('\r','',"gi");
				txt=txt.replace(':','":"');
				if(var_str=='{')
					var_str+='"'+txt+'"';
				else
					var_str+=',"'+txt+'"';
			}
			var_str+='}';
			var_str=var_str.replace('"",','',"gi");
			var_str=var_str.replace(',""','',"gi");
			resObj=eval("("+var_str+")");			 
		}
		return resObj; 

}

function tempAlreadyLoad(obj)
{
	for(j1=0;j1<dynamicFunctions.length;j1++)
	{
		if(dynamicFunctions[j1].template==obj.template)
			return true;
	}
	return false;
				
}
function processTemplateData(tdata,fname)
{
		filename=fname;
		if(arguments.length>2)
			actionFunction=arguments[2];
		else
			actionFunction='';
		filter_data_arr=tdata.split("<!--header-->");
		if(filter_data_arr.length>1)
		{
			resVars=parseResponse(tdata);
			if(filename.indexOf(".html")!=-1)
		
			{
				 var dom = $(filter_data_arr[0]);
				//alert(dom.html());
				  dom.filter('script').each(function(){
						 //     this.text || this.textContent || this.innerHTML || '');
						
												
						tObject="";
						if(this.innerHTML!=undefined&&this.innerHTML!=null&&this.innerHTML!='')
							tObject=eval("("+this.innerHTML+")");
						else if(this.textContent!=undefined&&this.textContent!=null&&this.textContent!='')
							tObject=eval("("+this.textContent+")");
						else if(this.text!=undefined&&this.text!=null&&this.text!='')
							tObject=eval("("+this.text+")");
						
						if(isset(tObject)&&tObject!=''&&!tempAlreadyLoad(tObject))
						{
							
							dynamicFunctions[dfCounter]=tObject;
							dfCounter++;
						}
						//alert(dynamicFunctions[dfCounter-1].template);
				});
			}

			filter_data_arr=tdata.split("<!--header-->");
			//alert(filter_data_arr[1]);
			if(actionFunction!='')
			{
				if(filter_data_arr.length>1)
					actionFunction(filter_data_arr[1],resVars);
				else
					actionFunction(tdata,resVars);
			}
			
			if(filename.indexOf(".html")!=-1)
			{
				
				for(jj=0;jj<dynamicFunctions.length;jj++)
				{
					
					if(isset(dynamicFunctions[jj]))
					{
						if(filename==dynamicFunctions[jj].template)
						{
							
							if(isset(dynamicFunctions[jj].secure))
							{
								if(dynamicFunctions[jj].secure&&login_id=='')
								{
									loadMiddleTemaplte('login');
								}
							}

							if(isset(dynamicFunctions[jj].loadJS))
							{
								jsArr=dynamicFunctions[jj].loadJS;
								for(jcounter=0;jcounter<jsArr.length;jcounter++)
								{
									jQuery.get(jsArr[jcounter], function(res){
										eval(res);		
									},'script');
								}
							}
						
							if(isset(dynamicFunctions[jj].events.afterLoadTemplate))
							{
								
								dynamicFunctions[jj].events.afterLoadTemplate();
							}
						}
					}
				}
			}
		}
		else
		{
			if(actionFunction!='')
			actionFunction(tdata);
		}

}
function loadTemplate(filename,actionFunction)
{
	
	actualFunction=function(rdata){		processTemplateData(rdata,filename,actionFunction);	};
	//alert('fffffff');
	jQuery.get(filename, actualFunction,'html');	

}
function isset(variable)
{
	if(variable==undefined||variable==null||variable=='')
		return false;
	return true;
}
function execJsonData(url,param,actionFunction)
{
	cacheFlag=true;
	if(arguments.length>3)
		cacheFlag=arguments[3];
	reqCounter++;
	splashImage(true);
	//$.mobile.loading( 'show' );
	actualFunction=function(rdata){
		//alert(JSON.stringify(rdata));
		/*if(isset(rdata.cache_key))
		{
			var temp_param = JSON.parse(JSON.stringify(rdata));
			cache[rdata.cache_key].content=temp_param;
			writeCachefile();
		}*/
		
		lowInternetConnection=false;
		reqCounter--;
		//alert(rdata);
		actionFunction(rdata);
		if(firstRequest)
		{
			setTimeout('checkAndApplyLoginCondition()',1000);
			firstRequest=false;
		}
		if(reqCounter<=0)
		{
			//$.mobile.loading( 'hide' );
			splashImage(false);
		}
	};
	//if(!firstRequest&&lowInternetConnection)
	loadFlag=true;
	if(cacheFlag)
	{
		content=getCacheVar(url,param);
		if(content)
		{
			actualFunction(content);
			loadFlag=false;
		}
	}
	if(loadFlag)
	{
		var temp_param = JSON.parse(JSON.stringify(param));		
		p=setCacheVar(url,temp_param,'');
		param['cache_key']=p;
		//alert(url);
		jQuery.getJSON(url+"?callback=?",param,actualFunction);
	}
}
function genrateUniqueId()
{
	var unid=Math.floor((Math.random()*10000)+1);
	return unid;
}





function submitForms(form_id)
{
	var validation=true;
	var valid=true;
	var callBackFunc='';
	var callBackError='';
	if(arguments.length>1)
		callBackFunc=arguments[1];
	if(arguments.length>2)
		callBackError=arguments[2];
	if(arguments.length>3)
		validation=arguments[3];
	if(validation)
	{
		jQuery("#"+form_id).validationEngine('attach', {promptPosition : "topLeft", autoPositionUpdate : true});

		valid=jQuery("#"+form_id).validationEngine('validate');
	
	}
	if(valid)
	{
		formObj=document.getElementById(form_id);
		//config.application
		var furl=formObj.action;
		for(k in config.application)
			furl=furl.replace('{{'+k+'}}',eval('config.application.'+k),"gi");
		var qstr = jQuery( "#"+form_id ).serialize();
		jQuery.ajax({
			type: "GET",
			url: furl,
			async: true,
			dataType   : 'jsonp',
			data: qstr,
			beforeSend: function (data){
				
			},
			error: function (XHR, textStatus, errorThrown){
				//alert(textStatus);
				if(callBackError!='')
					callBackError(textStatus);
			},
			complete: function (XHR, textStatus){
				
			},
			success: function(res){
				
				if(callBackFunc!='')
					callBackFunc(res);
			}
		});
		return true;
	}
	else
		return false;
}






function sysLoad()
{

	jQuery('document').ready(function()
	{
		//alert('asdsad');
		loadTemplate('js/config.txt',function(data) {
		//alert(data);
			settings_arr=data.split('\n');
			for(i=0;i<settings_arr.length;i++)
			{
				key_pair=settings_arr[i].split('=');
				if(key_pair.length>1)
				{
					key_subkey_arr=key_pair[0].split('-');
					if(key_subkey_arr.length==3)
					{
						if(typeof config[key_subkey_arr[0]]!='object')
							config[key_subkey_arr[0]]=new Object();
						if(typeof config[key_subkey_arr[0]][key_subkey_arr[1]]!='object')
							config[key_subkey_arr[0]][key_subkey_arr[1]]=new Object();
						config[key_subkey_arr[0]][key_subkey_arr[1]][key_subkey_arr[2]]=key_pair[1].replace('\r','');
					}
					else if(key_subkey_arr.length==2)
					{
						if(typeof config[key_subkey_arr[0]]!='object')
							config[key_subkey_arr[0]]=new Object();
						config[key_subkey_arr[0]][key_subkey_arr[1]]=key_pair[1].replace('\r','');
					}
					else
						config[key_subkey_arr[0]]=key_pair[1].replace('\r','');
				}
			}
			//alert(config.navigation.id);
                     
			autoLoad();
		});
	});
//pushReg();
}
sysLoad();