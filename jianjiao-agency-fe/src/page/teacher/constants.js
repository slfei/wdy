
import Vue from 'vue'

const degreeMap = {
  1: '大专',
  2: '本科',
  3: '硕士',
  4: '博士'
};

const titleMap = {
  1: '初级',
  2: '中级',
  3: '高级',
  4: '特级'
};


Vue.filter('degreeFilter', (value) => {
  return degreeMap[value] || value;
});

Vue.filter('titleFilter', (value) => {
  return titleMap[value] || value;
});


export default {
  degreeMap,
  titleMap
}
