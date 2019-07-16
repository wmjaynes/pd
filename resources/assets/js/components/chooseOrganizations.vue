<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Organizations for which you may publish events</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" v-for="org, orgIndex in this.approvedOrganizations">
                                <a  :href="eventsForUrl(org.id)">{{org.name}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Organizations for which you may create, but not yet publish events</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" v-for="org, orgIndex in this.unapprovedOrganizations()">
                                <a  :href="eventsForUrl(org.id)">{{org.name}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
</template>

<script>
    import {compareValues} from '../sort.js';

    export default {

        props: {
            userId: {
                type: Number,
                default: 2,
            },
        },

        data() {
            return {
                organization: {},
                allOrganizations: null,
                usersOrganizations: null,
                chosenAggregate: null,
                newAggregateName: "",
                deleteClicked: false,
                quickSearchQuery: "",
            }
        },

        methods: {

            eventsForUrl(orgId) {
              return '/eventsfor/' + orgId;
            },

            approvedOrganizations() {
                return [];
              return this.usersOrganizations.filter(org => org.pivot.approved === 1);
            },

            unapprovedOrganizations() {
                if (this.usersOrganizations == null) return [];
                console.log("usersOrganizations: "+this.usersOrganizations);
                let orgs = this.usersOrganizations.filter(org => org.pivot.approved === 0);
                console.log( "orgs: " + orgs);
                return this.usersOrganizations.filter(org => org.pivot.approved === 0);
            },

            getOrganizationsForUser() {
                let app = this;
                axios.get("/users/"+this.userId+"/organizations")
                    .then(function (resp) {
                        console.log(resp.data);
                        app.usersOrganizations = resp.data;
                        app.usersOrganizations.sort(compareValues('name'));
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load user organizations");
                    });
            }

        },



        mounted() {
            this.$nextTick(function () {
                this.getOrganizationsForUser();
                let app = this;
                axios.get('/organizations')
                    .then(function (resp) {
                        app.allOrganizations = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load all organizations");
                    });
            })
        }
    }
</script>

<style scoped>

</style>
