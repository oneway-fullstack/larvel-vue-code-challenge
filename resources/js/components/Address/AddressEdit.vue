<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Address Edit</div>
                    <div class="card-body">
                        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                            <form class="form" @submit.prevent="handleSubmit(update)">
                                <ValidationProvider name="address" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input v-model="form.address" class="form-control" id="address"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="city" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input v-model="form.city" class="form-control" id="city"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="country" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input v-model="form.country" class="form-control" id="country"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="postal code" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="postal_code">Postal code</label>
                                        <input v-model="form.postal_code" class="form-control" id="postal_code"/>
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
            address: {},
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
        getAddress: function (id) {
            axios.get(`/address/${id}`).then(function (res) {
                this.address = res.data;
                this.form = {
                    address: this.address.address,
                    city: this.address.city,
                    country: this.address.country,
                    postal_code: this.address.postal_code,
                    owner_id: this.address.owner_id
                }
            }.bind(this));
        },
        update: async function() {
            this.loading = true;
            try {
                axios.put(`/address/${this.address.id}`, this.form).then(function (res) {
                    this.$notify({
                        group: 'global',
                        type: 'success',
                        text: 'Address updated successfully!'
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
            this.$router.push({name: 'addresses'});
        },
        getOwnerName: function(owner) {
            return ownerFullName(owner)
        }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getAddress(id);
        this.getOwners();
    }
}
</script>
