var jsonUrl = "http://163.44.172.216/data.json";
var time_state = 0; //タイムテーブルの何番目か
var start_time = 0; //開始時刻
var count_time = 0; //経過時間(秒)
var pbar; //プログレスバー
var ptxt;
var table_state = [];
var table_time = [];
var table_subTheme = [];
var user_name = [];
var user_prob = [];
var new_prob = [];
var deltaProb = []; //アニメーション用
var updateProbCount = 0; //アニメーション用
var updateProbSec = 10;
var user_colorList = ["#e74c3c","#e67e22", "#f1c40f", "#27ae60","#3498db", "#8e44ad"];
var table_stateLabel = ["DC", "休憩", "共有"]
var prevTime = 0;
var important_keywords = [];
var important_keywords_count = 0;
var keywords = [];
//stram
var boxWidth = 1000;  //幅
var posX = [0,0,0];
var speed = 3;  //テキストの流れる速さ
var index = 0; //文字配列のインデックス
var elem_keys = [];
var keyQueue;
google.load("visualization", "1", {packages:["corechart"]});

$(function(){
    getJSON();
    updateTime();
    if(time_state > 0){
        prevTime = getPrevTime();
    }
    initMoji();
    pbar = document.getElementById('prog');
    ptxt = document.getElementById('outp');
    upPrgrss();
    setUserList();
    drawChart();
    setInterval("upPrgrss()",200);
    setInterval("updateTime()", 1);
    setInterval("update()", 5000);
});

function update(){
    updateJSON();
    updateChart();
}

function getJSON() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if(req.readyState == 4 && req.status == 200){
            var json = JSON.parse(req.responseText);
            start_time = json.startTime;
            for(var i = 0; i < json.timeTable.length; i++){
                table_state[i] = json.timeTable[i].state;
                table_time[i] = json.timeTable[i].time;
                table_subTheme[i] = json.timeTable[i].subTheme;
            }
            for(var i = 0; i < json.users.length; i++){
                user_name[i] = json.users[i].name;
                user_prob[i] = json.users[i].prob;
            }
            important_keywords_count = 0;
            var impKey = document.getElementById("impKey");
            impKey.textContent = null;
            for(key in json.important_key){
                important_keywords[important_keywords_count] = key;
                var elem = document.createElement('li');
                elem.innerHTML = key;
                impKey.appendChild(elem);
                important_keywords_count++;
            }
            for(var i = 0; i < json.keywords.length; i++){
                keywords.push(json.keywords[i]);
            }
            $.ajax({
                type: "POST",
                url: "./php/del_key.php",
                data: '',
                success: function() {}
            });
            document.getElementById("groupName").innerHTML = json.groupName;
            document.getElementById("theme").innerHTML = json.theme;
            document.getElementById("subTheme").innerHTML = table_stateLabel[time_state] + "：" + table_subTheme[time_state];
        }
    };
    req.open("GET", jsonUrl, false);
    req.send(null);
}
function updateJSON(){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if(req.readyState == 4 && req.status == 200){
            var json = JSON.parse(req.responseText);
            for(var i = 0; i < json.users.length; i++){
                new_prob[i] = json.users[i].prob;
            }
            important_keywords_count = 0;
            var impKey = document.getElementById("impKey");
            impKey.textContent = null;
            for(key in json.important_key){
                important_keywords[important_keywords_count] = key;
                var elem = document.createElement('li');
                elem.innerHTML = key;
                impKey.appendChild(elem);
                important_keywords_count++;
            }
            for(var i = 0; i < json.keywords.length; i++){
                keywords.push(json.keywords[i]);
            }
            $.ajax({
                type: "POST",
                url: "./php/del_key.php",
                data: '',
                success: function() {}
            });
            document.getElementById("subTheme").innerHTML = table_stateLabel[time_state] + "：" + table_subTheme[time_state];
        }
    };
    req.open("GET", jsonUrl, false);
    req.send(null);
}
function updateTime() {//時間測定関数
    count_time = (Date.now()/1000 - start_time);//秒
}
function upPrgrss(){
    pbar.value = ((count_time - prevTime*60)/(table_time[time_state]*60))*100; //「++」で 1 ずつ足す
    ptxt.innerHTML = Math.round(pbar.value) + "%";
    if(pbar.value>=pbar.max){
        pbar.value=0;
        ptxt.innerHTML= "0%";
        prevTime = getPrevTime();
        time_state = getTimeState();
        updateSubTheme();
    }
}
function updateSubTheme(){
    document.getElementById("subTheme").innerHTML = table_stateLabel[time_state] + "：" + table_subTheme[time_state];
}
function setUserList(){
    for(var i = 0; i < user_name.length; i++){
        var list = document.createElement('li');
        var list_mark = document.createElement('div');
        list_mark.style.backgroundColor = user_colorList[i];
        list_mark.className = "userListMark";
        var list_span = document.createElement('span');
        list_span.innerHTML = user_name[i];
        list_span.className = "userListLi";
        list.appendChild(list_mark);
        list.appendChild(list_span);
        document.getElementById("userListUl").appendChild(list);
    }
}
function getTimeState(){
    var count = 0;
    var d = count_time;
    while(true){
        d -= table_time[count]*60;
        if(d >= 0){
            count += 1;
        } else {
            break;
        }
    }
    return count;
}
function getPrevTime(){
    var t = 0;
    for(var i = 0; i <= time_state; i++){
        t += table_time[i];
    }
    return t;
}

function drawChart() {
  var dataPlot = [];
  dataPlot[0] = ['name', 'prob'];
  for(var i = 0; i < user_name.length; i++){
    dataPlot[i+1] = [user_name[i], user_prob[i]];
  }
  var data = new google.visualization.arrayToDataTable(dataPlot);
  var options = { //オプションの指定
    colors : user_colorList, //色指定
    backgroundColor: "transparent",
    legend : 'none',
    tooltip : {trigger : 'none'}
  };
  var chart = new google.visualization.PieChart(document.getElementById('chartContainer')); //グラフを表示させる要素の指定
  chart.draw(data, options);
}
function initMoji(){
    for(var i = 0; i < 3; i++){
      elem_keys[i] = document.createElement('span');
      elem_keys[i].className = "moji";
      document.getElementById('msgBox').appendChild(elem_keys[i]);
      elem_keys[i].style.right =  "-" + elem_keys[i].offsetWidth + "px";
      posX[i] = elem_keys[i].offsetWidth*(-1);
    }
    posX[0] += 1;
    setInterval("scrMsg()",15);
}

function scrMsg(){
  for(var i = 0; i < 3; i++){
        if(i == 0){
            if(posX[2] > boxWidth/4 || posX[0] > -elem_keys[0].offsetWidth){
                posX[0] += speed;
            }
        } else if(i == 1) {
            if(posX[0] > boxWidth/4 || posX[1] > -elem_keys[1].offsetWidth){
                posX[1] += speed;
            }
        } else if(i == 2){
            if(posX[1] > boxWidth/4 || posX[2] > -elem_keys[2].offsetWidth){
                posX[2] += speed;
            }
        }
        elem_keys[i].style.right = posX[i];
        if(posX[i] > boxWidth){
            posX[i] = elem_keys[i].offsetWidth*(-1);
            if(keywords.length > 0){
                elem_keys[i].innerHTML = keywords.shift();
            } else {
                elem_keys[i].innerHTML = "";
            }
        }
    }
}

function updateChart(){
    for(var i = 0; i < user_prob.length; i++){
        deltaProb[i] = (new_prob[i] - user_prob[i])/(1000/updateProbSec);
    }
    updateProb();
}

function updateProb(){
    if(updateProbCount >= 1000/updateProbSec){
        updateProbCount = 0;
        return;
    } else {
        updateProbCount++;
        setTimeout("updateProb()", updateProbSec);
    }
    for(var i = 0; i < user_prob.length; i++){
        user_prob[i] += deltaProb[i];
    }
    drawChart();
}

