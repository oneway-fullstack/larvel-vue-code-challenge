<script>
    import { extend, ValidationProvider } from 'vee-validate'
    import {
        required,
        email,
        numeric,
    } from 'vee-validate/dist/rules'
    import { messages } from 'vee-validate/dist/locale/en.json'

    extend('required', {
        ...required,
        message: messages.required
    });

    extend('email', {
        ...email,
        message: messages.email
    });
    extend('numeric', {
        ...numeric,
        message: messages.numeric
    });

    export default ValidationProvider
</script>
<style lang="scss">
    .form-group {
        &.required {
            .control-label:after {
                color: red;
                content: '*';
            }
        }

        &.has-error {
            .form-control,
            .form-control:focus {
                border-color: red;
            }
        }

        .invalid-feedback {
            display: block;
        }
    }
</style>
