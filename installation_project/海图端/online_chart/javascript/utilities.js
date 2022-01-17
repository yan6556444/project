function setCookie(key, value) {
    var expireDate = new Date;
    expireDate.setMonth(expireDate.getMonth() + 6);
    document.cookie = key + "=" + value + ";" + "expires=" + expireDate.toGMTString() + ";";
}

function getCookie(argument) {
    var buff = document.cookie;
    var args = buff.split(";");
    for(i = 0; i < args.length; i++) {
        var a = args[i].split("=");
        if(trim(a[0]) == argument) {
            return trim(a[1]);
        }
    }

    return "-1";
}

function getArgument(argument) {
    if(window.location.search != "") {
        // We have parameters
        var undef = document.URL.split("?");
        var args = undef[1].split("&");
        for(i = 0; i < args.length; i++) {
            var a = args[i].split("=");
            if(a[0] == argument) {
                return a[1];
            }
        }
        return "-1";
    }
    return "-1";
}

function checkKeyReturn(e) {
    if (e.keyCode == 13) {
        return true;
    }

    return false;
}

function trim(buffer) {
      return buffer.replace(/^\s+/, '').replace(/\s+$/, '');
}

function convert2Web(buffer) {
    buffer = buffer.replace('&', '&amp;');
    buffer = buffer.replace('<', '&lt;');
    buffer = buffer.replace('>', '&gt;');
    buffer = buffer.replace('\'', '&apos;');
    buffer = buffer.replace('\"', '&quot;');

    return buffer
}

function convert2Ascii(buffer) {
    buffer = buffer.replace('ü', 'ue');
    buffer = buffer.replace('ö', 'oe');
    buffer = buffer.replace('ä', 'ae');
    buffer = buffer.replace('ß', 'ss');
    buffer = buffer.replace('ø', 'oe');

    return buffer
}

function convert2Locode(buffer) {
    buffer = buffer.replace('ü', 'u');
    buffer = buffer.replace('ö', 'o');
    buffer = buffer.replace('ä', 'a');
    buffer = buffer.replace('ß', 'ss');
    buffer = buffer.replace('ø', 'o');

    return buffer
}

function convert2Text(buffer) {
    buffer = buffer.replace(/%20/g, ' ');
    buffer = buffer.replace(/&#176;/g, '°');

    return buffer
}

function format2FixedLength(number, length, fraclength) {
    var text = number.toFixed(fraclength);
    while (text.length < length) text = "0"+text;
    return text;
}

function loadXMLDoc(name) {
    if (window.XMLHttpRequest) {
        xhttp=new XMLHttpRequest();
    } else {
        xhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.open("GET",name,false);
    xhttp.send();

    return xhttp.responseXML;
}
