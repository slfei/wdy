
<template>
    <div class="filter-wrap">
        <div class="filter-list">
            <div class="filter-item" v-for="item in filters" @click="showPopup(item)" :class="{open: item.key === openingFilterKey}">
                <span>{{ item | filterName(selectedFilter) }}</span>
                <i class="ion-ios-arrow-down"></i>
            </div>
        </div>
        <!--<transition name="slide-down">-->
            <div class="filter-modal" v-show="openingFilterKey == 'area'">
                <em class="arrow"></em>
                <div class="area filter-content">
                    <aside v-iscroll="scrollOption">
                        <div class="v-scroll">
                            <div class="aside-item" v-for="(area, index) in data.area" :class="{active: highlightArea == area}" @tap="highlightArea = area">
                                {{ area.name }}
                            </div>
                        </div>
                    </aside>
                    <div class="main" v-if="highlightArea" v-iscroll="scrollOption">
                        <div class="v-scroll">
                            <div class="main-item" v-for="item in highlightArea.sub" @tap="selectArea(item)" :class="{active: selectedFilter.area == item}">
                                {{ item.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--</transition>-->
        <!--<transition name="slide-down">-->
            <div class="filter-modal" v-show="openingFilterKey == 'category'">
                <em class="arrow center"></em>
                <div class="filter-content">
                    <aside v-iscroll="scrollOption">
                        <div class="v-scroll">
                            <div class="aside-item"
                                 v-for="(c, index) in data.category"
                                 :class="{active: highlightCategory == c}"
                                 @tap="highlightCategory = c"
                            >
                                {{ c.name }}
                            </div>
                        </div>
                    </aside>
                    <div class="main" v-if="highlightCategory" v-iscroll="scrollOption">
                        <div class="v-scroll">
                            <div class="main-item"
                                v-for="item in highlightCategory.sub"
                                @tap="selectCategory(item)"
                                :class="{active: selectedFilter.category == item || selectedFilter.category.parent_id === item.id, 'has-sub': item.sub}">
                                <div class="level-2-node">{{ item.name }}</div>
                                <div class="level-3-list clearfix" v-show="item.sub">
                                    <div v-for="cat in item.sub" @tap="selectCategory(cat)" class="level-3-node" :class="{active: cat == selectedFilter.category}">
                                        {{ cat.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--</transition>-->
        <!--<transition name="slide-down">-->
            <div class="filter-modal" v-show="openingFilterKey == 'sort'">
                <em class="arrow right"></em>
                <div class="filter-content">
                    <ul class="main">
                        <li class="main-item t-center" v-for="item in sortTypeList" @click="selectSort(item)" :class="{active: selectedFilter.sort == item}">
                            {{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>
        <!--</transition>-->
        <transition name="fade">
            <div class="modal-overlay" v-show="openingFilterKey" @click="openingFilterKey = ''"></div>
        </transition>
    </div>
</template>
<style lang="stylus" src="@/css/filter.styl">

</style>
<script type="text/ecmascript-6">

    var sortTypeList = [/*{
        id: 1,
        type: 'default',
        name: '智能排序'
    },*/ {
        id: 2,
        type: 'score',
        name: '评分'
    }, {
        id: 3,
        type: 'distance',
        name: '距离'
    }, {
        id: 4,
        type: 'teacherCount',
        name: '教师数量'
    }, {
        id: 5,
        type: 'commentCount',
        name: '评论数量'
    }];
    import '@/directives/iscroll';

    export default {
        props: ['categoryId', 'data'],
        data(){
            return {
                filters: [{
                    key: 'area',
                    name: '附近'
                }, {
                    key: 'category',
                    name: '分类'
                }, {
                    key: 'sort',
                    name: '排序'
                }],
                sortTypeList: sortTypeList,
                highlightArea: null,
                highlightCategory: null,
                selectedFilter: {
                    area: '',
                    category: '',
                    sort: ''
                },
                openingFilterKey: '',
                scrollOption: {
                    mouseWheel: true,
                    tap: true,
                    click: false
                }
            }
        },

        filters: {
            filterName (filter, selectedFilter, key = 'name') {
                if (selectedFilter[filter.key]) {
                    return selectedFilter[filter.key][key];
                }
                return filter[key];
            }
        },

        created () {
            var filter = this.findCategoryById(this.categoryId);
            console.log(filter, this.categoryId);
            filter && (this.selectedFilter.category = filter);
            this.$watch('selectedFilter.category', function(value) {
                this.$emit('changeCategory', value);
                this.$emit('changeFilter', this.selectedFilter);
            });
            this.$watch('selectedFilter.area', function(value) {
                this.$emit('changeArea', value);
                this.$emit('changeFilter', this.selectedFilter);
            });
            this.$watch('selectedFilter.sort', function(value) {
                this.$emit('changeSort', value);
                this.$emit('changeFilter', this.selectedFilter);
            });
            console.log(this.data);
        },
        methods: {
            showPopup (item) {
                if (this.openingFilterKey === item.key) {
                    return this.openingFilterKey = '';
                }
                this.openingFilterKey = item.key;
                switch(item.key) {
                    case 'area':
                        this.highlightArea = this.findHighlightItem(this.data.area, 'area');
                        break;
                    case 'category':
                        this.highlightCategory = this.findHighlightItem(this.data.category, 'category');//this.highlightCategory || this.categoryList[0];
                        break;

                }
            },
            selectArea (area) {
                this.openingFilterKey = '';
                this.selectedFilter.area = area;
            },
            selectCategory (category) {
                if (category.sub) return ;
                this.openingFilterKey = '';
                this.selectedFilter.category = category;
            },

            selectSort(sortType) {
                this.openingFilterKey = '';
                this.selectedFilter.sort = sortType;
            },

            findHighlightItem (list, key) {
                var filter = this.selectedFilter[key];
                if (!filter) {
                    return list[0];
                }
                for (var i = 0, len = list.length; i < len; i++) {
                    var p = list[i];
                    /*if (p.sub) {
                        for (var j = 0, k = p.sub.length; j < k; j++) {
                            if (filter.id == p.sub[j].id) {
                                return p;
                            }
                        }
                    } else if (p.id == filter.id) {
                        return p;
                    }*/
                    if (deepSearchById(p, filter.id)) {
                        return p;
                    }
                }

                return list[0];
            },

            findCategoryById (id) {
                var list = this.data.category;
                for (var i = 0, len = list.length; i < len; i++) {
                    var item = deepSearchById(list[i], id);
                    if (item) return item;
                }
                return null;
            }
        }
    }

    function deepSearchById(item, id) {
        if (item.id == id) {
            return item;
        }
        if (item.sub) {
            for (var i = 0, len = item.sub.length; i < len; i++) {
                var obj = deepSearchById(item.sub[i], id);
                if (obj) return obj;
            }
        }
        return null;
    }
</script>
