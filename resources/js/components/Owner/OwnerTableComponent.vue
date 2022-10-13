<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "../TableButtonsComponent";
import { ownerFullName } from "../../utils";
import bus from "../../event-bus";

export default {
    components: { TableButtonsComponent },
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'First Name',
                    field: 'first_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Last Name',
                    field: 'last_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Number of addresses',
                    field: 'number_of_addresses',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Number of cars',
                    field: 'number_of_cars',
                    headerAlign: 'left',
                    align: 'left'
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
            selectedOwner: null
        }
    },
    methods: {
        showOwners: function () {
            axios.get('/owner').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'owner'}));
            }.bind(this));
        },
        onOwnerDelete: function(owner) {
            const message = `Are you sure to delete ${ownerFullName(owner)} owner?`;
            this.selectedOwner = owner;

            bus.$emit('confirmDelete', this.handleOwnerDelete, { message });
        },
        handleOwnerDelete: function() {
            return axios.delete(`/owner/${this.selectedOwner.id}`).then(function (res) {
                this.rows = this.rows.filter(r => r.id !== this.selectedOwner.id);
                this.selectedOwner = null;
            }.bind(this));
        }
    },
    created: function () {
        this.showOwners();

        bus.$on('onOwnerDelete', (owner) => {
            this.onOwnerDelete(owner);
        });

        bus.$on('onOwnerEdit', (owner) => {
            this.$router.push({ name: 'owners.edit', params: { id: owner.id } });
        });

        bus.$on('onOwnerView', (owner) => {
            this.$router.push({ name: 'owners.view', params: { id: owner.id } });
        });
    }
}
</script>
