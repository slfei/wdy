
window.addLogin = function () {
    document.getElementsByTagName('html')[0].classList.add('loginHtml');
    document.body.classList.add('loginHtml');
    document.getElementsByClassName('pageIndex')[0].classList.add('loginIndex')

};
window.removeLogin = function(){
    document.getElementsByTagName('html')[0].classList.remove('loginHtml');
    document.body.classList.remove('loginHtml');
    document.getElementsByClassName('loginIndex')[0].classList.remove('loginIndex')
}
