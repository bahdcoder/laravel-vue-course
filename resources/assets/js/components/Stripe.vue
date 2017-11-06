<template>
    <div>
        <button class="btn btn-success" @click="subscribe('monthly')">Subscribe to $9.99 Monthly</button>
        <button class="btn btn-info" @click="subscribe('yearly')"> Subscribe to $99.9 Yearly</button>
    </div>
</template>

<script>
import Swal from 'sweetalert';
import Axios from 'axios'
export default {
    props: ['email'],
    mounted() {
        this.handler = StripeCheckout.configure({
            key: 'pk_test_2VnQL9Cic4hLPeiYtvHellBI',
            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
            locale: 'auto',
            token(token) {
                Swal({ text: 'Please wait while we subscribe you to a plan ...', buttons: false });
                Axios.post('/subscribe', {
                    stripeToken: token.id,
                    plan: window.stripePlan
                }).then(resp => {
                    Swal({ text: 'Successfully subscribed', icon: 'success' })
                        .then(() => {
                            window.location = '';
                        });
                })
            }
        }) 
    },
    data() {
        return {
            plan: '',
            amount: 0,
            handler: null
        }
    },
    methods: {
        subscribe(plan) {
            if(plan == 'monthly') {
                window.stripePlan = 'monthly'
                this.amount = 999
            } else {
                window.stripePlan = 'yearly'
                this.amount = 9999
            }

            this.handler.open({
                name: 'Bahdcasts',
                description: 'Bahdcasts Subscription',
                amount: this.amount,
                email: this.email
            })
        }
    }
}
</script>
