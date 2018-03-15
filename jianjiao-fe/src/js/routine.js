import api from '@/js/api';
import utils from '@/js/utils';
/**
 *
 */
function uploadLocation(sucCb) {
    if ($tplData.wxconfig && window.wx && wx.getLocation) {
        wx.getLocation({
            success: function(res) {
                setLocation(res)
            },
            error: function(res) {
                console.log(res.errMsg);
            }
        });
    } else if ("geolocation" in navigator) {
        /* geolocation is available */
        // alert(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(function(position) {
            setLocation(position.coords);
        }, function (error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    break;
                case error.POSITION_UNAVAILABLE:
                case error.TIMEOUT:
                case error.UNKNOWN_ERROR:
                    // alert(error)
                    console.log("position fetch error" );
            }
        });
        //39.9801243 116.30323380000002
    } else {
        /* geolocation IS NOT available */
    }

    function setLocation(pos) {
        // alert(pos)
        api.post("/api/universal/setlocation", {
            lat: pos.latitude,
            lon: pos.longitude
        }).then(function (data) {
            sucCb && sucCb(data);
        }, function (err) {
            console.error(err)
        })
    }
}



/**
 * 初始化首页的标签浮层展示
 */
function initIndexTagGuide() {
    var elem = document.querySelector('.customize-tag');
    var viewPortHeight = Math.round(window.innerHeight / 3 * 3);

    var targetHeight = utils.getElementTop(elem);
    var mask = document.querySelector('.customize-tag-mask');
    var closeBtn = document.querySelector('.mask-confirm-button');
    var maskHook = document.querySelector('.relative-hook');
    var customizeBtn = document.querySelector('.customize-tag');

    var fn = utils.debounce(function () {
        if(document.body.scrollTop + viewPortHeight >= targetHeight){
            window.scrollTo(0, targetHeight - viewPortHeight/3*2);
            window.removeEventListener('scroll', fn)
            openMask();
        }
    }, 100, true);

    window.addEventListener('scroll', fn);
    
    mask.addEventListener('touchstart', function (e) {
        e.preventDefault()
    });

    function openMask() {
        maskHook.classList.add("relative");
        mask.style.display = "block";
    }

    function closeMask() {
        mask.style.display = "none";
        maskHook.classList.remove("relative");
    }

    closeBtn.addEventListener('click', closeMask);
    customizeBtn.addEventListener('click', closeMask, true);
}

function firstShowElement(element, callback) {
    var scrollElement = (document.scrollingElement || document.body);
    var top = element.getBoundingClientRect().top + scrollElement.scrollTop;
    var viewPortHeight = window.innerHeight;

    var fn = utils.debounce(function () {
        var scrollTop = scrollElement.scrollTop;
        //console.log(scrollTop, top);
        if(scrollTop + viewPortHeight >= top){
            window.removeEventListener('scroll', fn);
            callback(document.body.scrollTop);
        }
    }, 100, true);

    window.addEventListener('scroll', fn);
    fn();
}


export default {
    uploadLocation,
    initIndexTagGuide,
    firstShowElement
}
