export default {
    name: 'CommonMixins',
    methods: {
        route(name, params = null, getParams = null) {
            if (this.$page.routes[name] === undefined) {
                console.error('Route not found ', name);
            } else {
                let $route = '/' + this.$page.routes[name]
                    .split('/')
                    .map(s => s[0] == '{' ? params.shift() : s)
                    .join('/')

                if (getParams) {
                    $route = $route + '?' + getParams
                }

                return $route
            }

            return this.$page.routes[name]
        },

        downloadResume() {
            this.axios
                .get(this.route('resume-user.download-resume', []), { responseType: 'arraybuffer' })
                .then(response => {
                    let blob = new Blob([response.data], {type:'application/*'})
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'richard_jacobsen_resume_2020.pdf'
                    link.click()
                })
        },

        downloadResumeWord() {
            this.axios
                .get(this.route('resume-user.download-resume-word', []), { responseType: 'arraybuffer' })
                .then(response => {
                    let blob = new Blob([response.data], {type:'application/*'})
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'richard_jacobsen_resume_2020.docx'
                    link.click()
                })
        },

        triggerLoader() {
            this.$bus.$emit('isloading', true)
        },

        user() {
            return this.$page.user
        },

        currentRoute(name = null) {
            if (name) {
                return this.$page.currentRouteName === name
            }

            return this.$page.currentRouteName
        },
        formatDate(date, format) {
            return this.$moment(date).format(format)
        },
        tokenHeader() {
            return {
                Authorization: `Bearer ${localStorage.getItem('access_token')}`
            }
        },
        dateCurrent(date, currentPayDate) {
            return date && currentPayDate ? this.$moment(date).isSame(currentPayDate) : false
        },

        today() {
            return this.$moment(new Date(), "day")
        },

        isToday(date) {
            const today = this.today().startOf('day')
            return this.$moment(date).isSame(today, 'd')
        },

        isYesterday(date) {
            const yesterday = this.today().clone().subtract(1, 'days').startOf('day')
            return this.$moment(date).isSame(yesterday, 'd');
        },

        currency(amount, format = 'en-US', currency = 'USD') {
            if (typeof amount !== 'number') {
                return amount
            }

            const formatter = new Intl.NumberFormat(format, {
                style: 'currency',
                currency,
                minimumFractionDigits: 2,
            });

            amount = formatter.format(amount)

            return amount
        },

        wholeAmount(amount) {
            return amount.split('.')[0]
        },

        cents(amount) {
            return amount.split('.')[1]
        },
    },
}
