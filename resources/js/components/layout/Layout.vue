<template>
    <div :class="[bgColorSchemeValue, `main-content`]">
        <b-navbar class="top-nav navbar navbar-expand shadow-sm" :type="bgColorValue" :variant="bgColorValue">
            <b-navbar-brand>
                <div class="brand-name">
                    <div>
                        <img :src="getResumeUserProperty('gravatar', '')" class="user-gravatar rounded-full w-8 h-8 mr-3"/>
                    </div>
                </div>
            </b-navbar-brand>

            <b-navbar-nav class="ml-auto notifications pr-2">
                <b-nav-item class="pointer squared"  v-b-tooltip.hover.bottomleft="bgColorValue === 'light' ? 'Use Dark Theme' : 'Use Light Theme'" @click="setColorScheme"><font-awesome-icon icon="adjust"/></b-nav-item>
                <b-nav-item class="pointer squared ml-1" v-b-tooltip.hover.bottomleft="'Github Profile'" :href="getResumeUserProperty('github_profile', '#')"><font-awesome-icon :icon="['fab', 'github-alt']"/><span class="icon-visible pl-2">{{ getResumeUserProperty('github_profile', '') }}</span></b-nav-item>
                <b-nav-item class="pointer squared ml-1" title="Email" v-b-tooltip.hover.bottomleft="getResumeUserProperty('email')" :href="`mailto:${getResumeUserProperty('email')}`"><font-awesome-icon icon="envelope"/><span class="icon-visible pl-2">{{ getResumeUserProperty('email', '') }}</span></b-nav-item>
                <b-nav-item :class="[`pointer`, `squared`, `ml-1`, textColorSchemeValue]" v-b-tooltip.hover.bottomleft="`Phone: ${getResumeUserProperty('phone')}`" :href="`tel:${getResumeUserProperty('phone')}`"><font-awesome-icon icon="phone-square"/><span class="icon-visible pl-2">{{ getResumeUserProperty('phone', '') }}</span></b-nav-item>
                <b-nav-item class="pointer squared ml-1" v-b-tooltip.hover.bottomleft="'PDF Resume'" @click="downloadResume"><font-awesome-icon icon="file-pdf"/></b-nav-item>
                <b-nav-item class="pointer squared ml-1" v-b-tooltip.hover.bottomleft="'Word Resume'" @click="downloadResumeWord"><font-awesome-icon icon="file-word"/></b-nav-item>
                <b-nav-item v-if="!loggedIn && !pageEquals('login')" v-b-tooltip.hover.bottomleft="'Login'" href="/login" class="pointer squared ml-1"><font-awesome-icon icon="key"/></b-nav-item>
                <b-nav-item v-if="loggedIn" @click.prevent="logout" v-b-tooltip.hover.bottomleft="'Logout'" class="pointer squared ml-1"><font-awesome-icon icon="sign-out-alt"/></b-nav-item>
                <b-nav-item v-if="!loggedIn && pageEquals('login')" v-b-tooltip.hover.bottomleft="'Home'" href="/" class="pointer squared ml-1"><font-awesome-icon icon="home"/></b-nav-item>
            </b-navbar-nav>
        </b-navbar>

        <div class="layout-box">
            <div class="content w-full" :style="contentStyles">
                <slot v-bind:bgColorValue="bgColorValue" v-bind:textColorValue="textColorValue" v-bind:textColorSchemeValue="textColorSchemeValue"/>
            </div>
        </div>
        <loading-overlay :visible="isloading" :opacity="0.3"/>
    </div>
</template>

<script>
    import user from '@mixins/user'
    import ResumeUser from '@mixins/resumeUser'
    import LoadingOverlay from "../LoadingOverlay";

    export default {
        components: {
            LoadingOverlay,
        },

        mixins: [user, ResumeUser],

        props: {
            loading: { type: Boolean, default: false },
            title: {
                type: String,
            },
            contentStyles: {
                type: [Object, String],
                default: () => ({})
            },
        },

        created() {
            this.gravatar = this.$page.resume_gravatar
            if (!this.currentRoute('login')) {
                // this.$bus.$on('isloading', this.setLoading)
            }
        },

        data() {
            return {
                isloading: false,
                gravatar: null,
                lightColorScheme: true,
                bgColorValue: 'light',
                textColorValue: 'dark',
                textColorSchemeValue: 'text-dark',
                bgColorSchemeValue: 'light-layout',
                // notifications: [],
                // notificationInterval: null,
            }
        },

        mounted() {
            // this.loadNotifications()

            // this.notificationInterval = setInterval(this.loadNotifications, 60000)
        },

        beforeDestroy() {
            // clearInterval(this.notificationInterval)
        },

        methods: {
            updateTitle(title) {
                document.title = `${title} | ${this.$page.app.name}`
            },

            logout() {
                this.axios
                    .post(this.route('logout'))
                    .finally(response => this.$inertia.visit('/'))
            },

            pageEquals(page) {
                return this.$page.currentRouteName === page
            },

            setColorScheme()
            {
                this.lightColorScheme = !this.lightColorScheme
                this.bgColorValue = this.lightColorScheme ? 'light' : 'dark'
                this.textColorValue = this.lightColorScheme ? 'dark' : 'light'
                this.textColorSchemeValue = this.lightColorScheme ? 'text-dark' : 'text-light'
                this.bgColorSchemeValue = this.lightColorScheme ? 'light-layout' : 'dark-layout'
            },

            getResumeUserProperty(field, defaultValue) {
                if (this.$resumeUser) {
                    return this.$resumeUser[field]
                }

                return defaultValue
            },
        },

        computed: {
            slug() {
                return this.title.toLowerCase().replace(/[\s]+/, '-').replace(/\W+/, '')
            },
            logoA() {
                return this.$page.app.name.split(' ')[0]
            },
            logoB() {
                return this.$page.app.name.split(' ')[1]
            },
            loggedIn() {
                return typeof this.$user.email !== 'undefined'
            },
        },

        watch: {
            title: {
                immediate: true,
                handler: 'updateTitle',
            },

            '$page.flash': {
                handler() {
                    if (this.$page.flash.message.length) {
                        this.$toasted.info(this.$page.flash.message)
                    }

                    if (this.$page.flash.error.length) {
                        this.$toasted.error(this.$page.flash.message)
                    }

                    if (this.$page.flash.success.length) {
                        this.$toasted.success(this.$page.flash.message)
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '~sass/helpers';


</style>
