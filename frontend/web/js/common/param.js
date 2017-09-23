var json_province={
    //"全部省份" : "0",
    //ABCFGH
    "安徽":"10008","澳门":"10145",
    "北京":"10003",
    "重庆":"10028",
    "福建":"10024",
    "甘肃":"10023","贵州":"10026","广东":"10011","广西":"10012",
    "河北":"10016","河南":"10017","黑龙江":"10031","湖北":"10021","湖南":"10022","海南":"10019",
    //JLNQ
    "江苏":"10014","江西":"10015","吉林":"10004",
    "辽宁":"10027",
    "内蒙古":"10002","宁夏":"10007",
    "青海":"10030",
    //STXYZ
    "上海":"10000","山东":"10009","山西":"10010","陕西":"10029","四川":"10005",
    "天津":"10006",
    "新疆":"10013","西藏":"10025","香港":"10020",
    "云南":"10001","台湾":"10146",
    "浙江":"10018"
};
//各省控线 分页使用    固定页码取对应省份
var json_page_province={
    //"全部省份" : "0",
    //ABCFGH
    "1":"北京/上海",
    "2":"广东/广西",
    "3":"河北/河南",
    "4":"吉林/江西",
    "5":"湖北/湖南",
    "6":"内蒙古/黑龙江",
    "7":"四川/甘肃",
    "8":"山东/山西",
    "9":"北京/上海",
    "10":"北京/上海",
    "11":"北京/上海",
    "12":"北京/上海",
    "13":"北京/上海",
    "14":"北京/上海",
    "15":"北京/上海"
};
//批次
var json_batchType={
    "本科一批":"10036","本科二批":"10037","本科三批":"10038","一批":"10036","二批":"10037","三批":"10038","专科":"10148","提前":"10149"
    //,"专科批次":"10148"
};
//批次
var json_batchTypeShort={
    "一批":"10036","二批":"10037","三批":"10038","专科":"10148","提前":"10149"
    //,"专科批次":"10148"
};
var json_examieeType = {
    "文科":"10034","理科":"10035","综合":"10090","艺术类":"10091","体育类":"10093"
}

var json_years = {
    "2013":"","2012":"","2011":"","2010":"","2009":"","2008":"","2007":"","2006":"","2005":""
}

var json_schoolType = {
    "10039":	"综合类",
    "10040":	"理工类",
    "10041":	"农林类",
    "10042":	"医药类",
    "10043":	"师范类",
    "10044":	"语言类",
    "10045":	"财经类",
    "10046":	"政法类",
    "10047":	"体育类",
    "10048":	"艺术类",
    "10049":	"民族类",
    "10097":	"军事类",
    "10098":	"其它"

}

//控制线省份广告code
var json_codeKongzhi = {
    "贵州":"1152", "吉林":"1122", "青海":"1163", "重庆":"1150", "云南":"1153", "甘肃":"1162", "宁夏":"1164", "广东":"1144", "台湾":"1171",
    "澳门":"1182", "香港":"1181", "黑龙江":"1123", "内蒙古":"1115", "西藏":"1154", "新疆":"1165", "山东":"1137", "江西":"1136", "湖北":"1142",
    "山西":"1114", "辽宁":"1121", "江苏":"1132", "安徽":"1134", "四川":"1151", "天津":"1112", "上海":"1131", "北京":"1111", "浙江":"1133",
    "广西":"1145", "海南":"1146", "河南":"1141", "湖南":"1143", "陕西":"1161", "福建":"1135", "河北":"1113"
}

//生源地省份广告code
//var json_code = {
//		"贵州":"1452", "云南":"1453", "吉林":"1422", "青海":"1463", "重庆":"1450", "山东":"1437", "河北":"1413", "甘肃":"1462", "宁夏":"1464", "新疆":"1465", "西藏":"1454",
//		"内蒙古":"1415", "黑龙江":"1423", "香港":"1481", "澳门":"1482", "台湾":"1471", "江西":"1436", "湖北":"1442", "北京":"1411", "上海":"1431", "天津":"1412", "四川":"1451",
//		"安徽":"1434", "江苏":"1432", "浙江":"1433", "辽宁":"1421", "山西":"1414", "福建":"1435", "广西":"1445", "海南":"1446", "河南":"1441", "湖南":"1443", "陕西":"1461", "广东":"1444"
//}

//广告code
var json_code = {
    //所在地省份
    "北京":"0111", "上海":"0131", "天津":"0112", "四川":"0151", "安徽":"0134", "江苏":"0132", "浙江":"0133", "辽宁":"0121", "山西":"0114", "福建":"0135", "广东":"0144",
    "广西":"0145", "海南":"0146", "河南":"0141", "湖南":"0143", "陕西":"0161", "湖北":"0142", "江西":"0136", "河北":"0113", "山东":"0137", "香港":"0181", "澳门":"0182", "台湾":"0171",
    "重庆":"0150", "青海":"0163", "吉林":"0122", "云南":"0153", "贵州":"0152", "甘肃":"0162", "宁夏":"0164", "新疆":"0165", "西藏":"0154", "内蒙古":"0115", "黑龙江":"0123",
    //学历层次
    "普通本科":"0201", "独立学院":"0202", "高职高专":"0203", "中外合作办学":"0204", "民办高校":"0200", "远程教育学院":"0205", "HND项目":"0206", "成人教育":"0207","其它":"0208",
    //学校类别
    "综合":"0301", "理工":"0302", "农林":"0303", "医药":"0304", "师范":"0305", "语言":"0306", "财经":"0307", "政法":"0308", "体育":"0309", "艺术":"0310", "民族":"0311", "军事":"0312", "其它":"0313",
    //全部
    "全部":"9999",
    //专业类别
    "管理学类":"0521", "文学类":"0515", "理学类":"0517", "哲学类":"0511", "教育学类":"0514", "法学类":"0513", "经济学类":"0512", "农学类":"0519", "工学类":"0518", "医学类":"0520", "历史学类":"0516",
    //专业类别
    "交通运输类":"0612", "生化与药品类":"0613", "资源开发与测绘类":"0614", "材料与能源类":"0615", "土建类":"0616", "水利类":"0617", "制造类":"0618", "电子信息类":"0619", "环保、气象与安全类":"0620",
    "财经类":"0607", "医药卫生类":"0623", "旅游类":"0624", "公共事业类":"0625", "文化教育类":"0626", "艺术设计传媒类":"0627", "公安类":"0628", "轻纺食品类":"0621", "法律类":"0629", "农林牧渔类":"0611",
    //专业层次
    "本科":"0710", "专科":"0720",
    //批次
    "一批":"0804", "二批":"0805", "三批":"0806",
    //考生类别
    "文科":"0901", "理科":"0902",
    //特殊属性
    "教育部直属":"1004", "211工程":"1002", "985工程":"1001", "中央部委":"1005", "自主招生试点":"1006"

}


//分页点击
if(oldurl.indexOf('schoolhtm')==-1){
    $('body').on('click','.lin-searchtabl-footer ul li',function(){
        var cltxt=$(this).html();
        var ispre=cltxt=='上一页';
        var isnex=cltxt=='下一页';
        var islast=cltxt=='末页';
        var isfirst=cltxt=='首页';
        var lastpage=sessionStorage.getItem('total');
        var ishavapage=oldurl.indexOf('page');
        var page2=hasParameter('page');
        //判断点击分页不为上一页与下一页
        if(!ispre&&!isnex&&!isfirst&&!islast){
            var page2=hasParameter('page');
            if(page2 == null){
                var newurl=oldurl+'&page='+cltxt;
                window.location.href=newurl;
                return false;
            }else{
                cltxt=cltxt;
                newurl=replaceParamVal(oldurl,'page',cltxt);
                window.location.href=newurl;
            }

        }
        //点击分页上一页
        if(ispre){
            if(ishavapage==-1){
                alert('这已经是第一页了！');
                cltxt=1;
                newurl=oldurl+'&page='+cltxt;
            }else{
                if(page==1){
                    alert('这已经是第一页了！');
                }if(page>1){
                    cltxt=page-1;
                    newurl=replaceParamVal(oldurl,'page',cltxt);
                    window.location.href=newurl;
                }else{
                    cltxt=page;
                    newurl=replaceParamVal(oldurl,'page',cltxt);

                }
            }
        }
        //点击分页下一页
        if(isnex){
            if(lastpage==1){
                alert('这已经是最后一页了');
                cltxt=1;
            }else{
                if(page2 == null){
                    var newurl=oldurl+'&page=2';
                    window.location.href=newurl;
                    return false;
                }
                else if(parseInt(page)<lastpage){
                    cltxt=parseInt(page)+1;
                    newurl=replaceParamVal(oldurl,'page',cltxt);
                    window.location.href=newurl;
                }else{
                    cltxt=lastpage;
                    alert('这已经是最后一页了');
                }
            }
        }
        //点击首页
        if(isfirst){
            if(page!=1){
                cltxt=1;
                newurl=replaceParamVal(oldurl,'page',cltxt);
                window.location.href=newurl;
            }else{
                alert("这已经是首页了")
                return;
            }
        }
        //点击末页
        if(islast){

            if(page!=lastpage){
                if(page2 == null){
                    var newurl=oldurl+'&page='+lastpage;
                    window.location.href=newurl;
                    return false;
                }
                cltxt=lastpage;
                newurl=replaceParamVal(oldurl,'page',cltxt);
                window.location.href=newurl;
            }else{
                alert("这已经是末页了")
                return;
            }
        }
    });
}
//点击显示展开筛选
$('.lin-sechple-open').click(function(){
    if($(this).html()=="展开全部筛选"){
        $(".lin-sechple-special").slideDown();
        $(this).html("收起");
    }else{
        $(".lin-sechple-special").slideUp();
        $(this).html("展开全部筛选");
    }
});

var   buffer = [];
function getData(province,schooltype,page,size,keyWord1,schoolprop,schoolflag,schoolsort,schoolid){
    $.ajax({
        type:"GET",
        url:refLocation+"/soudaxue/queryschool.html?messtype=jsonp",
        dataType:"jsonp",
        data:{
            province:province,
            schooltype:schooltype,
            page:page,
            size:size,
            keyWord1:keyWord1,
            schoolprop:schoolprop,
            schoolflag:schoolflag,
            schoolsort:schoolsort,
            schoolid:schoolid
        },
        success:function(data){
            var schooldata=data.school;
            var totalRecordS = data.totalRecord.num;
            if(schooldata==undefined){

            }else{
                //表格数据填充
                buffer.push(schooldata);
            }
        },
    });
}

for(var i=1 ; i<=140 ; i++)
{ getData(province,schooltype,i,20,keyWord1,schoolprop,schoolflag,null,null); }

var data =buffer.slice(0,20);
var str = JSON.stringify(data);
console.log(str);
var str = JSON.stringify(buffer);
console.log(str);

