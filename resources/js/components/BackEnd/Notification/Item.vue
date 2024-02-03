<template>
    <li><!-- start message -->
        <a :href="notification.link">
            <div class="pull-left">
            <img :src="notification.avatar" class="img-circle" alt="User Image">
            </div>
            <h4>
                {{ notification.title }}
                <small><i class="fa fa-clock-o"></i> <TimeAgo :datetime="notification.created_at" /> </small>
            </h4>
            <p>{{ notification.message }}</p>
        </a>
    </li>
</template>
<script>
    export default {
        props:['notification']
    }
</script>
