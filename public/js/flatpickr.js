flatpickr('#reservation_date', {
  locale: 'ja',
  minDate: 'today',
  maxDate: new Date().fp_incr(60),
  
  disable: [
    function (date) {
      return restaurantRegularHolidays.includes(date.getDay());
    }
  ]
});