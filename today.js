
function dispDate(){

    // 一桁の数字を0埋め
    var fm = function(num) {
        num += "";
        if (num.length == 1) {
            num = "0" + num;
        }
        return num;     
    };

    var dt = new Date();
    var yea = dt.getFullYear();
    var mon = fm(dt.getMonth() + 1);
    var day = fm(dt.getDate());
    var week = dt.getDay();
    var hou = fm(dt.getHours());
    var min = fm(dt.getMinutes());
    var sec = fm(dt.getSeconds());

    var yobi= ["日","月","火","水","木","金","土"];

    console.log(week);

    document.getElementById("dat").value = yea + "/" + mon + "/" + day + "　" +yobi[week]+"曜日 "
                                            + hou + ":" + min + ":" + sec;
}
setInterval("dispDate()",1000);

