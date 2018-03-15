<template>
    <div class="page-institute-list">
        <div class="top-bar">
            <jui-header type="back"> 机构列表 </jui-header>
            <div class="has-header">
                <institute-filter
                        :category-id="highlightCategoryId"
                        :data="filterData"
                        @changeCategory="changeCategory"
                        @changeArea="changeArea"
                        @changeSort="changeSort"
                >
                    <div slot="empty">暂无数据</div>
                </institute-filter>
            </div>
        </div>

        <div class="content">
            <div v-infinite-scroll="loadMore"
                 infinite-scroll-disabled="canLoadMore">
                <institute-list :data="data">
                    <div slot="empty">
                        <div class="icon icon-no-result"></div>
                        <div class="text">更多机构正在收录中，敬请期待~</div>
                    </div>
                </institute-list>
            </div>
        </div>
    </div>
</template>
<style lang="stylus" src="../../css/page/institute.list.styl"></style>
<script type="text/ecmascript-6">
    import InstituteList from '@/components/InstituteList.vue'
    import JuiHeader from '@/components/Header.vue';
    import InstituteFilter from '@/components/InstituteFilter.vue';
    import api from '@/js/api';
    import { transformFilterData } from '@/js/utils';
    import { Toast } from 'mint-ui';


    var highlightCategoryId = $tplData.category_id;//location.pathname.split('/').pop();
    var filterData = transformFilterData($tplData.position, $tplData.filter.distance_filter, $tplData.category_list);
    export default {
        components: {
            InstituteList,
            JuiHeader,
            InstituteFilter
        },
        data(){
            return {
                highlightCategoryId: highlightCategoryId,
                data: $tplData.institute_list,
                loading: false,
                pager: {
                    total: $tplData.total,
                    start: $tplData.institute_list.length,
                    limit: 10
                },
                filter: {
                    area: null,
                    sort: null,
                    distance: null
                },
                filterData: filterData
            }
        },
        computed: {
            canLoadMore () {
                return this.loading || this.pager.total <= this.pager.start;
            }
        },

        methods: {
            fetch (needClear) {
                this.loading = true;
                // get data queryString: pager & filter
                api.searchInstitute({
                    category_id: this.highlightCategoryId,
                    city_id: this.filter.area,
                    distance_range: this.filter.distance,
                    sort_type: this.filter.sort,
                    limit: this.pager.limit,
                    start: needClear ? 0 : this.pager.start
                }).then(data => {
                    this.pager.total = data.total;
                    this.data = needClear ? data.result_list : this.data.concat(data.result_list);
                    this.pager.start = this.data.length;
                    this.loading = false;
                }).catch(msg => {
                    this.loading = false;
                    Toast(msg);
                });
            },

            changeCategory (category) {
                window.location.href = '/institute/category/' + category.id;
            },

            changeArea (area) {
                if (String(area.id).indexOf('distance_') == 0) {
                    this.filter.distance = area.distance_key;
                } else {
                    this.filter.area = area.id;
                }
                this.fetch(true);
            },

            changeSort (sortType) {
                this.filter.sort = sortType.id;
                this.fetch(true);
            },

            loadMore () {
                this.fetch();
            }
        }
    }

    function getQuery(key, search) {
        var reg = new RegExp('(?:^|\\?|&)' + key  + '=([^&]*)');
        search = search || location.search;
        if (reg.test(search)) {
            return RegExp.$1;
        }
    }
</script>
