<template>
    <div
        class="top-header is-flex is-justify-content-space-between px-6 is-align-items-center navbar is-fixed-top"
    >
        <div class="is-flex is-align-item-center">
            <a href="/"><h3 class="has-text-gray">F M D</h3></a>
        </div>
        <div>
            <div class="columns has-text-white nav-right">
                <div class="column is-flex is-align-items-center">
                    {{ $parent.header_title }}
                </div>
                <div class="column is-flex is-align-items-center">
                    <b-dropdown aria-role="list">
                        <template #trigger>
                            <b-button
                                :label="user_details.name"
                                type="is-primary"
                                icon-left="account"
                                icon-right="menu-down"
                                class="is-outlined"
                            />
                        </template>

                        <b-dropdown-item aria-role="listitem">
                            <a href="/user/profile">
                                <div class="media">
                                    <b-icon
                                        class="media-left"
                                        icon="account-details"
                                    ></b-icon>
                                    <div class="media-content">
                                        <h3>User Profile</h3>
                                    </div>
                                </div>
                            </a>
                        </b-dropdown-item>

                        <b-dropdown-item aria-role="listitem">
                            <a @click="SignoutUser">
                                <div class="media">
                                    <b-icon
                                        class="media-left"
                                        icon="logout"
                                    ></b-icon>
                                    <div class="media-content">
                                        <h3>Sign Out</h3>
                                    </div>
                                </div>
                            </a>
                        </b-dropdown-item>
                    </b-dropdown>
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
                active_user_details: "/api/user/active/details"
            },
            user_details: {}
        };
    },
    methods: {
        SignoutUser() {
            axios.post("/logout").then(() => {
                window.location.href = "/";
            });
        },
        GetActiveUserDetails() {
            axios.get(this.api_routes.active_user_details).then(response => {
                if (response.data.status !== apiResponseStatus.SUCCESS) {
                    this.$buefy.toast.open({
                        message: response.data.message,
                        type: "is-danger"
                    });
                }
                this.$parent.active_user_details = response.data.payload;
                this.user_details = response.data.payload;
            });
        }
    },
    created() {
        this.GetActiveUserDetails();
    }
};
</script>

<style></style>
