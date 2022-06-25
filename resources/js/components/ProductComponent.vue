<template lang="">
<div>
    <Header/>
<div class="container my-5 vld-parent" >
    <div class="row mb-3">
        <div class="col-8 offset-4">
            <div class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-primary" @click="create"><i class="fas fa-plus-circle"></i> Create</button>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <form @submit.prevent="view">
                        <div class="input-group mb-3">
                            <input v-model="search" type="text" class="form-control" placeholder="Search" >
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>
    <div class="row g-3">
        <div class="col-4">
            <div class="card">
                <h4 class="card-header">{{ isEditMode ? 'Edit' : 'Create' }}</h4>
                <div class="card-body">
                    <AlertError :form="product" :message="message" />
                    <form @submit.prevent="isEditMode ? update() : store()" >
                        <div class="mb-3">
                            <input v-model="product.name" type="text" class="form-control " placeholder="Name" autocomplete="off" :class="{ 'is-invalid':product.errors.has('name') }">
                            <HasError :form="product" field="name" />
                             
                        </div>
                        <div class="mb-3">
                            <input v-model="product.price" type="number" class="form-control " placeholder="Price" autocomplete="off" :class="{ 'is-invalid':product.errors.has('price') }">
                            <HasError :form="product" field="price" />

                        </div>
                        <button type="submit" class="btn btn-primary"  ><i class="far fa-save"></i> Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id">
                        <td>{{product.id}}</td>
                        <td>{{product.name}}</td>
                        <td>${{product.price}}</td>
                        <td>
                            <button type="button" class="btn btn-info" @click="edit(product)"><i class="far fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" @click="destory(product.id)"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-8 offset-4">
            <div class="row">

                <div class="col-8"></div>
                <div class="col-4">
                    <pagination :data="products" @pagination-change-page="view"></pagination>
                </div>
            </div>

        </div>
    </div>
    
        
</div>
</div>
</template>

<script>
import Header from './HeaderComponent.vue'
import Form from 'vform'
import 'vue-loading-overlay/dist/vue-loading.css'


export default {
    name: 'ProductComponent',
    components:{
        Header,
      
    },
    data() {
        return {
            isEditMode: false,
            search:'',
            products: {},
            product: new Form({
                name: '',
                price: '',
            }),
            message:'',
            
        }
    },
    methods: {
        create() {
            this.product.clear();
            this.isEditMode = false;
            this.product.name = '',
            this.product.price = ''
        },
        store() {
            this.$Progress.start();
             this.isLoading = true;
             let loader = this.$loading.show();
                
            this.product.post('/api/product')
                .then(res => {
                    this.view();
                    this.product.name="";
                    this.product.price="";
                    this.isLoading = false;
                    loader.hide();
                    Toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(error=>{
                    this.message=error.response.data.message;
                    this.$Progress.fail();
                    this.isLoading = false
                    loader.hide()
                });
        },
        
        view(page = 1) {
            
            this.$Progress.start();
            let loader = this.$loading.show();
            
            this.product.get(`/api/product?page=${page}&search=${this.search}`)
                .then(res => {
                    this.products = res.data;
                    this.$Progress.finish();
                    loader.hide()
                })
                .catch(error=>{
                    this.$Progress.fail();
                    loader.hide()
                });
        },
        edit(product) {
            this.product.clear();
            this.isEditMode = true;
            this.product.id = product.id,
            this.product.name = product.name,
            this.product.price = product.price
        },
        update() {
           let loader = this.$loading.show();
            this.product.put(`/api/product/${this.product.id}`)
                .then(res => {
                    this.view();
                    this.product.name="";
                    this.product.price="";
                    loader.hide();
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    
                })
                .catch(error=>{
                    this.message=error.response.data.message;
                    this.$Progress.fail();
                    loader.hide()
                })
        },
        destory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.product.delete(`/api/product/${id}`)
                        .then(res => {
                            this.view();
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )
                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            })
                        })
                    
                }
            })
            
        }
    },
    created() {
        this.view();
    }
}
</script>

<style lang="">

</style>
