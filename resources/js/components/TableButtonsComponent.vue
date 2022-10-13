<template>
    <div>
        <button class="btn btn-primary" @click="onView">View</button>
        <button class="btn btn-primary" @click="onEdit">Edit</button>
        <button class="btn btn-danger" @click="onDelete">Delete</button>
    </div>
</template>

<script>
import bus from "../event-bus";

export default {
    props: {
        row: {
            type: Object
        }
    },
    methods: {
        onDelete: function() {
            bus.$emit(`on${this.capitalizeFirstLetter(this.row.type)}Delete`, this.row);
        },
        onEdit: function() {
            bus.$emit(`on${this.capitalizeFirstLetter(this.row.type)}Edit`, this.row);
        },
        onView: function() {
            bus.$emit(`on${this.capitalizeFirstLetter(this.row.type)}View`, this.row);
        },
        capitalizeFirstLetter: function(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    }
}
</script>
