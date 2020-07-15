function startTime() {
    var today = new Date();
    var Y = today.getFullYear();
    var M = today.getMonth();
    var d = today.getDate();
    var D = today.getDay();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // var ms = today.getMilliseconds();
    // ms = Math.floor(ms / 10);
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    // ms = checkTime(ms);
    D = checkDay(D);
    M = checkMonth(M);
    document.getElementById('clockTopbar').innerHTML = D+', '+d+' '+M+' '+Y +' '+ h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 1000);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i}{
        return i;
    }  // add zero in front of numbers < 10
}
function checkDay(i){
    var day = '';
    if(i == 0){
        day = 'Sunday';
    }else if(i == 1){
        day = 'Monday';
    }else if(i == 2){
        day = 'Tuesday';
    }else if(i == 3){
        day = 'Wednesday';
    }else if(i == 4){
        day = 'Thursday';
    }else if(i == 5){
        day = 'Friday';
    }else if(i == 6){
        day = 'Saturday';
    }
    return day;
}
function checkMonth(i){
    var month = '';
    if (i == 0) {
        month = 'January';
    }else if (i == 1) {
        month = 'February';
    }else if (i == 2) {
        month = 'March';
    }else if (i == 3) {
        month = 'April';
    }else if (i == 4) {
        month = 'May';
    }else if (i == 5) {
        month = 'June';
    }else if (i == 6) {
        month = 'July';
    }else if (i == 7) {
        month = 'August';
    }else if (i == 8) {
        month = 'September';
    }else if (i == 9) {
        month = 'October';
    }else if (i == 10) {
        month = 'November';
    }else if (i == 11) {
        month = 'Desember';
    }
    return month;
}
