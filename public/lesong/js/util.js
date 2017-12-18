var util = {
    removeStore: function(key){
        localStorage.removeItem(key);
    },
    getStore: function(key) {
        var val = localStorage.getItem(key) || "";
        return ( val.substr(0, 1) === "{" || val.substr(0, 1) === "[" ) ? JSON.parse(localStorage.getItem(key)) : val;
    },
    setStore: function(key, value) {
        var value = typeof(value) === 'object' ? JSON.stringify(value) : value;
        localStorage.setItem(key, value)
    },
    //存取sessionStorage
    getSession: function(key) {
        var val = sessionStorage.getItem(key) || "";
        return ( val.substr(0, 1) === "{" || val.substr(0, 1) === "[" ) ? JSON.parse(sessionStorage.getItem(key)) : val;
    },
    setSession: function(key, value) {
        var value = typeof(value) === 'object' ? JSON.stringify(value) : value;
        sessionStorage.setItem(key, value)
    },
    useDefaultImg: function() {
        $('img').bind('error', function() {
            this.remove();
            //this.src = defaultImg;
            //$(this).unbind('error');
        });
    },
    post: function(vue, options) {
        var self = this;
        return new Promise(function (resolve, reject) {
            self._ajax(vue, options, 'POST', resolve, reject);
        });
    },
    get: function(vue, options) {
        var self = this;
        return new Promise(function (resolve, reject) {
            self._ajax(vue, options, 'GET', resolve, reject);
        });
    },
    _ajax: function(vue, options, methodType, resolve, reject) {
        var self = this;
        self.beforeAjax(vue, options);
        options.data = options.data ? options.data : {};
        reject = reject || function() {};
        $.ajax({
            headers: {
                'Content-Type':'application/json',
            },
            url: Config.API_URL + options.api,
            type: methodType,
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            },
            data: methodType === 'POST' ? JSON.stringify(options.data) : options.data,
            success: function(response, status, xhr) {
                // if(response.errcode === 0 || response.errcode === 1) {

                // } else {
                //     reject(response, status);
                // }
                if(response.errcode === 11) {
                    Util.removeStore('userInfo');
                    location.reload()
                }
                resolve(self.filter(response));
            },
            error: function(response, status) {
                reject(response, status);
            },
            complete: function(response) {
                self.afterAjax(vue, options);
            }
        });
    },
    beforeAjax: function(vue, options) {

    },
    afterAjax: function(vue, options) {

    },
    filter: function(data) {
        return data;
    },
    dateFormat: function(time, fmt) { //author: meizz
        if(time == null || time == ""){
            return "";
        }
        else
        {
            var date = new Date(time);
            var o = {
                "M+" : date.getMonth()+1,                 //月份
                "d+" : date.getDate(),                    //日
                "h+" : date.getHours(),                   //小时
                "m+" : date.getMinutes(),                 //分
                "s+" : date.getSeconds(),                 //秒
                "q+" : Math.floor((date.getMonth()+3)/3), //季度
                "S"  : date.getMilliseconds()             //毫秒
            };
            if(/(y+)/.test(fmt))
                fmt = fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
            for(var k in o)
                if(new RegExp("("+ k +")").test(fmt))
                    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));

            return fmt;
        }
    },
    //小数点保留2位
    toDecimal: function (x) {
        var f = parseFloat(x);
        if (isNaN(f)) {
            return false;
        }
        var f = Math.round(x*100)/100;
        var s = f.toString();
        var rs = s.indexOf('.');
        if (rs < 0) {
            rs = s.length;
            s += '.';
        }
        while (s.length <= rs + 2) {
            s += '0';
        }
        return s;
    },
    //根据日期返回星期
    toWeek : function(date){
        var d = new  Date(date).getDay();
        var str = "";
        switch(d){
            case 1:
                return "星期一";
                break;
            case 2:
                return "星期二";
                break;
            case 3:
                return "星期三";
                break;
            case 4:
                return "星期四";
                break;
            case 5:
                return "星期五";
                break;
            case 6:
                return "星期六";
                break;
            case 7:
                return "星期日";
                break;
        }
    },
    //根据两点的坐标获取距离
    getGreatDistance: function(lat1,lng1,lat2,lng2){
        var EARTH_RADIUS = 6378137.0;    //单位M
        var PI = Math.PI;
        var f = ((lat1 + lat2)/2)*PI/180.0;
        var g =  ((lat1 - lat2)/2)*PI/180.0;
        var l = ((lng1 - lng2)/2)*PI/180.0;

        var sg = Math.sin(g);
        var sl = Math.sin(l);
        var sf = Math.sin(f);

        var s,c,w,r,d,h1,h2;
        var a = EARTH_RADIUS;
        var fl = 1/298.257;

        sg = sg*sg;
        sl = sl*sl;
        sf = sf*sf;

        s = sg*(1-sl) + (1-sf)*sl;
        c = (1-sg)*(1-sl) + sf*sl;

        w = Math.atan(Math.sqrt(s/c));
        r = Math.sqrt(s*c)/w;
        d = 2*w*a;
        h1 = (3*r -1)/2/c;
        h2 = (3*r +1)/2/s;

        return d*(1 + fl*(h1*sf*(1-sg) - h2*(1-sf)*sg));
    },
    //获取今天之后的六天时间列表
    getDatelist: function(){
        var self = this;
        var datelist = [];
        for(var i=0; i<7;i++){

            datelist.push(self.GetDateStr((-1)*i));
        }
        return datelist;
    },
    GetDateStr: function (AddDayCount)
    {
        var item = {};
        var dd = new Date();
        dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
        // console.log("getdatestr====",Date.parse(new Date(dd))/1000);
        var y = dd.getYear();
        var m = (dd.getMonth()+1)<10?"0"+(dd.getMonth()+1):(dd.getMonth()+1);//获取当前月份的日期，不足10补0
        var d = dd.getDate()<10?"0"+dd.getDate():dd.getDate(); //获取当前几号，不足10补0
        // return y+"-"+m+"-"+d;
        item.name = m+"月"+d+"日";
        item.val = Date.parse(new Date(dd))/1000;
        return item;
    },
    //根据时间戳，截取时间
    gettimelist: function(timestamp){
        var timelist = [];
        var self = this, enddate,
            // date = self.getformat(timestamp),
            todaydate = self.getformat(timestamp);

        var beginDate = todaydate.toString()+" 08:00:00";

        // console.log("==今天的日期是==",self.getformat(Date.parse( new Date())));
        //开始时间戳
        var startdate = Date.parse(new Date(beginDate))/1000;

        if (todaydate === self.getformat(Date.parse( new Date())/1000)) {
            //今天
            enddate = Date.parse( new Date())/1000;
        }else if (new Date(timestamp) < new Date()){
            enddate = todaydate.toString()+" 23:00:00";
            //结束时间戳
            enddate = Date.parse(new Date(enddate))/1000;
        }
        for(var i = 0 ;i<40; i++){
            var second = 1800;
            var endtime = startdate+(i+1)*second;
            if(endtime <= enddate){
                timelist.push({'startname':self.dateFormat((startdate+(i*second))*1000,"hh:mm") ,
                    'startval':startdate+(i*second) ,'endname': self.dateFormat((endtime)*1000,"hh:mm"), 'endval':endtime} );
            }else{
                timelist.push({'startname':self.dateFormat((startdate+(i*second))*1000,"hh:mm") ,'startval':startdate+(i*second) ,
                    'endname': self.dateFormat((enddate)*1000,"hh:mm"), 'endval': enddate} );
                return timelist;
            }
        }

    },
    // function add0(m){return m<10?'0'+m:m }
    getformat: function(timestamp)
    {
        var self = this;
        //shijianchuo是整数，否则要parseInt转换
        var time = new Date(parseInt(timestamp)*1000);//new Date(Date(parseInt(timestamp) * 1000));// Date(parseInt(timestamp) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        // console.log("===计算时间=",time);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        var h = time.getHours();
        var mm = time.getMinutes();
        var s = time.getSeconds();
        return y+'/'+m+'/'+d;//+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    },
    //判断是iOS
}