<template>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
            <div v-for="product in products" :key="product.id" class="card card-body mb-2 mr-2">
                <h4>{{ product.name }}</h4>
                <p>{{ product.description }}</p>
                <div class="row">
                    <div class="col-md-6">Stock{{ product.amount }}</div>
                    <div class="col-md-6-right">{{ product.price }}</div>
                </div>
                <p class="text-right mt-2">
                    <button @click="editProduct(product)" class="btn btn-warning">Edit</button>
                    <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                </p>
            </div>
            </div>
        </div>
        <div class="col-md-4">
            <form>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="product.name">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea type="text" class="form-control" v-model="product.description"></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" v-model="product.price">
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="number" class="form-control" v-model="product.amount">
            </div>
            <button v-if="add" @click.prevent="addProduct()" class="btn btn-primary">Add Product</button>
            <button v-if="edit" @click.prevent="updateProduct(product.id)" class="btn btn-primary">Edit Product</button>
            <button @click.prevent="clearProduct()" class="btn btn-info">Clear</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            products:[],
            product:{
                id:'',
                name:'',
                description:'',
                price:'',
                amount:''
            },
            add:true,
            edit:true
        }
    },
    created(){
        this.viewProduct();
    },
    methods:{
        viewProduct(){
            fetch('api/products')
            .then(res => res.json())
            .then(res => {
                this.products = res.data
            })
            .catch(err => comsole.log(err));
        },
        addProduct(){
            fetch('api/products',{
                method:'post',
                body: JSON.stringify(this.product),
                headers:{
                    'content-type':'application/json'
                }
            })
            .then(res=> res.json())
            .then(data =>{
                //lert('Product added successfully');
                swal("Successfull","Product has been added", "success");
                this.product.id = '';
                this.product.name = '';
                this.product.description = '';
                this.product.price = '';
                this.product.amount = '';
                this.viewProduct();
            })
            //.catch(err => console.log(err));
            .catch(err => {
                swal("Failed", "Price fail to add", "error");
            });
        },
        editProduct(pro){
            this.add = false;
            this.edit = true;
            this.product.id = pro.id
            this.product.name = pro.name
            this.product.description = pro.description
            this.product.price = pro.price
            this.product.amount = pro.amount
        },
        updateProduct(id){
            fetch(`api/products/${id}`,{
                method:'put',
                body: JSON.stringify(this.product),
                headers:{
                    'content-type': 'application/json'
                }
            })
            .then(res=> res.json())
            .then(data =>{
                //alert('Product updated successfully');
                swal("Successfull!", "Product has been updated", "success");
                this.add = true;
                this.edit = false;
                this.product.name = '';
                this.product.description = '';
                this.product.price = '';
                this.product.amount = '';
                this.viewProduct();
            })
            //.catch(err => console.log(err));
            .catch(err => {
                swal("Failed!", "Product fail to update", "error");
            });
        },
        deleteProduct(id){
            swal({
                title: "Are you sure?",
                text: "Product will be deleted",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete)=>{
                if(willDelete)
                {
                    fetch(`api/products/${id}`,{
                        method:'delete'
                    })
                    .then(res=> res.json())
                    .then(data =>{
                        //alert('Product deleted successfully');
                        swal("Successfull!", "Product has been deleted", "success");
                        this.viewProduct();
                    })
                    //.catch(err => console.log(err));
                    .catch(err => {
                        swal("Failed!","Product fail to update", "error")
                    });
                }
            })
        },
        clearProduct(){
            this.add = true;
            this.edit = false;
            this.product.id = '';
            this.product.name = '';
            this.product.description = '';
            this.product.price = '';
            this.product.amount = '';
        }
    }
}
</script>

<style>

</style>
