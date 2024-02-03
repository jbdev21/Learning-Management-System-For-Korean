<template>
    <div class="waveform"></div>
</template>

<script>
import {Howl, Howler} from 'howler';
export default {
    props: ['file'],
    created(){
        var sound = new Howl({
            src: [$this.file],
            html5: true
        });

        sound.play();
    },
}
</script>

<style>

</style>