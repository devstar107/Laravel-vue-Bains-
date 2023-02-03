<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <div class="alert alert-info" v-if="response">{{ response }}</div>
                        <form method="POST" @submit="submitForm">

                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        :class="error.first_name ? 'form-control is-invalid' : 'form-control'"
                                        name="first_name" v-model="first_name" autocomplete="first_name" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="error.first_name">
                                        <strong>{{ error.first_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        :class="error.last_name ? 'form-control is-invalid' : 'form-control'"
                                        name="last_name" v-model="last_name" required autocomplete="last_name"
                                        autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="error.last_name">
                                        <strong>{{ error.last_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        :class="error.email ? 'form-control is-invalid' : 'form-control'" name="email"
                                        v-model="email" required autocomplete="email">

                                    <span class="invalid-feedback" role="alert" v-if="error.email">
                                        <strong>{{ error.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        :class="error.phone ? 'form-control is-invalid' : 'form-control'" name="phone"
                                        v-model="phone" required autocomplete="phone" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="error.phone">
                                        <strong>{{ error.phone[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Date of
                                    Birth</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        :class="error.date_of_birth ? 'form-control is-invalid' : 'form-control'"
                                        name="date_of_birth" v-model="date_of_birth" autocomplete="date_of_birth"
                                        autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="error.date_of_birth">
                                        <strong>{{ error.date_of_birth[0] }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="job" class="col-md-4 col-form-label text-md-end">Job</label>
                                <div class="col-md-6">
                                    <select id="job" type="date"
                                        :class="error.job ? 'form-control is-invalid' : 'form-control'" name="job"
                                        v-model="job" autocomplete="job" autofocus>
                                        <option value="Manager">Manager</option>
                                        <option value="Programmer">Programmer</option>
                                        <option value="HR">HR</option>
                                        <option value="Support">Support</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert" v-if="error.job">
                                        <strong>{{ error.job[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="previous_experience" class="col-md-4 col-form-label text-md-end">Previous
                                    Experience</label>

                                <div class="col-md-6">
                                    <input id="previous_experience" type="checkbox" name="previous_experience"
                                        v-model="previous_experience" autocomplete="date_of_birth" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="error.previous_experience">
                                        <strong>{{ error.previous_experience[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    props: ['csrf_token', 'userdata'],
    data() {
        this.user = JSON.parse(this.userdata);
        return {
            first_name: this.user && this.user.first_name ? this.user.first_name : '',
            last_name: this.user && this.user.last_name ? this.user.last_name : '',
            phone: this.user && this.user.phone ? this.user.phone : '',
            email: this.user && this.user.email ? this.user.email : '',
            date_of_birth: '',
            job: '',
            previous_experience: true,
            error: {},
            response: null
        }
    },
    mounted() {
        console.log('Component mounted.', this.user)
    },
    methods: {
        submitForm(event) {
            event.preventDefault();
            this.error = {};

            console.log(this.first_name, this.last_name);
            console.log(this.csrf_token);

            axios.post('/job-application', {
                first_name: this.first_name,
                last_name: this.last_name,
                phone: this.phone,
                email: this.email,
                job: this.job,
                previous_experience: this.previous_experience,
                date_of_birth: this.date_of_birth,
                csrf_token: this.csrf_token,
            }).then((response) => {
                console.log('response...', response);
                this.response = response.data;
            }).catch((error) => {
                console.log('error,,,', error.response.data.errors);
                this.error = error.response.data.errors;
            })
        }
    }
}
</script>
