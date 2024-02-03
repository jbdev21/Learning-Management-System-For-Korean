<template>
    <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-success" v-if="unread">{{ unread }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header text-center" v-if="!notifications.length">You have no notification</li>
            <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu" style="max-height:400px;">
                <li v-for="notification in notifications" :key='notification.id'><!-- start message -->
                    <a :href="notification.link">
                        <div class="pull-left" style="height:60px;">
                        <img :src="notification.avatar" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            {{ notification.title }}
                            <small><i class="fa fa-clock-o"></i> <TimeAgo :datetime="notification.created_at" /> </small>
                        </h4>
                        <p v-html="notification.message"></p>
                    </a>
                </li>
                <!-- end message -->
            </ul>
            </li>
            <li class="footer"><a href="/back-end/notification">See All Messages</a></li>
        </ul>
    </li>
</template>

<script>
import TimeAgo from 'vue2-timeago'
export default {
    components:{
        TimeAgo
    },
    data(){
        return {
            notifications: []
        }
    },
    computed:{
        unread(){
            return this.notifications.filter(e => {
                return e.read_at == null
            }).length
        }
    },
    created(){
        this.getList()

        Echo.private('App.Models.User.' + loggedUser.id)
            .notification((notification) => {
                this.notifyMe("GW",{
                    body: notification.message,
                    icon: notification.avatar,
                })

                // get the fixed url for notification
                axios.post('/back-end/notification/create-link',{
                    link: notification.link,
                    id:notification.id
                })
                .then( response => {
                    var newNotif = {
                        'id': notification.id,
                        'title': notification.title,
                        'message': notification.message,
                        'link': response.data,
                        'avatar': notification.avatar,
                        'created_': notification.created_at,
                    }
                    this.notifications.unshift(newNotif)
                })
                .catch( error => {
                    console.log(error)
                })


                if(this.notifications.length > 7){
                    this.notifications.pop()
                }
        });
    },
    methods:{
        getList(){
            axios.post('/back-end/notification/menu-list')
                .then( response => {
                    this.notifications = response.data
                })
                .catch( error => {
                    console.log(error)
                })
        },
        notifyMe(title, options) {
            // Let's check if the browser supports notifications
            if (window.Notification && Notification.permission !== "granted") {
                Notification.requestPermission(function (status) {
                if (Notification.permission !== status) {
                    Notification.permission = status;
                }
                });
            }
            
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notification");
            }

            // Let's check whether notification permissions have already been granted
            else if (Notification.permission === "granted") {
                // If it's okay let's create a notification
                var notification = new Notification(title, options);
            }	

            // Otherwise, we need to ask the user for permission
            else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        var notification = new Notification(title, options);
                    }
                });
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .menu li p{
        white-space: pre-line;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .messages-menu {
        .dropdown-menu{
            width:380px;
        }
    }
</style>
