<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="IE=edge" />
<title>eComps - History</title>

{!! Html::style('public/css/jquery-ui-1.10.4.custom.min.css') !!}
{!! Html::style('public/css/jquery.contextMenu.css') !!}
{!! Html::style('public/css/gridforms.css') !!}
{!! Html::style('public/css/reqGridforms.css') !!}
{!! Html::style('public/css/fullcalendar.min.css') !!}
{!! Html::style('public/css/gamecal.css') !!}
{!! Html::style('public/css/jquery.qtip.min.css') !!}

{!!HTML::script('public/js/jquery-1.9.1.min.js')!!}
{!!HTML::script('public/js/jquery-ui-1.10.4.custom.min.js')!!}
{!!HTML::script('public/js/ec-1.0.0.0.min.js')!!}
{!!HTML::script('public/js/underscore.js')!!}
{!!HTML::script('public/js/moment.min.js')!!}
{!!HTML::script('public/js/fullcalendar.min.js')!!}
{!!HTML::script('public/js/jquery.qtip.min.js')!!}
{!!HTML::script('public/js/jquery.contextMenu.js')!!}

{!! Html::style('public/css/ui.jqgrid.snap.css') !!}
{!! Html::style('public/css/smryGridForms.css') !!}

{!!HTML::script('public/js/jquery.jqGrid.min.js')!!}
{!!HTML::script('public/js/grid.locale-en.js')!!}

{!! Html::style('public/css/main.css') !!}


<script>

	// global variable for all ui resources to use
	var __masterSettings = new settings();
	__masterSettings.init();

	// header js object
	var _header = new header();

	// handles displaying modal overlay
	var _pgOverlay = new pgOverlay();
	var _alertModal = new modal();

	// the icons to use on the header
	var icons = [];
	icons.push(new icBtn('add', 'newRequest', 100, 'New Request'));
	icons.push(new icBtn('folder', 'showHistory', 200, 'History'));
	var toolsButton = new icBtn('support', 'help', 999, 'Help');
	toolsButton.cssClass = 'helpTools';
	icons.push(toolsButton);
	
	//this is set in codebehind if user is admin so that adminUrl is hidden to non-admin users if they view source
	var adminUrl = '';

	$(function() {
		// prepare the modal overlay
		_pgOverlay.build('pgOverlay');

		// handle header icon button clicks
		$(document).on("iconButtonClicked", function(e) {
			if (e.message.sender == 'master') {
				var newWin = e.message.isCtrl;
				//turn off ctrl key since focus is going to shift to a new window
				if (newWin) __masterSettings.isCtrl = false;
				var arg = e.message.arg;
				if (arg == 'newRequest') {
					_header.showGameCal();
				}
				else if (arg == 'showHistory') {
					if (newWin) window.open('history');
					else window.location = 'history';
				}
				else if (arg == 'admin') {
					if (newWin) window.open(adminUrl);
					else window.location = adminUrl;
				}
			}
		});

		__masterSettings.setupAlerter($('#alertOverlay'), $('#alertModal'));

		// build header with icons
		icons = _.filter(icons, function(i) { return i.action != 'admin'; });
		if (adminUrl != '') {
			icons.push(new icBtn('key', 'admin', 50, 'Admin'))
		}
		_header.setup('divHeader', icons);

		var menuItems = {};
		menuItems['contact'] = { name: 'Contact/Info' };
		if (__masterSettings.canShowExternalEdit()) menuItems['external'] = { name: 'Edit External Access' };
		menuItems['refresh'] = { name: 'Refresh Account' };
		menuItems['about'] = { name: 'About/Credits' };

		$.contextMenu({
			selector: '.helpTools',
			trigger: 'left',
			items: menuItems,
			callback: function(key, options) {
				optItemClick(key, options);
			}
		});

		__masterSettings.masterFormatting($('#pageWrapper'));
	});

	function optItemClick(key, options) {
		if (key == 'contact') {
			_header.showHelpForm();
		}
		else if (key == 'external') {
			_header.showUnpwForm();
		}
		else if (key == 'refresh') {
			__masterSettings.refreshSelf(true);
		}
		else if (key == 'about') {
			window.location = 'about';
		}
	}

	// respond to a new ticket request event from header
	_header.startNewRequest = function(msg) {
		if (msg.newWin) window.open(__masterSettings.rootUrl + 'request.aspx?game=' + msg.gameId);
		else window.location = 'request.aspx?game=' + msg.gameId;
	}

	// post back the attempt to impersonate another user
	_header.userChangeSelected = function() {
		$('.actionImpersonate').click();
	}
</script>

</head>
<body>
	    
    <div id="pgOverlay"></div>
    <div id="pgOverlayImg">
        <img class="overlayImage" />
    </div>
    <div id="alertOverlay"></div>
    <div id="alertModal">    
        <div class="alertWrapper">
            <fieldset class="alertContent">
                <legend>MESSAGE</legend>
                <div data-row-span="1">
                    <div data-field-span="1">
                        <div class="alertMessage"></div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    
    <div>
        <div id="pageWrapper">
            <div id="divHeader">
                

				<style>
                    .headerModal 
                    {
                        position:absolute;
                        border:2px dotted #E9F4FF;
                        -moz-border-radius: 20px;
                        -webkit-border-radius:20px;
                        -khtml-border-radius:20px;
                        -moz-box-shadow: 0 1px 5px #626971;
                        -webkit-box-shadow: 0 1px 5px #626971;
                        display: none;
                        z-index:102;            
                        font-size: .8em;
                        overflow: auto;
                    }
                    .userImpersonate 
                    {
                        width: 400px;
                        height: 125px;
                    }
                    .userImpSelect 
                    {
                        height: 40px;
                        width: 400px;
                        overflow: auto;
                    }
                    
                    #calWrapper 
                    {
                        width: 940px;
                        height: 720px;
                        background-color: #4B4B57;
                    }
                    #masterCal 
                    {
                        max-width: 900px;
                        margin: 0 auto;
                        font-size: .8em;
                        color: #4B4B57;
                    }
                    .calendar 
                    {
                        border: none !important;
                    }
                    #helpContainer 
                    {
                        width: 950px;
                        height: 385px;
                    }
                    #unpwContainer 
                    {
                        width: 550px;
                        height: 208px;
                    }
                    #copyClipboardContainer 
                    {
                        width: 848px;
                        height: 130px;
                    }
                </style>

                <div class="headerModal ecstyle" id="calWrapper">
                    
                <style>
                    .calContainer 
                    {
                        
                    }
                    .calActionContainer 
                    {
                        width: 100%;
                        padding-bottom: 5px;
                    }
                    .calMonthName
                    {
                        float: left;
                        padding-left: 22px;
                        padding-top: 15px;
                        font-size: 2.2em;
                        letter-spacing: -2px;
                        text-transform: uppercase;
                    }
                    .calActions 
                    {
                        float: right;
                        padding-right: 12px;
                    }
                    .calButton 
                    {
                        padding: 5px 5px 0px 10px;
                    }
                
                    a.calendarGameEvent:link {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    a.calendarGameEvent:visited {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    a.calendarGameEvent:hover {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    a.calendarGameEvent:active {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    
                </style>
                <div class="calContainer">
                    <div class="calActionContainer">
                        <div class="calMonthName">
                        </div>
                        <div class="calActions">
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div id="masterCal" class="calendar"></div>
                </div>
                </div>

                <div class="headerModal" id="helpContainer">
                    
                
                <style>
                    .helpOverlay 
                    {
                        background-color: rgba(0, 0, 0, 0.7);
                        position:fixed;
                        top:0px;
                        bottom:0px;
                        left:0px;
                        right:0px;
                        z-index:100;
                        display: none;
                    }
                    .helpWrapper 
                    {
                        color:#4B4B57;
                        font-size: .9em !important;
                    }
                    .leftCol
                    {
                        float: left;
                        width: 50%;
                    }
                    .rightCol 
                    {
                        float: left;
                        width: 50%;
                    }
                    .contactWrapper 
                    {
                        border-right: 1px dotted #212126;
                    }
                    .infoWrapper 
                    {
                        background-color: White;
                    }
                    .helpInfoEntry 
                    {
                        font-weight: 900;
                        font-size: 1.1em;
                    }
                    .contactSuccess 
                    {
                        text-align: center;
                        display: none;
                        line-height: 40px;
                    }
                    .helpLinks li
                    {
                        padding-left: 2px;
                        padding-right: 2px;
                        border: none;
                    }
                    .helpLinks ul {
                      list-style-type: none;
                      margin: 0;
                      padding: 0;
                    }
                     
                    .helpLinks li:last-child {
                        border-bottom: none;
                    }
                     
                    .helpLinks li a {
                        text-decoration: none;
                        display: block;
                    }
                    
                    .helpLinks a:link {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    .helpLinks a:visited {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    .helpLinks a:hover {color:#4B4B67 !important; font-style: normal; text-decoration: none; font-weight: bold;}
                    .helpLinks a:active {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                </style>
                
                <div class="helpWrapper req-grid-form">
                    <div class="helpOverlay"></div>
                    
                    <fieldset>
                    
                    <div class="leftCol">
                        <div class="pageHeader">
                            <legend class="pageHeaderLgd">CONTACT</legend>        
                        </div>
                    </div>
                    <div class="rightCol">
                        <div class="pageHeader">
                            <legend class="pageHeaderLgd">INFO</legend>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                    <div class="leftCol">
                        <div class="contactWrapper">
                            <div data-row-span="1" class="contactRow">
                                <div data-field-span="1" class="messageBlock">
                                    <label>message</label>
                                    <textarea id="txtMessage" class="message" cols="100" rows="14" autocomplete="off" style="resize: none;"></textarea>
                                </div>
                            </div>
                            <div>
                                <a class="submit contactSubmit">SUBMIT</a>
                            </div>
                            <div class="pageHeader contactSuccess">
                                SENT SUCCESSFULLY
                            </div>
                        </div>
                    </div>
                    <div class="rightCol">
                        <div class="infoWrapper">    
                            <div style="width: 100%">
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>name</label>
                                        <span class="helpInfoEntry">Mario Washington (Business Operations)</span>
                                    </div>
                                </div>
                                <div data-row-span="7">
                                    <div data-field-span="5">
                                        <label>Tickets.com account</label>
                                        <span class="helpInfoEntry"></span>
                                    </div>
                                    <div data-field-span="2">
                                        <label>CC on File?</label>
                                        <span class="helpInfoEntry hasCc"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="pageHeader" style="padding-top: 20px">
                                <legend class="pageHeaderLgd">HELP</legend>
                            </div>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <label>links</label>
                                    <div class="helpContent" style="width: 100%"></div>        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                    
                    </fieldset>
                </div>
                </div>

                <div class="headerModal" id="unpwContainer">
                    
                
                <style>
                    .unpwWrapper 
                    {
                        
                        font-size: .8em !important;
                    }
                    .unpwOverlay 
                    {
                        background-color: rgba(0, 0, 0, 0.7);
                        position:fixed;
                        top:0px;
                        bottom:0px;
                        left:0px;
                        right:0px;
                        z-index:100;
                        display: none;
                    }
                    .unpwSuccess 
                    {
                        text-align: center;
                        display: none;
                    }
                </style>
                
                <div class="unpwWrapper req-grid-form">
                    <div class="unpwOverlay"></div>
                    <fieldset>
                        <div class="pageHeader">
                            <legend class="pageHeaderLgd">EXTERNAL ACCESS</legend>        
                        </div>
                        <div data-row-span="1" class="unpwRow">
                            <div data-field-span="1">
                                <label>username</label>
                                <input name="ctl00$hdr$hdrUnpw$txtUsername" type="text" id="ctl00_hdr_hdrUnpw_txtUsername" size="25" maxlength="20" class="username" autocomplete="off" value="mwashington" />
                            </div>
                        </div>
                        <div data-row-span="1" class="unpwRow">
                            <div data-field-span="1">
                                <label>password</label>
                                <input type="password" size="25" maxlength="20" value="" class="password" autocomplete="off" />
                            </div>
                        </div>
                        <div>
                            <div style="width: 50%; float: left;">
                                <a class="submit unpwSubmit">SUBMIT</a>
                            </div>
                            <div style="width: 50%; float: left;">
                                <a class="submit unpwRemove">REMOVE</a>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="pageHeader unpwSuccess">
                            UPDATED
                        </div>
                    </fieldset>
                </div>
                </div>

                <div class="headerModal" id="copyClipboardContainer">
                      <div class="copyWrapper">
                        <fieldset>
                            <legend>COPY TEXT</legend>
                            <div data-row-span="1">
                                <div data-field-span="1">
                                    <textarea class="txtCopy" cols="100" rows="4" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

	@include('includes.topbar')

	<div style="float: right; margin-top: 2px; padding-right: 14px" class="actions"></div>
	<div style="clear: both"></div>
            </div>
            
            <div id="mainContent">
                

                <div class="pageHeader filterHeader">Image Attribution</div>
                    <div id="imgAttrWrapper" class="imgAttrWrapper grid-form">
                    
                        <style>
                    .helpOverlay 
                    {
                        background-color: rgba(0, 0, 0, 0.7);
                        position:fixed;
                        top:0px;
                        bottom:0px;
                        left:0px;
                        right:0px;
                        z-index:100;
                        display: none;
                    }
                    .helpWrapper 
                    {
                        color:#4B4B57;
                        font-size: .9em !important;
                    }
                    .leftCol
                    {
                        float: left;
                        width: 50%;
                    }
                    .rightCol 
                    {
                        float: left;
                        width: 50%;
                    }
                    .contactWrapper 
                    {
                        border-right: 1px dotted #212126;
                    }
                    .infoWrapper 
                    {
                        background-color: White;
                    }
                    .helpInfoEntry 
                    {
                        font-weight: 900;
                        font-size: 1.1em;
                    }
                    .contactSuccess 
                    {
                        text-align: center;
                        display: none;
                        line-height: 40px;
                    }
                    .helpLinks li
                    {
                        padding-left: 2px;
                        padding-right: 2px;
                        border: none;
                    }
                    .helpLinks ul {
                      list-style-type: none;
                      margin: 0;
                      padding: 0;
                    }
                     
                    .helpLinks li:last-child {
                        border-bottom: none;
                    }
                     
                    .helpLinks li a {
                        text-decoration: none;
                        display: block;
                    }
                    
                    .helpLinks a:link {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    .helpLinks a:visited {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    .helpLinks a:hover {color:#4B4B67 !important; font-style: normal; text-decoration: none; font-weight: bold;}
                    .helpLinks a:active {color:#4B4B57 !important; font-style: normal; text-decoration: none;}
                    
                    .imgAttrWrapper
                    {
                        background-color: #C6D0D9;
                    }
                    .imgRow 
                    {
                        overflow: hidden;
                    }
                    .imgLeft
                    {
                        float: left;
                        width: 120px;
                        overflow: hidden;
                    }
                    .imgRight 
                    {
                        float: none;
                        overflow: hidden;
                    }
                    .imgEntry 
                    {
                        padding-right: 10px;
                    }
                    .imgAttr 
                    {
                        font-size: .7em;
                    }
                    
                    .grid-form [data-row-span] [data-field-span].focus { background-color: #4B4B57 !important; color: #C6D0D9 !important; }
                    .grid-form [data-row-span] [data-field-span]:hover { background-color: #4B4B57 !important; color: #C6D0D9 !important; }
                    
                    #imgAttrWrapper a:link {color:#FFF68F; font-style: normal; text-decoration: none;}
                    #imgAttrWrapper a:visited {color:#FFF68F; font-style: normal; text-decoration: none;}
                    #imgAttrWrapper a:hover {color:#C6D0D9; font-style: normal; text-decoration: none;}
                    #imgAttrWrapper a:active {color:#FFF68F; font-style: normal; text-decoration: none;}
                    
                    </style>
                
                    
                        <fieldset>
                            <div class="imgAttribution"><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/add_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/add_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://yanlu.de" title="Yannick">Yannick</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/history_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/history_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/info_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/info_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://yanlu.de" title="Yannick">Yannick</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/approve_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/approve_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://picol.org" title="Picol">Picol</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/modify_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/modify_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/delete_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/delete_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/disapprove_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/disapprove_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://picol.org" title="Picol">Picol</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/support_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/support_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/prev2_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/prev2_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/next2_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/next2_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/cabinet_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/cabinet_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/activity_32_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/activity_32_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/uref_24_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/uref_24_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div><div data-row-span="1"><div class="imgRow" data-field-span="1"><div class="imgLeft"><img class="imgEntry" src="https://ecomps.nymets.com/_images/prb_24_off.png"><img class="imgEntry" src="https://ecomps.nymets.com/_images/prb_24_on.png"></div><div class="imgRight"><div class="imgAttr"><div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></div></div><div style="clear: both"></div></div></div></div></fieldset>
                    </div>
                </div>
            
        </div>
    </div>
    
    <div id="divHiddenActions" style="display: none">
        <input type="submit" name="ctl00$btnImpersonate" value="go" id="ctl00_btnImpersonate" class="actionImpersonate" />
    </div>
    
</form>
</body>
</html>