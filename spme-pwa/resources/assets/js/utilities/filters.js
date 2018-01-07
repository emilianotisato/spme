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
    return moment(date).format('DD MMM h:mm A')
});

/**
 * Parse description to replace new lines for <br> elements
 */
Vue.filter('nToBr', (text) => {
    return text.replace(/\n/g, "<br />")
});