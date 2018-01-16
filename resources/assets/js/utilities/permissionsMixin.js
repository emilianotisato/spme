export const permissionsMixin = {
    computed: {
        authUser() {
            return this.$store.state.auth_user
        },

        isAuthUser() {
            return this.$store.state.auth_user.id != undefined
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