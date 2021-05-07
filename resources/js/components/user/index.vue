<template>
    <div class="section">
        <div class="columns mt-5-p">
            <div class="column is-three-quarters">
                <div class="columns">
                    <div class="column">
                        <article class="message is-link">
                            <div class="message-header">
                                <p>Total Payin</p>
                            </div>
                            <div class="message-body">
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon is-large is-success"
                                            ><i
                                                class="mdi mdi-cash mdi-48px"
                                            ></i
                                        ></span>
                                    </div>
                                    <div
                                        class="media-content has-text-centered"
                                    >
                                        <span class="is-size-3">{{
                                            total_payin
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="column">
                        <article class="message is-info">
                            <div class="message-header">
                                <p>Date Registered</p>
                            </div>
                            <div class="message-body">
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon is-large is-success"
                                            ><i
                                                class="mdi mdi-calendar-range mdi-48px"
                                            ></i
                                        ></span>
                                    </div>
                                    <div
                                        class="media-content has-text-centered"
                                    >
                                        <span class="is-size-3">{{
                                            new Date(
                                                $parent.active_user_details.created_at
                                            ).toLocaleDateString("en-PH", {
                                                weekday: "long",
                                                year: "numeric",
                                                month: "long",
                                                day: "numeric"
                                            })
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div v-for="(payout, i) in payouts" :key="i" class="columns">
                    <div class="column">
                        <a
                            v-on:click="
                                ViewInvestmentAndInterestRecords(payout.id)
                            "
                            ><article class="message is-success">
                                <div class="message-header">
                                    <p>Plan {{ i + 1 }} - Total Payout</p>
                                </div>
                                <div class="message-body">
                                    <div class="media">
                                        <div class="media-left">
                                            <span
                                                class="icon is-large is-success"
                                                ><i
                                                    class="mdi mdi-cash mdi-48px"
                                                ></i
                                            ></span>
                                        </div>
                                        <div
                                            class="media-content has-text-centered"
                                        >
                                            <span class="is-size-3">{{
                                                payout.result
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                    <div v-if="payout.is_cooldown" class="column">
                        <article class="message is-default">
                            <div class="message-header">
                                <p>Plan {{ i + 1 }} - 1st Month Cooldown</p>
                            </div>
                            <div class="message-body">
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon is-large is-success"
                                            ><i
                                                class="mdi mdi-calendar-range mdi-48px"
                                            ></i
                                        ></span>
                                    </div>
                                    <div
                                        class="media-content has-text-centered"
                                    >
                                        <span
                                            v-if="
                                                GetMonthCountdown(payout.date) >
                                                    0
                                            "
                                            class="is-size-3"
                                            >{{
                                                GetMonthCountdown(payout.date)
                                            }}
                                            day(s) left</span
                                        >
                                        <span v-else class="is-size-3"
                                            >Cooldown Finished</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
            <div class="column is-one-quarter">
                <div class="box">
                    <h3
                        class="is-size-5 has-text-weight-bold has-text-centered mb-4"
                    >
                        FMD LOGISTICS INTERNATIONAL CORPORATION
                    </h3>
                    <p class="is-size-7 mb-3">
                        WE OFFER CO-PARTNERSHIP PROGRAM WHEREIN VENTURERS ARE
                        WELCOME TO AVAIL OUR LIMITED ALLOTED SLOTS.
                    </p>
                    <p class="is-size-7 mb-3 has-text-weight-semibold">
                        WE HAVE FOUR (4) TYPE OF SLOTS AVAILABLE:
                    </p>

                    <ul class="is-size-7 mb-3">
                        <li>
                            <h4 class="has-text-weight-semibold">
                                VENTURER IS COMPANY INSURED
                            </h4>
                            <div>P11,000 - 33.3%</div>
                            <div>P23,000 - 37.8%</div>
                        </li>
                        <li>
                            <h4 class="has-text-weight-semibold mt-1">
                                VENTURER IS AXA INSURED
                            </h4>
                            <div>P55,000 - 45%</div>
                            <div>P315,000 - 55%</div>
                        </li>
                    </ul>
                    <b-menu>
                        <b-menu-list label="About FMD">
                            <b-menu-item :active="true" expanded>
                                <template #label="">
                                    HOW DOES IT WORK?
                                </template>
                                <div>
                                    <p class="is-size-7 mb-3">
                                        THIS IS A 6 MONTHS LOCK-IN PROGRAM, ALTHOUGH, WE HAVE 1
                                        MONTH (30 DAYS) COOLING OFF PROCESS JUST IN CASE THE
                                        VENTURER NEEDS HIS/HER MONEY BACK SINCE HE/SHE DOESN’T
                                        LIKE THE PROGRAM ANYMORE. NO INTEREST WILL BE GIVEN ONCE
                                        IT WAS PULLED OUT.
                                    </p>
                                    <p class="is-size-7 mb-3">
                                        P11,000 and P23,000 - VENTURER’S MONEY IS COMPANY
                                        INSURED. HE/SHE WILL RECEIVE A CERTIFICATE THAT
                                        CERTIFIES THE VENTURER AS PART OF OUR 6 MONTHS
                                        CO-PARTNERSHIP PROGRAM.
                                    </p>
                                </div>
                            </b-menu-item>
                            <b-menu-item>
                                <template #label="">
                                    ABOUT BEING INSURED BY FMD
                                </template>
                                <div>
                                    <p class="is-size-7 mb-3">
                                        IF THE VENTURER HAD BEEN ON AN ACCIDENT, AND/OR DIED
                                        NATURALLY, THE SAID FAMILY WILL REQUIRE TO GIVE US THE
                                        FOLLOWING PAPERS TO SHOW PROOF THAT THE CURRENT VENTURER
                                        HAVE ALREADY BEEN DECEASED. THIS WILL REQUIRE US TO HAVE
                                        A 7 DAYS PROCESSING AND 1 MONTH (30 DAYS) OF WAITING,
                                        AND UPON ON 37TH DAY (7 DAYS AND 1 MONTH), THE FAMILY
                                        WILL RECEIVE P10,000 INITIAL PAYOUT, AND UPON COMPLETION
                                        OF THE 6 MONTH CO-PARTNERSHIP PROGRAM, THEY WILL RECEIVE
                                        ANOTHER P10,000 ALONG WITH THEIR P11,000 FUNDING.
                                    </p>
                                    <p class="is-size-7 mb-3">
                                        P55,000 and P315,000 - VENTURER IS INSURED BY AXA FOR 1
                                        YEAR. OTHER INFORMATION IS TO BE DISCUSSED BY OUR
                                        CUSTOMER SERVICE REPRESENTATIVES.
                                    </p>
                                </div>
                            </b-menu-item>
                            <b-menu-item>
                                <template #label="">
                                    HOW ABOUT THE BILLING?
                                </template>
                                <div>
                                    <p class="is-size-7 mb-3">
                                        EX. 55K - 45% 6 MONTHS LOCK-IN 1ST MONTH = COOLING OFF
                                        PERIOD, NO DISTRIBUTION OF BILLING/DIVIDEND. P4,125
                                        (7.5%) 2ND MONTH = DISTRIBUTION OF FIRST BILLING. THIS
                                        INCLUDES THE FIRST MONTH BILLING WHICH IS P4,125 (7.5%)
                                        + 2ND MONTH’S BILLING P4,125 (7.5%) 3RD MONTH = P4,125
                                        (7.5%) 4TH MONTH = P4,125 (7.5%) 5TH MONTH = P4,125
                                        (7.5%) 6TH MONTH = P4,125 (7.5%) + THE VENTURER’S FUNDS
                                        (P55,000)
                                    </p>
                                </div>
                            </b-menu-item>
                            <b-menu-item>
                                <template #label="">
                                    HOW TO AVAIL OUR CO-PARTNERSHIP PROGRAM?
                                </template>
                                <div>
                                    <p class="is-size-7 mb-3 is-italic">
                                        Unit 1107 Corporate 145 Building Mother Ignacia st. Brgy
                                        South Triangle Quezon City.
                                    </p>
                                    <p class="is-size-7 mb-3">
                                        <ul>
                                            <li class="mb-2">Opens at 10:00 AM to 7:00 PM, Monday to Saturday</li>
                                            <li><span class="has-text-weight-semibold">Company Mobile:</span> 09560740560 Look for Sean or IC</li>
                                            <li><span class="has-text-weight-semibold">Email:</span> fmdintertionalcorp@gmail.com</li>
                                            <li><span class="has-text-weight-semibold">Website:</span> fmdlogisticsintlcorp.com</li>
                                        </ul>
                                    </p>
                                </div>
                            </b-menu-item>
                        </b-menu-list>
                    </b-menu>
                </div>
            </div>
        </div>
        <b-modal
            v-model="isIIHModalActive"
            has-modal-card
            full-screen
            :can-cancel="false"
        >
            <investment-interest-history-modal v-bind:iih="current_IIH_data" />
        </b-modal>
    </div>
</template>

<script>
import investment_interest_history_modal from "../modals/investment_interest_history_modal";

export default {
    components: {
        "investment-interest-history-modal": investment_interest_history_modal
    },
    data() {
        return {
            api_routes: {
                active_user_investments: "/api/user/active/investments",
                payouts_by_investment_id:
                    "/api/user/active/payouts/investment-id",
                active_investments_by_id: "/api/user/active/investments/id",
                interest_history_by_investment_id:
                    "/api/user/interest/history/investment-id"
            },
            total_payin: "",
            payouts: [],
            isIIHModalActive: false,
            current_IIH_data: {
                investments: [],
                interests: []
            },
            previous_viih_id: null
        };
    },
    methods: {
        ActiveUserInvestments() {
            axios
                .get(this.api_routes.active_user_investments)
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        this.$buefy.toast.open({
                            message: response.data.message,
                            type: "is-danger"
                        });
                    }
                    var total_payin = 0;
                    response.data.payload.map(investment => {
                        total_payin += investment.amount;
                        if (investment.type === 1) {
                            this.GetTotalPayout(investment).then(result => {
                                this.payouts.push({
                                    id: investment.id,
                                    user_id: investment.user_id,
                                    result: result,
                                    is_cooldown: investment.is_cooldown,
                                    date: investment.date
                                });
                            });
                        }
                    });
                    this.total_payin = appHelper.currencyFormatter.format(
                        total_payin
                    );
                });
        },
        async GetTotalPayout(investment) {
            var total_payout = investment.amount;
            await axios
                .post(this.api_routes.payouts_by_investment_id, {
                    investment_id: investment.id
                })
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        return true;
                    }
                    total_payout += response.data.payload.interest;
                    total_payout +=
                        response.data.payload.additional_investments;
                });
            return appHelper.currencyFormatter.format(total_payout);
        },
        GetMonthCountdown(date) {
            var cooldown_date = new Date(date);
            var current_date = new Date();
            cooldown_date.setDate(cooldown_date.getDate() + 30);
            var date_compute = cooldown_date - current_date;

            if (date_compute <= 0) {
                return 0;
            }
            return Math.ceil(
                Math.abs(cooldown_date - current_date) / (1000 * 60 * 60 * 24)
            );
        },
        ViewInvestmentAndInterestRecords(investment_id) {
            if (this.previous_viih_id === investment_id) {
                this.isIIHModalActive = true;
                return true;
            }
            axios
                .post(this.api_routes.active_investments_by_id, {
                    investment_id
                })
                .then(response => {
                    if (response.data.status !== apiResponseStatus.SUCCESS) {
                        this.$buefy.toast.open({
                            message: response.data.message,
                            type: "is-danger"
                        });
                    }
                    this.current_IIH_data.investments = response.data.payload;
                    this.isIIHModalActive = true;

                    axios
                        .post(
                            this.api_routes.interest_history_by_investment_id,
                            {
                                investment_id
                            }
                        )
                        .then(interest_response => {
                            if (
                                interest_response.data.status !==
                                apiResponseStatus.SUCCESS
                            ) {
                                this.$buefy.toast.open({
                                    message: interest_response.data.message,
                                    type: "is-danger"
                                });
                            }

                            this.current_IIH_data.interests =
                                interest_response.data.payload;
                        });

                    this.previous_viih_id = investment_id;
                });
        }
    },
    created() {
        this.ActiveUserInvestments();
    }
};
</script>

<style>
.message-header + .message-body {
    height: 120px;
}
</style>
