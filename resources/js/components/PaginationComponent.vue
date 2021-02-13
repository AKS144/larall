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

        <!--Pagination-->
            <div class="row mt-2">
                <div class="col-md-8">
                    <nav>
                        <ul class="pagination">
                                <li v-bind:class="{disabled:!pagination.first_link}" class="page-item"><a href="#" @click="viewProduct(pagination.first_link)" class="page-link">&laquo;</a></li>
                                <li v-bind:class="{disabled:!pagination.prev_link}" class="page-item"><a href="#" @click="viewProduct(pagination.prev_link)" class="page-link">&lt;</a></li>
                                <li v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active: !pagination.current_page == n}" class="page-item"><a href="#" class="page-link" @click="viewProduct(pagination.path_page + n)">{{n}}</a></li>
                                <li v-bind:class="{disabled:!pagination.next_link}" class="page-item"><a href="#" @click="viewProduct(pagination.next_link)" class="page-link">&gt;</a></li>
                                <li v-bind:class="{disabled:!pagination.last_link}" class="page-item"><a href="#" @click="viewProduct(pagination.last_link)" class="page-link">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    Page:{{pagination.from_page}} - {{pagination.to_page}}
                    Total:{{pagination.total_page}}
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
            edit:false,
            pagination: {}
        }
    },
    created(){
        this.viewProduct();
    },
    methods:{
        viewProduct(page){
            page = page || '/api/products';
            //fetch('api/products')
            fetch(page)
            .then(res => res.json())
            .then(res => {
                this.products = res.data;
                this.pagination = {
                    current_page: res.meta.current_page,
                    last_page: res.meta.last_page,
                    from_page: res.meta.from,
                    to_page: res.meta.to,
                    total_page: res.meta,total,
                    path_page: res.meta.path+"?page=",
                    first_link: res.links.first,
                    last_link: res.links.last,
                    prev_link: res.links.prev,
                    next_link: res.links.next
                };
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
               //this.product.id = '';
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
.product-item{
    width: 350px;
    float: left;
}
</style>
