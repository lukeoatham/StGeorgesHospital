function markDocumentLinks() {
	jQuery('a[href*=".pdf"]:not(.no-mark)').addClass('pdfdocument').append(' (PDF)');
	jQuery('a[href*=".xls"]:not(.no-mark)').addClass('xlsdocument').append(' (Excel)');
	jQuery('a[href*=".doc"]:not(.no-mark)').addClass('docdocument').append(' (Word)');
	jQuery('a[href*=".txt"]:not(.no-mark)').addClass('txtdocument').append(' (TXT)');
	jQuery('a[href*=".csv"]:not(.no-mark)').addClass('docdocument').append(' (CSV)');
	return true;	
}

function getCookie(name) {
    var dcookie = document.cookie; 
    var cname = name + "=";
    var clen = dcookie.length;
    var cbegin = 0;
        while (cbegin < clen) {
        var vbegin = cbegin + cname.length;
            if (dcookie.substring(cbegin, vbegin) == cname) { 
            var vend = dcookie.indexOf (";", vbegin);
                if (vend == -1) vend = clen;
            return unescape(dcookie.substring(vbegin, vend));
            }
        cbegin = dcookie.indexOf(" ", cbegin) + 1;
            if (cbegin == 0) break;
        }
    return null;
}

function setCookie(name,value,expires,path,domain,secure) {
	var today = new Date();
	today.setTime( today.getTime() );
	
	if ( expires ) {
		expires = expires * 1 * 60; // time in minutes
	}
	
	var expires_date = new Date( today.getTime() + (expires) );
	
	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
	( ( path ) ? ";path=" + path : "" ) +
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );

    return null;
}
function noCookieBar() { // set a 6 month cookie if user closes cookie bar
	setCookie('emergencymsg','closed','60','/',0,0);
	location.reload(true);
	return true;
}

function gaTrackDownloadableFiles() {

	var links = jQuery('a');

	for(var i = 0; i < links.length; i++) {
		if (links[i].href.indexOf('.pdf') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.csv') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.doc') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.ppt') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.rtf') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.xls') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		} else if (links[i].href.indexOf('.rtf') != "-1") {
			$(links[i]).attr("onclick","javascript: _gaq.push(['_trackPageview', '"+links[i].href+"']);");
		}
	}

	return true;	
}