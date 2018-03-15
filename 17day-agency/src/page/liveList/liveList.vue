<template>
<div id="liveList">
    <div class="head">
        <h3>{{$t('liveList.title.listTitle')}}</h3>
        <div class="text">
            {{$t('liveList.text.download')}}<span @click="link(1)">{{$t('liveList.btn.liveTitle')}}</span>{{$t('liveList.text.client')}}！{{$t('liveList.text.tips')}} <span @click="link(2)">{{$t('liveList.btn.setPassword')}}</span> {{$t('liveList.text.ba')}}
            ！）
        </div>
    </div>

    <div class="playType">
        <span class="pre">{{$t('liveList.title.liveType')}}</span>
        <ul>
            <li @click="handleClick(index)" v-for="(type,index) in typeList" :class="[index==isActive?'active':'']">{{type}}</li>
        </ul>
        <span class="choose">
                <el-checkbox size="small" v-model="isChoose" @change="choose()"></el-checkbox>  {{$t('liveList.checkbox.myCourse')}}
            </span>
    </div>

    <div class="timelist">
        <ul>
            <li v-for="(item,index) in timeList" :class="[hasActive==index?'active':'']" @click='getLivelist(index)'>{{item.date}} ( {{item.count}} )</li>
        </ul>

    </div>

    <div class="liveList">
        <el-table class="table w-table" :data="liveList" style="width:950px" :empty-text="$t('liveList.tips.noData')">
            <el-table-column :label="$t('liveList.table.liveCourse')" width="340">
                <template scope="scope">
                        <p class="course">{{scope.row.course_name}}</p>
                        <p class="course">{{scope.row.title}}</p>
                    </template>
            </el-table-column>

            <el-table-column prop="teacher_name" :label="$t('liveList.table.teacher')" width="122">
                <template scope="scope">
                        <p class="teacher">{{scope.row.teacher_name}}</p>
                    </template>
            </el-table-column>

            <el-table-column :label="$t('liveList.table.time')" width="148">
                <template scope="scope">
                        <span>{{scope.row.start+" ~ "+scope.row.end}}</span>
                    </template>
            </el-table-column>
            <el-table-column :label="$t('liveList.table.type')" width="90">
                <template scope="scope" prop="type">
                        <span v-if="scope.row.type==1">{{$t('liveList.text.free')}}</span>
                        <span v-else>{{$t('liveList.text.pay')}}</span>
                    </template>
            </el-table-column>
            <el-table-column :label="$t('liveList.table.status')" width="110">
                <template scope="scope">
                        <span v-if="nowTime<(scope.row.start_time-30*60)">{{$t('liveList.status.noStart')}}</span>
                        <span v-else-if="nowTime>=(scope.row.start_time-30*60) && nowTime<scope.row.start_time">{{$t('liveList.status.toStar')}}</span>
                        <span class="living" v-if="scope.row.live_status == 1">{{$t('liveList.status.living')}}</span>
                        <span v-if="scope.row.live_status == 4" class="gray">{{$t('liveList.status.end')}}</span>
                    </template>
            </el-table-column>
            <el-table-column :label="$t('liveList.table.operation')" width="138">
<!--                 <template scope="scope">
                    <el-button size="medium"
                               class="w-button"
                               v-if="nowTime>=(scope.row.start_time-30*60) && nowTime <=(scope.row.end_time+30*60)"
                               @click="link(3)" >
                         {{$t('liveList.btn.enterCourse')}}
                    </el-button>
                    <el-button size="medium"  class="w-button" v-else-if="nowTime<(scope.row.start_time-30*60)" @click="modify(scope.row)">{{$t('liveList.btn.edit')}}</el-button>
                    <span class="liveover" v-else>- -</span>
                </template> -->
            </el-table-column>
        </el-table>
    </div>
    <!--  分页器start-->
    <div class="pagination" v-show="isPageshow">
        <el-pagination class="w-pagination" @current-change="handleCurrentChange" :current-page="currentPage" :page-size="pageSize" layout="prev, pager, next" :total="taskTotal">
        </el-pagination>
    </div>
    <!--  分页器end-->
</div>
</template>

<script>
import * as api from '@/js/api'
export default {
    data() {
        return {
            currentPage: 1, //默认显示第一页
            taskTotal: 0, //总数据量，初始化为0
            pageSize: 10, //每页默认展示10条数据
            isActive: 0,
            hasActive: 0,
            typeList: [this.$t('liveList.typeList[0]'), this.$t('liveList.typeList[1]'), this.$t('liveList.typeList[2]')],
            type: '',
            isChoose: false,
            liveDt: "", //20180104
            nowTime: '',
            timeList: [],
            message: '',
            timer: "",
            liveList: [],
            isPageshow: false,
        }
    },
    created() {
        this.handleClick(0)
        api.liveList.getCurrentTime().then((res) => {
            this.nowTime = res.time
        })
    },
    mounted() {
        this.judgeTime()
    },
    methods: {
        handleClick(index) {
            this.isActive = index;
            if (index == 0) {
                this.type = ''
            } else {
                this.type = index
            }
            api.liveList.getSevenDay({
                account: this.isChoose,
                type: this.type
            }).then((res) => {
                this.timeList = res.data;
                this.liveDt = this.timeList[this.hasActive].live_dt
            }).then(() => {
                this.getLivelist(this.hasActive)
            })

        },
        getLivelist(index) {
            this.hasActive = index;
            this.liveDt = this.timeList[this.hasActive].live_dt
            api.liveList.getLiveList({
                page_size: this.pageSize,
                page_num: this.currentPage,
                type: this.type,
                account: this.isChoose,
                live_dt: this.liveDt
            }).then((res) => {
                this.liveList = res.data
                this.taskTotal = res.total
                this.isPageshow=res.total;
            })
            //console.log(this.liveDt,this.type,this.isChoose,"当前的时间")
        },
        choose() {
            this.handleClick(this.isActive)
        },
        judgeTime() {
            clearInterval(this.timer)
            this.timer = setInterval(() => {
                api.liveList.getCurrentTime().then((res) => {
                    this.nowTime = res.time
                })
            }, 1000 * 60)
        },
        handleCurrentChange(current) {
            this.currentPage = current
            api.liveList.getLiveList({
                page_size: this.pageSize,
                page_num: this.currentPage,
                type: this.type,
                account: this.isChoose,
                live_dt: this.liveDt
            }).then(res => {
                this.liveList = res.data
                this.taskTotal = res.total
                this.isPageshow = res.total;
            });
        },
        link(val) {
            switch (val) {
                case 1:
                    location.href = "http://wdyapp.bj.bcebos.com/WdyLive_SetUp_1_0_0_5.exe"
                    break;
                    //点击下载伟东云客户端下载的链接
                case 2:
                    window.location.href = "//" + window.WWW_HOST + "/center/edit?type=tab3";
                    break;
                    //修改密码
                case 3:
                    //window.location.href="//www.wdyclass.com";
                    break;

                    //进入课堂
            }
        },
        modify(row) {
            this.$router.push({
                path: '/modifyCourse/' + row.course_id + '/审核通过'
            });
        },
        getCookie(name) {
            var arr
            var reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
            if (arr = document.cookie.match(reg))
                return (arr[2]);
            else
                return null;
        }


    },
    destroyed() {
        clearInterval(this.timer)

    }

}
</script>

<style lang="scss" scoped="scoped">
* {
    margin: 0;
    padding: 0;
}
.w-button {
    height: 34px;
    width: 96px;
    font-size: 14px;
}
.head {
    overflow: hidden;
    margin-top: 10px;
    h3 {
        float: left;
        margin-right: 25px;
        font-size: 16px;
    }
    .text {
        font-size: 14px;
        float: left;
        color: #999;
        span {
            color: #268FFF;
            cursor: pointer;
            font-size: 14px;
        }
    }
}
.playType {
    margin-top: 40px;
    overflow: hidden;
    display: flex;
    .pre {
        height: 36px;
        margin-right: 20px;
        display: inline-block;
        line-height: 36px;
        text-align: left;
        font-size: 16px;
        color: #000;
        font-weight: bold;
    }
    .choose {
        height: 36px;
        display: inline-block;
        line-height: 36px;
        text-align: left;
        font-size: 12px;
        color: #000;
        font-weight: bold;
    }
    ul {
        display: inline-block;
    }
    ul li {
        list-style: none;
        float: left;
        margin-right: 20px;
        border: 1px solid #268FFF;
        border-radius: 4px;
        color: #268FFF;
        height: 36px;
        width: 96px;
        font-size: 16px;
        text-align: center;
        line-height: 36px;
        cursor: pointer;
    }
    .active {
        background: #268FFF;
        color: #fff;
    }
}
.timelist {
    overflow: hidden;
    margin-top: 40px;
    ul li {
        float: left;
        height: 50px;
        width: 135px;
        font-size: 14px;
        color: #268FFF;
        text-align: center;
        line-height: 50px;
        border: 1px solid #268fff;
        border-right: none;
        cursor: pointer;
        &.active {
            background: #268FFF;
            color: #fff;
        }
        &:first-child {
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }
        &:last-child {
            border-right: 1px solid #268FFF;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }
    }
}
.liveList {
    margin-top: 20px;
    .gray {
        color: #999;
    }
    .living {
        color: #268FFF;
        display: inline-block;
        background: url("../../assets/images/liveicon.png") no-repeat;
        background-position: center right;
        padding-right: 14px;
    }
    .liveover {
        display: inline-block;
        height: 34px;
        width: 96px;
        line-height: 34px;
        /* text-align: center;*/
    }
    .course,
    .teacher {
        width: 370px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .teacher {
        width: 112px;
    }
}
.pagination {
    width: 1020px;
    text-align: center;
    margin-top: 20px;
    .el-pagination {
        display: inline-block;
    }
}
</style>
<style lang="scss">
#liveList {
    th {
        height: 54px;
    }
    td {
        height: 76px;
    }
    .el-checkbox__inner {
        width: 14px;
        height: 14px;
        border-radius: 3px;
    }
    .el-checkbox__inner::after {
        height: 6px;
        left: 4px;
        position: absolute;
        top: 1px;
        transform: rotate(45deg) scaleY(1);
        width: 3px;
    }

}
</style>
