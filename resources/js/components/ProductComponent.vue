<template>
<div id="myproduct">
    <div class="row mt-2 mb-2">
        <div class="col-md-2">&nbsp;</div>
        <!--search in vue-->
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" v-model="search" class="form-control">
                <div class="input-group-prepend">
                    <button @click.prevent="searchProduct()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <!--end-->
        
        <div class="col-md-2 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#cart">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge badge-light">{{badge}}</span>
            </button>
            <div class="modal fade" id="cart">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Your Cart</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!--CartItem-->
                            <div class="modal-body">
                                <table class="table table-striped text-left">
                                    <tbody>
                                        <tr v-for="(cart, n) in carts" v-bind:key="cart.id">
                                            <td>{{cart.name}}</td>
                                            <td>Rp.{{cart.price}}</td>
                                            <td width="100"><input type="text" readonly class="form-control" v-model="cart.amount"></td>
                                            <td width="60">
                                                <button @click="removeCart(n)" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-footer">
                                Total Price:{{totalprice}} &nbsp;
                                <a href="/checkout" class="btn btn-primary">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p><br/></p>

        <!--Product with search using vue-->
        <div class="row">
        <div class="col-md-8">
            <div v-if="showsearch==true">
                <div class="row">
                    <div v-for="cari in caris" v-bind:key="cari.id" class="col-md-6">
                        <div class="card md-4">
                            <img :src="cari.image" :alt="cari.name" class="card-img-top">
                            <div class="card-body">
                                <h4>{{ cari.name }}</h4>
                                <p>{{ cari.description }}</p>
                                <div class="row">
                                    <div class="col-md-6">Stock{{ cari.amount }}</div>
                                    <div class="col-md-6 text-right">Rp.{{ cari.price }}</div>
                                </div>
                                <p class="text-right mt-2">
                                    <input type="number" v-model="quantity" style="width:60px"/>
                                    <button @click="addCart(cari)" class="btn btn-primary">Add to Cart</button>
                                    <button @click="editProduct(cari)" class="btn btn-warning">Edit</button>
                                    <button @click="deleteProduct(cari.id)" class="btn btn-danger">Delete</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="showsearch==false">
            <div class="row">
            <div v-for="product in products" v-bind:key="product.id" class="card card-body col-md-6">
                <h4>{{ product.name }}</h4>
                <p>{{ product.description }}</p>
                <div class="row">
                    <div class="col-md-6">Stock{{ product.amount }}</div>
                    <div class="col-md-6 text-right">Rp.{{ product.price }}</div>
                </div>
                <p class="text-right mt-2">
                    <input type="number" v-model="quantity" style="width:60px"/>
                    <button @click="addCart(product)" class="btn btn-primary">Add to Cart</button>
                    <button @click="editProduct(product)" class="btn btn-warning">Edit</button>
                    <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                </p>
                </div>
            </div>
            </div>
        </div>
    <!--End-->


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
<!--Pagination End-->

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
            pagination: {},
            carts:[],
            cartadd:{
                id:'',
                name:'',
                price:'',
                amount:''
            },
            badge:'0',
            quantity:'1',
            totalprice:'0',

            //for search in vuejs
            search:'',
            showsearch: false,
            caris:[]
        }
    },
    created(){
        this.viewProduct();
        this.viewCart();
    },
    methods:{
        //search in vue
        searchProduct(){
            fetch('/api/product/search?q='+this.search)
            .then(res => res.json())
            .then(res =>{
                this.caris = res;
                this.search = '';
                this.showsearch = true;
            })
            .catch(err =>{
                console.log(err);
            });
        },

        //cart function
        viewCart(){
            if(localStorage.getItem('carts')){
                this.carts = JSON.parse(localStorage.getItem('carts'));
                this.badge = this.carts.length;
                this.totalprice = this.carts.reduce((total, item)=>{
                    return total + item.amount * item.price;
                },0);
            }
        },
        addCart(pro){
            this.cartadd.id = pro.id;
            this.cartadd.name = pro.name;
            this.cartadd.price = pro.price;
            //this.cartadd.amount = pro.amount;
            this.cartadd.amount = this.quantity;
            this.carts.push(this.cartadd);
            this.cartadd = {};
            this.storeCart();
        },
        removeCart(pro){
            this.carts.splice(pro, 1);
            this.storeCart();
        },
        storeCart(){
            let parsed = JSON.stringify(this.carts);
            localStorage.setItem('carts',parsed);
            this.viewCart();
        },

    //product function
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
                    total_page: res.meta.total,
                    path_page: res.meta.path+"?page=",
                    first_link: res.links.first,
                    last_link: res.links.last,
                    prev_link: res.links.prev,
                    next_link: res.links.next
                };
            })
            .catch(err => console.log(err));
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
                //alert('Product added successfully');
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
.product-item{
    width: 350px;
    float: left;
}
</style>
