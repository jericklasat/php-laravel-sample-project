<template>
    <div class="columns">
        <div class="column login-left">
            <b-image
                src="/images/logo3.jpeg"
                ratio="1by1"
                class="full-height"
            ></b-image>
        </div>
        <div class="column login-right">
            <div class="sectio full-height">
                <div class="columns is-vcentered is-mobile is-centered">
                    <div class="column is-half">
                        <div class="container">
                            <div class="">
                                <h2
                                    class="is-size-3 has-text-white has-text-centered mb-5"
                                >
                                    Welcome to FMD Logistics!
                                </h2>
                                <form v-on:submit="PerformLogin">
                                    <b-field
                                        label="Email"
                                        class="has-text-white"
                                        label-position="inside"
                                        v-bind:type="
                                            form_label_danger.email
                                                ? 'is-danger'
                                                : ''
                                        "
                                    >
                                        <b-input
                                            rounded
                                            type="email"
                                            v-model="form.email"
                                            maxlength="50"
                                            required
                                            size="is-small"
                                        >
                                        </b-input>
                                    </b-field>
                                    <b-field
                                        label="Password"
                                        label-position="inside"
                                        class="has-text-white"
                                        v-bind:type="
                                            form_label_danger.password
                                                ? 'is-danger'
                                                : ''
                                        "
                                    >
                                        <b-input
                                            type="password"
                                            rounded
                                            v-model="form.password"
                                            password-reveal
                                            required
                                            minlength="8"
                                            size="is-small"
                                        >
                                        </b-input>
                                    </b-field>
                                    <p
                                        v-if="form_label_danger.failed"
                                        class="help is-danger"
                                    >
                                        These credentials do not match our
                                        records.
                                    </p>
                                    <div class="field mt-5">
                                        <div class="control">
                                            <button
                                                class="button is-fullwidth is-primary is-small is-rounded"
                                            >
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                    <div class="field mt-5">
                                        <div class="control">
                                            <a
                                                href="/register"
                                                class="button is-fullwidth is-warning is-small is-rounded"
                                            >
                                                Create Account
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            routes: {
                login: "/login"
            },
            form: {
                email: "",
                password: ""
            },
            form_label_danger: {
                email: false,
                password: false,
                failed: false
            }
        };
    },
    methods: {
        PerformLogin(evt) {
            evt.preventDefault();
            axios.get("/sanctum/csrf-cookie").then(() => {
                axios
                    .post(this.routes.login, this.form)
                    .then(response => {
                        window.location.href = "/home";
                    })
                    .catch(error => {
                        if (error.response.status === 403) {
                            this.form_label_danger.email = true;
                            this.form_label_danger.password = true;
                            this.form_label_danger.failed = true;
                            return true;
                        } else {
                            if (
                                Object.keys(error.response.data.errors).length >
                                0
                            ) {
                                this.form_label_danger.email = true;
                                this.form_label_danger.password = true;
                                this.form_label_danger.failed = true;
                            }
                        }
                    });
            });
        }
    },
    created() {}
};
</script>

<style>
#app {
    height: 100vh;
    overflow: hidden;
}
.columns {
    padding: 0;
    margin: 0;
    height: 100%;
}
.column {
    padding: 0;
    margin: 0;
}
.full-height {
    height: 100%;
}
.login-right {
    background-color: #2c3741;
}
.button {
    border-radius: 0;
}
</style>
