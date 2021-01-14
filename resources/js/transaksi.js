import Vue from 'vue'
import axios from 'axios'
​
Vue.filter('currency', function (money) {
    return accounting.formatMoney(money, "Rp ", 2, ".", ",")
})
new Vue({
    el: '#dw',
    data: {
        produk: {
            id: '',
            qty: '',
            harga: '',
            nama: ''          
        }
    },
    watch: {
        //apabila nilai dari product > id berubah maka
        'produk.id': function() {
            //mengecek jika nilai dari product > id ada
            if (this.produk.id) {
                //maka akan menjalankan methods getProduct
                this.getProduk()
            }
        }
    },
    //menggunakan library select2 ketika file ini di-load
    mounted() {
        $('#produk_id').select2({
            width: '100%'
        }).on('change', () => {
            //apabila terjadi perubahan nilai yg dipilih maka nilai tersebut 
            //akan disimpan di dalam var product > id
            this.produk.id = $('#produk_id').val();
        });
    },
    methods: {
        getProduk() {
            //fetch ke server menggunakan axios dengan mengirimkan parameter id
            //dengan url /api/product/{id}
            axios.get(`/api/produk/${this.produk.id}`)
            .then((response) => {
                //assign data yang diterima dari server ke var product
                this.produk = response.data
            })
        }
    }
})