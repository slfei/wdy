export default {
  phone: {
    valid: function(value) {
      return /^1[3|4|5|7|8]\d{9}$/.test(value);
    },
    message: '手机号码格式不正确'
  }
}
