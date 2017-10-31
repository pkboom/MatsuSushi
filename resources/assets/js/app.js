window.Vue = require('vue');

// create a global variable to contain root vue
window.Event = new Vue();

require('./bootstrap');
require('./cookies');
require('./menu');
require('./upload');
require('./cart');
require('./chat');
require('./admin-chat');



