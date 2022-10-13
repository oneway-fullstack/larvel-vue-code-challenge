<template>
    <div :id="id" ref="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ message }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="handleYes">
                        Yes&nbsp;
                        <span class="spinner-border spinner-border-sm" v-if="loading"></span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import bus from '../event-bus';

export default {
    props: {
        id: {
            type: String,
            default: "confirm-delete-modal"
        }
    },
    data() {
      return {
          message: '',
          cb: null,
          loading: false
      }
    },
    mounted() {
        bus.$on('confirmDelete', this.show);
    },
    methods: {
        show: function(cb, { message }) {
            this.message = message;
            this.cb = cb;
            $(`#${this.id}`).modal('show');
        },
        hide: function() {
            $(`#${this.id}`).modal('hide');
        },
        handleYes: async function() {
            this.loading = true;

            try {
                await this.cb();
                this.hide();
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
