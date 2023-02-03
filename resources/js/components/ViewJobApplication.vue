<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Job Applications</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="alert alert-info" v-if="alert">{{ alert }}</div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Job Filter</label>
                                    <select @change="handleJob" v-model="jobFilter" class="form-control">
                                        <option value="all">All</option>
                                        <option value="Hr">HR</option>
                                        <option value="Programmer">Programmer</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Support">Support</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div>
                            <table class="table-bordered" id="job-app">
                                <thead>
                                    <tr>
                                        <th>Submitted Date</th>
                                        <th>Application ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Date of Birth</th>
                                        <th>Job</th>
                                        <th>Previous Experience</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="app in applications">
                                        <td>{{ app.created_at }}</td>
                                        <td>{{ app.id }}</td>
                                        <td>{{ app.first_name }}</td>
                                        <td>{{ app.last_name }}</td>
                                        <td>{{ app.email }}</td>
                                        <td>{{ app.phone }}</td>
                                        <td>{{ app.date_of_birth }}</td>
                                        <td>{{ app.job }}</td>
                                        <td>{{ app.previous_experience }}</td>
                                        <td>{{ app.status ? app.status : 'N/A' }}</td>
                                        <td>
                                            <template v-if="app.status == 'in_process'">
                                                <button @click="approve(app.id)">Approve</button>
                                                <button @click="deny(app.id)">Deny</button>
                                            </template>
                                            <button @click="approve(app.id)"
                                                v-if="app.status == 'denied'">Approve</button>
                                            <button @click="deny(app.id)" v-if="app.status == 'approved'">Deny</button>
                                            <button>Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    props: ['csrf_token'],
    data() {
        return {
            applications: [],
            alert: null,
            jobFilter: 'all'
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.init();
        setTimeout(() => $("#job-app").DataTable(), 1300)

    },
    methods: {
        handleJob() {
            this.init(this.jobFilter);
        },
        init(job = null) {
            axios.get('/view-job-application?job=' + this.jobFilter).then((response) => {
                console.log('response...', response);
                this.applications = response.data;
            }).catch((error) => {
                console.log('error,,,', error.response.data.errors);
                this.error = error.response.data.errors;
            })
        },
        deny(id) {
            console.log(id);
            axios.get('/deny-app/' + id).then((response) => {
                this.alert = response.data;
                console.log('response...', response);
                this.init();
            })
        },
        approve(id) {
            console.log(id);
            axios.get('/approve-app/' + id).then((response) => {
                console.log('response...', response);
                this.alert = response.data;
                this.init();
            })
        },
        submitForm(event) {
            event.preventDefault();
            this.error = {};

            console.log(this.first_name, this.last_name);
            console.log(this.csrf_token);

            axios.get('/view-job-application').then((response) => {
                console.log('response...', response);
            }).catch((error) => {
                console.log('error,,,', error.response.data.errors);
                this.error = error.response.data.errors;
            })
        }
    }
}
</script>
