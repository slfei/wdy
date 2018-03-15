$(function(){
    function GetRTime(){
        var EndTime= refundData['refund_info']['add_time'];
        var NowTime = new Date();
        var t =(EndTime*1000)+ 3*24*60*60*1000-NowTime.getTime();
        var d = 0;
        var h = 0;
        var m = 0;
        var s = 0;
        /*var d=Math.floor(t/1000/60/60/24);
        t-=d*(1000*60*60*24);
        var h=Math.floor(t/1000/60/60);
        t-=h*60*60*1000;
        var m=Math.floor(t/1000/60);
        t-=m*60*1000;
        var s=Math.floor(t/1000);*/
        if(t>0){
            var d=Math.floor(t/1000/60/60/24);
            var h=Math.floor(t/1000/60/60%24);
            var m=Math.floor(t/1000/60%60);
            var s=Math.floor(t/1000%60);
        }       
 
        $("#dd").text(setDouble(d));
        $("#hh").text(setDouble(h));
        $("#mm").text(setDouble(m));
        $("#ss").text(setDouble(s));
    }
    function setDouble(num){
        if(num < 10){
            return '0'+num;
        }
        return num;
    };
    console.log('a');
    if(refundData['refund_result'].status ===1){
        setInterval(GetRTime,1000);
    }


})
