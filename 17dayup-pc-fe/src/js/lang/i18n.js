
function baseGet(obj,path){
    var path = path.split('.');

    var index = 0,length = path.length;
    while (obj != null && index < length) {
        obj = obj[path[index++]];
      }
    return (index && index == length) ? obj : undefined;
};

function getKey(path,obj){

   var result = obj == null ? path : baseGet(obj,path);

   return result === undefined ? path : result;
};

export function i18n(path){
    var obj = lang;

    return getKey(path,obj)
}
