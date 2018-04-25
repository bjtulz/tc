function setToken(userid,token){ 
         var cookieString="userid="+escape(userid)+";token="+escape(token); 
         var date=new Date(); 
         date.setTime(date.getTime+expireHours*3600*1000); 
         cookieString=cookieString+"; expire="+date.toGMTString(); 
         document.cookie=cookieString;
}

function getCookie(name){ 
         var strCookie=document.cookie; 
         var arrCookie=strCookie.split("; "); 
         for(var i=0;i<arrCookie.length;i++){ 
               var arr=arrCookie[i].split("="); 
               if(arr[0]==name)return arr[1]; 
         } 
         return ""; 
}

