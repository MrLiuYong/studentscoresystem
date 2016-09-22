/**
 *
 */

function MyAjax(url, data, callfun) {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest()
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //console.log(xmlhttp.responseText);
            callfun(xmlhttp.responseText);
        }
    }


    xmlhttp.open("post", url, true);
    xmlhttp.send(data);
}

function upfile(elem, url) {

    var form = new FormData();
    form.append("file", elem.files[0]);
    MyAjax(url,form,function (data) {
        var info = JSON.parse(data);
        document.getElementById('icon').setAttribute('src', info.url);
        document.getElementById('txticon').setAttribute('value', info.url);
    });
}