<template>
<div id="profile">
    <v-organ v-if="iscurrentType==2"></v-organ>
    <v-person v-else-if="iscurrentType==1"></v-person>
    <div class="nullPage" v-else-if="iscurrentType==3">
        {{$t('profile.noPermissions')}}
    </div>
</div>
</template>

<script>
import * as api from '@/js/api'
import person from './personProfile'
import organ from './organProfile'
export default {
    name: "profile",
    data() {
        return {
            iscurrentType: "",
        }
    },
    beforeCreate() {
        api.common.checkCurrenttype().then(res => {

            if (res.status == 705) {
                this.iscurrentType = 3
            } else {
                this.iscurrentType = res.data.type
            }

        })

    },
    components: {
        "v-person": person,
        "v-organ": organ
    }
}
</script>
<style scoped="scoped" lang="scss">
#profile {
    .nullPage {
        width: 100%;
        text-align: center;
        padding-top: 178px;
        color: #268FFF;
        font-size: 20px;
    }
}
</style>
