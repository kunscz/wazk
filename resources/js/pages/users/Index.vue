<template>
    <div>
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.roles.map(role => role.name).join(', ') }}</td>
                    <td>
                        <Link :href="`/users/${user.id}/edit`" v-if="$page.props.auth.user.can['edit users']">Edit</Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },
    props: {
        users: Array,
    },
};
</script>