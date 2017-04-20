/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

var push_ini= 0;

var device_reg_id = 'device_reg_id';
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicity call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
        var pushNotification = window.plugins.pushNotification;
		device_reg_id = 'device_reg_id';       
		pushNotification.register(app.successHandler, app.errorHandler,{"senderID":"227160694361","ecb":"app.onNotificationGCM"});
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
		//var parentElement = document.getElementById(id);
     //   var listeningElement = parentElement.querySelector('.listening');
      //  var receivedElement = parentElement.querySelector('.received');

      //  listeningElement.setAttribute('style', 'display:none;');
      //  receivedElement.setAttribute('style', 'display:block;');

     //   console.log('Received Event: ' + id);
    },
    // result contains any message sent from the plugin call
    successHandler: function(result) {
        //alert('Callback Success! Result = '+result)
    },
    errorHandler:function(error) {
        alert(error);
    },
    onNotificationGCM: function(e) {
        switch( e.event )
        {
            case 'registered':
			 if(typeof(Storage)!=="undefined" && localStorage.getItem(device_reg_id) == null)
                if ( e.regid.length > 0 )
                {
                    var uid = localStorage.getItem("User_Id");
                    jQuery.ajax({
                        type: 'POST',
                        data: {'action':'insert-token','uid':uid,'uuid':device.uuid,'device_udid':'android', 'device_token':e.regid},
                        url: 'http://artworldwebsolutions.com/service-notifications/webservice/insertdevicetokens.php',
                        crossDomain: true,
                        async: true,
                        dataType: 'jsonp',
                        beforeSend: function (data){
                            //$.mobile.loading('show');
							//activeLoader('show');
                            //alert("before send");
                        },
                        error: function (XHR, textStatus, errorThrown){
                            //$.mobile.loading('hide');
							activeLoader('hide');
                            alert(textStatus);
                        },
                        complete: function (XHR, textStatus){
                            //$.mobile.loading('hide');
							activeLoader('hide');
                            //alert("request complete");
                        },
                        success: function(data){
							activeLoader('hide');
                            localStorage.setItem(device_reg_id, e.regid);
                        }
                    });
                }
                break;

            case 'message':
                // this is the actual push notification. its format depends on the data model from the push server
                //alert('Message: '+JSON.stringify(e));
				//alert(JSON.stringify(e.payload));
				//alert(e.payload.custom);
				
				//alert('https://'+config.application.server+'/notificationst/getnotification/'+config.application.user);
				
				var date = new Date();
				var push_exec = date.getTime();
				var timegap=push_exec-push_ini;
				if(timegap>2000)
				{
				var r = confirm(e.message);	
				jQuery.ajax({
					type: "GET",
					url: 'http://artworldwebsolutions.com/service-notifications/webservice/getnotification.php',
					dataType   : 'jsonp',
					data:{'notification_id':e.payload.custom},
					beforeSend: function (data){						
						activeLoader('show');						
					},
					error: function (XHR, textStatus, errorThrown){
						
						activeLoader('hide');
						alert(textStatus);
					},
					complete: function (XHR, textStatus){
						
						activeLoader('hide');
					},
					success: function(res){
						activeLoader('hide');
                        alert(JSON.stringify(res));					
					}
				});

				var d = new Date();
				push_ini = d.getTime();
				
			}
		
		
				//var r = confirm(e.message);
				//runtimePopup(e.message, "");
                break;

            case 'error':
                //alert('GCM error = '+e.msg);
                break;

            default:
                //alert('An unknown GCM event has occurred');
                break;
        }
    }

};
