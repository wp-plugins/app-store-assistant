(function() {

	function addASAButton(ed, url){
		ed.addButton('asa_app', {
			title : 'ASA: App shortcode',
			image : url+'/images/AppStore_Button.png',
			onclick : function() {
				idPattern = /([0-9]+)/;
				var appID = prompt("App ID", "Enter the id of the Mac or iOS app");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[asa_item id="'+m[1]+'" more_info_text="open in App Store..."]');
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
					ed.execCommand('mceInsertContent', false, '[asa_item id="'+m[1]+'"  more_info_text="open in iTunes..."]');
				}
		});  
	}
	function addASAFButton(ed, url){
		ed.addButton('asaf_atomfeed', {
			title : 'ASA: Apple ATOM Feed shortcode',
			image : url+'/images/asaf_Button.png',
			onclick : function() {
				idPattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
				var appID = prompt("ATOM/RSS Feed URL", "http://itunes.apple.com/us/rss/toppaidmacapps/limit=25");
				var m = idPattern.exec(appID);
				if (m != null && m != 'undefined')
					ed.execCommand('mceInsertContent', false, '[asaf_atomfeed atomurl="'+m[0]+'" mode="iOS" more_info_text="open in  Store..."]');
				}
		});  
	}

	tinymce.create('tinymce.plugins.AppStoreAssistant', {  
        init : function(ed, url) {
            addASAButton(ed,url);
            addiTunesButton(ed,url);  
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
                version : "2.0"
            };
        }
  
    });  
    tinymce.PluginManager.add('asa_mce', tinymce.plugins.AppStoreAssistant);

})();