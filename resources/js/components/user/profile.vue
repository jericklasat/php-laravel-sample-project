<template>
    <div class="container">
        <div class="columns is-centered mt-10-p">
            <div class="column is-half">
                <div class="box">
                    <form v-on:submit="UpdateProfile">
                        <b-menu>
                            <b-menu-list icon="account" label="User Profile">
                                <b-menu-item icon="email">
                                    <template #label="props">
                                        Email
                                        <b-icon
                                            class="is-pulled-right"
                                            :icon="
                                                props.expanded
                                                    ? 'menu-down'
                                                    : 'menu-up'
                                            "
                                        ></b-icon>
                                    </template>
                                    <div class="pt-4">
                                        <b-field
                                            class="has-text-white"
                                            label-position="inside"
                                            v-bind:type="
                                                form_label_danger.email
                                                    ? 'is-danger'
                                                    : ''
                                            "
                                        >
                                            <b-input
                                                type="email"
                                                v-model="form.email"
                                                maxlength="50"
                                                required
                                                size="is-small"
                                                placeholder="ex: juandelacruz@mail.com"
                                            >
                                            </b-input>
                                        </b-field>
                                    </div>
                                </b-menu-item>
                                <b-menu-item icon="account-circle">
                                    <template #label="props">
                                        Full Name
                                        <b-icon
                                            class="is-pulled-right"
                                            :icon="
                                                props.expanded
                                                    ? 'menu-down'
                                                    : 'menu-up'
                                            "
                                        ></b-icon>
                                    </template>
                                    <div class="pt-4">
                                        <b-field
                                            class="has-text-white"
                                            label-position="inside"
                                            v-bind:type="
                                                form_label_danger.name
                                                    ? 'is-danger'
                                                    : ''
                                            "
                                        >
                                            <b-input
                                                type="text"
                                                v-model="form.name"
                                                maxlength="50"
                                                required
                                                size="is-small"
                                                placeholder="ex: Juan Dela Cruz"
                                            >
                                            </b-input>
                                        </b-field>
                                    </div>
                                </b-menu-item>
                                <b-menu-item icon="form-textbox-password">
                                    <template #label="props">
                                        Password
                                        <b-icon
                                            class="is-pulled-right"
                                            :icon="
                                                props.expanded
                                                    ? 'menu-down'
                                                    : 'menu-up'
                                            "
                                        ></b-icon>
                                    </template>
                                    <div class="pt-4">
                                        <b-field
                                            class="has-text-white"
                                            label-position="inside"
                                            v-bind:type="
                                                form_label_danger.password
                                                    ? 'is-danger'
                                                    : ''
                                            "
                                        >
                                            <b-input
                                                type="password"
                                                v-model="form.password"
                                                password-reveal
                                                minlength="8"
                                                size="is-small"
                                            >
                                            </b-input>
                                        </b-field>
                                    </div>
                                </b-menu-item>
                                <b-menu-item
                                    icon="calendar-account"
                                    :label="
                                        'Date Registered: ' + date_registered
                                    "
                                    disabled
                                ></b-menu-item>
                                <b-menu-item
                                    class="is-italic"
                                    icon="calendar-edit"
                                    :label="'Date Updated: ' + date_updated"
                                    disabled
                                ></b-menu-item>
                            </b-menu-list>
                        </b-menu>
                        <div>
                            <div class="control mt-5">
                                <p class="mb-2 is-italic is-size-7">
                                    All the changes will take effect in next
                                    page reload/login.
                                </p>
                                <button
                                    class="button is-fullwidth is-primary is-small"
                                >
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            api_routes: {
                update_user_profile: "/api/user/profile/update/id"
            },
            date_registered: "",
            date_updated: "",
            form: {
                email: "",
                password: "",
                name: "",
                user_id: null
            },
            form_label_danger: {
                email: false,
                name: false,
                password: false
            }
        };
    },
    methods: {
        UpdateProfile(evt) {
            evt.preventDefault();
            axios
                .post(this.api_routes.update_user_profile, this.form)
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        this.$buefy.toast.open({
                            message: response.data.message,
                            type: "is-danger"
                        });
                    }
                    this.$buefy.toast.open({
                        message: "Profile Updated",
                        type: "is-success"
                    });
                });
        }
    },
    watch: {
        "$parent.active_user_details": {
            handler(newval) {
                this.form.email = newval.email;
                this.form.name = newval.name;
                this.form.user_id = newval.id;
                this.date_registered = new Date(
                    newval.created_at
                ).toLocaleDateString("en-PH", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                });
                this.date_updated = new Date(
                    newval.updated_at
                ).toLocaleDateString("en-PH", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                });
            },
            deep: true
        }
    },
    created() {
        this.$parent.header_title = "User Profile";
    }
};
</script>

<style></style>
