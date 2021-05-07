<template>
    <div class="container">
        <div class="columns mt-10-p">
            <div class="column">
                <a v-on:click="ViewMonthlyInvestmentsHistory">
                    <article class="message is-link">
                        <div class="message-header">
                            <p>Monthly Investments</p>
                        </div>
                        <div class="message-body">
                            <div class="media">
                                <div class="media-left">
                                    <span class="icon is-large is-success"
                                        ><i class="mdi mdi-cash mdi-48px"></i
                                    ></span>
                                </div>
                                <div class="media-content has-text-centered">
                                    <span class="is-size-2">{{
                                        monthly_earnings
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
            <div class="column">
                <a v-on:click="ViewYearlyInvestmentsHistory">
                    <article class="message is-warning">
                        <div class="message-header">
                            <p>Annual Investments</p>
                        </div>
                        <div class="message-body">
                            <div class="media">
                                <div class="media-left">
                                    <span class="icon is-large is-success"
                                        ><i
                                            class="mdi mdi-cash-multiple mdi-48px"
                                        ></i
                                    ></span>
                                </div>
                                <div class="media-content has-text-centered">
                                    <span class="is-size-2">{{
                                        yearly_earnings
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
            <div class="column">
                <a v-on:click="is_user_list_modal = true">
                    <article class="message is-success">
                        <div class="message-header">
                            <p>Head Count</p>
                        </div>
                        <div class="message-body">
                            <div class="media">
                                <div class="media-left">
                                    <span class="icon is-large is-success"
                                        ><i
                                            class="mdi mdi-account-group mdi-48px"
                                        ></i
                                    ></span>
                                </div>
                                <div class="media-content has-text-centered">
                                    <span class="is-size-2">{{
                                        headcount
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
        </div>
        <div class="section">
            <div class="box">
                <h3
                    class="is-size-4 mb-4 has-text-primary is-uppercase has-text-weight-semibold"
                >
                    New Transaction
                </h3>
                <b-table
                    :data="table.data"
                    :paginated="true"
                    :per-page="10"
                    :current-page.sync="table.currentPage"
                    :loading="table.isLoading"
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
                        label="Fullname"
                        sortable
                        v-slot="props"
                        :searchable="true"
                    >
                        {{ props.row.name }}
                    </b-table-column>

                    <b-table-column
                        field="date"
                        label="Date Registered"
                        sortable
                        v-slot="props"
                        :searchable="true"
                    >
                        <span class="tag is-success">
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
                    <b-table-column
                        field="id"
                        label="Action"
                        width="40"
                        sortable
                        numeric
                        v-slot="props"
                        :searchable="false"
                    >
                        <b-button
                            type="is-primary is-light"
                            class="action-btn"
                            v-on:click="
                                OpenNewTransactionModal(
                                    props.row.id,
                                    props.row.name
                                )
                            "
                            >Transact</b-button
                        >
                        <b-button
                            type="is-primary is-light"
                            class="mt-2 action-btn"
                            v-on:click="
                                OpenUpdateTransactionModal(
                                    props.row.id,
                                    props.row.name
                                )
                            "
                            >Update</b-button
                        >
                    </b-table-column>
                </b-table>
            </div>
        </div>

        <b-modal
            v-model="isNewTransactionModalActive"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="New Transction Modal"
            aria-modal
        >
            <template #default="props">
                <form v-on:submit="CreateNewTransaction">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">
                                New Transaction for {{ selected_user_name }}
                            </p>
                        </header>
                        <section class="modal-card-body">
                            <b-field label="Type">
                                <b-select
                                    placeholder="Select Type"
                                    v-model="form.type"
                                    expanded
                                    required
                                >
                                    <option value="1">
                                        New
                                    </option>
                                    <option value="2">
                                        Existing
                                    </option>
                                </b-select>
                            </b-field>
                            <b-field
                                v-if="form.type === '2'"
                                label="Existing Investment"
                            >
                                <b-select
                                    placeholder="Select Existing Investment"
                                    v-model="form.investment_id"
                                    expanded
                                    required
                                >
                                    <option
                                        v-for="(investment,
                                        i) in current_user_investments"
                                        :key="i"
                                        :value="investment.id"
                                    >
                                        {{ investment.name }}
                                    </option>
                                </b-select>
                            </b-field>
                            <b-field v-if="form.type === '1'" label="Plans">
                                <b-select
                                    placeholder="Select Plan"
                                    v-model="form.plan"
                                    expanded
                                    required
                                >
                                    <option
                                        v-for="(plan, i) in plans"
                                        :key="i"
                                        v-bind:value="plan.id"
                                    >
                                        {{ plan.name }}
                                    </option>
                                </b-select>
                            </b-field>
                            <b-field label="Amount">
                                <b-input
                                    v-model="form.amount"
                                    type="number"
                                    min="0"
                                    placeholder="Amount"
                                    required
                                >
                                </b-input>
                            </b-field>
                            <b-field label="Select a date">
                                <b-datepicker
                                    v-model="form.date"
                                    placeholder="Type or select a date..."
                                    icon="calendar-today"
                                    locale="en-PH"
                                    editable
                                    required
                                >
                                </b-datepicker>
                            </b-field>
                            <b-field label="Attachment">
                                <b-field
                                    class="file is-primary"
                                    :class="{ 'has-name': !!form.attachment }"
                                >
                                    <b-upload
                                        v-model="form.attachment"
                                        class="file-label"
                                        accept="image/*"
                                        required
                                    >
                                        <span class="file-cta">
                                            <b-icon
                                                class="file-icon"
                                                icon="upload"
                                            ></b-icon>
                                            <span class="file-label"
                                                >Click to upload</span
                                            >
                                        </span>
                                        <span
                                            class="file-name"
                                            v-if="form.attachment"
                                        >
                                            {{ form.attachment.name }}
                                        </span>
                                    </b-upload>
                                </b-field>
                            </b-field>
                        </section>
                        <footer class="modal-card-foot">
                            <b-button label="Close" @click="props.close" />
                            <b-button
                                label="Submit"
                                native-type="submit"
                                type="is-primary"
                            />
                        </footer>
                    </div>
                </form>
            </template>
        </b-modal>

        <b-modal
            v-model="isUpdateTransactionModalActive"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="Update Transction Modal"
            aria-modal
        >
            <template #default="props">
                <form v-on:submit="UpdateTransaction">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">
                                Update Transaction for {{ selected_user_name }}
                            </p>
                        </header>
                        <section class="modal-card-body">
                            <b-field label="Existing Investment">
                                <b-select
                                    placeholder="Select Existing Investment"
                                    v-model="form_update.investment_id"
                                    expanded
                                    required
                                >
                                    <option
                                        v-for="(investment,
                                        i) in current_user_investments"
                                        :key="i"
                                        :value="investment.id"
                                    >
                                        {{ investment.name }}
                                    </option>
                                </b-select>
                            </b-field>
                            <b-field label="Attachment">
                                <b-field
                                    class="file is-primary"
                                    :class="{
                                        'has-name': !!form_update.attachment
                                    }"
                                >
                                    <b-upload
                                        v-model="form_update.attachment"
                                        class="file-label"
                                        accept="image/*"
                                        required
                                    >
                                        <span class="file-cta">
                                            <b-icon
                                                class="file-icon"
                                                icon="upload"
                                            ></b-icon>
                                            <span class="file-label"
                                                >Click to upload</span
                                            >
                                        </span>
                                        <span
                                            class="file-name"
                                            v-if="form_update.attachment"
                                        >
                                            {{ form_update.attachment.name }}
                                        </span>
                                    </b-upload>
                                </b-field>
                            </b-field>
                        </section>
                        <footer class="modal-card-foot">
                            <b-button label="Close" @click="props.close" />
                            <b-button
                                label="Submit"
                                native-type="submit"
                                type="is-primary"
                            />
                        </footer>
                    </div>
                </form>
            </template>
        </b-modal>
        <b-modal
            v-model="is_investment_history_modal"
            has-modal-card
            full-screen
            :can-cancel="false"
        >
            <InvestmentHistory v-bind:investments="investments_history" />
        </b-modal>
        <b-modal
            v-model="is_user_list_modal"
            has-modal-card
            full-screen
            :can-cancel="false"
        >
            <UserListModal v-bind:users="user_list" />
        </b-modal>
    </div>
</template>

<script>
import InvestmentHistory from "../modals/investment_history";
import UserListModal from "../modals/user_list_modal";

export default {
    components: {
        InvestmentHistory,
        UserListModal
    },
    data() {
        return {
            api_routes: {
                transaction_create: "/api/admin/transaction/create",
                plan_list_all: "/api/admin/plan/list/all",
                user_list_all: "/api/admin/user/list/all",
                monthly_investments: "/api/admin/investments/monthly",
                yearly_investments: "/api/admin/investments/yearly",
                active_investments_by_user_id:
                    "/api/admin/investments/active/user-id",
                update_investment_attachment_by_id:
                    "/api/admin/investments/attachment/update/id",
                monthly_investments_history:
                    "/api/admin/investments/history/monthly",
                yearly_investments_history:
                    "/api/admin/investments/history/yearly"
            },
            isNewTransactionModalActive: false,
            isUpdateTransactionModalActive: false,
            table: {
                data: [],
                isLoading: false,
                currentPage: 1
            },
            selected_user_id: null,
            selected_user_name: "",
            monthly_earnings: "",
            yearly_earnings: "",
            headcount: 0,
            plans: [],
            current_user_investments: [],
            form: {
                plan: null,
                amount: null,
                attachment: null,
                investment_id: null,
                type: null,
                date: null
            },
            form_update: {
                attachment: null,
                investment_id: null
            },
            is_monthly_investment_history_loaded: false,
            is_yearly_investment_history_loaded: false,
            is_investment_history_modal: false,
            investments_history: [],
            is_user_list_modal: false,
            user_list: []
        };
    },
    methods: {
        ListAllUser() {
            axios.get(this.api_routes.user_list_all).then(response => {
                if (response.data.status !== apiResponseStatus.SUCCESS) {
                    this.$buefy.toast.open({
                        message: response.data.message,
                        type: "is-danger"
                    });
                }
                var user_list = [];
                response.data.payload.map(user => {
                    if (user.status) {
                        user_list.push(user);
                    }
                });
                this.table.data = user_list;
                this.headcount = response.data.payload.length;
                this.user_list = response.data.payload;
            });
        },
        ListAllPlan() {
            axios.get(this.api_routes.plan_list_all).then(response => {
                if (response.data.status !== apiResponseStatus.SUCCESS) {
                    this.$buefy.toast.open({
                        message: response.data.message,
                        type: "is-danger"
                    });
                }
                this.plans = response.data.payload;
            });
        },
        OpenNewTransactionModal(id, name) {
            this.selected_user_id = id;
            this.selected_user_name = name;
            this.isNewTransactionModalActive = true;
            axios
                .post(this.api_routes.active_investments_by_user_id, {
                    user_id: id
                })
                .then(response => {
                    this.current_user_investments = response.data.payload;
                });
        },
        CreateNewTransaction(evt) {
            evt.preventDefault();
            var form_data = new FormData();
            form_data.append("user_id", this.selected_user_id);
            Object.keys(this.form).map(key => {
                if (key === "date") {
                    form_data.append(
                        "date",
                        this.form.date.getFullYear() +
                            "-" +
                            (parseInt(this.form.date.getMonth()) + 1) +
                            "-" +
                            this.form.date.getDate()
                    );
                } else {
                    form_data.append(key, this.form[key]);
                }
            });
            axios
                .post(this.api_routes.transaction_create, form_data)
                .then(() => {
                    this.isNewTransactionModalActive = false;
                    this.$buefy.toast.open({
                        message: "New Transcation Created",
                        type: "is-success"
                    });
                    this.form = {
                        plan: null,
                        amount: null,
                        attachment: null,
                        investment_id: null,
                        type: null,
                        date: null
                    };
                });
        },
        OpenUpdateTransactionModal(id, name) {
            this.selected_user_id = id;
            this.selected_user_name = name;
            this.isUpdateTransactionModalActive = true;
            axios
                .post(this.api_routes.active_investments_by_user_id, {
                    user_id: id
                })
                .then(response => {
                    this.current_user_investments = response.data.payload;
                });
        },
        UpdateTransaction(evt) {
            evt.preventDefault();
            var form_data = new FormData();
            form_data.append("investment_id", this.form_update.investment_id);
            form_data.append("attachment", this.form_update.attachment);
            axios
                .post(
                    this.api_routes.update_investment_attachment_by_id,
                    form_data
                )
                .then(() => {
                    this.isUpdateTransactionModalActive = false;
                    this.$buefy.toast.open({
                        message: "Transcation Updated",
                        type: "is-success"
                    });
                    this.form_update = {
                        attachment: null,
                        investment_id: null
                    };
                });
        },
        ListActiveMonthlyInvestments() {
            axios.get(this.api_routes.monthly_investments).then(response => {
                if (response.data.status !== apiResponseStatus.SUCCESS) {
                    this.$buefy.toast.open({
                        message: response.data.message,
                        type: "is-warning"
                    });
                    return true;
                }
                this.monthly_earnings = appHelper.currencyFormatter.format(
                    response.data.payload
                );
            });
        },
        ListActiveYearlyInvestments() {
            axios.get(this.api_routes.yearly_investments).then(response => {
                if (response.data.status !== apiResponseStatus.SUCCESS) {
                    this.$buefy.toast.open({
                        message: response.data.message,
                        type: "is-warning"
                    });
                }
                this.yearly_earnings = appHelper.currencyFormatter.format(
                    response.data.payload
                );
            });
        },
        ListMonthlyInvestmentsHistory() {
            axios
                .get(this.api_routes.monthly_investments_history)
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        this.$buefy.toast.open({
                            message: response.data.message,
                            type: "is-warning"
                        });
                        return true;
                    }
                    this.investments_history = response.data.payload;
                    this.is_monthly_investment_history_loaded = true;
                    this.is_yearly_investment_history_loaded = false;
                });
        },
        ListYearlyInvestmentsHistory() {
            axios
                .get(this.api_routes.yearly_investments_history)
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        this.$buefy.toast.open({
                            message: response.data.message,
                            type: "is-warning"
                        });
                        return true;
                    }
                    this.investments_history = response.data.payload;
                    this.is_yearly_investment_history_loaded = true;
                    this.is_monthly_investment_history_loaded = false;
                });
        },
        ViewMonthlyInvestmentsHistory() {
            this.is_investment_history_modal = true;
            if (this.is_monthly_investment_history_loaded) {
                return true;
            }
            this.ListMonthlyInvestmentsHistory();
        },
        ViewYearlyInvestmentsHistory() {
            this.is_investment_history_modal = true;
            if (this.is_yearly_investment_history_loaded) {
                return true;
            }
            this.ListYearlyInvestmentsHistory();
        }
    },
    watch: {
        "form.plan": {
            handler(plan_id) {
                this.plans.map(plan => {
                    if (plan.id === plan_id) {
                        this.form.amount = plan.amount;
                    }
                });
            },
            deep: true
        },
        "form.investment_id": {
            handler(investment_id) {
                this.current_user_investments.map(investment => {
                    if (investment.id === investment_id) {
                        this.form.amount = parseInt(
                            investment.name.split(" - ")[0].replace(",", "")
                        );
                    }
                });
            },
            deep: true
        }
    },
    created() {
        this.ListAllUser();
        this.ListAllPlan();
        this.ListActiveMonthlyInvestments();
        this.ListActiveYearlyInvestments();
    }
};
</script>

<style>
.action-btn {
    width: 100px;
}
</style>
