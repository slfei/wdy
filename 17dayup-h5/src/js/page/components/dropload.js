(function($){
    var win = window;

    $.fn.scrollload=function(options){
    	return new ScrollLoad(this, options);
    };

    var ScrollLoad = function(e, options){
    	var _this = this;

    	_this.element = e;
        _this.loading = false;
        _this._scrollTop = 0;
        _this._threshold = 0;
        _this.isData = true;
        _this.isLock = false;
        _this.init(options);
    };

    /**
     * 初始化
     */
    ScrollLoad.prototype.init = function(options){
    	console.log("初始化成功")
    	var _this = this;

    	var defaults = {
            scrollArea: _this.element,
    		loadDown: {
    			ndClass: 'scroll-down',
    			ndLoading: '<div class="scroll_loading">加载中...</div>',
    			ndNoData: '<div class="scroll_noData">已经到底了</div>'
    		},
            autoLoad : true,
            threshold: 0,
    		loadDownFn: '',
            checkoutTab: ''
    	};

    	 _this.opts = $.extend(true, {}, defaults, options);


    	if(_this.opts.loadDownFn != ''){
            _this.element.append('<div class='+ _this.opts.loadDown.ndClass +'>' + _this.opts.loadDown.ndLoading + '</div>');
            _this.$domDown = $('.' + this.opts.loadDown.ndClass);
    	};

        if(_this.opts.scrollArea){
            _this._scrollContentHeight = _this.element[0].scrollHeight;
            _this._scrollWindowHeight = _this.element.height();
        };

        if(_this.opts.threshold != 0){
            _this._threshold = _this.opts.threshold;
        };


        _this.element.on('scroll',function(){
            _this._scrollTop = _this.element.scrollTop();

            if(_this.opts.loadDownFn != '' && _this.isData && !_this.loading && (_this._scrollContentHeight - _this._threshold) <= (_this._scrollWindowHeight + _this._scrollTop)){
                loadDown(_this);
            }
        });

        if(_this.opts.checkoutTab != ''){
            $(_this.opts.checkoutTab).on('click',function(){
        
                _this.loading = false;
                _this.isData = $(this).data('hasdata');
                _this.isajax = $(this).data('ajax');
                _this._scrollContentHeight = _this.element[0].scrollHeight;
                _this._scrollWindowHeight = _this.element.height();
                 // _this.$domDown.show()
                if(_this.isData){
                    _this.$domDown.html(_this.opts.loadDown.ndLoading).show();
                }else{
                    _this.$domDown.html(_this.opts.loadDown.noData).show();
                }

                if(!_this.isajax){
                    _this.hide();
                }
                _this.reload()
            });
        };

        fnAutoLoad(_this);

    };

    ScrollLoad.prototype.hide = function(){
        var _this = this;
        _this.$domDown.hide();
    };

     /**
      * 无数据
      */
    ScrollLoad.prototype.noData = function(index){
        var _this = this;
            _this.isData = false;
           
            if(index != undefined && _this.opts.checkoutTab != ''){
                $(_this.opts.checkoutTab).eq(index).data('hasdata',false);
                if((_this._scrollContentHeight - _this._threshold) <= _this._scrollWindowHeight){
                    _this.$domDown.hide().html(_this.opts.loadDown.ndNoData);
                }else{
                    _this.$domDown.show().html(_this.opts.loadDown.ndNoData);
                }
            };
    };

    /**
     * 重新加载
     */
    ScrollLoad.prototype.reload =function(){
        
        var _this = this;

        if(_this.isData){
            _this.loading = false;
            fnRecoverContentHeight(_this);
            fnAutoLoad(_this);
        }else{
            if(_this._scrollContentHeight == _this._scrollWindowHeight){
                _this.$domDown.hide();
            }else{
                _this.$domDown.html(_this.opts.loadDown.ndNoData);
            }
        }
    };

    ScrollLoad.prototype.lock = function(){
        var _this = this;
        _this.isLock = true;
    };

    ScrollLoad.prototype.unlock = function(){
        var _this = this;
        _this.isLock =false;
    };

    /**
     * 调用ajax
     */
    function loadDown(_this){
        _this.loading = true;
        _this.$domDown.show();
        if(!_this.isLock){
            // console.log(23)
            _this.opts.loadDownFn(_this);
        }
    };

    /**
     * 获取文档高度
     */
    function fnRecoverContentHeight(_this){
            _this._scrollContentHeight = _this.element[0].scrollHeight;
    };

    /**
     * 文档高度小于窗口高度自动加载
     */
    function fnAutoLoad(_this){
        if(_this.opts.loadDownFn != '' && _this.opts.autoLoad){
            if((_this._scrollContentHeight - _this._threshold) <= _this._scrollWindowHeight){
                loadDown(_this);
            }
        }
    };

})(window.jQuery)
