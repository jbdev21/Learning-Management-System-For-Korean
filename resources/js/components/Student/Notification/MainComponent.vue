<template>
    <li class="dropdown notification-nav">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell-o"></i>
            <span class='badge-info' v-if="unread">{{ unread }}</span>
        </a>
        <ul class="dropdown-menu">
            <li  v-for="notification in notifications" :key='notification.id' :title="notification.message" :class="{ 'unread' : notification.read_at == null}">
                <a :href="notification.link">
                    <img :src="notification.avatar" align="left" class="img img-responsive img-circle" alt="">
                    <div class="content" style="margin-left:5px;">
                        <h4>
                            {{ notification.title }}
                        </h4>
                        <p v-html="notification.message"></p>
                        <div class="datatime"><TimeAgo :datetime="notification.created_at" /></div>
                    </div>
                </a>
            </li>
            <li class='text-center' v-if="notifications.length < 1"><a href="#" class='text-muted' style="font-size:10px;"><i><small>No Notification</small></i></a></li>
            <li role="separator" class="divider"></li>
            <li class="footer text-center">
                <a :href="listurl" >See All Notifications</a>
            </li>
        </ul>
    </li>
</template>

<script>
import TimeAgo from 'vue2-timeago'
export default {
    props:['listurl'], 
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
                axios.post('/my-dashboard/notification/create-link',{
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
 
                    if(this.notifications.length > 10){
                        this.notifications.pop()
                    }
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
            axios.post('/my-dashboard/notification/menu-list')
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
    .notification-nav li p{
        width: 100%;
        white-space: pre-line;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .notification-nav {
        .dropdown-menu{
            width:380px;
        }
    }
</style>

