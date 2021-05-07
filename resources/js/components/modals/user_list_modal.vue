<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-title">Users List</p>
        </header>
        <section class="modal-card-body">
            <div class="container">
                <div class="box">
                    <b-table
                        :data="users"
                        :paginated="true"
                        :per-page="10"
                        :current-page.sync="user_table.currentPage"
                        :loading="user_table.isLoading"
                        :pagination-rounded="true"
                        sort-icon="arrow-up"
                        default-sort="date"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page"
                        :striped="true"
                        :hoverable="true"
                    >
                        <b-table-column
                            field="email"
                            label="Email"
                            sortable
                            v-slot="props"
                            :searchable="true"
                        >
                            {{ props.row.email }}
                        </b-table-column>
                        <b-table-column
                            field="name"
                            label="Name"
                            sortable
                            v-slot="props"
                            :searchable="true"
                        >
                            {{ props.row.name }}
                        </b-table-column>

                        <b-table-column
                            field="status"
                            label="Status"
                            sortable
                            v-slot="props"
                            :searchable="true"
                        >
                            <b-field>
                                <b-switch
                                    :value="users_status[props.row.id]"
                                    type="is-info"
                                    :outlined="true"
                                    :rounded="false"
                                    v-on:input="
                                        ToggleStatus($event, props.row.id)
                                    "
                                >
                                    Active
                                </b-switch>
                            </b-field>
                        </b-table-column>

                        <b-table-column
                            field="created_at"
                            label="Date"
                            sortable
                            v-slot="props"
                            :searchable="true"
                        >
                            <span class="tag is-dark">
                                {{
                                    new Date(
                                        props.row.created_at
                                    ).toLocaleDateString("en-PH", {
                                        weekday: "long",
                                        year: "numeric",
                                        month: "long",
                                        day: "numeric"
                                    })
                                }}
                            </span>
                        </b-table-column>
                    </b-table>
                </div>
            </div>
        </section>
        <footer class="modal-card-foot">
            <b-button
                icon-left="arrow-left"
                label="Back"
                @click="$parent.close()"
            />
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        users: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            user_table: {
                isLoading: false,
                currentPage: 1
            },
            users_status: {},
            api_routes: {
                update_user_and_investment_status:
                    "/api/admin//user-and-investment/update/status"
            }
        };
    },
    methods: {
        ToggleStatus(status, user_id) {
            axios
                .post(this.api_routes.update_user_and_investment_status, {
                    status,
                    user_id
                })
                .then(response => {
                    console.log(response.data);
                });
        }
    },
    created() {
        this.users.map(user => {
            this.users_status[user.id] = user.status === 1 ? true : false;
        });
    }
};
</script>

<style></style>
