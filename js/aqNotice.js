function aqnotice(b,k,e){
	var f,g;
	void 0!=document.getElementById("aqWrapNotice")&&document.getElementById("aqWrapNotice").parentNode.removeChild(document.getElementById("aqWrapNotice"));
	var d=document.createElement("div");
	d.id="aqWrapNotice";
	d.innerHTML='<div id="aqNoticeInBorder"><div id="aqNoticeText">'+b+"</div></div>";
	document.body.appendChild(d);
	var a=document.getElementById("aqWrapNotice");
	document.getElementById("aqNoticeIcon");
	b=document.getElementById("aqNoticeText");
	d=document.getElementById("aqNoticeInBorder");
a.style.position="fixed";
a.style.right="10px";
a.style.top="100px";
a.style.width="300px";
a.style.fontSize="11px";
a.style.fontFamily="Tahoma";
a.style.boxShadow="0 0 5px rgba(0,0,0,0.1)";
a.style.borderRadius="2px";
a.style.opacity=0;
a.style.background="#f8f8f8";
a.style.color="#333333";
a.style.textShadow=" 0 1px 0 rgba(255,255,255,0.8)";
a.style.border="1px solid #dedede";
d.style.borderRadius="2px";
d.style.border="1px solid #fefefe";
b.style.width="260px";
b.style.padding="10px 5px";
b.style.paddingLeft="40px";
switch(k){
	case "warning":b.style.background="url("+e+"/warning.png) 10px center no-repeat";
	break;
	case "ok":b.style.background="url("+e+"/ok.png) 10px center no-repeat";
	break;
	case "error":b.style.background="url("+e+"/error.png) 10px center no-repeat"; break;
	}
	

	var c=1,h=parseInt(a.offsetLeft+a.offsetWidth+20);
	1>=c&&(f=setInterval(function(){c++;a.style.opacity=parseFloat(c/10);
	a.style.top=parseInt(a.offsetTop+c/3)+"px";
	9==c&&(clearInterval(f),setTimeout(function(){a.offsetLeft<h&&(g=setInterval(function(){c--;
a.style.left=a.offsetLeft+20+"px";
a.style.opacity=parseFloat(c/10);
a.offsetLeft>=h&&(a.parentNode.removeChild(a),clearInterval(g))},30))},5E3))},25))};

