<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "../TableButtonsComponent";
import { fullAddress } from "../../utils";
import bus from "../../event-bus";

export default {
    data() {
        return {
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
                {
                    label: 'Owner Name',
                    field: 'owner_name',
                    headerAlign: 'left',
                    align: 'left',
                },
                {
                    label: 'Number of cars',
                    field: 'number_of_cars',
                    headerAlign: 'left',
                    align: 'left',
                },
                {
                    label: 'Actions',
                    headerAlign: 'right',
                    align: 'right',
                    component: TableButtonsComponent
                }
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true,
            selectedAddress: null,
        }
    },
    methods: {
        showAddresses: function () {
            axios.get('/address').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'address'}));
            }.bind(this));
        },
        onAddressDelete: function(address) {
            const message = `Are you sure to delete this address (${fullAddress(address)})?`;
            this.selectedAddress = address;

            bus.$emit('confirmDelete', this.handleAddressDelete, { message });
        },
        handleAddressDelete: function() {
            return axios.delete(`/address/${this.selectedAddress.id}`).then(function (res) {
                this.rows = this.rows.filter(r => r.id !== this.selectedAddress.id);
                this.selectedAddress = null;
            }.bind(this));
        }
    },
    created: function () {
        this.showAddresses();

        bus.$on('onAddressDelete', (address) => {
            this.onAddressDelete(address);
        });

        bus.$on('onAddressEdit', (address) => {
            this.$router.push({ name: 'addresses.edit', params: { id: address.id } });
        });

        bus.$on('onAddressView', (address) => {
            this.$router.push({ name: 'addresses.view', params: { id: address.id } });
        });
    }
}
</script>
