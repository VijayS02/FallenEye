function setCookie(email,token,name,guildID,fame,rank) {
  var d = new Date();
  d.setTime(d.getTime() + (1*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  var path = "/";
  document.cookie =  "email=" + email + ";" + expires + ";path="+path;
  document.cookie =  "token="+token+";" + expires + ";path="+path;
  document.cookie =  "name="+name+";" + expires + ";path="+path;
  document.cookie =  "guildID="+guildID+";" + expires + ";path="+path;
  document.cookie =  "fame="+fame+";" + expires + ";path="+path;
  document.cookie =  "rank="+rank+";" + expires + ";path="+path;

}

//console.log("Called.");
var id =0;
var loggedIn = false;
var email = "";
var token = "";
var curPath = "";
function getPath(path){
  curPath = path;
  //console.log(path);
}

function getHTML ( url, callback ,onFinish) {
  // Feature detection
  if ( !window.XMLHttpRequest ) return;

  // Create new request
  var xhr = new XMLHttpRequest();

  // Setup callback
  xhr.onload = function() {
    if ( callback && typeof( callback ) === 'function' ) {
      if (xhr.readyState == 4){
        callback( this.responseText ,onFinish);
      }
      //console.log("Loaded")
    }
  }

  // Get the HTML
  xhr.open( 'GET', url );
  xhr.responseType = 'text';
  xhr.send();
  return;
}

function updateCookie(name,val,exdays){
    var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  var path = "/";
   document.cookie =  name+"="+val+";" + expires + ";path="+path+";";
}

function logout(){
  var path = "/";
  //console.log(" logout Called.");
  var expires = "expires= Thu, 01 Jan 1970 00:00:00 GMT"
  document.cookie =  "email= ;" + expires + "; path="+path+";";
  document.cookie =  "token= ;" + expires + ";path="+path+";";
  document.cookie =  "name= ;" + expires + ";path="+path+";";
  document.cookie =  "guildID= ;" + expires + ";path="+path+";";
  document.cookie =  "fame= ;" + expires + ";path="+path+";";
  document.cookie =  "rank= ;" + expires + ";path="+path+";";
  //alert(document.cookie);
  window.location.href = "/index.php";

}
if(getCookie("mode")== null){
  var d = new Date();
d.setTime(d.getTime() + (30*24*60*60*1000));
var expires = "expires="+ d.toUTCString();
document.cookie = "mode=0;" + expires + ";path=/";
}
function getCookie(name){

  //console.log(" getCookie Called.");
  var ca =  decodeURIComponent(document.cookie).split(';');
  for(var i=0; i<ca.length; i++) {
    var c = ca[i].trim();
    if (c.indexOf(name+"=") == 0) {
            return c.substring((name+"=").length, c.length); 
    }

  }
  return  null;
}

function loadLoginDiv(){
  //console.log("Loading login section.");
  try{
       if(loggedIn){

        var navDiv = document.getElementsByClassName("navLogin")[0];
        navDiv.style.textAlign = "center";
        navDiv.innerHTML ="<p2 style='margin-top:4px;float:left;width:50%;'>" +getCookie("name") +"<br>Fame: "+getCookie("fame") + "</p2><a style='float:left' class='nvLgnBtn' href="+curPath+"/~logout.php"+">LOGOUT</a>";
  }
  
    //console.log(loggedIn);
  }catch(Excp){}
}


function miniloaderOn(){
  $("#loader" ).ready(function(){
    //console.log("ok");
    $( "#loader" ).css('display', 'block');
});
}

function miniloaderOff(){
  $("#loader" ).ready(function(){
    //console.log("ok");
    $( "#loader" ).css('display', 'none');
});
}

function loaderOn(){
  $("#loader" ).ready(function(){
    //console.log("ok");
    $('.mainWrapper').css("filter","blur(5px)");
    $('#page-mask').css("display","block");
    $( "#loader" ).css('display', 'block');
});


  
}


function loaderOff(){
  $("#loader" ).ready(function(){
    //console.log("ok");
    $( "#loader" ).css('display', 'none');
    $('.mainWrapper').css("filter","blur(0px)");
    $('#page-mask').css("display","none");
});
}
function main(){

  //console.log(" Main Called.");
  //console.log(document.cookie);
  var ca =  decodeURIComponent(document.cookie).split(';');
  loaderOn();
  var email ="";
  var token = "";
  var name = "";
  for(var i=0; i<ca.length; i++) {
    var c = ca[i].trim();
    if (c.indexOf("email=") == 0) {
            email =  c.substring("email=".length, c.length); 
    }
    else if (c.indexOf("token=") == 0) {
            token =  c.substring("token=".length, c.length); 
    }
    else if (c.indexOf("name=") == 0) {
            name =  c.substring("name=".length, c.length); 
    }
    
  }
  if(email == ""){
    console.log("Empty Email. Not logging in.");
    try{
          if(reqLogin){

          tmp = [];
          var result = "";
          var items = location.search.substr(1).split("&");
          for (var index = 0; index < items.length; index++) {
              tmp = items[index].split("=");
              if (tmp[0] === "item") result = decodeURIComponent(tmp[1]);
          }
          if(result == ""){

            window.location.href = "\\~login.php";
            
          }
          else{
            
            if(window.location.pathname.indexOf("buy") !== -1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=buy";
            }else if(window.location.pathname.indexOf("sell") !== -1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=sell";
            }else if(window.location.pathname.indexOf("market") !== -1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=market";
            }
          }
        }
        }catch(excp){
          //console.log("Login not required.");
          loaderOff();
         }
  }


  //console.log("https://ae.rotf.io/guild/listMembers?guid="+encodeURI(email+"&token="+token));
  //Check if users token and email will work
  getHTML("https://ae.rotf.io/guild/listMembers?guid="+encodeURI(email+"&token="+token), function (responsestring) {
    var parser = new DOMParser(); 
    
    
    response = parser.parseFromString(responsestring,"application/xml")
      //console.log("Data recieved.");
      if(response.documentElement.innerHTML == "Bad Login" || response.documentElement.innerHTML == "Login token expired") {

        console.log("Login Failed.");
          var path = "/";
          //console.log(" logout Called.");
          var expires = "expires= Thu, 01 Jan 1970 00:00:00 GMT"
          document.cookie =  "email= ;" + expires + "; path="+path+";";
          document.cookie =  "token= ;" + expires + ";path="+path+";";
          document.cookie =  "name= ;" + expires + ";path="+path+";";
          document.cookie =  "guildID= ;" + expires + ";path="+path+";";
          document.cookie =  "fame= ;" + expires + ";path="+path+";";
          document.cookie =  "rank= ;" + expires + ";path="+path+";";
        //console.log("https://ae.rotf.io/guild/listMembers?guid="+encodeURI(email+"&token="+token));
        //console.log(reqLogin);
        try{
         if(reqLogin){
            tmp = [];
            var result = "";
          var items = location.search.substr(1).split("&");
          for (var index = 0; index < items.length; index++) {
              tmp = items[index].split("=");
              if (tmp[0] === "item") result = decodeURIComponent(tmp[1]);
          }
          if(result != ""){
            if(window.location.pathname.indexOf("buy")!==-1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=buy";
            }else if(window.location.pathname.indexOf("sell")!==-1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=sell";
            }else if(window.location.pathname.indexOf("market")!==-1){
              window.location.href = "\\~login.php?item=" + encodeURI(result) +"&loc=market";
            }
          }
          else{
            console.log("Redirecting.");
            window.location.href = "\\~login.php";}
          }
        }catch(excp){
          //console.log(excp);
          console.log("Login not required.");
                  }
        loggedIn = false;
        
      } 
      else{
        loggedIn = true;
        try{
          if(loginPage){
            window.location.href = "\\index.php";
          }
        }catch(excp){
          //console.log("Not login page.");
                  }

        //console.log("Logged in.");
      }
      loadLoginDiv();
      loaderOff();
  });
 

     
}





function loginuser() {
  //ADD 2FA QUERY (Option box)
  //console.log(" loginuser Called.");
  loaderOn();
  //start loading animation
  var email = document.getElementById("usrnm").value;
  var psw = document.getElementById("pswd").value;
  var twoFa = document.getElementById("2fa").value.replace(" ","");

  email = encodeURI(email.trim());
  pass = encodeURI(psw.trim());
  var parser = new DOMParser();
  //console.log("Sending data.");
  getHTML("https://ae.rotf.io/account/verify?guid="+email+"&gameClientVersion=X3.4&cacheBust=522542&password="+pass+"&2fa="+twoFa, function (responsestring) {
      //console.log('http://192.223.31.195/account/verify?ignore=3548773&guid='+email.value+'&gameClientVersion=X2.2&cacheBust=522542&password='+psw.value)
      response = parser.parseFromString(responsestring,"application/xml")
      console.log("Data recieved.");
      if(response.documentElement.innerHTML == "Bad Login" ) {
        if(logintries == 0){
        var loginbox = document.getElementById("loginBox");
        inhtm = loginbox.innerHTML;
        var para = document.createElement("P"); 
        para.className = "shake"
        para.id = "alertText";
        para.style.marginTop = "12vh";
        para.style.marginBottom = 0;
        para.style.gridArea = "title";
        para.innerText = "Incorrect Login.";
        para.style.color = "red";
        document.getElementById('cont1').insertBefore(para,null);
        logintries = logintries + 1;
      }else{
        var para = document.getElementById("alertText");
        para.className = "temp";
        para.innerText = "Incorrect Login.";
        setTimeout(function() {
            para.className = "shake";
          }, 50);
      }
      }else if(response.documentElement.innerHTML.indexOf( "Rate limit exceeded") != -1){
        if(document.getElementById("alertText")!= null){
          var para = document.getElementById("alertText");
          para.className = "temp";
          para.innerText = "Rate Limit Exceeded. Please wait.";

          setTimeout(function() {
            para.className = "shake";
          }, 50);
          
        }else{
        var loginbox = document.getElementById("loginBox");
        inhtm = loginbox.innerHTML;
        var para = document.createElement("P"); 
        para.id == "alertText";
        para.className = "shake"
        para.style.gridArea = "title";
        para.innerText = "Rate Limit Exceeded.";
        para.style.color = "red";
        para.style.marginTop = "12vh";
        para.style.marginBottom = 0;
        document.getElementById('cont1').insertBefore(para,null);
      }
    }
      else if(response.documentElement.innerHTML.indexOf( "Bad 2fa pin") != -1){
        if(document.getElementById("alertText")!= null){
          var para = document.getElementById("alertText");
          para.className = "temp";
          para.innerText = "Incorrect 2fa pin.";

          setTimeout(function() {
            para.className = "shake";
          }, 50);
          
        }else{
        var loginbox = document.getElementById("loginBox");
        inhtm = loginbox.innerHTML;
        var para = document.createElement("P"); 
        para.id == "alertText";
        para.className = "shake"
        para.style.gridArea = "title";
        para.innerText = "Incorrect 2fa pin.";
        para.style.color = "red";
        para.style.marginTop = "12vh";
        para.style.marginBottom = 0;
        document.getElementById('cont1').insertBefore(para,null);
      }


      } else{
        var el = document.createElement('html'); 
        el.innerHTML = response.documentElement.innerHTML;
        //console.log(el.innerHTML);
        username = el.getElementsByTagName('name')[0].innerText;
        token = el.getElementsByTagName('token')[0].innerText;
        guildID = el.getElementsByTagName('guild')[0].getAttribute("id");
        fame = el.getElementsByTagName('fame')[0].innerText;
        //console.log(fame);
        usermail = email;
        userrank = el.getElementsByTagName('rank')[0].innerText;
        setCookie(email,token,username,guildID,fame,userrank);
        //console.log("done.");
            var result = null,
        tmp = [];
        var redir= null;
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === "item") result = decodeURIComponent(tmp[1]);
             if (tmp[0] === "loc") redir = decodeURIComponent(tmp[1]);
        }
        if(result != null && redir != null){
          window.location.href = "\\Trading\\~"+redir+".php?item=" + encodeURI(result);
        }
        else{window.location.href = "\\index.php";
      }
      }
      
      loaderOff();
  });  

}
resData = [];
function searchMarket(item,imgLoc){
  loaderOn();
  //console.log(" searchMarket Called.");
  //console.log("Sending data.");
  var parser = new DOMParser();
  //console.log("https://ae.rotf.io/auctionHouse/search?search="+encodeURI(item)+"&token="+getCookie("token")+"&guid="+getCookie("email"));
  getHTML("https://ae.rotf.io/auctionHouse/search?search="+encodeURI(item)+"&token="+getCookie("token")+"&guid="+getCookie("email"),
  function (responsestring) {
      //console.log('http://192.223.31.195/account/verify?ignore=3548773&guid='+email.value+'&gameClientVersion=X2.2&cacheBust=522542&password='+psw.value)
      response = parser.parseFromString(responsestring,"application/xml");
      doc = response.documentElement;
      //console.log(doc);

      results = doc.getElementsByTagName("Result");
      var total = 0;
      store = document.getElementById("tradCont");
      //console.log(results);
      donator = false;
      rank = parseInt(getCookie("rank"));
       if(rank >= 4 && rank < 100) {
          donator = true;
        } 
      for(var i =0;i<results.length;i++){
          var cur = results[i];
          //console.log(cur);
          var  accid = cur.getElementsByTagName("AccId")[0].innerHTML;
          var saleid = cur.getElementsByTagName("SaleId")[0].innerHTML;
          var  seller = cur.getElementsByTagName("Seller")[0].innerHTML;
          var  price = cur.getElementsByTagName("Price")[0].innerHTML;
          var  type = cur.getElementsByTagName("Type")[0].innerHTML;
          var  time = cur.getElementsByTagName("Time")[0].innerHTML;
          var  hours = cur.getElementsByTagName("Hours")[0].innerHTML;
          resData.push([accid,time,price,type,saleid]);
          total = total + parseInt(price);
          var div = document.createElement("div");
          div.className = "srchRes";
          //console.log(div);
          if(donator ){
            div.innerHTML = '<img src="'+imgLoc+'" style="margin-left:45%;margin-top:1em;width:2em;height:2em;" class="srchResImg"><p1> '+seller+'</p1><p1>'+price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</p1><p1>'+hours+' Hours</p1><button  class="btnBuyDisabled">Disabled</button>';
          }else if(price > parseInt(getCookie("fame"))){
            div.innerHTML = '<img src="'+imgLoc+'" style="margin-left:45%;margin-top:1em;width:2em;height:2em;" class="srchResImg"><p1> '+seller+'</p1><p1>'+price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</p1><p1>'+hours+' Hours</p1><button class="btnBuyDisabled">Not enough Fame</button>';
          }else{
          div.innerHTML = '<img src="'+imgLoc+'" style="margin-left:45%;margin-top:1em;width:2em;height:2em;" class="srchResImg"><p1> '+seller+'</p1><p1>'+price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</p1><p1>'+hours+' Hours</p1><button id="'+i+'" class="btnBuy">Buy</button>';
          }
         // console.log(store);
          store.appendChild(div);
      }
      if(total == 0){
        var h1 = document.createElement("h1");
        h1.textContent = "No sales for this item.";
        if (responsestring.indexOf( "Can't find the item in XML data.") != -1) {
            h1.textContent = "No such item.";
       }
        store.appendChild(h1);
      }
      document.getElementById("avgFame").innerHTML = "Average fame cost: <b>" + (Math.round(total/results.length)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +"</b> <img src=\"fame.png\">";
      loaderOff();
    });
}

function itemBought(id){
  $(".navLogin").addClass("shake");
  setTimeout(function(){
                $(".navLogin").removeClass("shake");
            }, 1*1000);
  $("#"+id).addClass("btnBought");
  $("#"+id).css("background-color","green");
  $("#"+id).removeClass("btnBuy");
  $("#"+id).text("BOUGHT!") ;
}

function itemFailed(id){
  $("#"+id).addClass("shake");
  $("#"+id).css("background-color","red");
  $("#"+id).text("FAILED!") ;
  $("#"+id).addClass("btnBought");
  $("#"+id).removeClass("btnBuy");
  alert("Purchase failed. - Try refreshing or logging out then logging in again. ");
}


$('#themeStyle').ready(function(){
  console.log(getCookie("mode"));
    if(getCookie("mode") == "1"){
      $("#styleChkbx").ready(function(){
        $("#styleChkbx").attr('checked', true);

      });
    }



});
$(document).ready(function () {

    $(document).on('click',".styleSwitch",function () { 
      $(document).on('click',"#styleChkbx",function(){
         if($('#themeStyle').attr('href').indexOf("styleDark.css")==-1){
            var href = $('#themeStyle').attr('href').replace("style.css","styleDark.css");
            $('#themeStyle').attr('href',href);
            updateCookie("mode","1",30);
         }else{
          var href = $('#themeStyle').attr('href').replace("styleDark.css","style.css");
            $('#themeStyle').attr('href',href);
            updateCookie("mode","0",30);
         }
         console.log(getCookie("mode"));
         });

    });


  });

$(document).ready(function () {
    $(document).on('click',".btnBuy",function () {  

         if(this.textContent=="Buy"){
            id = this.id;
            this.textContent = "Confirm?";
            var btn = $(this);
            btn.prop('disabled', true);
            loaderOn();
            setTimeout(function(){
                loaderOff();
                btn.prop('disabled', false);
            }, 1*1000);//1 sec timeout before confirm

         }else{
          loaderOn();
           var accid = resData[this.id][0];
           var time = resData[this.id][1];
           var price = resData[this.id][2];
           var type = resData[this.id][3];
           var saleid = resData[this.id][4];
           var parser = new DOMParser();
           id = this.id;
           getHTML("https://ae.rotf.io/auctionHouse/buy?g="+getCookie("email")+"&id="+saleid+"&time="+time+"&token="+getCookie("token")+"&type="+type+"&guid="+getCookie("email")+"&price="+price+"&accId="+accid, function (responsestring) {
            updateCookie("fame",(parseInt(getCookie("fame"))-price).toString(),1);
            if(responsestring == "Success"){
              itemBought(id);
            }else{
              console.log(responsestring);
              itemFailed(id);
            }
            loadLoginDiv();
            loaderOff();
        });

         }
        
          
    });
});

function searchTrades(){
  //console.log(" searchTrades Called.");
  searchbar = document.getElementById('tradeSearchBar');
  searchVal = searchbar.value.toLowerCase();
  miniloaderOn();

  //console.log(searchVal);
  items = document.getElementsByClassName('item');
  //console.log(items);
  for(var i = 0;i<items.length;i++){
    cur = items[i];
    if(cur.id.toLowerCase().indexOf(searchVal) == -1){
      cur.style.display = "none";
    }else{
      cur.style.display = "grid";
    }
  }
  miniloaderOff();
}

function itmSelSearchItems(){
  searchbar = document.getElementById('itemSelectorSearch');
  searchVal = searchbar.value.toLowerCase();
  miniloaderOn();

  //console.log(searchVal);
  items = document.getElementsByClassName('itemSelectorItem');
  //console.log(items);
  for(var i = 0;i<items.length;i++){
    cur = items[i];
    if(cur.id.toLowerCase().indexOf(searchVal) == -1){
      cur.style.display = "none";
    }else{
      cur.style.display = "grid";
    }
  }
  items = document.getElementsByClassName('itemSelectorItemHidden');
  //console.log(items);
  for(var i = 0;i<items.length;i++){
    cur = items[i];
    if(cur.id.toLowerCase().indexOf(searchVal) == -1){
      cur.style.display = "none";
    }else{
      cur.style.display = "grid";
    }
  }
  miniloaderOff();


}
main();

var selector = "jimbo";
var buy = [];
var buyId = [];
var sellId = [];
var sell = [];
$(document).on('click',".itemSelectorBtnClk",function () {

resetImgs();
var modal = document.getElementById("itemSelector");
modal.style.display = "block";
selector = $(this).parent().attr('id');
var hidden = [];
 if(selector.indexOf("buy") === 0 || selector.indexOf("sel")===0){
    if(selector.substring(0,3) == "buy"){
       sel = selector.substring(3,selector.length);
       if(buyId.indexOf(sel) != -1){
            hidden = JSON.parse(JSON.stringify(buy));
            hidden[buyId.indexOf(sel)] = "null";
       }else{
        hidden = buy;
       }
    }else if(selector.substring(0,3) == "sel"){
       sel = selector.substring(3,selector.length);
       if(sellId.indexOf(sel) != -1){
            hidden =  JSON.parse(JSON.stringify(sell));
            hidden[sellId.indexOf(sel)] = "null";
       }else{
        hidden = sell;
       }
    }
    var arr = document.getElementsByClassName("itemSelectorItem");
    
    for(var i =0;i<arr.length;i++){

      for(var ix =0;ix<hidden.length;ix++){
        if(hidden[ix] == arr[i].id){
          //console.log(hidden);
          //console.log(arr[i].id);
          arr[i].className="itemSelectorItemHidden";
        }
      }
        
    }

  }

});


 function resetImgs(){
  miniloaderOn();
    var arr = document.getElementsByClassName("itemSelectorItemHidden");
    for(var i =0;i<arr.length;i++){
          arr[i].className="itemSelectorItem";
    }
  miniloaderOff();
 }
$(document).on('click',".itemSelectorBtnClose",function(event){
  resetImgs();
  selector = $(this).parent().attr("id");
  if(selector.indexOf("buy") === 0 || selector.indexOf("sel")===0){
    if(selector.substring(0,3) == "buy"){
      sel = selector.substring(3,selector.length);
      if(buyId.indexOf(sel) != -1){
        buy[buyId.indexOf(sel)] = "null";
        buyId[buyId.indexOf(sel)] = "null";
      }
    }
    if(selector.substring(0,3) == "sel"){
      sel = selector.substring(3,selector.length);
      if(sellId.indexOf(sel) != -1){
        sell[sellId.indexOf(sel)] = "null";
        sellId[sellId.indexOf(sel)] = "null";
      }
    }
  }
  $(this).parent().remove();
  resetImgs();
});



$(document).on('click',".itemSelectorItem",function(event){
  
  //console.log("#"+selector+" select");
  $(".itemSelectorSearch").val("");
  $("#"+selector+" .itemSelectorHidden").val(this.id);
  $("#"+selector + " .itemSelectorBtnTxt").remove();
  $("#"+selector+" .itemSelectorBtnImg").attr("src",$(this).children("img").attr("src"));
  $("#"+selector+" .itemSelectorBtnImg").css("display","block");
  if(selector.indexOf("buy") === 0 || selector.indexOf("sel")===0){
    if(selector.substring(0,3) == "buy"){
      sel = selector.substring(3,selector.length);
      if(buyId.indexOf(sel) != -1){
        buy[buyId.indexOf(sel)] = this.id;
      }else{
      buyId.push(sel);
      buy.push(this.id);
      }
    }else if(selector.substring(0,3) == "sel"){
      sel = selector.substring(3,selector.length);
      if(sellId.indexOf(sel) != -1){
        sell[sellId.indexOf(sel)] = this.id;
      }else{
      sellId.push(sel);
      sell.push(this.id);
      }
    }
  }
  document.getElementsByClassName("itemSelector")[0].style.display = "none";
  resetImgs();
});

$(document).on('click',".itemSelector",function(event) {
    if(event.target == document.getElementsByClassName("itemSelector")[0]){
      this.style.display = "none";
      resetImgs();
    }

});
var buys = 0;
var sells = 0;
$(document).on('click',".itemSelectorClear",function(event) {
  document.getElementsByClassName("itemSelector")[0].style.display = "none";
  $("#"+selector+" .itemSelectorHidden").val("");
  $("#"+selector).append('<div class="itemSelectorBtnTxt">-</div>');
  $("#"+selector+" .itemSelectorBtnImg").css("display","none");

});
$(document).on('click',".itemSelectorRefresh",function(event) {
  resetImgs();
  $('.itemSelectorSearch').val("");
});


$(document).on('click',".addItemSelector",function(event) {
  resetImgs();
  rawData = $("#optionStore").html();
  var html ="";
  if(this.id == "buy"){
   html = '<div class="itemSelectorBtn" id="buy'+buys.toString()+'" ><div class="itemSelectorBtnClk"><img class="itemSelectorBtnImg" src=""><div class="itemSelectorBtnTxt">+</div></div><select class="itemSelectorHidden"  name="buy"><option value="NONE---"></option> '+rawData+'</select><input class="itemSelectorBtnQty" title="Quantity" name="buyQuantity" type="number" value="1" min="1"><span title="Remove item" class="itemSelectorBtnClose">&times;</span></div>';
   buys = buys+1;
  }else{
    html = '<div class="itemSelectorBtn" id="sel'+sells.toString()+'" ><div class="itemSelectorBtnClk"><img class="itemSelectorBtnImg" src=""><div class="itemSelectorBtnTxt">+</div></div><select class="itemSelectorHidden"  name="sell"><option value="NONE---"></option> '+rawData+'</select><input class="itemSelectorBtnQty" title="Quantity" name="sellQuantity" type="number" value="1" min="1"><span title="Remove item" class="itemSelectorBtnClose">&times;</span></div>';
    sells = sells +1;
  }
  $(this).parent().append(html);

});

$(document).on('click',".itemSelectorClose",function(event) {
      document.getElementsByClassName("itemSelector")[0].style.display = "none";
      resetImgs();
    


});
function errorText(text){
  if( $("#addTradForm #addErr").length){
    $("#addTradForm #addErr").removeClass("shake");
    $("#addTradForm #addErr").text(text);
     $("#addTradForm #addErr").addClass("shake");
  }else{
     $("#addTradForm").prepend("<p id=\"addErr\" style='color:red;' class='shake'>"+text+"</p>");
  }
}
$(document).on('click','#addTradSubmit',function(){
  if(buys == 0){
    errorText("Please add a item to be bought.");
    return; 
  }
  if(sells ==0){
   errorText("Please add a item to be sold.");
    return; 
  }
  var failed = false;
  try{
    for(var i =0;i<buys;i++){
    if($("#buy"+i.toString()+" .itemSelectorHidden").val() == "NONE---"){
     errorText("You have not selected an item.");
      $("#buy"+i.toString()).addClass("shake");
      failed = true;
    }
  }
  if(failed){return;}
  }catch(Except){
   errorText("Please add a item to be bought.");
    return; 
  }
  try{
    for(var i =0;i<sells;i++){
    if($("#sel"+i.toString()+" .itemSelectorHidden").val() == "NONE---"){
      errorText("You have not selected an item.");
      $("#sel"+i.toString()).addClass("shake");
      failed = true;
    }
  }
  if(failed){return;}
  }catch(Except){
    errorText("Please add a item to be sold.");
    return; 
  }
  $("#addTrade").submit();

});

$("#addTrade #token").ready(function(){
  $("#addTrade #accountName").val(getCookie('name'));
  $("#addTrade #email").val(getCookie('email'));
  $("#addTrade #token").val(getCookie('token'));


});