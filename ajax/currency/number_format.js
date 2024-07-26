module.exports = {
    formatCurrency: function(number) {
      const formatter = new Intl.NumberFormat();
      return formatter.format(number);
    }
};
  
