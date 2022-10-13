<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Owner Details</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-7">
                            <li class="py-2">
                                <b>First name:</b> {{ owner.first_name }}
                            </li>
                            <li class="py-2">
                                <b>Last name:</b> {{ owner.last_name }}
                            </li>
                        </ul>

                        <div>
                            <h3>Addresses</h3>
                            <bootstrap-4-datatable :columns="addressConfig.columns" :data="owner.addresses" :filter="addressConfig.filter" :per-page="addressConfig.perPage" class="table-bordered"></bootstrap-4-datatable>
                            <bootstrap-4-datatable-pager v-model="addressConfig.page" type="abbreviated"></bootstrap-4-datatable-pager>
                        </div>

                        <div>
                            <h3>Cars</h3>
                            <bootstrap-4-datatable :columns="carConfig.columns" :data="owner.cars" :filter="carConfig.filter" :per-page="carConfig.perPage" class="table-bordered"></bootstrap-4-datatable>
                            <bootstrap-4-datatable-pager v-model="carConfig.page" type="abbreviated"></bootstrap-4-datatable-pager>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary" @click="onEdit">Edit</button>
                            <button type="submit" class="btn btn-danger" @click="back">Back</button>
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
            owner: {},
            loading: false,
            addressConfig: {
                columns: [
                    {
                        label: 'ID',
                        field: 'id',
                        align: 'center'
                    },
                    {
                        label: 'Address',
                        field: 'address',
                        headerAlign: 'left',
                        align: 'left',
                        interpolate: true,
                        representedAs: function (r) {
                            return r.address + '<br>' + r.city + '<br>' + r.country + '<br>' + r.postal_code;
                        }
                    },
                ],
                page: 1,
                filter:  '',
                perPage: 20,
            },
            carConfig: {
                columns: [
                    {
                        label: 'ID',
                        field: 'id',
                        align: 'center'
                    },
                    {
                        label: 'Make',
                        field: 'make',
                        headerAlign: 'left',
                        align: 'left'
                    },
                    {
                        label: 'Model',
                        field: 'model',
                        headerAlign: 'left',
                        align: 'left'
                    },
                    {
                        label: 'Year',
                        field: 'year',
                        headerAlign: 'left',
                        align: 'left'
                    }
                ],
                page: 1,
                filter:  '',
                perPage: 20,
            }
        }
    },
    methods: {
        getOwner: function (id) {
            axios.get(`/owner/${id}`).then(function (res) {
                this.owner = res.data;
            }.bind(this));
        },
        onEdit: function() {
            this.$router.push({ name: 'owners.edit', params: { id: this.owner.id } });
        },
        back: function() {
            this.$router.push({ name: 'owners' });
        }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getOwner(id);
    }
}
</script>
