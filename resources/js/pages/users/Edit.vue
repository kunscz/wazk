<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="submit">
            <input v-model="form.name" type="text" placeholder="Name" />
            <input v-model="form.email" type="email" placeholder="Email" />
            <select v-model="form.roles" multiple>
                <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        user: Object,
        roles: Array,
    },
    setup(props) {
        const form = useForm({
            name: props.user.name,
            email: props.user.email,
            roles: props.user.roles.map(role => role.name),
        });

        function submit() {
            form.put(`/users/${props.user.id}`);
        }

        return { form, submit };
    },
};
</script>