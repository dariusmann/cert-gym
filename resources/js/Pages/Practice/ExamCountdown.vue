<template>
    <div>
        <span>{{ timeString }}</span>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: 'ExamCountdown',
    props: {
        // Expect an end time as a Moment.js object
        endTimeMoment: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            timeString: '',
            interval: null,
        };
    },
    methods: {
        updateTimer() {
            const nowUtc = moment.utc();
            const distance = this.endTimeMoment.diff(nowUtc);

            if (distance < 0) {
                clearInterval(this.interval);
                this.timeString = '00:00:00';
                this.$emit('countdown-finished');
                return;
            }

            // Convert distance to a duration and then to hours, minutes, and seconds
            const duration = moment.duration(distance);
            const hours = Math.floor(duration.asHours());
            const minutes = Math.floor(duration.minutes());
            const seconds = Math.floor(duration.seconds());

            // Formatting the time string with leading zeros
            this.timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        },
    },
    mounted() {
        this.updateTimer(); // Initialize the timer
        this.interval = setInterval(this.updateTimer, 1000);
    },
    beforeDestroy() {
        clearInterval(this.interval); // Clear the interval when the component is destroyed
    },
};
</script>
