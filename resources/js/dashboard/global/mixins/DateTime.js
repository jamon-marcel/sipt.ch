import moment from 'moment';

export default {
  methods: {

    /**
     * Format a date object
     * 
     * @param date date 
     * @param string format 
     */
    
    dateFormat(date, format = 'DD.MM.YYYY') {
      return moment(date).format(format);
    },

    /**
     * Format a string to '00.00'
     * 
     * @param string time 
     * @return string time
     */

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