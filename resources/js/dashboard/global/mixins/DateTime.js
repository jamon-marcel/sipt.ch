import moment from 'moment';

export default {
  methods: {
    dateFormat(date, format = 'DD.MM.YYYY') {
      return moment(date).format(format);
    },

    // filter out dates, format and create string
    datesToString(data, format = 'DD.MM.YY', appendYear = false) {
      let str = [...data.map(x => x.date)].join('/');
      return !appendYear ? str : str + moment(data[0].date).format('Y');
    },

    timeFormat(time) {
      if (time.length == 0) return;
      let t = time.split('.');
      if (t[1] !== undefined) {
        if (t[1].length == 1) {
          return t[0] + '.' + t[1] + '0';
        }
        return t[0] + '.00';
      }
      return time;
    }
  }
};