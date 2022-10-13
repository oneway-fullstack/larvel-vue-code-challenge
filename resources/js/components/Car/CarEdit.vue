<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Car Edit</div>
                    <div class="card-body">
                        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                            <form class="form" @submit.prevent="handleSubmit(update)">
                                <ValidationProvider name="make" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="make">Make</label>
                                        <input v-model="form.make" class="form-control" id="make"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="model" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <input v-model="form.model" class="form-control" id="model"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="year" rules="required|numeric" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input v-model="form.year" class="form-control" id="year"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="owner_id" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="owner_id">Owner</label>
                                        <select v-model="form.owner_id" class="form-control" id="owner_id">
                                            <option v-for="owner in owners" :value="owner.id" >{{ getOwnerName(owner) }}</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <button type="submit" class="btn btn-primary">
                                    Save&nbsp;
                                    <span class="spinner-border spinner-border-sm" v-if="loading"></span>
                                </button>
                                <button type="submit" class="btn btn-danger" @click="cancel">Cancel</button>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ValidationObserver } from "vee-validate"
import ValidationProvider from "../ValidationProvider";
import { ownerFullName } from "../../utils";

export default {
    components: { ValidationObserver, ValidationProvider },
    data() {
        return {
            owners: [],
            car: {},
            form: {},
            loading: false,
        }
    },
    methods: {
        getOwners: function() {
            axios.get('/owner').then(function (res) {
                this.owners = res.data;
            }.bind(this));
        },
        getCar: function (id) {
            axios.get(`/car/${id}`).then(function (res) {
                this.car = res.data;
                this.form = {
                    make: this.car.make,
                    model: this.car.model,
                    year: this.car.year,
                    owner_id: this.car.owner_id
                }
            }.bind(this));
        },
        update: async function() {
            this.loading = true;
            try {
                axios.put(`/car/${this.car.id}`, this.form).then(function (res) {
                    this.$notify({
                        group: 'global',
                        type: 'success',
                        text: 'Car updated successfully!'
                    });
                }.bind(this));
            } catch (e) {
                this.$notify({
                    group: 'global',
                    type: 'error',
                    text: e.message
                })
            } finally {
                this.loading = false
            }
        },
        cancel: function() {
            this.$router.push({name: 'cars'});
        },
        getOwnerName: function(owner) {
            return ownerFullName(owner)
        }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getCar(id);
        this.getOwners();
    }
}
</script>
