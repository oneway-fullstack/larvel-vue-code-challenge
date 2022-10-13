<template>
    <div>
        <ul class="list-unstyled">
            <li><b>Avg Addresses</b>: {{ data.avg_addresses }}</li>
            <li><b>Avg Cars</b>: {{ data.avg_cars }}</li>
        </ul>
    </div>
</template>

<script>

export default {
    data() {
        return {
            data: {},
            loading: true
        }
    },
    methods: {
        aggregateOwners: function () {
            axios.get('/owner/aggregate').then(function (res) {
                this.data = res.data;
            }.bind(this));
        }
    },
    created: function () {
        this.aggregateOwners()
    }
}
</script>
