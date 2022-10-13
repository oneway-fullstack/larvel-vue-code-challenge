<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Car Details</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-7">
                            <li class="py-2">
                                <b>Make :</b> {{ car.make }}
                            </li>
                            <li class="py-2">
                                <b>Model :</b> {{ car.model }}
                            </li>
                            <li class="py-2">
                                <b>Year :</b> {{ car.year }}
                            </li>
                            <li class="py-2">
                                <b>Owner:</b> {{ car.owner_name }}
                            </li>
                            <li class="py-2">
                                <b>Address:</b> {{ fullAddress }}
                            </li>
                        </ul>

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
            car: {},
            loading: false,
        }
    },
    methods: {
        getCar: function (id) {
            axios.get(`/car/${id}`).then(function (res) {
                this.car = res.data;
            }.bind(this));
        },
        onEdit: function() {
            this.$router.push({ name: 'cars.edit', params: { id: this.car.id } });
        },
        back: function() {
            this.$router.push({ name: 'cars' });
        },
    },
    computed: {
      fullAddress() {
          return getFullAddress(this.car.address);
      }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getCar(id);
    }
}
</script>
