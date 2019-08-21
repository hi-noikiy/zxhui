/** bowen_site_com-v0.0.1 MIT License By www.we7pc.com */
if(!window.localStorage){
    var cache = setcookie;
}else{
    var storage=window.localStorage;
    var cache = function(n,v,t){
        if(!n || n == ''){
            return false;
        }
        if(v==false){
            return storage.removeItem(n);
        }else if(v){
            return storage[n] = v;
        }else{
            return storage[n];
        }
    }
}

function display(obj)
{
    if(obj instanceof jQuery){
        if(obj.is(":hidden")){
            obj.show();
        }else{
            obj.hide();
        }
    }else{
        if($("#" + obj).is(":hidden")){
            $("#" + obj).show();
        }else{
            $("#" + obj).hide();
        }
    }
}

//截取字符长度
function cutcontent(content,len){
    var data = '';
    if(content.length>len){
        var data = content.substr("0",len) + '...';
    }else{
        var data = content;
    }
    return data;
}

function search_article(params,page,psize)
{
    var data = {params:params, page:page, psize:psize};
    var page = (page != null)?page:'1';
    var psize = (psize != null)?psize:'12';
    $.post("./index.php?c=site&a=entry&m=bowen_site&do=web&r=selector.getArticles"
        ,data
        ,function(res){
            return res;
        }
    ,"json");
}