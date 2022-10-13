<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Address Details</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-7">
                            <li class="py-2">
                                <b>Address:</b> {{ fullAddress }}
                            </li>
                            <li class="py-2">
                                <b>Owner:</b> {{ address.owner_name }}
                            </li>
                        </ul>

                        <div>
                            <h3>Cars</h3>
                            <bootstrap-4-datatable :columns="carConfig.columns" :data="address.cars" :filter="carConfig.filter" :per-page="carConfig.perPage" class="table-bordered"></bootstrap-4-datatable>
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
import { fullAddress as getFullAddress } from "../../utils";

export default {
    data() {
        return {
            address: {},
            loading: false,
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
        getAddress: function (id) {
            axios.get(`/address/${id}`).then(function (res) {
                this.address = res.data;
            }.bind(this));
        },
        onEdit: function() {
            this.$router.push({ name: 'addresses.edit', params: { id: this.address.id } });
        },
        back: function() {
            this.$router.push({ name: 'addresses' });
        }
    },
    computed: {
        fullAddress() {
            return getFullAddress(this.address);
        }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getAddress(id);
    }
}
</script>
