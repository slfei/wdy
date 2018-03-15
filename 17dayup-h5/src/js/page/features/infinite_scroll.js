import utils from '../../utils'
import api from '../../api'
import common from '../../common'
import empty from './empty'
// add .infinite-scroll to the wrapper with data-url attribuate


var container = $(".infinite-scroll")

class Pager {
    constructor(page_num = 1, page_size) {
        this.page_num = page_num;
        this._is_loading = false;
        this._is_finish = false;
    }

    next() {
        if (this._is_loading || this._is_finish) {
            return
        }
        this._is_loading = true;
        return ++this.page_num;
    }

    done() {
        this._is_loading = false;
    }


    fail() {
        this._is_loading = false;
        this.page_num--;
    }

    finish() {
        console.log('pageNum', this.page_num);
        if (this.page_num >=2){
            container.find('#loading').show().html("我是有底线的");
        } else {
            container.find('#loading').hide();
        }
        this._is_finish = true;
    }

    reset() {
        this.page_num = 0;
        this._is_finish = false;
        this._is_loading = false;
    }
}


var pager = new Pager()
var containerHeight = container.height();
var params = container.data('params');


if (container.length) {
    container.append('<div id="loading" class="load"><img src="/static/img/load/loading.gif"></div>')
    bindScrollEvent(window)
}


function bindScrollEvent(win) {
    win = $(win);
    var winHeight = win.height()
    var prefetchDistance = 2 * winHeight;

    var infiniteScrollFn = utils.debounce(function () {
        try {
            var scrollTop = win.scrollTop()
            if ((scrollTop + prefetchDistance) > containerHeight) {
                container.find('#loading').show();
                loadData()
            }
        } catch (e) {
            console.log(e);
        }
    }, 100, true)

    win.off("scroll", infiniteScrollFn)
    win.on("scroll", infiniteScrollFn)
}

function loadData() {
    var dataUrl = container.data('url')    
    var nextPage = pager.next();
    
    if (nextPage) {
        container.find('#loading').show()

        api.post(dataUrl, utils.assign({
            page_num: nextPage
        }, params)).then(function (data) {
            common.ui.loading.hide()

            if (data) {
   
                container.find('#loading').hide().before(data);
                pager.done()
                setTimeout(function () {
                    containerHeight = container.height()
                }, 100)
            } else {
                // 第一页却没有数据
                if(nextPage==1){
                    container.html(empty.normal('暂无内容'))
                }
                pager.finish()
                // win.off("scroll", infiniteScrollFn)
            }
        }, function () {
            pager.fail()
        })
    } else {
        common.ui.loading.hide()
        pager.finish()     
        console.log("is loading or no more data!");
    }
}


export default {
    reload(_p) {
        // 重载一般用在切换 tab 的场景，展示 loading
        common.ui.loading.show("正在加载...")
        params = utils.assign(_p, params);
        pager.reset()
        container.html('<div id="loading" class="load"><img src="/static/img/load/loading.gif"></div>')
        loadData()
    },
    // 优惠券初始化
    init() {
        pager.reset()
        loadData()
    }
}
