import modalHTML from './modal.html'
import './modal.styl';

var uid = 0;

export default class {

    constructor () {
        this.createModal();

    }

    createModal() {
        var id = 'passport_modal_' + uid++;
        var doc = document.createElement('div');
        doc.innerHTML = modalHTML;
        var modal = doc.firstElementChild;
        modal.id = id;

        document.body.appendChild(modal);
        this.$modal = modal;
        var _this = this;
        modal.addEventListener('click', function(e) {
            if (e.target.classList.contains('close-btn')) {
                _this.hide();
            }
        });
    }

    show () {
        this.$modal.classList.remove('hide');
    }

    hide () {
        this.$modal.classList.add('hide');
    }

    appendHTML (html) {
        var d = document.createElement('div');
        d.innerHTML = html;
        this.$modal.firstElementChild.appendChild(d.firstElementChild);
    }

    find (selector) {
        return this.$modal.querySelector(selector)
    }

    destroy () {
        document.body.removeChild(this.modal);
    }
};