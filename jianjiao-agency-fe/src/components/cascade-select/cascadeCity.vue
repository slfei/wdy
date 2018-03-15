<template>
  <div class="distpicker-address-wrapper">
      <el-select @change="getCities" v-model="currentProvince"
      :disabled="disabled" :placeholder="placeholders.province">
        <el-option v-for="(item, index) in provinces"
                :value="item"
                :key="index">
          {{ item }}
        </el-option>
      </el-select>
      <el-select @change="getAreas" v-model="currentCity" :placeholder="placeholders.city" :disabled="disabled">
        <el-option v-for="(item, index) in cities"
                :value="item"
                :key="index">
          {{ item }}
        </el-option>
      </el-select>
      <el-select v-model="currentArea" :disabled="disabled" :placeholder="placeholders.area">
        <el-option v-for="(item, index) in areas "
                :value="item"
                :key="index">
          {{ item }}
        </el-option>
      </el-select>
  </div>
</template>

<script>
import DISTRICTS from './dist.js';

const DEFAULT_CODE = 100000

export default {
  name: 'v-distpicker',
  props: {
    value: '',
    // province: { type: [String, Number], default: '' },
    // city: { type: [String, Number], default: '' },
    // area: { type: [String, Number], default: '' },
    staticPlaceholder: { type: Boolean, default: false },
    placeholders: {
      type: Object,
      default() {
        return {
          province: '省',
          city: '市',
          area: '区',
        }
      }
    },
    disabled: { type: Boolean, default: false },
    addressHeader: { type: String, default: 'address-header' },
    addressContainer: { type: String, default: 'address-container' },
  },
  data() {
    return {
      provinces: [],
      cities: [],
      areas: [],
      currentProvince: '',
      currentCity: '',
      currentArea: ''
    }
  },
  created () {
      this.recieveValue();
      this.provinces = this.getDistricts()
      this.cities = this.province ? this.getDistricts(this.getAreaCode(this.determineType(this.province))) : []
      this.areas = this.city ? this.getDistricts(this.getAreaCode(this.determineType(this.city), this.area)) : []

      this.$watch(function() {
        return this.currentProvince + ' ' + this.currentCity + ' ' + this.currentArea;
      }, function(newValue) {
        console.log(newValue);
        this.$emit('input', newValue);
      });
  },
  watch: {
    // currentProvince(vaule) {
    //   this.$emit('province', this.setData(vaule))
    // },
    // currentCity(value) {
    //   this.$emit('city', this.setData(value, this.currentProvince))
    // },
    // currentArea(value) {
    //   this.$emit('area', this.setData(value, this.currentProvince))
    //   if (value != this.placeholders.area) this.emit('selected')
    // },

    value() {
      this.recieveValue();
    }
  },
  methods: {
    recieveValue () {
      var tmp = Array.isArray(this.value) ? this.value : this.value.split(/\s+/);
      this.currentProvince = tmp[0] || '';
      this.currentCity = tmp[1] || '';
      this.currentArea = tmp[2] || '';
    },

    setData(value, check = '') {
      return {
        code: this.getAreaCode(value, check),
        value: value,
      }
    },
    getCities() {
      this.currentCity = ''//this.placeholders.city
      this.currentArea = ''//this.placeholders.area
      this.cities = this.determineValue(this.currentProvince, this.placeholders.province)
      this.cleanList('areas')

    },
    getAreas() {
       this.currentArea = ''//this.placeholders.area
       this.areas = this.determineValue(this.currentCity, this.placeholders.city, this.currentProvince)

    },
    resetProvince() {
      this.provinces = this.getDistricts()
    },
    resetCity() {
      this.getCities()
    },
    chooseProvince(name) {
      this.currentProvince = name
      this.getCities()
    },
    chooseCity(name) {
      this.currentCity = name
      this.getAreas()
    },
    chooseArea(name) {
      this.currentArea = name
    },
    getAreaCode(name, check = '') {
      for(let x in DISTRICTS) {
        for(let y in DISTRICTS[x]) {
          if(name === DISTRICTS[x][y]) {
            if (check.length > 0) {
              if (y.slice(0, 2) !== this.getAreaCode(check).slice(0, 2)) {
                continue
              } else {
                return y
              }
            } else {
              return y
            }
          }
        }
      }
    },
    getCodeValue(code) {
      console.log(code)
      for(let x in DISTRICTS) {
        for(let y in DISTRICTS[x]) {
          if(code === parseInt(y)) {
            return DISTRICTS[x][y]
          }
        }
      }
    },
    getDistricts(code = DEFAULT_CODE) {
      return DISTRICTS[code] || []
    },
    determineValue(currentValue, placeholderValue, check = '') {
      if(currentValue === placeholderValue) {
        return []
      } else {
        return this.getDistricts(this.getAreaCode(currentValue, check))
      }
    },
    determineType(value) {
      if(typeof value === 'number') {
        return this.getCodeValue(value)
      }

      return value
    },
    cleanList(name) {
      this[name] = []
    },
  }
}
</script>
<style lang="styl">
  .distpicker-address-wrapper
    display flex
    .el-select
      flex 1
      &:not(:last-child)
        margin-right 10px
      .el-input
        width auto
</style>
