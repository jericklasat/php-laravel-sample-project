<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-title">Investment and Interest History</p>
        </header>
        <section class="modal-card-body">
            <b-tabs position="is-centered" class="block">
                <b-tab-item label="Investments">
                    <div class="container">
                        <div class="box">
                            <b-table
                                :data="iih.investments"
                                :paginated="true"
                                :per-page="10"
                                :current-page.sync="
                                    investment_table.currentPage
                                "
                                :loading="investment_table.isLoading"
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
                                    field="type"
                                    label="Type"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    <b-tag
                                        v-if="props.row.type === 1"
                                        type="is-success"
                                        size="is-large"
                                        >Primary</b-tag
                                    >
                                    <b-tag
                                        v-else
                                        type="is-warning"
                                        size="is-large"
                                        >Additional</b-tag
                                    >
                                </b-table-column>
                                <b-table-column
                                    field="name"
                                    label="Plan"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    {{ props.row.name }}
                                </b-table-column>

                                <b-table-column
                                    field="amount"
                                    label="Amount"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    {{ FormatCurrency(props.row.amount) }}
                                </b-table-column>

                                <b-table-column
                                    field="attachment"
                                    label="Attachment"
                                    v-slot="props"
                                >
                                    <b-image
                                        :src="props.row.attachment"
                                        alt="Thumbnail"
                                        ratio="16by9"
                                    ></b-image>
                                </b-table-column>

                                <b-table-column
                                    field="date"
                                    label="Date"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    <span class="tag is-dark">
                                        {{
                                            new Date(
                                                props.row.date
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
                </b-tab-item>
                <b-tab-item label="Interests">
                    <div class="container">
                        <div class="box">
                            <b-table
                                :data="iih.interests"
                                :paginated="true"
                                :per-page="10"
                                :current-page.sync="interest_table.currentPage"
                                :loading="interest_table.isLoading"
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
                                    field="name"
                                    label="Plan"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    {{ props.row.name }}
                                </b-table-column>

                                <b-table-column
                                    field="amount"
                                    label="Amount"
                                    sortable
                                    v-slot="props"
                                    :searchable="true"
                                >
                                    {{ FormatCurrency(props.row.amount) }}
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
                </b-tab-item>
            </b-tabs>
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
        iih: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            investment_table: {
                isLoading: false,
                currentPage: 1
            },
            interest_table: {
                isLoading: false,
                currentPage: 1
            }
        };
    },
    methods: {
        FormatCurrency(amount) {
            return appHelper.currencyFormatter.format(amount);
        }
    }
};
</script>

<style></style>
