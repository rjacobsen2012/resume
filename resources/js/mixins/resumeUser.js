export default {
    name: 'ResumeUser',
    created() {
        this.$resumeUser = this.$page.resumeUser
    },
    methods: {
        resumeUser() {
            return this.$page.resumeUser
        },
    },
}
