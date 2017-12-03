export const permissionsMixin = {
    computed: {
        authUser() {
            return this.$store.state.auth_user
        },

        isAuthUser() {
            return this.$store.state.auth_user.id != undefined
        },

        userIsActive() {
            return Boolean(this.$store.state.auth_user.habilitado)
        },

        accountIsActive() {
            return Boolean(this.$store.state.auth_user.account.habilitada)
        },

        isAdminEmailVerified() {

            if(this.userHasRole('web_admin')) {

                return Boolean(this.$store.state.auth_user.verified)
            }

            // Need an axios call here?? if auth user is not admin do I need to check this anyway??


        }
    },

    methods: {
        userCan(permission) {
            if(this.authUser.permissions != undefined) {
                return this.authUser.permissions.includes(permission)
            }
        },

        userHasRole(role) {

            let hasRole = false
            this.authUser.roles.forEach(roleObject => {
                if (roleObject.name === role) {
                    hasRole = true
                }
            })

            return hasRole

        }

    }
}