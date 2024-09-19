import { createApp } from 'vue';
import FollowButton from './components/FollowButton.vue';

// Crée une nouvelle instance de Vue et enregistre le composant
createApp({
    components: {
        'follow-button': FollowButton
    }
}).mount('#app');  // Remplace #app par l'ID de l'élément racine où Vue sera monté
