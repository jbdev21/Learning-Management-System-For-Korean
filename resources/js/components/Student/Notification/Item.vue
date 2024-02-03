<template>
    <li><!-- start message -->
        <a :href="notification.link">
            <div class="pull-left">
            <img :src="notification.avatar" class="img img-circle" style="border-radius:50%; border:1px solid;" alt="User Image">
            </div>
            <h4>
                {{ notification.title }}
                <small><i class="fa fa-clock-o"></i> <TimeAgo :datetime="notification.created_at" /> </small>
            </h4>
            <p v-html="notification.message"></p>
        </a>
    </li>
</template>
<script>
    export default {
        props:['notification']
    }
</script>

