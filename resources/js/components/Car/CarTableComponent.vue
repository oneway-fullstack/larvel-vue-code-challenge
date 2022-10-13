<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "../TableButtonsComponent";
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
                },
                {
                    label: 'Owner Name',
                    field: 'owner_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Address',
                    field: 'address',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: function (r) {
                        if (!r.address) return '';

                        const address = r.address;
                        return address.address + '<br>' + address.city + '<br>' + address.country + '<br>' + address.postal_code;
                    }
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
            selectedCar: null
        }
    },
    methods: {
        showCars: function () {
            axios.get('/car').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this));
        },
        onCarDelete: function(car) {
            const message = `Are you sure to delete this car (${car.make})?`;
            this.selectedCar = car;

            bus.$emit('confirmDelete', this.handleCarDelete, { message });
        },
        handleCarDelete: function() {
            return axios.delete(`/car/${this.selectedCar.id}`).then(function (res) {
                this.rows = this.rows.filter(r => r.id !== this.selectedCar.id);
                this.selectedCar = null;
            }.bind(this));
        },
    },
    created: function () {
        this.showCars();

        bus.$on('onCarDelete', (car) => {
            this.onCarDelete(car);
        });

        bus.$on('onCarEdit', (car) => {
            this.$router.push({ name: 'cars.edit', params: { id: car.id } });
        });

        bus.$on('onCarView', (car) => {
            this.$router.push({ name: 'cars.view', params: { id: car.id } });
        });
    }
}
</script>
