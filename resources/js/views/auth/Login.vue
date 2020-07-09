<template>
    <layout title="Login">
        <template v-slot:default="slotProps">
            <b-card :bg-variant="slotProps.bgColorValue" :text-variant="slotProps.textColorValue" :border-variant="slotProps.bgColorValue" class="m-4">
                <b-form @submit.prevent="login">
                    <b-form-group model="email" :errors="validationErrors">
                        <b-form-input v-model.trim="form.email" type="text" placeholder="Email Address" />
                        <div v-show="fieldError('email')" class="validation-error">{{ fieldError('email') }}</div>
                    </b-form-group>

                    <b-form-group model="password" :errors="validationErrors">
                        <b-form-input v-model="form.password" type="password" placeholder="Password" />
                        <div v-show="fieldError('password')" class="validation-error">{{ fieldError('password') }}</div>
                    </b-form-group>

                    <div class="row">
                        <div class="col">
                            <b-checkbox v-model="form.remember" :unchecked-value="null">Remember Me</b-checkbox>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <b-button @click="triggerLoader" variant="primary" type="submit">Login</b-button>
                        </div>
                    </div>
                </b-form>
            </b-card>
        </template>
    </layout>
</template>

<script>
    import Layout from "../../components/layout/Layout";

    export default {
        components: {Layout},

        data() {
            return {
                loading: false,

                validationErrors: {},

                form: {
                    email: '',
                    password: '',
                    remember: null,
                },
            }
        },

        methods: {
            login(event) {
                this.loading = true

                this.axios
                    .post('login', this.form, { baseURL: '/' })
                    .then(this.handleSuccess)
                    .catch(error => {
                        this.validationErrors = this.$addLaravelErrors(error.response)
                        this.$toasted.error("Unable to log in")
                    })
                    .finally(() => this.loading = false)
            },

            handleSuccess(response) {
                if (response.data.success) {
                    this.token = response.data.access_token
                    localStorage.setItem('access_token', this.token)
                    window.location = this.route('resume.index');
                } else {
                    this.$toasted.error("Unable to log in")
                }
            },

            fieldError(field) {
                if (this.validationErrors && this.validationErrors[field]) {
                    return this.validationErrors[field]
                }

                return null
            },
        },
    }
</script>

<style lang="scss" scoped>
    .login-form {
        display: flex;
        flex-direction: column;
        justify-content: center;

        width: 100%;

        .container {
            max-width: 600px;
            width: 100%;
            margin: auto;
            padding: 1rem;
        }
    }
</style>
