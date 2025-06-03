import { createRouter, createWebHistory } from 'vue-router';
import ClientsPage from '../components/ClientsPage.vue';

const routes = [
  {
    path: '/',
    name: 'Clients',
    component: ClientsPage
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;