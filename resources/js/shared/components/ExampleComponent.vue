<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Example Component
                    </div>
                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        errors: {
            type: Array,
            required: false,
            default: [],
        }
    },
    components: {},
    data() {
        return {
            alert: window.AlertHelper,
            dates: window.DateHelper,
        }
    },
    computed: {
        //
    },
    watch: {
        // Example
        errors(_errors) {
            //
        }
    },
    mounted() {
        this.loadAxiosInterceptors();
        this.exampleMethod('Component loaded.');
    },
    updated() {
        //
    },
    methods: {
        exampleMethod(_var) {
            console.log(_var);
            this.alert.success(_var);
        },
        loadAxiosInterceptors() {
            axios.interceptors.response.use(function (response) {
                return response;
            }, function (error) {
                if (error.response.status === 302 && error.response.data && error.response.data.data.location !== undefined) {
                    // Handle redirect
                    window.location = ''; // TODO: Update this
                } else if (error.response.status === 419) {
                    // Handle expired page
                    window.location = ''; // TODO: Update this
                } else if (error.response.status >= 500) {
                    // Handle server error
                    window.location = ''; // TODO: Update this
                } else {
                    // Fail in Axios
                    return Promise.reject(error);
                }
            });
        }
    }
}
</script>
