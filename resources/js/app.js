//

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
Echo.private(`App.Models.User.${USER_ID}`)
    .notification(function (data) { 
        pushNotification(data);
    });
    
// Listen for the custom PostViewed event on the user's posts channel
Echo.private(`posts.${USER_ID}`)
    .listen('.post-viewed', function () {
        // We can show a small info toast for this if needed, or ignore
        console.log('Post viewed by someone');
    });

Echo.private(`notifications.newComment.${USER_ID}`)
    .notification( function (data) {
        pushNotification(data);
    });

Echo.private(`notifications.newLike.${USER_ID}`)
    .notification( function (data) {
        pushNotification(data);
    });
