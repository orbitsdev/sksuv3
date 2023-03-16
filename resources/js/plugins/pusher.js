
const pusher = require('pusher-js');

class Pusher {
  
  initialize() {

    const newPush = new pusher();

  }
}

export default new Pusher();

// window.Pusher = require('pusher-js');

// window.Echo = Echo({
//     broadcaster: 'pusher',
//     key:process.env.VITE_PUSHER_APP_KEY,
//     cluster:process.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,

// });