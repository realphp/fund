(function(B){function w(l,a,g,f){var b=B(g,a);b.addData(l);b.make();f=f||0;var c=b.getModuleCount(),h=b.getModuleCount()+2*f;this.text=l;this.level=a;this.version=g;this.moduleCount=h;this.isDark=function(d,h){d-=f;h-=f;return 0>d||d>=c||0>h||h>=c?!1:b.isDark(d,h)};this.addBlank=function(c,b,k,g){var f=this.isDark,a=1/h;this.isDark=function(h,q){var m=q*a,F=h*a,l=m+a,p=F+a;return f(h,q)&&(c>l||m>k||b>p||F>g)}}}function C(l,a,g,f,b){g=Math.max(1,g||1);for(f=Math.min(40,f||40);g<=f;g+=1)try{return new w(l,
a,g,b)}catch(c){}}function u(l,a,g,f,b,c,h,d){l.isDark(h,d)&&a.rect(f,b,c,c)}function y(l,a,g,f,b,c,h,d){var e=l.isDark;l=f+c;var k=b+c;g=g.radius*c;var n=h-1,A=h+1,G=d-1,D=d+1,q=e(h,d),m=e(n,G);c=e(n,d);var F=e(n,D),n=e(h,D),D=e(A,D);d=e(A,d);A=e(A,G);h=e(h,G);q?(m=!c&&!h,c=!c&&!n,n=!d&&!n,h=!d&&!h,m?a.moveTo(f+g,b):a.moveTo(f,b),c?(a.lineTo(l-g,b),a.arcTo(l,b,l,k,g)):a.lineTo(l,b),n?(a.lineTo(l,k-g),a.arcTo(l,k,f,k,g)):a.lineTo(l,k),h?(a.lineTo(f+g,k),a.arcTo(f,k,f,b,g)):a.lineTo(f,k),m?(a.lineTo(f,
b+g),a.arcTo(f,b,l,b,g)):a.lineTo(f,b)):(e=c&&n&&F,n=d&&n&&D,d=d&&h&&A,c&&h&&m&&(a.moveTo(f+g,b),a.lineTo(f,b),a.lineTo(f,b+g),a.arcTo(f,b,f+g,b,g)),e&&(a.moveTo(l-g,b),a.lineTo(l,b),a.lineTo(l,b+g),a.arcTo(l,b,l-g,b,g)),n&&(a.moveTo(l-g,k),a.lineTo(l,k),a.lineTo(l,k-g),a.arcTo(l,k,l-g,k,g)),d&&(a.moveTo(f+g,k),a.lineTo(f,k),a.lineTo(f,k-g),a.arcTo(f,k,f+g,k,g)))}function p(l,a){var g=C(a.text,a.ecLevel,a.minVersion,a.maxVersion,a.quiet);if(!g)return null;var f=v(l).data("qrcode",g),b=f[0].getContext("2d");
v(a.background).is("img")?b.drawImage(a.background,0,0,a.size,a.size):a.background&&(b.fillStyle=a.background,b.fillRect(a.left,a.top,a.size,a.size));var c=a.mode;if(1===c||2===c){var c=a.size,h="bold "+a.mSize*c+"px "+a.fontname,d=v("<canvas/>")[0].getContext("2d");d.font=h;var e=d.measureText(a.label).width,d=a.mSize,k=e/c,e=(1-k)*a.mPosX,n=(1-d)*a.mPosY,k=e+k,d=n+d;1===a.mode?g.addBlank(0,n-.01,c,d+.01):g.addBlank(e-.01,n-.01,k+.01,d+.01);b.fillStyle=a.fontcolor;b.font=h;b.fillText(a.label,e*c,
n*c+.75*a.mSize*c)}else if(3===c||4===c){var c=a.size,h=a.mSize,d=h*(a.image.naturalWidth||1)/(a.image.naturalHeight||1),e=(1-d)*a.mPosX,n=(1-h)*a.mPosY,k=e+d,A=n+h;3===a.mode?g.addBlank(0,n-.01,c,A+.01):g.addBlank(e-.01,n-.01,k+.01,A+.01);b.drawImage(a.image,e*c,n*c,d*c,h*c)}c=g.moduleCount;h=a.size/c;d=u;H&&0<a.radius&&.5>=a.radius&&(d=y);b.beginPath();for(e=0;e<c;e+=1)for(n=0;n<c;n+=1)d(g,b,a,a.left+n*h,a.top+e*h,h,e,n);v(a.fill).is("img")?(b.strokeStyle="rgba(0,0,0,0.5)",b.lineWidth=2,b.stroke(),
g=b.globalCompositeOperation,b.globalCompositeOperation="destination-out",b.fill(),b.globalCompositeOperation=g,b.clip(),b.drawImage(a.fill,0,0,a.size,a.size),b.restore()):(b.fillStyle=a.fill,b.fill());return f}function K(l){var a=v("<canvas/>").attr("width",l.size).attr("height",l.size);return p(a,l)}function I(l){if(E&&"canvas"===l.render)return K(l);if(E&&"image"===l.render)return v("<img/>").attr("src",K(l)[0].toDataURL("image/png"));var a;if(a=C(l.text,l.ecLevel,l.minVersion,l.maxVersion,l.quiet)){var g=
l.size,f=l.background,b=Math.floor,c=a.moduleCount,h=b(g/c),b=b(.5*(g-h*c)),d,g={position:"relative",left:0,top:0,padding:0,margin:0,width:g,height:g};l={position:"absolute",padding:0,margin:0,width:h,height:h,"background-color":l.fill};g=v("<div/>").data("qrcode",a).css(g);f&&g.css("background-color",f);for(f=0;f<c;f+=1)for(d=0;d<c;d+=1)a.isDark(f,d)&&v("<div/>").css(l).css({left:b+d*h,top:b+f*h}).appendTo(g);a=g}else a=null;return a}var v=jQuery,E=function(){var l=document.createElement("canvas");
return Boolean(l.getContext&&l.getContext("2d"))}(),H="[object Opera]"!==Object.prototype.toString.call(window.opera),J={render:"canvas",minVersion:1,maxVersion:40,ecLevel:"L",left:0,top:0,size:200,fill:"#000",background:null,text:"no text",radius:0,quiet:0,mode:0,mSize:.1,mPosX:.5,mPosY:.5,label:"no label",fontname:"sans",fontcolor:"#000",image:null};v.fn.qrcode=function(l){var a=v.extend({},J,l);return this.each(function(){"canvas"===this.nodeName.toLowerCase()?p(this,a):v(this).append(I(a))})}})(function(){var B=
function(){function w(g,f){if("undefined"==typeof g.length)throw Error(g.length+"/"+f);var b=function(){for(var c=0;c<g.length&&0==g[c];)c+=1;for(var d=Array(g.length-c+f),b=0;b<g.length-c;b+=1)d[b]=g[b+c];return d}(),c={getAt:function(c){return b[c]},getLength:function(){return b.length},multiply:function(b){for(var d=Array(c.getLength()+b.getLength()-1),e=0;e<c.getLength();e+=1)for(var k=0;k<b.getLength();k+=1)d[e+k]^=p.gexp(p.glog(c.getAt(e))+p.glog(b.getAt(k)));return w(d,0)},mod:function(b){if(0>
c.getLength()-b.getLength())return c;for(var d=p.glog(c.getAt(0))-p.glog(b.getAt(0)),e=Array(c.getLength()),k=0;k<c.getLength();k+=1)e[k]=c.getAt(k);for(k=0;k<b.getLength();k+=1)e[k]^=p.gexp(p.glog(b.getAt(k))+d);return w(e,0).mod(b)}};return c}var C=function(g,f){var b=u[f],c=null,h=0,d=null,e=[],k={},n=function(k,f){for(var q=h=4*g+17,m=Array(q),a=0;a<q;a+=1){m[a]=Array(q);for(var n=0;n<q;n+=1)m[a][n]=null}c=m;l(0,0);l(h-7,0);l(0,h-7);q=y.getPatternPosition(g);for(m=0;m<q.length;m+=1)for(a=0;a<
q.length;a+=1){var n=q[m],p=q[a];if(null==c[n][p])for(var x=-2;2>=x;x+=1)for(var r=-2;2>=r;r+=1)c[n+x][p+r]=-2==x||2==x||-2==r||2==r||0==x&&0==r?!0:!1}for(q=8;q<h-8;q+=1)null==c[q][6]&&(c[q][6]=0==q%2);for(q=8;q<h-8;q+=1)null==c[6][q]&&(c[6][q]=0==q%2);q=y.getBCHTypeInfo(b<<3|f);for(m=0;15>m;m+=1)a=!k&&1==(q>>m&1),6>m?c[m][8]=a:8>m?c[m+1][8]=a:c[h-15+m][8]=a;for(m=0;15>m;m+=1)a=!k&&1==(q>>m&1),8>m?c[8][h-m-1]=a:9>m?c[8][15-m-1+1]=a:c[8][15-m-1]=a;c[h-8][8]=!k;if(7<=g){q=y.getBCHTypeNumber(g);for(m=
0;18>m;m+=1)a=!k&&1==(q>>m&1),c[Math.floor(m/3)][m%3+h-8-3]=a;for(m=0;18>m;m+=1)a=!k&&1==(q>>m&1),c[m%3+h-8-3][Math.floor(m/3)]=a}if(null==d){q=B.getRSBlocks(g,b);m=I();for(a=0;a<e.length;a+=1)n=e[a],m.put(n.getMode(),4),m.put(n.getLength(),y.getLengthInBits(n.getMode(),g)),n.write(m);for(a=n=0;a<q.length;a+=1)n+=q[a].dataCount;if(m.getLengthInBits()>8*n)throw Error("code length overflow. ("+m.getLengthInBits()+">"+8*n+")");for(m.getLengthInBits()+4<=8*n&&m.put(0,4);0!=m.getLengthInBits()%8;)m.putBit(!1);
for(;!(m.getLengthInBits()>=8*n);){m.put(236,8);if(m.getLengthInBits()>=8*n)break;m.put(17,8)}for(var z=0,n=a=0,p=Array(q.length),x=Array(q.length),r=0;r<q.length;r+=1){var u=q[r].dataCount,v=q[r].totalCount-u,a=Math.max(a,u),n=Math.max(n,v);p[r]=Array(u);for(var t=0;t<p[r].length;t+=1)p[r][t]=255&m.getBuffer()[t+z];z+=u;t=y.getErrorCorrectPolynomial(v);u=w(p[r],t.getLength()-1).mod(t);x[r]=Array(t.getLength()-1);for(t=0;t<x[r].length;t+=1)v=t+u.getLength()-x[r].length,x[r][t]=0<=v?u.getAt(v):0}for(t=
m=0;t<q.length;t+=1)m+=q[t].totalCount;m=Array(m);for(t=z=0;t<a;t+=1)for(r=0;r<q.length;r+=1)t<p[r].length&&(m[z]=p[r][t],z+=1);for(t=0;t<n;t+=1)for(r=0;r<q.length;r+=1)t<x[r].length&&(m[z]=x[r][t],z+=1);d=m}q=d;m=-1;a=h-1;n=7;p=0;x=y.getMaskFunction(f);for(r=h-1;0<r;r-=2)for(6==r&&--r;;){for(t=0;2>t;t+=1)null==c[a][r-t]&&(z=!1,p<q.length&&(z=1==(q[p]>>>n&1)),x(a,r-t)&&(z=!z),c[a][r-t]=z,--n,-1==n&&(p+=1,n=7));a+=m;if(0>a||h<=a){a-=m;m=-m;break}}},l=function(b,d){for(var e=-1;7>=e;e+=1)if(!(-1>=b+
e||h<=b+e))for(var a=-1;7>=a;a+=1)-1>=d+a||h<=d+a||(c[b+e][d+a]=0<=e&&6>=e&&(0==a||6==a)||0<=a&&6>=a&&(0==e||6==e)||2<=e&&4>=e&&2<=a&&4>=a?!0:!1)};k.addData=function(c){c=v(c);e.push(c);d=null};k.isDark=function(b,d){if(0>b||h<=b||0>d||h<=d)throw Error(b+","+d);return c[b][d]};k.getModuleCount=function(){return h};k.make=function(){for(var c=0,b=0,d=0;8>d;d+=1){n(!0,d);var e=y.getLostPoint(k);if(0==d||c>e)c=e,b=d}n(!1,b)};k.createTableTag=function(c,b){c=c||2;var d;d='<table style=" border-width: 0px; border-style: none;';
d+=" border-collapse: collapse;";d+=" padding: 0px; margin: "+("undefined"==typeof b?4*c:b)+"px;";d+='">';d+="<tbody>";for(var e=0;e<k.getModuleCount();e+=1){d+="<tr>";for(var h=0;h<k.getModuleCount();h+=1)d+='<td style="',d+=" border-width: 0px; border-style: none;",d+=" border-collapse: collapse;",d+=" padding: 0px; margin: 0px;",d+=" width: "+c+"px;",d+=" height: "+c+"px;",d+=" background-color: ",d+=k.isDark(e,h)?"#000000":"#ffffff",d+=";",d+='"/>';d+="</tr>"}d+="</tbody>";return d+="</table>"};
k.createImgTag=function(d,c){d=d||2;c="undefined"==typeof c?4*d:c;var b=k.getModuleCount()*d+2*c,e=c,h=b-c;return a(b,b,function(c,b){return e<=c&&c<h&&e<=b&&b<h?k.isDark(Math.floor((b-e)/d),Math.floor((c-e)/d))?0:1:1})};return k};C.stringToBytes=function(a){for(var f=[],b=0;b<a.length;b+=1){var c=a.charCodeAt(b);f.push(c&255)}return f};C.createStringToBytes=function(a,f){var b=function(){for(var c=J(a),b=function(){var d=c.read();if(-1==d)throw Error();return d},d=0,e={};;){var k=c.read();if(-1==
k)break;var n=b(),l=b(),p=b(),k=String.fromCharCode(k<<8|n);e[k]=l<<8|p;d+=1}if(d!=f)throw Error(d+" != "+f);return e}();return function(c){for(var h=[],d=0;d<c.length;d+=1){var e=c.charCodeAt(d);128>e?h.push(e):(e=b[c.charAt(d)],"number"==typeof e?(e&255)==e?h.push(e):(h.push(e>>>8),h.push(e&255)):h.push(63))}return h}};var u={L:1,M:0,Q:3,H:2},y=function(){var a=[[],[6,18],[6,22],[6,26],[6,30],[6,34],[6,22,38],[6,24,42],[6,26,46],[6,28,50],[6,30,54],[6,32,58],[6,34,62],[6,26,46,66],[6,26,48,70],
[6,26,50,74],[6,30,54,78],[6,30,56,82],[6,30,58,86],[6,34,62,90],[6,28,50,72,94],[6,26,50,74,98],[6,30,54,78,102],[6,28,54,80,106],[6,32,58,84,110],[6,30,58,86,114],[6,34,62,90,118],[6,26,50,74,98,122],[6,30,54,78,102,126],[6,26,52,78,104,130],[6,30,56,82,108,134],[6,34,60,86,112,138],[6,30,58,86,114,142],[6,34,62,90,118,146],[6,30,54,78,102,126,150],[6,24,50,76,102,128,154],[6,28,54,80,106,132,158],[6,32,58,84,110,136,162],[6,26,54,82,110,138,166],[6,30,58,86,114,142,170]],f={},b=function(c){for(var b=
0;0!=c;)b+=1,c>>>=1;return b};f.getBCHTypeInfo=function(c){for(var a=c<<10;0<=b(a)-b(1335);)a^=1335<<b(a)-b(1335);return(c<<10|a)^21522};f.getBCHTypeNumber=function(c){for(var a=c<<12;0<=b(a)-b(7973);)a^=7973<<b(a)-b(7973);return c<<12|a};f.getPatternPosition=function(c){return a[c-1]};f.getMaskFunction=function(c){switch(c){case 0:return function(c,d){return 0==(c+d)%2};case 1:return function(c,d){return 0==c%2};case 2:return function(c,d){return 0==d%3};case 3:return function(c,d){return 0==(c+
d)%3};case 4:return function(c,d){return 0==(Math.floor(c/2)+Math.floor(d/3))%2};case 5:return function(c,d){return 0==c*d%2+c*d%3};case 6:return function(c,d){return 0==(c*d%2+c*d%3)%2};case 7:return function(c,d){return 0==(c*d%3+(c+d)%2)%2};default:throw Error("bad maskPattern:"+c);}};f.getErrorCorrectPolynomial=function(c){for(var b=w([1],0),d=0;d<c;d+=1)b=b.multiply(w([1,p.gexp(d)],0));return b};f.getLengthInBits=function(c,b){if(1<=b&&10>b)switch(c){case 1:return 10;case 2:return 9;case 4:return 8;
case 8:return 8;default:throw Error("mode:"+c);}else if(27>b)switch(c){case 1:return 12;case 2:return 11;case 4:return 16;case 8:return 10;default:throw Error("mode:"+c);}else if(41>b)switch(c){case 1:return 14;case 2:return 13;case 4:return 16;case 8:return 12;default:throw Error("mode:"+c);}else throw Error("type:"+b);};f.getLostPoint=function(c){for(var b=c.getModuleCount(),d=0,e=0;e<b;e+=1)for(var a=0;a<b;a+=1){for(var g=0,f=c.isDark(e,a),l=-1;1>=l;l+=1)if(!(0>e+l||b<=e+l))for(var p=-1;1>=p;p+=
1)0>a+p||b<=a+p||0==l&&0==p||f!=c.isDark(e+l,a+p)||(g+=1);5<g&&(d+=3+g-5)}for(e=0;e<b-1;e+=1)for(a=0;a<b-1;a+=1)if(g=0,c.isDark(e,a)&&(g+=1),c.isDark(e+1,a)&&(g+=1),c.isDark(e,a+1)&&(g+=1),c.isDark(e+1,a+1)&&(g+=1),0==g||4==g)d+=3;for(e=0;e<b;e+=1)for(a=0;a<b-6;a+=1)c.isDark(e,a)&&!c.isDark(e,a+1)&&c.isDark(e,a+2)&&c.isDark(e,a+3)&&c.isDark(e,a+4)&&!c.isDark(e,a+5)&&c.isDark(e,a+6)&&(d+=40);for(a=0;a<b;a+=1)for(e=0;e<b-6;e+=1)c.isDark(e,a)&&!c.isDark(e+1,a)&&c.isDark(e+2,a)&&c.isDark(e+3,a)&&c.isDark(e+
4,a)&&!c.isDark(e+5,a)&&c.isDark(e+6,a)&&(d+=40);for(a=g=0;a<b;a+=1)for(e=0;e<b;e+=1)c.isDark(e,a)&&(g+=1);c=Math.abs(100*g/b/b-50)/5;return d+10*c};return f}(),p=function(){for(var a=Array(256),f=Array(256),b=0;8>b;b+=1)a[b]=1<<b;for(b=8;256>b;b+=1)a[b]=a[b-4]^a[b-5]^a[b-6]^a[b-8];for(b=0;255>b;b+=1)f[a[b]]=b;return{glog:function(b){if(1>b)throw Error("glog("+b+")");return f[b]},gexp:function(b){for(;0>b;)b+=255;for(;256<=b;)b-=255;return a[b]}}}(),B=function(){var a=[[1,26,19],[1,26,16],[1,26,13],
[1,26,9],[1,44,34],[1,44,28],[1,44,22],[1,44,16],[1,70,55],[1,70,44],[2,35,17],[2,35,13],[1,100,80],[2,50,32],[2,50,24],[4,25,9],[1,134,108],[2,67,43],[2,33,15,2,34,16],[2,33,11,2,34,12],[2,86,68],[4,43,27],[4,43,19],[4,43,15],[2,98,78],[4,49,31],[2,32,14,4,33,15],[4,39,13,1,40,14],[2,121,97],[2,60,38,2,61,39],[4,40,18,2,41,19],[4,40,14,2,41,15],[2,146,116],[3,58,36,2,59,37],[4,36,16,4,37,17],[4,36,12,4,37,13],[2,86,68,2,87,69],[4,69,43,1,70,44],[6,43,19,2,44,20],[6,43,15,2,44,16],[4,101,81],[1,80,
50,4,81,51],[4,50,22,4,51,23],[3,36,12,8,37,13],[2,116,92,2,117,93],[6,58,36,2,59,37],[4,46,20,6,47,21],[7,42,14,4,43,15],[4,133,107],[8,59,37,1,60,38],[8,44,20,4,45,21],[12,33,11,4,34,12],[3,145,115,1,146,116],[4,64,40,5,65,41],[11,36,16,5,37,17],[11,36,12,5,37,13],[5,109,87,1,110,88],[5,65,41,5,66,42],[5,54,24,7,55,25],[11,36,12,7,37,13],[5,122,98,1,123,99],[7,73,45,3,74,46],[15,43,19,2,44,20],[3,45,15,13,46,16],[1,135,107,5,136,108],[10,74,46,1,75,47],[1,50,22,15,51,23],[2,42,14,17,43,15],[5,150,
120,1,151,121],[9,69,43,4,70,44],[17,50,22,1,51,23],[2,42,14,19,43,15],[3,141,113,4,142,114],[3,70,44,11,71,45],[17,47,21,4,48,22],[9,39,13,16,40,14],[3,135,107,5,136,108],[3,67,41,13,68,42],[15,54,24,5,55,25],[15,43,15,10,44,16],[4,144,116,4,145,117],[17,68,42],[17,50,22,6,51,23],[19,46,16,6,47,17],[2,139,111,7,140,112],[17,74,46],[7,54,24,16,55,25],[34,37,13],[4,151,121,5,152,122],[4,75,47,14,76,48],[11,54,24,14,55,25],[16,45,15,14,46,16],[6,147,117,4,148,118],[6,73,45,14,74,46],[11,54,24,16,55,
25],[30,46,16,2,47,17],[8,132,106,4,133,107],[8,75,47,13,76,48],[7,54,24,22,55,25],[22,45,15,13,46,16],[10,142,114,2,143,115],[19,74,46,4,75,47],[28,50,22,6,51,23],[33,46,16,4,47,17],[8,152,122,4,153,123],[22,73,45,3,74,46],[8,53,23,26,54,24],[12,45,15,28,46,16],[3,147,117,10,148,118],[3,73,45,23,74,46],[4,54,24,31,55,25],[11,45,15,31,46,16],[7,146,116,7,147,117],[21,73,45,7,74,46],[1,53,23,37,54,24],[19,45,15,26,46,16],[5,145,115,10,146,116],[19,75,47,10,76,48],[15,54,24,25,55,25],[23,45,15,25,46,
16],[13,145,115,3,146,116],[2,74,46,29,75,47],[42,54,24,1,55,25],[23,45,15,28,46,16],[17,145,115],[10,74,46,23,75,47],[10,54,24,35,55,25],[19,45,15,35,46,16],[17,145,115,1,146,116],[14,74,46,21,75,47],[29,54,24,19,55,25],[11,45,15,46,46,16],[13,145,115,6,146,116],[14,74,46,23,75,47],[44,54,24,7,55,25],[59,46,16,1,47,17],[12,151,121,7,152,122],[12,75,47,26,76,48],[39,54,24,14,55,25],[22,45,15,41,46,16],[6,151,121,14,152,122],[6,75,47,34,76,48],[46,54,24,10,55,25],[2,45,15,64,46,16],[17,152,122,4,153,
123],[29,74,46,14,75,47],[49,54,24,10,55,25],[24,45,15,46,46,16],[4,152,122,18,153,123],[13,74,46,32,75,47],[48,54,24,14,55,25],[42,45,15,32,46,16],[20,147,117,4,148,118],[40,75,47,7,76,48],[43,54,24,22,55,25],[10,45,15,67,46,16],[19,148,118,6,149,119],[18,75,47,31,76,48],[34,54,24,34,55,25],[20,45,15,61,46,16]],f=function(b,d){var a={};a.totalCount=b;a.dataCount=d;return a},b={},c=function(b,d){switch(d){case u.L:return a[4*(b-1)+0];case u.M:return a[4*(b-1)+1];case u.Q:return a[4*(b-1)+2];case u.H:return a[4*
(b-1)+3]}};b.getRSBlocks=function(b,d){var a=c(b,d);if("undefined"==typeof a)throw Error("bad rs block @ typeNumber:"+b+"/errorCorrectLevel:"+d);for(var g=a.length/3,n=[],l=0;l<g;l+=1)for(var p=a[3*l+0],u=a[3*l+1],q=a[3*l+2],m=0;m<p;m+=1)n.push(f(u,q));return n};return b}(),I=function(){var a=[],f=0,b={getBuffer:function(){return a},getAt:function(b){return 1==(a[Math.floor(b/8)]>>>7-b%8&1)},put:function(a,g){for(var d=0;d<g;d+=1)b.putBit(1==(a>>>g-d-1&1))},getLengthInBits:function(){return f},putBit:function(b){var h=
Math.floor(f/8);a.length<=h&&a.push(0);b&&(a[h]|=128>>>f%8);f+=1}};return b},v=function(a){var f=C.stringToBytes(a);return{getMode:function(){return 4},getLength:function(b){return f.length},write:function(b){for(var a=0;a<f.length;a+=1)b.put(f[a],8)}}},E=function(){var a=[],f={writeByte:function(b){a.push(b&255)},writeShort:function(b){f.writeByte(b);f.writeByte(b>>>8)},writeBytes:function(b,a,g){a=a||0;g=g||b.length;for(var d=0;d<g;d+=1)f.writeByte(b[d+a])},writeString:function(b){for(var a=0;a<
b.length;a+=1)f.writeByte(b.charCodeAt(a))},toByteArray:function(){return a},toString:function(){var b;b="[";for(var c=0;c<a.length;c+=1)0<c&&(b+=","),b+=a[c];return b+"]"}};return f},H=function(){var a=0,f=0,b=0,c="",h={},d=function(a){if(!(0>a)){if(26>a)return 65+a;if(52>a)return 97+(a-26);if(62>a)return 48+(a-52);if(62==a)return 43;if(63==a)return 47}throw Error("n:"+a);};h.writeByte=function(e){a=a<<8|e&255;f+=8;for(b+=1;6<=f;)c+=String.fromCharCode(d(a>>>f-6&63)),f-=6};h.flush=function(){0<f&&
(c+=String.fromCharCode(d(a<<6-f&63)),f=a=0);if(0!=b%3)for(var e=3-b%3,k=0;k<e;k+=1)c+="="};h.toString=function(){return c};return h},J=function(a){var f=0,b=0,c=0,h=function(a){if(65<=a&&90>=a)return a-65;if(97<=a&&122>=a)return a-97+26;if(48<=a&&57>=a)return a-48+52;if(43==a)return 62;if(47==a)return 63;throw Error("c:"+a);};return{read:function(){for(;8>c;){if(f>=a.length){if(0==c)return-1;throw Error("unexpected end of file./"+c);}var d=a.charAt(f);f+=1;if("="==d)return c=0,-1;d.match(/^\s$/)||
(b=b<<6|h(d.charCodeAt(0)),c+=6)}d=b>>>c-8&255;c-=8;return d}}},l=function(a,f){var b=Array(a*f),c=function(a){var b=0,c=0;return{write:function(f,g){if(0!=f>>>g)throw Error("length over");for(;8<=b+g;)a.writeByte(255&(f<<b|c)),g-=8-b,f>>>=8-b,b=c=0;c|=f<<b;b+=g},flush:function(){0<b&&a.writeByte(c)}}},h=function(){var a={},b=0,c={add:function(f){if(c.contains(f))throw Error("dup key:"+f);a[f]=b;b+=1},size:function(){return b},indexOf:function(b){return a[b]},contains:function(b){return"undefined"!=
typeof a[b]}};return c};return{setPixel:function(d,c,f){b[c*a+d]=f},write:function(d){d.writeString("GIF87a");d.writeShort(a);d.writeShort(f);d.writeByte(128);d.writeByte(0);d.writeByte(0);d.writeByte(0);d.writeByte(0);d.writeByte(0);d.writeByte(255);d.writeByte(255);d.writeByte(255);d.writeString(",");d.writeShort(0);d.writeShort(0);d.writeShort(a);d.writeShort(f);d.writeByte(0);var e;e=3;for(var k=h(),l=0;4>l;l+=1)k.add(String.fromCharCode(l));k.add(String.fromCharCode(4));k.add(String.fromCharCode(5));
var l=E(),p=c(l);p.write(4,e);for(var u=0,v=String.fromCharCode(b[u]),u=u+1;u<b.length;){var q=String.fromCharCode(b[u]),u=u+1;k.contains(v+q)?v+=q:(p.write(k.indexOf(v),e),4095>k.size()&&(k.size()==1<<e&&(e+=1),k.add(v+q)),v=q)}p.write(k.indexOf(v),e);p.write(5,e);p.flush();e=l.toByteArray();d.writeByte(2);for(k=0;255<e.length-k;)d.writeByte(255),d.writeBytes(e,k,255),k+=255;d.writeByte(e.length-k);d.writeBytes(e,k,e.length-k);d.writeByte(0);d.writeString(";")}}},a=function(a,f,b,c){for(var h=l(a,
f),d=0;d<f;d+=1)for(var e=0;e<a;e+=1)h.setPixel(e,d,b(e,d));b=E();h.write(b);h=H();b=b.toByteArray();for(d=0;d<b.length;d+=1)h.writeByte(b[d]);h.flush();b='<img src="';b+="data:image/gif;base64,";b+=h;b+='"';b+=' width="';b+=a;b+='"';b+=' height="';b+=f;b+='"';c&&(b+=' alt="',b+=c,b+='"');return b+="/>"};return C}();(function(w){"function"===typeof define&&define.amd?define([],w):"object"===typeof exports&&(module.exports=w())})(function(){return B});!function(w){w.stringToBytes=function(w){for(var u=
[],y=0;y<w.length;y++){var p=w.charCodeAt(y);128>p?u.push(p):2048>p?u.push(192|p>>6,128|p&63):55296>p||57344<=p?u.push(224|p>>12,128|p>>6&63,128|p&63):(y++,p=65536+((p&1023)<<10|w.charCodeAt(y)&1023),u.push(240|p>>18,128|p>>12&63,128|p>>6&63,128|p&63))}return u}}(B);return B}());