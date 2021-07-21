<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <div>
                        <img :src="product.path" width="50" height="50">
                    </div>
                    <!-- <input type="file" class="form-control" v-on:change="onChange"> -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                product: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/products/${this.$route.params.id}`)
                .then((res) => {
                    this.product = res.data;
                });
        },
        methods: {
            onChange(e) {
                this.product.file = e.target.files[0];
            },
            updateProduct1(e) {
                e.preventDefault();
                let existingObj = this;

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                // let data = new FormData();
                let data = this.product;
                if (this.product.file) {
                    data.file = this.product.file;
                }
                // data.append('name', this.product.name);
                // data.append('detail', this.product.detail);
console.log('data', data);

                axios.patch(`http://localhost:8000/api/products/${this.$route.params.id}`, data, config)
                    .then(function (res) {
                        // existingObj.success = res.data.success;
                        this.$router.push({ name: 'home' });
                    })
                    .catch(function (err) {
                        existingObj.output = err;
                    });
            },
            updateProduct() {
                this.axios
                    .patch(`http://localhost:8000/api/products/${this.$route.params.id}`, this.product)
                    .then((res) => {
                        this.$router.push({ name: 'home' });
                    });
            }
        }
    }
</script>