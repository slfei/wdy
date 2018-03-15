<template>
<span>还剩{{time}}</span>
</template>
<script>
export default {
    props: ['applyTime'],
    data() {
        return {
            now: +new Date()
        };
    },
    methods: {
        format(t) {
            let day = Math.floor(t / 86400000);
            let hour = Math.floor((t / 3600000) % 24);
            let min = Math.floor((t / 60000) % 60);
            let sec = Math.floor((t / 1000) % 60);
            hour = hour < 10 ? "0" + hour : hour;
            min = min < 10 ? "0" + min : min;
            //sec = sec < 10 ? "0" + sec : sec;
            console.log(t);
            return `${day}天${hour}小时${min}分`;
        }
    },
    computed: {
        startTime: function() {
            return this.applyTime.replace(/^(\d{4}-\d{2}-\d{2})\s([\d:]+)$/, '$1T$2+08:00');
        },
        time: function() {
            var delayTime = 3 * 24 * 3600 * 1000;
            return this.format(new Date(this.startTime).getTime() + delayTime - this.now);
        }
    },
    mounted() {
        let self = this;
        this.timer = setInterval(function() {
            self.now = new Date().getTime();
        }, 1000);

    },
    destroyed() {
        clearInterval(this.timer);
    }
}
</script>
