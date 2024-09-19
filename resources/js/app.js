import { createApp } from 'vue';
import FollowButton from './components/FollowButton.vue';  // Utilise le chemin correct

const app = createApp({});

app.component('follow-button', FollowButton);
app.mount('#app');// Remplace #app par l'ID de l'élément racine où Vue sera monté
