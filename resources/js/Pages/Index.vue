<template>
    <dashboard-layout>
    </dashboard-layout>
</template>

<script>
    import DashboardLayout from '../Layouts/DashboardLayout'

    export default {
        components: {
            DashboardLayout
        },
        data() {
            return {
                state: 'dashboard'
            }
        },
        mounted() {
            window.location.href = route('users.index');
        }
    }
</script>
