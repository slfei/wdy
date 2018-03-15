<template>
    <div class="cascade-select">
        <el-select
            v-model="activeValue[index]"
            placeholder="请选择"
            v-for="(level, index) in activeOptions"
            :key="index"
            @change="change"
        >
            <el-option
                v-for="item in level"
                :key="item[valueKey]"
                :value="item[valueKey]"
                :label="item[labelKey]"
            >
            </el-option>
        </el-select>
    </div>
</template>
<script>
    export default {
        props: {
            data: {},
            value: {},
            labelKey: {
                type: String,
                default: 'label'
            },
            valueKey: {
                type: String,
                default: 'value'
            },
            childKey: {
                type: String,
                default: 'children'
            }
        },
        data (){
            return {
                activeValue: []
            }
        },
        computed: {
            activeOptions: {
                get () {
                    const activeValue = this.activeValue;
                    const { valueKey, childKey } = this;

                    const loadActiveOptions = (options, activeOptions = []) => {
                        const level = activeOptions.length;
                        activeOptions[level] = options;
                        let active = activeValue[level];
                        if (active !== undefined && active !== null) {
                            options = options.filter(option => option[valueKey] === active)[0];
                            if (options && options[childKey]) {
                                loadActiveOptions(options[childKey], activeOptions);
                            }
                        }
                        return activeOptions;
                    };

                    var options = loadActiveOptions(this.data);
                    return options;
                }
            }

        },

        created () {
            this.$watch('data', function(value) {
                this.setActiveValue();
            });
            this.$watch('value', function(value) {
                this.setActiveValue();
            });
            this.$watch('activeValue', function(newValue, oldValue) {
                 if(!this.arrayEqual(newValue, this.value)){
                    this.$emit('input', newValue.slice());
                    console.log('change~~~', newValue.pop());

                 }
            });
            this.setActiveValue();
        },

        methods: {

            setActiveValue () {
                var ret = [];// this.activeValue;
                const { childKey, valueKey } = this;
                var data = this.data;

                for (var i = 0, len = this.value.length; i < len; i++) {
                    var item = data.filter(item => item[valueKey] == this.value[i])[0];
                    if (item) {
                        ret.push(item[valueKey]);
                        data = item[childKey];
                    } else {
                        break;
                    }
                }
                this.activeValue = ret;

            },
            arrayEqual(a, b) {
                if (a === b) return true;
                if (isVoid(a) || isVoid(b)) return false;
                if (a.length !== b.length) return false;
                for (var i = 0, len = a.length; i < len; i++) {
                    if (a[i] !== b[i]) return false;
                }

                return true;
            },
            change(){
                console.log(this.activeValue)
            }
        }
    }

    function isVoid(a) {
        return a === undefined || a === null;
    }
</script>
