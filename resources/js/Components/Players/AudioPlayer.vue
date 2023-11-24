<template>
    <div class="custom-audio-player">
        <audio
            rel="audioPlayer"
            :volume="volume"
            @input="audioUpdateVolume"
            @timeupdate="timeupdate"
            preload="metadata" ref="audioPlayer">
            <source :src="src" type="audio/mp3">
        </audio>
        <div class="controls">
            <button @click="playPauseToggle">{{ isPlaying ? 'Pause' : 'Play' }}</button>
            <input type="range" @input="seekTo" step="0.1" max="100">
            <button @click="check">Check</button>
            <button @click="need">need</button>
        </div>
    </div>
</template>

<script>
import fileMixin from "@/mixins/fileMixin";
import cookieService from "@/services/cookieService";

export default {
    name: 'AudioPlayer',
    props: {
        src: {}
    },
    data() {
        return {
            isPlaying: false,
            volume: 0.03,
            currentTime: 5,
            duration: 0,
        };
    },
    methods: {
        playPauseToggle() {
            const audio = this.$refs.audioPlayer
            audio.play()
        },
        seekTo(event) {
            const audio = this.$refs.audioPlayer;
            console.log(audio.currentTime)
            audio.currentTime = this.currentTime;
        },
        check() {
            const audio = this.$refs.audioPlayer;
            console.log(audio.currentTime)
        },
        need() {
            const audio = this.$refs.audioPlayer;
            audio.currentTime = 10
        },
       async tt() {
           try {
               setInterval(() => {
                   console.log(this.$refs.audioPlayer.currentTime);
               }, 1000);
           } catch (e) {
               console.log(e);
           }
        },
        timeupdate(event) {
            console.log(event.target.currentTime)
            const currentTime = event.target.currentTime
            const duration = event.target.duration
            const progress = (currentTime/duration) * 100
            // console.log(progress)
            console.log(this.$refs.audioPlayer.currentTime)
        }
    },
    mounted() {
        // this.tt()
    },
};
</script>

<style scoped>
.custom-audio-player {
    position: relative;
    width: 300px; /* Задайте размеры по своему усмотрению */
}

.controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>
