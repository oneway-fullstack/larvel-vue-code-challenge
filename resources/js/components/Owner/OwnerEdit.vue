<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Owner Edit</div>
                    <div class="card-body">
                        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                            <form class="form" @submit.prevent="handleSubmit(update)">
                                <ValidationProvider name="first name" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="first-name">First name</label>
                                        <input v-model="form.first_name" class="form-control" id="first-name"/>
                                        <div class="invalid-feedback" v-if="errors[0]">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider name="last name" rules="required" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label for="last-name">Last name</label>
                                        <input v-model="form.last_name" class="form-control" id="last-name"/>
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

export default {
    components: { ValidationObserver, ValidationProvider },
    data() {
        return {
            owner: {},
            form: {},
            loading: false,
        }
    },
    methods: {
        getOwner: function (id) {
            axios.get(`/owner/${id}`).then(function (res) {
                this.owner = res.data;
                this.form = {
                    first_name: this.owner.first_name,
                    last_name: this.owner.last_name
                }
            }.bind(this));
        },
        update: async function() {
            this.loading = true;
            try {
                axios.put(`/owner/${this.owner.id}`, this.form).then(function (res) {
                    this.$notify({
                        group: 'global',
                        type: 'success',
                        text: 'Owner updated successfully!'
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
            this.$router.push({name: 'owners'});
        }
    },
    created: function () {
        const id = this.$route.params.id;
        this.getOwner(id);
    }
}
</script>
