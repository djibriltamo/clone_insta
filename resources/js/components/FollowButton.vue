<template>
    <div id="app">
        <button class="btn btn-sm btn-primary" @click="followProfile" v-text="follow"></button>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        name: 'FollowButton',

        props: ['profileId', 'follows'],

        data : function() {
            return {
                status: this.follows
            }
        },

        methods: {
            followProfile() {
                axios.post('/follows/' + this.profileId)
                    .then(response => {
                        this.status = !this.status
                    })
                    .catch(errors => {
                        if (errors.response.status === 401) {
                            window.location = '/login';
                        }
                    })
            }
        },

        computed : {
            follow() {
                return (this.status) ? 'Ne plus suivre' : 'Suivre';
            }
        }
    };
</script>

