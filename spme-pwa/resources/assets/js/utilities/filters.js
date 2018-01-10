/**
 * Format date alone
 */
Vue.filter('justDate', (date) => {
    return moment(date).format('DD MMM');
});

/**
 * Format date with time
 */
Vue.filter('fullDateAndTime', (date) => {
    let end = moment(new Date())
    return 'actualizado ' + end.to(date) + ' (' + moment(date).format('DD MMMM, h:mm A') + ')'
    // return moment(date).format('DD MMM h:mm A')
});

/**
 * Parse description to replace new lines for <br> elements
 */
Vue.filter('nToBr', (text) => {
    return text.replace(/\n/g, "<br />")
});