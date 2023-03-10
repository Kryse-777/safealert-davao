<script>
    function notifyMe() {
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notification");
        }

        // Let's check whether notification permissions have already been granted
        else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
            var notification = new Notification('Warning: You are on a COVID Risk Area, be wary of your surroundings' +
                ' and vacate the premises as soon as possible');
        }

        // Otherwise, we need to ask the user for permission
        else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
        // If the user accepts, let's create a notification
                if (permission === "granted") {
                    var notification = new Notification('Warning: You are on a COVID Risk Area, be wary of your' +
                        ' surroundings and vacate the premises as soon as possible');
                }
            });
        }

        // At last, if the user has denied notifications, and you
        // want to be respectful there is no need to bother them any more.
    }
</script>
