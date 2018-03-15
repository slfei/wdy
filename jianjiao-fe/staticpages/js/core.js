/*global
 console,
 FormData,
 fetch
 */

function genFormData(p) {
    'use strict';
    var data = new FormData(),
        val,
        k,
        i,
        l;
    for (k in p) {
        if (p.hasOwnProperty(k)) {
            val = p[k];
            if (Array.isArray(val)) {
                for (i = 0, l = val.length; i < l; i += 1) {
                    data.append(k + '[]', val[i]);
                }
            } else {
                data.append(k, val);
            }
        }
    }
    return data;
}

function rectsIntersect(a, b) {
    'use strict';
    return a[0] < b[2] && a[2] > b[0] && a[1] < b[3] && a[3] > b[1];
}

function getPageRect() {
    'use strict';
    var isquirks, page, doc, x, y, w, h;
    isquirks = document.compatMode !== 'BackCompat';
    page = isquirks ? document.documentElement : document.body;
    doc = document.documentElement;
    x = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
    y = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
    w = window.innerWidth === undefined ? window.innerWidth : page.clientWidth;
    h = window.innerHeight === undefined ? window.innerHeight : page.clientHeight;
    return [x, y, x + w, y + h];
}

function getElementRect(element) {
    'use strict';
    var x = 0,
        y = 0,
        w = element.offsetWidth,
        h = element.offsetHeight;
    while (element.offsetParent !== null) {
        x += element.offsetLeft;
        y += element.offsetTop;
        element = element.offsetParent;
    }
    return [x, y, x + w, y + h];
}

function getElementTop(element) {
    'use strict';
    var y = 0;
    while (element.offsetParent !== null) {
        y += element.offsetTop;
        element = element.offsetParent;
    }
    return y;
}

function VisibilityMonitor(showfn, hidefn) {
    'use strict';

    function check() {
        var elements = document.getElementsByClassName('lazyload'),
            i,
            isshown,
            lockitems,
            top_temp;

        for (i = 0; i < elements.length; i += 1) {
            isshown = elements[i].classList.contains('show');
            if (rectsIntersect(getPageRect(), getElementRect(elements[i])) !== isshown) {
                isshown = !isshown;
                if (isshown) {
                    if (elements[i].complete) {
                        showfn(elements[i]);
                    } else if (elements[i].complete === undefined) {
                        showfn(elements[i]);
                    }
                } else {
                    if (hidefn) {
                        hidefn(elements[i]);
                    }
                }
            }
        }
        lockitems = document.getElementsByClassName('lockonhead');
        for (i = 0; i < lockitems.length; i += 1) {
            if (lockitems[i].originalTop) {
                top_temp = lockitems[i].originalTop;
            } else {
                top_temp = getElementTop(lockitems[i]);
            }
            if (top_temp < window.scrollY) {
                lockitems[i].classList.add('fixed');
                lockitems[i].originalTop = top_temp;
            } else {
                lockitems[i].classList.remove('fixed');
                lockitems[i].originalTop = 0;
            }
        }

    }

    if (window.attachEvent) {
        window.attachEvent('onresize', check);
        window.attachEvent('onscroll', check);
    } else if (window.addEventListener) {
        window.addEventListener('resize', check, true);
        window.addEventListener('scroll', check, true);
    }
    check();
    setInterval(function () {
        check();
    }, 1000);
}

var visibilityMonitor = new VisibilityMonitor(
    function (element) {
        'use strict';
        element.classList.add('show');
        setTimeout(function () {
            element.classList.remove('lazyload');
        }, 500);
    },
    null
);

Array.prototype.slice.call(document.querySelectorAll('.table-button')).forEach(function (item) {
    'use strict';
    item.addEventListener('click', function (e) {
        var node = document.getElementsByClassName('table-content')[this.getAttribute('data-id')];
        if (node) {
            if (node.classList.contains('open')) {
                node.classList.remove('open');
                this.classList.remove('open');
            } else {
                node.classList.add('open');
                this.classList.add('open');
            }
        }
    });
});

Array.prototype.slice.call(document.querySelectorAll('.button-select')).forEach(function (item) {
    'use strict';
    item.addEventListener('click', function (e) {
        var node = document.getElementsByClassName('button-select active')[0];
        if (node) {
            if (node.classList.contains('active')) {
                node.classList.remove('active');
                this.classList.add('active');
            } else {
                node.classList.add('active');
                this.classList.remove('active');
            }
        }
    });
});

if (document.getElementById('form-input')) {
    document.getElementById('form-input').addEventListener('change', function (e) {
        'use strict';
        if (this.classList.contains('invalid')) {
            this.classList.remove('invalid');
        }
    });
}

if (document.getElementById('form-textarea')) {
    document.getElementById('form-textarea').addEventListener('change', function (e) {
        'use strict';
        if (this.classList.contains('invalid')) {
            this.classList.remove('invalid');
        }
    });
}

if (document.getElementById('form-submit')) {
    document.getElementById('form-submit').addEventListener('click', function (e) {
        'use strict';
        e.preventDefault();
        var input = document.getElementById('form-input'),
            textarea = document.getElementById('form-textarea'),
            data = {},
            self = this;
        if (input.value === '') {
            input.classList.add('invalid');
            input.focus();
        } else if (textarea.value === '') {
            textarea.classList.add('invalid');
            textarea.focus();
        } else {
            data.type = 1;
            if (document.getElementById('form-select1').classList.contains('active')) {
                data.type = 2;
            }
            data.phone = input.value;
            data.text = textarea.value;
            self.classList.add('disabled');
            self.innerText = '提交中...';
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/feedback/receivefeedback');
            xhr.send(genFormData(data));
            xhr.onload = function () {
                self.classList.remove('disabled');
                self.innerText = '提交';
                input.value = '';
                textarea.value = '';
                document.getElementById('notify').classList.add('show');
                setTimeout(function () {
                    document.getElementById('notify').classList.remove('show');
                }, 2000);

            };

        }
    });
}
