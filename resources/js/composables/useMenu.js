import { ref } from 'vue';
import Echo from 'laravel-echo';

export function useMenu() {
    const menus = ref([]);

    Echo.channel('menus').listen('MenuUpdated', (event) => {
        menus.value = event.menu;
    });

    return { menus };
}