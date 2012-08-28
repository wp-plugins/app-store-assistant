(function() {

	function addiOSButton(ed, url){
		ed.addButton('ios_app', {
			title : 'ASA: iOS App shortcode',
			image : url+'/images/iOS_App_Button.png',
			onclick : function() {
				idPattern = /([0-9]+)/;
				var appID = prompt("iOS App ID", "Enter the id of the iOS app");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[ios_app id="'+m[1]+'" more_info_text="open in App Store..."]');
				}
		});  
	}
	function addiTunesButton(ed, url){
		ed.addButton('itunes_store', {
			title : 'ASA: iTunes shortcode',
			image : url+'/images/iTunes_Button.png',
			onclick : function() {
				idPattern = /([0-9]+)/;
				var appID = prompt("iOS iTunes ID", "Enter the id of the iTunes item");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[itunes_store id="'+m[1]+'"  more_info_text="open in iTunes..."]');
				}
		});  
	}
	function addMacAppButton(ed, url){
		ed.addButton('mac_app', {
			title : 'ASA: Mac App shortcode',
			image : url+'/images/Mac_App_Button.png',
			onclick : function() {
				idPattern = /([0-9]+)/;
				var appID = prompt("Mac App ID", "Enter the id of the Mac app");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[mac_app id="'+m[1]+'" more_info_text="open in Mac App Store..."]');
				}
		});  
	}
	function addASAFButton(ed, url){
		ed.addButton('asaf_atomfeed', {
			title : 'ASA: Apple ATOM Feed shortcode',
			image : url+'/images/asaf_Button.png',
			onclick : function() {
				idPattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
				var appID = prompt("ATOM Feed URL", "http://itunes.apple.com/us/rss/toppaidmacapps/limit=25");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[asaf_atomfeed atomurl="'+m[0]+'" mode="iOS" more_info_text="open in App Store..."]');
				}
		});  
	}

	tinymce.create('tinymce.plugins.AppStoreAssistant', {  
        init : function(ed, url) {
            addiOSButton(ed,url);
            addiTunesButton(ed,url);  
            addMacAppButton(ed,url);  
            addASAFButton(ed,url);  
        },  
        createControl : function(n, cm) {  
            return null;  
        },
        getInfo : function() {
            return {
                longname : "App Store Assistent Shortcode",
                author : 'Scott Immerman',
                authorurl : 'http://theiphoneappslist.com/',
                infourl : 'http://theiphoneappslist.com/',
                version : "1.0"
            };
        }
  
    });  
    tinymce.PluginManager.add('asa_mce', tinymce.plugins.AppStoreAssistant);

})();