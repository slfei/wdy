// 返回空内容
export default {
    normal(msg){
        return `
        <div class="no-result">
            <i class="icon icon-empty"></i>
            <div class="empty-desc">${ msg || '暂无相关课程'}</div>
        <div>`
    }
}
